import { getConnection } from './../database/database';

const getUrlServicio = async (tipoApi) => {
    const conn = await getConnection();
    return new Promise((resolve, reject) => {
        var sql = "SELECT CONCAT(CONCAT(id_protocolo,'://'), id_mh_api) AS url "
            + "FROM scc_mh_apis WHERE id_mh_tipo_api = '" + tipoApi + "'";
        conn.query(sql, (err, rows, fields) => {
            if (!err) {
                if (rows.length > 0) {
                    resolve(rows[0].url);
                }
            } else {
                console.log("error :" + err);
                console.log(sql);
                reject("error :" + err);
            }
        });
    });
}

module.export = {
    getUrlServicio
};