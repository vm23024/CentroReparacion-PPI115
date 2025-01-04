import { getConnection } from '../database/database';
import { getTokenMh } from '../extpost/getTokenMh';
import { getSelloMh } from '../extpost/getSelloMh';
import { consultaDte } from '../extpost/consultaDte';
import { consultaDteReporte } from '../extpost/consultaDteReporte';

const getDteEstados = async (request, response) => {
    try {
        //Conectando con la base de datos
        const connection = await getConnection();//Conectando a la base de datos
        //Leyendo parametros
        const solicitados = request.query;
        //Solicitando token del dia
        const tokenUtilizar = await getTokenMh(solicitados.fecha);//Obteniendo token o crean uno nuevo
        //console.log("Token a utilizar: " + tokenUtilizar);
        if (tokenUtilizar != '') {
            //Construyendo sql para solicitar dtes creados
            const sql = "SELECT dtes.codigo_generado,"
                + "dtes.tipo_dte,"
                + "dtes.codigo_control,"
                + "dtes.firma_recibida,"
                + "dtes.id_abono,"
                + "dtes.tipo_factura, "
                + "JSON_UNQUOTE(JSON_EXTRACT(dtes.json_creado, '$.identificacion.version')) AS version "
                + "FROM scc_dtes_creados dtes "
                + "INNER JOIN scc_creditos_abonos_mercado ab "
                + "ON ab.id_abono = dtes.id_abono "
                + "WHERE dtes.estado LIKE '%" + solicitados.estado + "%' AND "
                + "ab.fecha = '" + solicitados.fecha + "' AND "
                + "dtes.id_referencia = '" + solicitados.referencia + "' AND "
                + "dtes.tabla_referencia = 'creditos_mercados'";
            console.log("SLQ a extraer: " + sql);
            //Si es sello pendiente solicitar nuevo sello
            const result = await connection.query(sql);
            //response.send("Tipo: "+ typeof result);
            let contador = 0;
            for (let i in result) {
                console.log("Solicitando estado(Con trim): (SELLO%20PENDIENTE)-" + solicitados.estado + "-");
                if (solicitados.estado.includes('PENDIENTE')) {
                    //console.log("Entre a obtener el sello");
                    let sellos = await getSelloMh(tokenUtilizar,
                        result[i].firma_recibida,
                        "01",
                        result[i].tipo_dte,
                        result[i].codigo_control,
                        result[i].version,
                        result[i].codigo_generado);
                    console.log("Sello obtenido: "+sellos);
                    if (sellos.includes('RECHAZADO')) {
                        let consulta = await consultaDteReporte(result[i].codigo_generado,
                            result[i].tipo_dte,
                            tokenUtilizar);
                        console.log("Resultado consulta DTE: " + consulta);
                        if (consulta == "actualizado") {
                            contador++;
                        }
                    } else {
                        contador++;
                        //console.log("Se actualizo dte: "+sellos);
                    }
                } else {
                    console.log("No estoy entrando a al sellado pendiente");
                }
                if (solicitados.estado.includes('RECHAZADO')) {
                    console.log("Si entro a rechazados: ");
                    let consulta = await consultaDte(result[i].codigo_generado,
                        result[i].tipo_dte,
                        tokenUtilizar);
                    if (consulta == "actualizado") {
                        // console.log("Resultado consulta DTE: "+consulta);
                        contador++;
                    } else {
                        console.log("NO se actualizo: " + consulta);
                    }

                }


                /*sellos.then((resultado) => {
                    console.log("Resultado anterior: "+resultado);
                    contador++;
                }).catch(fallo);*/
                //console.log(sellos);

            }
            response.json("Se actualizaron " + contador + " dtes previamente creados");
        }else{
            response.status(500);
            response.send("No fue posible obtener un token");
            console.log("No se ha podido obtener un token");
        }


    } catch (error) {
        response.status(500);
        response.send("Errores: " + error.message);
        console.log("Errores inesperados: " + error.message);
    }
};


export const methods = {
    getDteEstados
};