"use strict";

var _promiseMysql = _interopRequireDefault(require("promise-mysql"));
var _config = _interopRequireDefault(require("./../config"));
function _interopRequireDefault(e) { return e && e.__esModule ? e : { "default": e }; }
var connection = _promiseMysql["default"].createConnection({
  host: _config["default"].host,
  database: _config["default"].database,
  user: _config["default"].user,
  password: _config["default"].password
});
var getConnection = function getConnection() {
  return connection;
};
module.exports = {
  getConnection: getConnection
};