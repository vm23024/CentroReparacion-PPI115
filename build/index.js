"use strict";

var _app = _interopRequireDefault(require("./app"));
function _interopRequireDefault(obj) { return obj && obj.__esModule ? obj : { "default": obj }; }
var main = function main() {
  _app["default"].listen(_app["default"].get("port"), function () {
    console.log("Servidor levantado en puerto: " + _app["default"].get("port"));
    console.log("Base de datos utilizada: " + process.env.DB_HDO);
    console.log("Contraseña: " + process.env.PASSWORD_HDO);
  });
};
main();