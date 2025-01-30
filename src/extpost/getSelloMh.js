import { getConnection } from './../database/database';
import { getUrlServicio } from './../extpost/getUrlServicio';

const getSelloMh = async (token,
    dteFirmado,
    ambiente,
    tipoDte,
    codigoControl,
    version,
    codigoGen) => {
    const conexion = await getConnection();
    const url = await getUrlServicio('AUTORIZAR', 'sccsv_2017');
    const urlSello = await getUrlServicio('SELLAR', 'sccsv_2017');
    return new Promise((resolve, reject) => {
        let data = JSON.stringify({
            "ambiente": ambiente,
            "idEnvio": 1,
            "version": parseInt(version),
            "tipoDte": tipoDte,
            "documento": dteFirmado
        });
        var XMLHttpRequest = require("xmlhttprequest").XMLHttpRequest;
        var xhr = new XMLHttpRequest();
        xhr.withCredentials = true;
        xhr.open("POST", urlSello);
        xhr.setRequestHeader("Accept", "application/json");
        xhr.setRequestHeader("Content-Type", "application/json");
        xhr.setRequestHeader("Authorization", token);
        //xhr.responseText = 'json';
        //console.log("Token enviado: "+token);
        xhr.send(data);
        xhr.onload = () => {
            //console.log("Entrando en onload");
            if (xhr.readyState == 4 && xhr.status == 200) {
                let respuesta = JSON.parse(xhr.responseText);
                let fechaProcesado = respuesta.fhProcesamiento.split(' ');
                let fechaHora = fechaProcesado[0].split('/');
                //console.log(xhr.responseText);
                //resolve(xhr.responseText);
                try {
                    if(respuesta.codigoMsg === '095' || respuesta.codigoMsg === '097'){
                        respuesta.estado = 'PENDIENTE';
                    }
                    let actualizar = "UPDATE scc_dtes_creados "
                        + "SET sello_recibido = '" + respuesta.selloRecibido + "'"
                        + ", estado = '" + respuesta.estado + "'"
                        + ", fecha_procesado = '" + fechaHora[2] + "-" + fechaHora[1] + "-" + fechaHora[0] + " " + fechaProcesado[1] + "'"
                        + ", observaciones = 'codigo: " + respuesta.codigoMsg
                        + "\n\rdescripcionMensaje: " + respuesta.descripcionMsg
                        + "\n\robservaciones: " + respuesta.observaciones + "'"
                        + ",firma_recibida = '" + dteFirmado + "'"
                        + " WHERE codigo_generado = '" + codigoGen + "'"
                        + " AND tipo_dte = '" + tipoDte + "'"
                        + " AND codigo_control = '" + codigoControl + "'";
                    let actualizado = conexion.query(actualizar);
                    console.log("Se actualizo: "+respuesta.selloRecibido);
                    resolve(respuesta.selloRecibido);
                } catch (e) {
                    console.log("Respuesta: " + xhr.responseText);
                    reject("Error: " + e);
                    
                }
            } else {
                console.log("Estados readyState: "+xhr.readyState);
                console.log("Estado estatus: "+xhr.responsText);
                if(xhr.readyState === 4 && xhr.status === 400){
                    reject("No se ha podido sellar: "+urlSello);
                }
                
                /*try {
                    let respuesta2 = JSON.parse(xhr.responseText);
                    let fechaProcesado = respuesta2.fhProcesamiento.split(' ');
                    let fechaHora = fechaProcesado[0].split('/');
                    if(respuesta2.codigoMsg === '095' || respuesta2.codigoMsg === '097'){
                        respuesta2.estado = 'PENDIENTE';
                    }
                    let actualizar = "UPDATE scc_dtes_creados "
                        + "SET sello_recibido = '" + respuesta2.selloRecibido + "'"
                        + ", estado = '" + respuesta2.estado + "'"
                        + ", fecha_procesado = '" + fechaHora[2] + "-" + fechaHora[1] + "-" + fechaHora[0] + " " + fechaProcesado[1] + "'"
                        + ", observaciones = 'codigo: " + respuesta2.codigoMsg
                        + "\n\rdescripcionMensaje: " + respuesta2.descripcionMsg
                        + "\n\rObservaciones: " + respuesta2.observaciones + "'"
                        + ", firma_recibida = '" + dteFirmado + "'"
                        + " WHERE codigo_generado = '" + codigoGen + "'"
                        + " AND tipo_dte = '" + tipoDte + "'"
                        + " AND codigo_control = '" + codigoControl + "'";
                    let actualizado = 
                    conexion.query(actualizar, function(error, results){
                        if(error) throw error;
                        console.log("Actualizado: ", results);
                        resolve(respuesta2.estado);
                    });
                    //console.log("Se actualizo en base de datos: " + respuesta2.estado);
                    //console.log("Se actualiza lo rechazado: "+actualizar);
                    
                }catch(e){
                    console.log("Errores de json con token?: "+token);
                    console.log("Objecto de json: "+e);
                    reject("Errores de json: "+xhr.responseText);
                }*/
                
            }
        };

    });
}

module.exports = {
    getSelloMh
};