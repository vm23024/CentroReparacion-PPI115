import { getConnection } from './../database/database';

const consultaDteReporte = async (codigoGen, tipoDte, token) => {
    const con = await getConnection();
    const url = "https://admin.factura.gob.sv/prod/consulta/query/listaByFilter/";//"https://admin.factura.gob.sv/prod/consulta/consulta-ssc/dte/";
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
                    "tipoRpt": "E",
                    "codigoGeneracion": codigoGen
                });

                var xhr = new XMLHttpRequest();
                xhr.withCredentials = true;

                xhr.open("POST", url+codigoGen);
                xhr.setRequestHeader("Accept", "application/json");
                xhr.setRequestHeader("Content-Type", "application/json");
                xhr.setRequestHeader("Authorization", token);
                //xhr.responseType = 'json';
                xhr.send(data);
                xhr.onload = () => {
                    if (xhr.readyState == 4 && xhr.status == 200) {
                        try {
                            let resConsulta = JSON.parse(xhr.responseText);
                            if (resConsulta.estadoDoc != 'Error') {
                                let fechaProcesado = resConsulta.fechaProcesado.split(' ');
                                let fechaHora = fechaProcesado[0].split('-');
                                let estado = 'PROCESADO';
                                
                                //console.log("Sello valido: "+resConsulta.selloVal);
                                //resolve(resConsulta);
                                let actualizar = "UPDATE scc_dtes_creados "
                                    + "SET estado = '" + estado + "' "
                                    + ",sello_recibido = '" + resConsulta.selloRecibido + "' "
                                    + ",fecha_procesado = '" + resConsulta.fechaProcesado + "' "
                                    + ", observaciones = '" + resConsulta.observaciones + "' "
                                    + " WHERE codigo_generado = '" + resConsulta.codGen + "'"
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
                                console.log("Errores en transmision previa: "+url+codigoGen);
                                reject("Parece que existen errores: "+Object.values(resConsulta));
                            }
                        } catch (er) {
                            console.log("Respuesta sin poder ser procesada: "+xhr.responseText);
                            console.log("Response: "+xhr.response);
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
    consultaDteReporte
};