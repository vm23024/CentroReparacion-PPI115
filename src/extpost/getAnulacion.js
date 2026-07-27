import { getConnection } from './../database/database';
import { getUrlServicio } from './../extpost/getUrlServicio';

const getAnulacion = async (token,
    dteFirmado,
    ambiente,
    tipoDte,
    codigoControl,
    version,
    codigoGen,
    codAnulacion) => {
    const conexion = await getConnection();
    //const url = await getUrlServicio('AUTORIZAR', 'sccsv_2017');
    const urlAnular = await getUrlServicio('ANULAR', 'sccsv_2017');
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
        xhr.open("POST", urlAnular);
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
                    
                    let actualizar = "UPDATE scc_dtes_creados "
                        + "SET estado = CONCAT(estado, '(Anulado)')"
                        + ", observaciones = CONCAT(observaciones, 'Anulacion procesada con sello: "
                        + respuesta.selloRecibido+ " \t\r"
                        + "con fecha: "+ fechaHora[2] + "-" + fechaHora[1] + "-" + fechaHora[0] + " " + fechaProcesado[1] + "\n "
                        + "codigo generacion anulacion: "+codAnulacion+"')"
                        + " WHERE codigo_generado = '" + codigoGen + "'"
                        + " AND tipo_dte = '" + tipoDte + "'"
                        + " AND codigo_control = '" + codigoControl + "'";
                    let actualizado = conexion.query(actualizar);
                    //console.log("Se anulo con sello: " + respuesta.selloRecibido);
                    resolve(respuesta.selloRecibido);
                } catch (e) {
                    console.log("No se logro anular: " + xhr.responseText);
                    reject("Error: " + e);

                }
            } else {
                console.log("Parametros rechazados para anular: " + dteFirmado);
                console.log("Estado estatus: " + xhr.responsText);
                reject("No se proceso la anulacion: " + urlAnular);

            }
        };

    });
}

module.exports = {
    getAnulacion
};