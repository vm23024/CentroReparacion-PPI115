import { getConnection } from '../database/database';
import { getTokenMh } from '../extpost/getTokenMh';
import { getAnulacion } from '../extpost/getAnulacion';
import { getUrlServicio } from '../extpost/getUrlServicio';

import { promises as fs } from "fs";
import path from "path";
import zlib from "zlib";
import { promisify } from "util";
import { json } from 'stream/consumers';

// Convertir funciones zlib basadas en callbacks a Promesas
const gunzip = promisify(zlib.gunzip);
const gzip = promisify(zlib.gzip);



const getContingencia = async (request, response) => {
    try {
        //Leyendo parametros enviados por get
        const solicitados = request.query;
        //console.log("Parametros: "+solicitados.codigo_generado);
        //Seteando conexion a la base de datos
        const con = await getConnection();
        //Fecha para solicitar o consultar el token a utilizar
        var fecha_token = new Date();
        //console.log("Hora tokan: "+("0" + fecha_token.getHours()).slice(-2) + ":" + ("0" + fecha_token.getMinutes()).slice(-2) + ":" + ("0" + fecha_token.getSeconds()).slice(-2));
        //Solicitando token
        var token = await getTokenMh(fecha_token.getFullYear() + "-" + (fecha_token.getMonth() + 1) + "-" + fecha_token.getDate());
        //Urls a utilizar para firma y anulacion
        const urlFirma = await getUrlServicio('FIRMAR', 'sccsv_2017');

        //Consulta para extraer firma de dte a invalidar
        var sqlDte = "SELECT codigo_generado,"
            + "codigo_control,"
            + "tipo_dte,"
            + "firma_recibida, "
            + "IFNULL(JSON_UNQUOTE(JSON_EXTRACT(json_creado, '$.identificacion.ambiente')), '01') AS ambiente,"
            + "IFNULL(JSON_UNQUOTE(JSON_EXTRACT(json_creado, '$.identificacion.version')), 1) AS version, "
            + "IFNULL(JSON_UNQUOTE(JSON_EXTRACT(json_creado, '$.identificacion.tipoDte')), '" + solicitados.tipo_dte + "') AS tipo_dte, "
            + "json_creado, "
            + "sello_recibido "
            + "FROM scc_dtes_creados "
            + "WHERE codigo_generado = '" + solicitados.codigo_generado + "' "
            + "AND codigo_control = '" + solicitados.codigo_control + "' "
            + "AND tipo_dte = '" + solicitados.tipo_dte + "'";
        //console.log("Sql: " + sqlDte);
        //Ejecutando query 
        var resultado = await con.query(sqlDte);
        var json_creado = JSON.parse(resultado[0].json_creado);
        const codigoGeneracion = config.generarCodigoUid4();
        if(solicitados.tipo_dte === '03'){
            json_creado.receptor.tipoDocumento = '36';
            json_creado.receptor.numDocumento = json_creado.receptor.nit;
        }
        if(solicitados.tipo_dte === '14'){
            json_creado.receptor = json_creado.sujetoExcluido;
            json_creado.emisor.nomEstablecimiento = json_creado.emisor.nombre;
            json_creado.emisor.tipoEstablecimiento = "02";
            
        }
        if(json_creado.receptor == null){
            json_creado.receptor = {
                "tipoDocumento" : null,
                "numDocumento" : null,
                "nombre" : null
            }
        }
        var momentoActual = new Date();
        var json_anular = {
            "identificacion": {
                "fecAnula": momentoActual.getFullYear() + "-" + ("0" + (momentoActual.getMonth() + 1)).slice(-2) + "-" + ("0" + (momentoActual.getDate())).slice(-2),
                "horAnula": ("0" + momentoActual.getHours()).slice(-2) + ":" + ("0" + momentoActual.getMinutes()).slice(-2) + ":" + ("0" + momentoActual.getSeconds()).slice(-2) ,
                "version": 2,
                "ambiente": resultado[0].ambiente,
                "codigoGeneracion": codigoGeneracion
            },
            "emisor":
            {
                "nit": json_creado.emisor.nit,
                "nombre": json_creado.emisor.nombre,
                "tipoEstablecimiento": json_creado.emisor.tipoEstablecimiento,
                "telefono": json_creado.emisor.telefono.replace('-', ''),
                "correo": json_creado.emisor.correo,
                "codEstable": json_creado.emisor.codEstable,
                "codPuntoVenta": json_creado.emisor.codPuntoVenta,
                "nomEstablecimiento": json_creado.emisor.nombre

            },
            "documento":
            {
                "tipoDte": json_creado.identificacion.tipoDte,
                "codigoGeneracion": json_creado.identificacion.codigoGeneracion,
                "codigoGeneracionR": null,
                "tipoDocumento": json_creado.receptor.tipoDocumento,
                "numDocumento": json_creado.receptor.numDocumento,
                "nombre": json_creado.receptor.nombre,
                "selloRecibido": resultado[0].sello_recibido,
                "numeroControl": json_creado.identificacion.numeroControl,
                "fecEmi": json_creado.identificacion.fecEmi,
                "montoIva": parseFloat(json_creado.resumen.totalIva),
                "correo": json_creado.receptor.correo,
                "telefono": json_creado.receptor.telefono
            },
            "motivo":
            {
                "tipoAnulacion": 2,
                "motivoAnulacion": decodeURIComponent(solicitados.motivo),
                "nombreResponsable": decodeURIComponent(solicitados.nombre),
                "tipDocResponsable": "37",
                "numDocResponsable": json_creado.emisor.nit,
                "nombreSolicita": json_creado.emisor.nombre,
                "tipDocSolicita": "37",
                "numDocSolicita": json_creado.emisor.nit

            }
        };
        if (token != '') {
            //Solicitar credenciales
            let sqlCredenciales = "SELECT nit, "
                + "password_privado AS psw "
                + "FROM empresas.sccsv_2017" //+ process.env.DB_PRESTAN
                + " WHERE nombre_db = 'sccsv_2017'";// + process.env.DB_PRESTAN + "'";
            var credenciales = await con.query(sqlCredenciales);
            try {
                let jsonFirmar = json_anular;
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

                        console.log("JSON:"+JSON.stringify(jsonFirmar));
                        //response.json(respuesta);
                        /* let fechaProcesado = respuesta.fhProcesamiento.split(' ');
                         let fechaHora = fechaProcesado[0].split('/');*/


                        let anulacion = getAnulacion(
                            token,
                            respuesta.body,
                            jsonFirmar.identificacion.ambiente,
                            solicitados.tipo_dte,
                            solicitados.codigo_control,
                            jsonFirmar.identificacion.version,
                            jsonFirmar.identificacion.codigoGeneracion
                        );
                        anulacion.then(async (value) => {
                            let insAnulacion =
                                "INSERT INTO " +
                                "scc_dtes_anulados(" +
                                "codG_anulacion, " +
                                "codG_factura, " +
                                "codC_factura, " +
                                "tipoDte_factura, " +
                                "motivo, " +
                                "createdBy, " +
                                "createdDate, " +
                                "firma, " +
                                "sello_anulacion, " +
                                "fecha_procesado) " +
                                "VALUES('" +
                                codigoGeneracion +
                                "','" +
                                solicitados.codigo_generado +
                                "', '" +
                                solicitados.codigo_control +
                                "', '" +
                                solicitados.tipo_dte +
                                "','" +
                                decodeURIComponent(solicitados.motivo) +
                                "', '" +
                                decodeURIComponent(solicitados.nombre) +
                                "', '" +
                                momentoActual.getFullYear() +
                                "-" +
                                ("0" + (momentoActual.getMonth() + 1)).slice(-2) +
                                "-" +
                                ("0" + momentoActual.getDate()).slice(-2) +
                                " " +
                                (" 0" + momentoActual.getHours()).slice(-2) +
                                ":" +
                                ("0" + momentoActual.getMinutes()).slice(-2) +
                                ":" +
                                ("0" + momentoActual.getSeconds()).slice(-2) +
                                "', '" +
                                respuesta.body +
                                "', '" +
                                value +
                                "', '" +
                                momentoActual.getFullYear() +
                                "-" +
                                ("0" + (momentoActual.getMonth() + 1)).slice(-2) +
                                "-" +
                                ("0" + momentoActual.getDate()).slice(-2) +
                                " " +
                                (" 0" + momentoActual.getHours()).slice(-2) +
                                ":" +
                                ("0" + momentoActual.getMinutes()).slice(-2) +
                                ":" +
                                ("0" + momentoActual.getSeconds()).slice(-2) +
                                "')";
                            var insertandoAnulacion = await con.query(insAnulacion);
                            if (insertandoAnulacion) {
                                ///Funcion para crear y guardar DTE firmado y sellado
                                //Agregando sello a objeto json
                                json_anular.sello = value;
                                json_anular.firma = respuesta.body;
                                // 1. Extraer año, mes y día desde fecEmi (Formato esperado: "YYYY-MM-DD")
                                console.log("Se inserto en tabla de anulaciones");
                                const fechaEmi = json_anular.documento.fecEmi;
                                const [anio, mes, dia] = fechaEmi.split("-");
            
                                // 2. Construir la ruta de carpetas dinámicas de forma absoluta
                                const carpetaDestino = path.join(
                                "/srv/http/huella/jsonDTEs",
                                anio,
                                mes,
                                dia,
                                );
            
                                // 3. Crear las carpetas si no existen (recursive: true maneja todo el árbol automáticamente)
                                await fs.mkdir(carpetaDestino, { recursive: true });
            
                                // 4. Definir el nombre del archivo y guardarlo
                                const nombreArchivo = `anulacion-${codigoGeneracion}.json`;
                                const rutaCompletaArchivo = path.join(
                                carpetaDestino,
                                nombreArchivo,
                                );
            
                                await fs.writeFile(
                                rutaCompletaArchivo,
                                JSON.stringify(json_anular, null, 2),
                                "utf8",
                                );
                            }
                            response.json({
                                "selloAnulacion": value
                            });
                        }).catch((err) => {
                            console.log(err);
                            console.log("JsonAnulacion:" + jsonFirmar);
                            response.send(err);
                        })


                    } else {
                        console.log("Rechazado: " + xhr.response);
                        response.send("Error tambien: " + xhr);

                    }
                };
            } catch (error) {
                console.log("Error: " + error.message);
                console.log(json_anular);
                response.status(500);
                response.send("No se parsear json a firmar: " + error.message);
            }
        }

    } catch (e) {
        response.status(500);
        response.send("Error: " + e.message);
        console.log("Error creando json: " + e);
        console.log("Json creado: "+ json_creado);
    }
};

export const methods = {
    getContingencia
}