import { getConnection } from './../database/database';

const consultaDte = async (codigoGen, tipoDte, token) => {
    const con = await getConnection();
    const url = "https://admin.factura.gob.sv/prod/consulta/query/listaByFilter/"; //https://api.dtes.mh.gob.sv/fesv/recepcion/consultadte/";
    return new Promise((resolve, reject) => {
        let sqlCredenciales = "SELECT nit "
            + "FROM empresas.sccsv_2017" //+ process.env.DB_PRESTAN
            + " WHERE nombre_db = 'sccsv_2017'"
        //extrayendo nit emisor
        con.query(sqlCredenciales, (err, rows, fields) => {
            if (!err) {
                //console.log("Extrayendo nit de emisor: "+rows[0].nit);
                let nitEmisor = rows[0].nit;//Instanciando nit emisor
                //Iniciando consulta de dte
                var XMLHttpRequest = require("xmlhttprequest").XMLHttpRequest;
                var data = JSON.stringify({
                    "nitEmisor": nitEmisor,
                    "tdte": tipoDte,
                    "codigoGeneracion": codigoGen,
                    "tipoRpt":"E"
                });

                var xhr = new XMLHttpRequest();
                xhr.withCredentials = true;

                xhr.open("POST", url);
                xhr.setRequestHeader("Accept", "application/json");
                xhr.setRequestHeader("Content-Type", "application/json");
                xhr.setRequestHeader("Authorization", token);
                //xhr.responseType = 'json';
                xhr.send(data);
                xhr.onload = () => {
                    if (xhr.readyState == 4 && (xhr.status == 202 || xhr.status == 200)) {
                        try {
                            let resConsulta = JSON.parse(xhr.responseText);
                            if (resConsulta.body[0].estado == 'PROCESADO' || resConsulta.body[0].estado == 'VALIDADO' || resConsulta.body[0].estado == 'OBSERVADO') {
                                var verificarEstado = "";
                                if(resConsulta.body[0].estado == 'VALIDADO' || resConsulta.body[0].estado == 'OBSERVADO'){
                                    verificarEstado = "PROCESADO";
                                }
                                let fechaProcesado = resConsulta.body[0].fechaRegistro.split(' ');
                                let fechaHora = fechaProcesado[0].split('-');
                                let actualizar = "UPDATE scc_dtes_creados "
                                    + "SET estado = '" + verificarEstado + "' "
                                    + ",sello_recibido = '" + resConsulta.body[0].selloRecibido + "' "
                                    + ",fecha_procesado = '" + resConsulta.body[0].fechaRegistro + "' "
                                    + ", observaciones = 'observaciones: " + resConsulta.body[0].observaciones + "' "
                                    + " WHERE codigo_generado = '" + resConsulta.body[0].codigoGeneracion + "'"
                                    + " AND tipo_dte = '" + tipoDte + "'";
                                con.query(actualizar, (err, resultados) => {
                                    if(!err){
                                        resolve("actualizado");
                                    }else{
                                        console.log("No se actualizo: "+actualizar);
                                        reject("No fue posible actualizar");
                                    }
                                });
                            }else{
                                resolve("DTE sigue siendo invalido: "+Object.values(resConsulta));
                                console.log("Estado DTE: "+resConsulta);
                            }
                        } catch (er) {
                            console.log("Respuesta sin poder ser procesada: "+xhr.responseText);
                            console.log("Response: "+resConsulta);
                            console.log("Error capturado: "+er.message);
                            reject("No se logro procesar respuesta");
                        }


                    }else{
                        console.log("Estado de ready: "+xhr.readyState);
                        console.log("Estado de respuesta: "+xhr.status);
                        console.log("Respuesta: "+xhr.responseText);
                        resolve("Algo inesperado");
                    }
                };

            }else{
                console.log("No se pudo extraer credenciales: "+sqlCredenciales);
                reject("No se pudo realizar consulta: "+sqlCredenciales);
            }
        });
    });

};

module.exports = {
    consultaDte
};