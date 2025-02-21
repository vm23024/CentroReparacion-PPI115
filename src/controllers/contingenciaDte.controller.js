import { getConnection } from '../database/database';
import { getTokenMh } from '../extpost/getTokenMh';
//import { getUrlServicio } from '../extpost/getUrlServicio';


const getContingencia = async (request, response) => {
    try {
        //Leyendo parametros enviados por get
        const solicitados = request.query;
        //console.log("Parametros: "+solicitados.codigo_generado);
        //Seteando conexion a la base de datos
        const con = await getConnection();
        //Fecha para solicitar o consultar el token a utilizar
        var fecha_token = new Date();
        //console.log("Fecha tokan: "+fecha_token.getFullYear() + "-" + (fecha_token.getMonth() + 1) + "-" + fecha_token.getDate());
        //Solicitando token
        var token = await getTokenMh(fecha_token.getFullYear() + "-" + (fecha_token.getMonth() + 1) + "-" + fecha_token.getDate());
        //Consulta para extraer firma de dte a invalidar
        var sqlDte = "SELECT codigo_generado,"
            + "codigo_control,"
            + "tipo_dte,"
            + "firma_recibida, "
            + "IFNULL(JSON_UNQUOTE(JSON_EXTRACT(json_creado, '$.identificacion.ambiente')), '01') AS ambiente,"
            + "IFNULL(JSON_UNQUOTE(JSON_EXTRACT(json_creado, '$.identificacion.version')), 1) AS version, "
            + "IFNULL(JSON_UNQUOTE(JSON_EXTRACT(json_creado, '$.identificacion.tipoDte')), '"+solicitados.tipo_dte+"') AS tipo_dte, "
            + "json_creado, "
            + "sello_recibido "
            + "FROM prestan.scc_dtes_creados "
            + "WHERE codigo_generado = '" + solicitados.codigo_generado + "' "
            + "AND codigo_control = '" + solicitados.codigo_control + "' "
            + "AND tipo_dte = '" + solicitados.tipo_dte + "'";
        console.log("Sql: "+sqlDte);
        //Ejecutando query 
        var resultado = await con.query(sqlDte);
        var json_creado = JSON.parse(resultado[0].json_creado);
        var json_anular = {
            "identificacion": {
                "fecAnula": fecha_token.getFullYear() + "-" + ("0" + (fecha_token.getMonth() + 1)).slice(-2) + "-" + fecha_token.getDate(),
                "horAnula": ("0"+fecha_token.getHours()).slice(-2)+":"+("0"+fecha_token.getMinutes()).slice(-2)+":"+("0"+fecha_token.getSeconds()).slice(-2), 
                "version" : 2,
                "ambiente" : resultado[0].ambiente,
                "codigoGeneracion" : solicitados.codigo_generado   
            },
            "emisor" : 
            {
                "nit": json_creado.emisor.nit,
                "nombre": json_creado.nombre,
                "tipoEstablecimiento" : json_creado.emisor.tipoEstablecimiento,
                "telefono" : json_creado.emisor.telefono.replace('-', ''),
                "correo" : json_creado.emisor.correo,
                "codEstable" : json_creado.emisor.codEstable,
                "codPuntoVenta" : json_creado.emisor.codPuntoVenta,
                "nomEstablecimiento" : json_creado.emisor.nomEstablecimiento

            },
            "documento" : 
            {
                "tipoDte": json_creado.identificacion.tipoDte,
                "codigoGeneracion": json_creado.identificacion.codigoGeneracion,
                "codigoGeneracionR" : null,
                "tipoDocumento" : json_creado.receptor.tipoDocumento,
                "numDocumento" : json_creado.receptor.numDocumento,
                "nombre" : json_creado.receptor.nombre,
                "selloRecibido": resultado[0].sello_recibido,
                "numeroControl": json_creado.identificacion.numeroControl,
                "fecEmi": json_creado.identificacion.fecEmi,
                "montoIva" : parseFloat(json_creado.resumen.totalIva)
            },
            "motivo" : 
            {
                "tipoAnulacion": 2,
                "motivoAnulacion": solicitados.motivo,
                "nombreResponsable": solicitados.nombre,
                "tipDocResponsable": "37",
                "numDocResponsable": json_creado.emisor.nit,
                "nombreSolicita": json_creado.emisor.nombre,
                "tipDocSolicita": "37",
                "numDocSolicita": json_creado.emisor.nit

            }
        };
        response.json(json_anular);


        /*
        //Preparando invocacion api externa 
        const urlInvalidacion = "https://apitest.dtes.mh.gob.sv/fesv/anulardte";//await getUrlServicio('CONTANULAR');
        //console.log("url destino: "+urlInvalidacion);
        var XMLHttpRequest = require("xmlhttprequest").XMLHttpRequest;
        var xhr = new XMLHttpRequest();
        let data = JSON.stringify({
            "ambiente": resultado[0].ambiente,
            "idEnvio": 1,
            "version": parseInt(resultado[0].version),
            "tipoDte": resultado[0].tipo_dte,
            "documento": resultado[0].firma_recibida
        });
        xhr.withCredentials = true;
        xhr.open("POST", urlInvalidacion);
        xhr.setRequestHeader("Authorization", token);
        xhr.setRequestHeader("Content-Type", "application/json");
        xhr.setRequestHeader("Accept", "application/json")
        xhr.responseType = 'json';
        xhr.send(data);
        xhr.onload = () => {
            //console.log("Entrando en onload");
            if (xhr.readyState == 4 && xhr.status == 200) {
                let respuesta = JSON.parse(xhr.responseText);
                let fechaProcesado = respuesta.fhProcesamiento.split(' ');
                let fechaHora = fechaProcesado[0].split('/');
                try {
                    let actualizar = "UPDATE scc_dtes_creados "
                        + "SET sello_recibido = '" + respuesta.selloRecibido + "'"
                        + ", estado = CONCAT(estado, '(ANULADO)')"
                        + ", fecha_procesado = '" + fechaHora[2] + "-" + fechaHora[1] + "-" + fechaHora[0] + " " + fechaProcesado[1] + "'"
                        + ", observaciones = 'codigo: " + respuesta.codigoMsg
                        + "\n\rdescripcionMensaje: " + respuesta.descripcionMsg
                        + "\n\robservaciones: " + respuesta.observaciones + "'"
                        + " WHERE codigo_generado = '" + resultado[0].codigo_generado + "'"
                        + " AND tipo_dte = '" + resultado[0].tipo_dte + "'"
                        + " AND codigo_control = '" + resultado[0].codigo_control + "'";
                    let actualizado = con.query(actualizar);
                    console.log("Respuesta: " + xhr.responseText);
                   // resolve("ok");
                } catch (e) {
                    //reject("Error: " + e);
                    console.log("Respuesta: " + xhr.responseText);
                }
            } else {
                try {
                    let respuesta2 = JSON.parse(xhr.responseText);
                    //let fechaProcesado = respuesta2.fhProcesamiento.split(' ');
                    //let fechaHora = fechaProcesado[0].split('/');
                    let actualizar = "UPDATE scc_dtes_creados "
                        + "SET observaciones = 'codigo: " + respuesta2.codigoMsg
                        + "\n\rdescripcionMensaje: " + respuesta2.descripcionMsg
                        + "\n\rObservaciones: " + respuesta2.observaciones + "'"
                        + " WHERE codigo_generado = '" + solicitados.codigo_generado + "'"
                        + " AND tipo_dte = '" + solicitados.tipo_dte + "'"
                        + " AND codigo_control = '" + solicitados.codigo_control + "'";
                    let actualizado = con.query(actualizar);
                    console.log("Se actualizo en base de datos: " + respuesta2.estado);
                    //response.json("Json Actualizado pero rechazado:"+Object.keys(respuesta2));
                }catch(e){
                    console.log("Errores de json: "+xhr.response);
                    console.log("Errores json catcheado: "+e);
                   // response.send("Errores de json: "+Object.keys(xhr));
                }
                
            }
        }*/

    } catch (e) {
        response.status(500);
        response.send("Error: " + e.message);
        console.log("Error creando json: "+e);
    }
};

export const methods = {
    getContingencia
}