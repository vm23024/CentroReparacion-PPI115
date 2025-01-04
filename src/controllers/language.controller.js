import {getConnection} from "./../database/database";
const getLanguages = async (request, response) => {
    try{
        const connection= await getConnection();
        const result= await connection.query("SHOW DATABASES");
        
        response.json(result);
    }catch(error){
        response.status(500);
        response.send(error.message);
    }
    
};

//Desde aca tambein se pueden realizar mas meotodos o funciones que nos devuelvan un solo id o un grupo de registros
//Utilizacion del where de la tabla

const getLanguage = async (request, response) => {
    try{
        //Se identifican los parametros enviados por medio de GETS
        const { campoId } = request.params;
        const connection= await getConnection();
        //se realiza la consulta especifica.
        const result= await connection.query("SELECT * FROM tabla WHERE id = ?", campoId);
        response.json(result);
    }catch(error){
        response.status(500);
        response.send(error.message);
    }
    
};

const updateLanguage = async (request, response) => {
    try{
        //Se identifican los parametros enviados por medio de GETS
        const { campoId } = request.params;
        const {valor1, valor2} = req.body;
        const cuerpoCampos = {valor1, valor2};
        if(campoId === undefined || campo1 === undefined || campo2 === undefined){
            response.status(400).json({message: "Datos vacios, favor llenar los datos obligatorios para poder actualizarlos"});
        }
        //Se vuelven a verificar los campos
        const connection= await getConnection();
        //se realiza la consulta especifica.
        const result= await connection.query("UPDATE tabla SET ? WHERE id = ?", [cuerpoCampos, campoId]);
        response.json(result);
    }catch(error){
        response.status(500);
        response.send(error.message);
    }
    
};


//Esta sentencia nos ayudara a recibir parametros con metodo post
const addLanguages = async (request, response) => {
    try{
        //Recibiendo campos enviados por metodo post
        const {campo1, campo2} = request.body;
        //En esta parte se deberia tambien realizar una verificacion de campos para comprobar que los datos que se ingresaran 
        //Esten en base a la estructura de la tabla por ejemplo realizar una verificacion de campos vacios como el siguiente ejemplo:
        if(campo1 === undefined || campo2 === undefined){
            response.status(400).json({message: "Datos vacios, favor llenar los datos obligatorios"});
        }
        //Para insertar mas facil se crea un objeto con el nombre de la tabla y como cuerpo los campos como la siguiente manera
        const tabla = { campo1, campo2 };
        const connection = await getConnection();
        //Para realizar una insercion 
        const result = await connection.query("INSERT INTO tabla SET ?", tabla);
        //El resultado deberia arrojar los siguientes parametros
        //en formato json
        /*
            {
                "fieldContent":  0,
                "affectedRows": numeroFilasAfectadas,
                "insertedId": idRecienInsertado,
                "serverStatus": codigoDeEstadoServidor,
                "warningCount": numeroDeAdvertenciasRetornados,
                "message":  mensajeAdvertencia,
                "protocolo41": true,
                "changedRows": 0
            }
        */
        response.json("agregar lenguaje");
    }catch(error){
        response.status(500);
        response.send(error.message);
    }
    
};

export const methods = {
    getLanguages,
    getLanguage,
    addLanguages
};