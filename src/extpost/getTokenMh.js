import { getConnection } from './../database/database';
//import { getUrlServicio } from './getUrlServicio'; 

const getTokenMh = async (fecha) => {
    const conexion = await getConnection();
    const urlAutorizar = "https://api.dtes.mh.gob.sv/seguridad/auth";//await getUrlServicio('AUTORIZAR');
    return new Promise((resolve, reject) => {
        let token; //variable que retornara el token solicitado

        //Buscar token del dia indicado
        var fechaBs = new Date();//Objeto fecha
        /*if (fecha === "" || fecha === undefined) {//Si la variable fecha viene vacia
            fechaBs = new Date();//Se captura el dia en curso
            //console.log("No se tiene fecha: "+fecha);
        } else {
            fechaBs = new Date(fecha + ' 00:00:00');//Se crea un nuevo objeto fecha con la fecha indicada
            //console.log("Se tiene fecha: "+ fechaBs);
        }*/

        let sql = "SELECT token_creado, "
            + "fecha_hora "
            + "FROM scc_tokens_mh "
            + "WHERE fecha_hora = '" + fechaBs.getFullYear() + "-" + ("0" + (fechaBs.getMonth() + 1)).slice(-2) + "-"
            + ("0" + fechaBs.getDate()).slice(-2) + "'";//Consultar token antes de solicitar uno nuevo
            //console.log("Token a extraer: "+sql);
        conexion.query(sql, (err, rows, fields) => {
            if (!err) {
                /*var filas = json(rows);
                token = filas.token_creado;*/
                if (rows.length > 0) {
                    //console.log("Setear el token: " + rows[0].token_creado);
                    token = rows[0].token_creado;
                    resolve(token);
                    //return token;
                } else {
                    //console.log("Solicitar token y guardarlo");
                    console.log("No tengo credencial, sacando nueva");
                    let sqlCredenciales = "SELECT nit, "
                        + "password_acceso_mh "
                        + "FROM empresas.sccsv_2017" //+ process.env.DB_PRESTAN
                        + " WHERE nombre_db = 'sccsv_2017'" //+ process.env.DB_PRESTAN + "'";
                    conexion.query(sqlCredenciales, (err, rows, fields) => {
                        //Extrayendo credenciales para solicitar nuevo token
                        if (!err) {//Si la consulta no arroja errores
                            //console.log("Solicitar nuevo token");
                            let usuario = rows[0].nit;//seteando usuario del ministerio de hacienda
                            let passwd = rows[0].password_acceso_mh;//
                            //Solicitar nuevo token
                            var XMLHttpRequest = require("xmlhttprequest").XMLHttpRequest;
                            var data = "";

                            var xhr = new XMLHttpRequest();
                            xhr.withCredentials = true;

                            //console.log("Url: " + urlAutorizar);
                            xhr.open("POST", "https://api.dtes.mh.gob.sv/seguridad/auth?user=" + usuario + "&pwd=" + passwd);
                            xhr.setRequestHeader("user", usuario);
                            xhr.setRequestHeader("pwd", passwd);
                            xhr.responseType = 'json';
                            xhr.send();
                            xhr.onload = () => {
                                if (xhr.readyState == 4 && xhr.status == 200) {
                                    // console.log(JSON.parse(xhr.responseText)) ;
                                    let respuesta = JSON.parse(xhr.responseText)
                                    if (respuesta.body.token !== '') {
                                        //let fechaCreacion = Date.now();
                                        try {
                                            let insrNuevoToken = "INSERT INTO scc_tokens_mh "
                                                + "VALUES('" + fechaBs.getFullYear() + "-" + ("0" + (fechaBs.getMonth() + 1)).slice(-2) + "-" + ("0" + fechaBs.getDate()).slice(-2) + "', "
                                                + "'" + fechaBs.getHours() + ":" + fechaBs.getMinutes() + ":" + fechaBs.getSeconds() + "', "
                                                + "'" + respuesta.body.token + "')";
                                            let insertado = conexion.query(insrNuevoToken,function(error, results){
                                                if(error){
                                                    reject(error);
                                                    throw error;
                                                }else{
                                                    token = respuesta.body.token;
                                                    resolve(token);
                                                } 

                                            });
                                            
                                            /*insertado.then(respuesta => {
                                                console.log("Error insertado: "+respuesta);
                                            });*/
                                            //console.log(insrNuevoToken);
                                            //token = respuesta.body.token;

                                        }
                                        catch (er) {
                                            reject(er);
                                            console.log("Error guardando: " + er);
                                        }

                                    }
                                    token = respuesta.body.token;
                                    resolve(token);

                                } else {
                                    console.log(`Error no regresaron token: ${xhr.status}`);
                                }
                            }
                            xhr.onerror = (e) => {
                                console.log("Error en guardado de token 1:"+ xhr.statusText);
                                reject("Error guardado 1: "+e);
                            };



                        } else {
                            console.log("Error al extraer credenciales 1: " + err);
                            console.log(sqlCredenciales);
                            reject("Error: " + err);
                        }
                    });
                    //Solicitando nuevo token al MH
                    /*
                    
                    */
                }
            } else {
                //Volver a solicitar token
                let sqlCredenciales = "SELECT nit, "
                    + "password_acceso_mh "
                    + "FROM empresas.sccsv_2017" //+ process.env.DB_PRESTAN
                    + " WHERE nombre_db = 'sccsv_2017'" //+ process.env.DB_PRESTAN + "'";
                conexion.query(sqlCredenciales, (err, rows, fields) => {
                    //Extrayendo credenciales para solicitar nuevo token
                    if (!err) {//Si la consulta no arroja errores
                        //console.log("Solicitar nuevo token");
                        let usuario = rows[0].nit;//seteando usuario del ministerio de hacienda
                        let passwd = rows[0].password_acceso_mh;//
                        //Solicitar nuevo token
                        var XMLHttpRequest = require("xmlhttprequest").XMLHttpRequest;
                        var data = "";

                        var xhr = new XMLHttpRequest();
                        xhr.withCredentials = true;

                        console.log("Url: " + urlAutorizar);
                        xhr.open("POST", "https://api.dtes.mh.gob.sv/seguridad/auth?user=" + usuario + "&pwd=" + passwd);
                        xhr.setRequestHeader("user", usuario);
                        xhr.setRequestHeader("pwd", passwd);
                        xhr.responseType = 'json';
                        xhr.send();
                        xhr.onload = () => {
                            if (xhr.readyState == 4 && xhr.status == 200) {
                                // console.log(JSON.parse(xhr.responseText)) ;
                                let respuesta = JSON.parse(xhr.responseText)
                                if (respuesta.body.token !== '') {
                                    //let fechaCreacion = Date.now();
                                    try {
                                        let insrNuevoToken = "INSERT INTO scc_tokens_mh "
                                            + "VALUES('" + fechaBs.getFullYear() + "-" + ("0" + (fechaBs.getMonth() + 1)).slice(-2) + "-" + ("0" + fechaBs.getDate()).slice(-2) + "', "
                                            + "'" + fechaBs.getHours() + ":" + fechaBs.getMinutes() + ":" + fechaBs.getSeconds() + "', "
                                            + "'" + respuesta.body.token + "')";
                                        let insertado = conexion.query(insrNuevoToken);
                                        token = respuesta.body.token;
                                        resolve(token);
                                        /*insertado.then(respuesta => {
                                            console.log("Error insertado: "+respuesta);
                                        });*/
                                        //console.log(insrNuevoToken);
                                        //token = respuesta.body.token;

                                    }
                                    catch (er) {
                                        reject(er);
                                        console.log("Error guardando 2: " + er);
                                        //return "";
                                    }

                                }
                                token = respuesta.body.token;
                                resolve(token);

                            } else {
                                console.log(`Error no regresaron token 2: ${xhr.status}`);
                                reject("No se obtuvo token 2");
                            }
                        }
                        xhr.onerror = (e) => {
                            console.log("Error de insertado: "+xhr.statusText);
                            reject("No se logro guardar el token 2: ");
                        };



                    } else {
                        console.log("Error al extraer credenciales 2: " + err);
                        console.log("Objeto conexion: "+ Object.keys(conexion));
                        console.log("Valores de objeto: " + Object.values(conexion));
                        //console.log("SQL credenciales 2: "+sqlCredenciales);
                        //return "";
                        reject("Error: " + err);
                    }
                });
            }
        });
        /*conexion.end((error) => {
            if(error){
                console.log('Error cerrando conexion: '+error);
                return;
            }
        });*/
    });

    //console.log(result);


    //return token;

};

module.exports = {
    getTokenMh
};
