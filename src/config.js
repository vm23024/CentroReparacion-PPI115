import {config} from "dotenv";
const crypto = require("crypto");
config();
console.log("Usuario: "+process.env.USER_HDO);
console.log("Puerto: "+process.env.PORT_HDO);
export default{
    host: process.env.HOST || "",
    database: process.env.DB_HDO || "",
    user: process.env.USER_HDO || "",
    password: process.env.PASSWORD_HDO || "",
    generarCodigoUid4: () => crypto.randomUUID().toUpperCase(),
    application:{
        cors: {
            server: [
                {
                    origin: "localhost:"+process.env.PORT_HDO,
                    credentials: false
                }
            ]
        }
    }
};
