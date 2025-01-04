import {getConnection} from '../database/database';
import { getTokenMh } from '../extpost/getTokenMh';

const getStatusApi = async (request, response) => {
    try{
        const conection = await getConnection();
        var tokenDia = await getTokenMh('fecha');
        response.json("Corriendo!!!!");
        //console.log("Token obtenido: "+tokenDia);
        //console.log("Conexion: "+Object.keys(conection.connection));
        //console.log("Valores: "+Object.values(conection.connection));
        
        
    }catch(e){
        response.status(500);
        response.send("Algo no corre bien: "+e.message);
    }
}

export const methods = {
    getStatusApi
};