import {config} from "dotenv";
config();
console.log("Usuario: "+process.env.USER_HDO);
export default{
    host: process.env.HOST || "",
    database: process.env.DB_HDO || "",
    user: process.env.USER_HDO || "",
    password: process.env.PASSWORD_HDO || "",
    application:{
        cors: {
            server: [
                {
                    origin: "localhost:"+process.env.PORT,
                    credentials: false
                }
            ]
        }
    }
};
