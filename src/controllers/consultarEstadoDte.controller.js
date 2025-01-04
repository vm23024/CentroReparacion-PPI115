import { getConnection } from '../database/database';
import { getTokenMh } from '../extpost/getTokenMh';
import { consultaDteReporte } from '../extpost/consultaDteReporte';

const consultarDte = async (request, response) => {
    let solicitudes = request.query;
    //console.log("getest: "+solicitudes.gen);
    var con = await getConnection();
    //Solicito token
    var fecha_token = new Date();
    var token = await getTokenMh(fecha_token.getFullYear() + "-" + ("0" + (fecha_token.getMonth() + 1)).slice(-2) + "-" + ("0" + fecha_token.getDate()).slice(-2));
    if (token != '') {
        //Solicitar credenciales
        let sqlCredenciales = "SELECT nit, "
            + "password_privado AS psw "
            + "FROM empresas.sccsv_2017" //+ process.env.DB_PRESTAN
            + " WHERE nombre_db = 'sccsv_2017'";// + process.env.DB_PRESTAN + "'";
        var credenciales = await con.query(sqlCredenciales);

        //console.log("Credenciales: "+Object.keys(credenciales[0]));
        let sqlJson = "SELECT json_creado,"
            + "codigo_generado,"
            + "codigo_control,"
            + "tipo_dte, "
            + "estado "
            + "FROM scc_dtes_creados "
            + "WHERE codigo_generado = '" + solicitudes.gen + "' AND "
            + "codigo_control = '" + solicitudes.con + "' AND "
            + "tipo_dte = '" + solicitudes.tipo + "'";
        //console.log("SqlSon "+sqlJson);
        con.query(sqlJson, function (error, datos) {
            if (error) {
                console.log("Parece que hubo erro al extraer el json a trabajar");
                response.status(500);
                response.send("Eeror extrayendo json a trabajar: " + error);

            } else {
                try {
                    var jsonFirmar = JSON.parse(datos[0].json_creado);    //Solicitar firma
                    jsonFirmar.identificacion.numeroControl = solicitudes.con;
                    if(datos[0].estado != 'PROCESADO'){
                        let consulta = consultaDteReporte(jsonFirmar.identificacion.codigoGeneracion,
                            jsonFirmar.identificacion.tipoDte,
                            token);
                        response.send("Obteniendo respuesta: "+consulta);
                    }else{
                        response.send("DTE ya fue procesado");
                    }
                    
                } catch (e) {
                    console.log("No se logro extraer la informacion: " + e.message);
                    console.log("SQL a extraer: " + sqlJson);
                    response.status(500);
                    response.send("Errores extrayendo jsons");
                }
            }
        });


    } else {
        console.log("No se logro extraer token");
        response.status(500);
        response.send("No fue posible obtener token");
    }


    //response.send("Requestes: " + Object.keys(request.body.dteJson));
};

export const methods = {
    consultarDte
};