"use strict";

Object.defineProperty(exports, "__esModule", {
  value: true
});
exports["default"] = void 0;
var _express = _interopRequireDefault(require("express"));
var _morgan = _interopRequireDefault(require("morgan"));
var _cors = _interopRequireDefault(require("cors"));
var _language = _interopRequireDefault(require("./routes/language.routes"));
var _dtes = _interopRequireDefault(require("./routes/dtes.routes"));
var _status = _interopRequireDefault(require("./routes/status.routes"));
var _contingenciaDte = _interopRequireDefault(require("./routes/contingenciaDte.routes"));
var _dteFirmar = _interopRequireDefault(require("./routes/dteFirmar.routes"));
var _consultaDteReporte = _interopRequireDefault(require("./routes/consultaDteReporte.routes"));
function _interopRequireDefault(e) { return e && e.__esModule ? e : { "default": e }; }
var config = {
  application: {
    cors: {
      server: [{
        origin: "*",
        credentials: false
      }]
    }
  }
};
var app = (0, _express["default"])();
var PORT = 4002;
app.set("port", PORT);
app.use((0, _morgan["default"])("dev"));
app.use(_express["default"].json());
app.use((0, _cors["default"])(config.application.cors.server));
app.use("/api/languages", _language["default"]);
app.use("/api/dtes", _dtes["default"]);
app.use("/api/statusApi", _status["default"]);
app.use("/api/contingenciaAnular", _contingenciaDte["default"]);
app.use("/api/dteFirma", _dteFirmar["default"]);
app.use("/api/consultarDte", _consultaDteReporte["default"]);
var _default = exports["default"] = app;