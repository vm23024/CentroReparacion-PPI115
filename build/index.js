"use strict";

var _app = _interopRequireDefault(require("./app"));
function _interopRequireDefault(e) { return e && e.__esModule ? e : { "default": e }; }
var main = function main() {
  _app["default"].listen(_app["default"].get("port"), function () {
    console.log("Servidor levantado en puertos: " + _app["default"].get("port"));
    console.log("Base de datos utilizada: " + process.env.DB_HDO);
    console.log("Contraseña: " + process.env.PASSWORD_HDO);
  });
};
main();