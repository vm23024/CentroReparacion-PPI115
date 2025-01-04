import { getConnection } from '../database/database';
import { getTokenMh } from '../extpost/getTokenMh';
import { getSelloMh } from '../extpost/getSelloMh';
import { consultaDte } from '../extpost/consultaDte';

const getFirma = async (request, response) => {
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
            + "tipo_dte "
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
                    let urlFirma = "http://65.111.166.70:8113/firmardocumento/";
                    let data = JSON.stringify({
                        "nit": credenciales[0].nit,
                        "passwordPri": credenciales[0].psw,
                        "activo": true,
                        "dteJson": jsonFirmar
                    });
                    var XMLHttpRequest = require("xmlhttprequest").XMLHttpRequest;
                    var xhr = new XMLHttpRequest();
                    xhr.withCredentials = true;
                    xhr.open("POST", urlFirma);
                    xhr.setRequestHeader("Accept", "application/json");
                    xhr.setRequestHeader("Content-Type", "application/json");
                    //xhr.responseText = 'json';
                    //console.log("Token enviado: "+token);
                    xhr.send(data);
                    xhr.onload = () => {
                        //console.log("Entrando en onload");
                        if (xhr.readyState == 4 && xhr.status == 200) {
                            let respuesta = JSON.parse(xhr.responseText);

                            //console.log("Firmas:"+Object.keys(respuesta));
                            //response.json(respuesta);
                            /* let fechaProcesado = respuesta.fhProcesamiento.split(' ');
                             let fechaHora = fechaProcesado[0].split('/');*/
                            try {
                                let update = "UPDATE scc_dtes_creados "
                                    + "SET firma_recibida = '" + respuesta.body + "' "
                                    + "WHERE codigo_control = '" + solicitudes.gen + "' AND "
                                    + "codigo_control = '" + solicitudes.con + "' AND "
                                    + "tipo_dte = '" + solicitudes.tipo + "'";
                                //console.log("update: "+update);
                                //Guardar json firmado
                                let actualizado = con.query(update, function (err, result) {
                                    if (err) {
                                        console.log("Errores: " + err);
                                        response.status(500);
                                        response.send("Errores: " + err);
                                    } else {
                                        //console.log("Se agrego fila:" + Object.values(result));
                                        let sello = getSelloMh(
                                            token,
                                            respuesta.body,
                                            jsonFirmar.identificacion.ambiente,
                                            jsonFirmar.identificacion.tipoDte,
                                            solicitudes.con,
                                            jsonFirmar.identificacion.version,
                                            jsonFirmar.identificacion.codigoGeneracion

                                        );
                                        if (sello == "RECHAZADO") {
                                            let consulta = consultaDte(jsonFirmar.identificacion.codigoGeneracion,
                                                jsonFirmar.identificacion.tipoDte,
                                                token);
                                        }
                                        sello.then(seled => {

                                            response.json({
                                                "sello": seled
                                            });
                                        }).catch(error => response.send("Errro enviando sello: " + error));

                                    }
                                });
                                //console.log("Insertado: "+insertado);
                                //Solicitar sello

                                //Actualizar json guardado en base de datos

                            } catch (e) {
                                response.status(500);
                                response.send("Error al guardar firma: " + e);
                                console.log("Respuesta: " + xhr.responseText);
                            }
                        } else {
                            try {
                                let respuesta2 = JSON.parse(xhr.responseText);

                                let actualizar = "UPDATE scc_dtes_creados "
                                    + "SET estado = '" + respuesta2.status + "'"
                                    + ", observaciones = 'codigo: " + respuesta2.body.codigo
                                    + "\n\rdescripcionMensaje: " + respuesta2.body.mensaje + "'"
                                    + " WHERE codigo_generado = '" + solicitudes.gen + "'"
                                    + " AND tipo_dte = '" + solicitudes.tipo + "'"
                                    + " AND codigo_control = '" + solicitudes.con + "'";
                                let actualizado = conexion.query(actualizar);
                                console.log("Se rechazo la firma: " + respuesta2.status);
                                response.status(500);
                                response.send("Firmar rechazada: " + respuesta2.responseText);
                            } catch (e) {
                                console.log("Errores al intentar guardar rechazo de firma: " + xhr.response);
                                response.status(500);
                                response.send("Errores al intentar guardar rechazo de firma:" + xhr.responseText);
                            }

                        }
                    };
                } catch (e) {
                    console.log("No se logro extraer la informacion: " + e.message);
                    console.log("SQL a extraer del Try-catch Principal: " + sqlJson);
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
    getFirma
};