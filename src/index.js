import app from "./app";

const main=()=>{
    app.listen(app.get("port"), () => {
        console.log("Servidor levantado en puertos: "+app.get("port"));
        console.log("Base de datos utilizada: "+process.env.DB_HDO);
        console.log("Contraseña: "+process.env.PASSWORD_HDO);
    });
};

main();