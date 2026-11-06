"use strict";

function _typeof(o) { "@babel/helpers - typeof"; return _typeof = "function" == typeof Symbol && "symbol" == typeof Symbol.iterator ? function (o) { return typeof o; } : function (o) { return o && "function" == typeof Symbol && o.constructor === Symbol && o !== Symbol.prototype ? "symbol" : typeof o; }, _typeof(o); }
Object.defineProperty(exports, "__esModule", {
  value: true
});
exports.methods = void 0;
var _database = require("../database/database");
var _getTokenMh = require("../extpost/getTokenMh");
var _getAnulacion = require("../extpost/getAnulacion");
var _getUrlServicio = require("../extpost/getUrlServicio");
var _config = _interopRequireDefault(require("../config.js"));
var _fs = require("fs");
var _path = _interopRequireDefault(require("path"));
var _zlib = _interopRequireDefault(require("zlib"));
var _util = require("util");
function _interopRequireDefault(e) { return e && e.__esModule ? e : { "default": e }; }
function _regeneratorRuntime() { "use strict"; /*! regenerator-runtime -- Copyright (c) 2014-present, Facebook, Inc. -- license (MIT): https://github.com/facebook/regenerator/blob/main/LICENSE */ _regeneratorRuntime = function _regeneratorRuntime() { return e; }; var t, e = {}, r = Object.prototype, n = r.hasOwnProperty, o = Object.defineProperty || function (t, e, r) { t[e] = r.value; }, i = "function" == typeof Symbol ? Symbol : {}, a = i.iterator || "@@iterator", c = i.asyncIterator || "@@asyncIterator", u = i.toStringTag || "@@toStringTag"; function define(t, e, r) { return Object.defineProperty(t, e, { value: r, enumerable: !0, configurable: !0, writable: !0 }), t[e]; } try { define({}, ""); } catch (t) { define = function define(t, e, r) { return t[e] = r; }; } function wrap(t, e, r, n) { var i = e && e.prototype instanceof Generator ? e : Generator, a = Object.create(i.prototype), c = new Context(n || []); return o(a, "_invoke", { value: makeInvokeMethod(t, r, c) }), a; } function tryCatch(t, e, r) { try { return { type: "normal", arg: t.call(e, r) }; } catch (t) { return { type: "throw", arg: t }; } } e.wrap = wrap; var h = "suspendedStart", l = "suspendedYield", f = "executing", s = "completed", y = {}; function Generator() {} function GeneratorFunction() {} function GeneratorFunctionPrototype() {} var p = {}; define(p, a, function () { return this; }); var d = Object.getPrototypeOf, v = d && d(d(values([]))); v && v !== r && n.call(v, a) && (p = v); var g = GeneratorFunctionPrototype.prototype = Generator.prototype = Object.create(p); function defineIteratorMethods(t) { ["next", "throw", "return"].forEach(function (e) { define(t, e, function (t) { return this._invoke(e, t); }); }); } function AsyncIterator(t, e) { function invoke(r, o, i, a) { var c = tryCatch(t[r], t, o); if ("throw" !== c.type) { var u = c.arg, h = u.value; return h && "object" == _typeof(h) && n.call(h, "__await") ? e.resolve(h.__await).then(function (t) { invoke("next", t, i, a); }, function (t) { invoke("throw", t, i, a); }) : e.resolve(h).then(function (t) { u.value = t, i(u); }, function (t) { return invoke("throw", t, i, a); }); } a(c.arg); } var r; o(this, "_invoke", { value: function value(t, n) { function callInvokeWithMethodAndArg() { return new e(function (e, r) { invoke(t, n, e, r); }); } return r = r ? r.then(callInvokeWithMethodAndArg, callInvokeWithMethodAndArg) : callInvokeWithMethodAndArg(); } }); } function makeInvokeMethod(e, r, n) { var o = h; return function (i, a) { if (o === f) throw Error("Generator is already running"); if (o === s) { if ("throw" === i) throw a; return { value: t, done: !0 }; } for (n.method = i, n.arg = a;;) { var c = n.delegate; if (c) { var u = maybeInvokeDelegate(c, n); if (u) { if (u === y) continue; return u; } } if ("next" === n.method) n.sent = n._sent = n.arg;else if ("throw" === n.method) { if (o === h) throw o = s, n.arg; n.dispatchException(n.arg); } else "return" === n.method && n.abrupt("return", n.arg); o = f; var p = tryCatch(e, r, n); if ("normal" === p.type) { if (o = n.done ? s : l, p.arg === y) continue; return { value: p.arg, done: n.done }; } "throw" === p.type && (o = s, n.method = "throw", n.arg = p.arg); } }; } function maybeInvokeDelegate(e, r) { var n = r.method, o = e.iterator[n]; if (o === t) return r.delegate = null, "throw" === n && e.iterator["return"] && (r.method = "return", r.arg = t, maybeInvokeDelegate(e, r), "throw" === r.method) || "return" !== n && (r.method = "throw", r.arg = new TypeError("The iterator does not provide a '" + n + "' method")), y; var i = tryCatch(o, e.iterator, r.arg); if ("throw" === i.type) return r.method = "throw", r.arg = i.arg, r.delegate = null, y; var a = i.arg; return a ? a.done ? (r[e.resultName] = a.value, r.next = e.nextLoc, "return" !== r.method && (r.method = "next", r.arg = t), r.delegate = null, y) : a : (r.method = "throw", r.arg = new TypeError("iterator result is not an object"), r.delegate = null, y); } function pushTryEntry(t) { var e = { tryLoc: t[0] }; 1 in t && (e.catchLoc = t[1]), 2 in t && (e.finallyLoc = t[2], e.afterLoc = t[3]), this.tryEntries.push(e); } function resetTryEntry(t) { var e = t.completion || {}; e.type = "normal", delete e.arg, t.completion = e; } function Context(t) { this.tryEntries = [{ tryLoc: "root" }], t.forEach(pushTryEntry, this), this.reset(!0); } function values(e) { if (e || "" === e) { var r = e[a]; if (r) return r.call(e); if ("function" == typeof e.next) return e; if (!isNaN(e.length)) { var o = -1, i = function next() { for (; ++o < e.length;) if (n.call(e, o)) return next.value = e[o], next.done = !1, next; return next.value = t, next.done = !0, next; }; return i.next = i; } } throw new TypeError(_typeof(e) + " is not iterable"); } return GeneratorFunction.prototype = GeneratorFunctionPrototype, o(g, "constructor", { value: GeneratorFunctionPrototype, configurable: !0 }), o(GeneratorFunctionPrototype, "constructor", { value: GeneratorFunction, configurable: !0 }), GeneratorFunction.displayName = define(GeneratorFunctionPrototype, u, "GeneratorFunction"), e.isGeneratorFunction = function (t) { var e = "function" == typeof t && t.constructor; return !!e && (e === GeneratorFunction || "GeneratorFunction" === (e.displayName || e.name)); }, e.mark = function (t) { return Object.setPrototypeOf ? Object.setPrototypeOf(t, GeneratorFunctionPrototype) : (t.__proto__ = GeneratorFunctionPrototype, define(t, u, "GeneratorFunction")), t.prototype = Object.create(g), t; }, e.awrap = function (t) { return { __await: t }; }, defineIteratorMethods(AsyncIterator.prototype), define(AsyncIterator.prototype, c, function () { return this; }), e.AsyncIterator = AsyncIterator, e.async = function (t, r, n, o, i) { void 0 === i && (i = Promise); var a = new AsyncIterator(wrap(t, r, n, o), i); return e.isGeneratorFunction(r) ? a : a.next().then(function (t) { return t.done ? t.value : a.next(); }); }, defineIteratorMethods(g), define(g, u, "Generator"), define(g, a, function () { return this; }), define(g, "toString", function () { return "[object Generator]"; }), e.keys = function (t) { var e = Object(t), r = []; for (var n in e) r.push(n); return r.reverse(), function next() { for (; r.length;) { var t = r.pop(); if (t in e) return next.value = t, next.done = !1, next; } return next.done = !0, next; }; }, e.values = values, Context.prototype = { constructor: Context, reset: function reset(e) { if (this.prev = 0, this.next = 0, this.sent = this._sent = t, this.done = !1, this.delegate = null, this.method = "next", this.arg = t, this.tryEntries.forEach(resetTryEntry), !e) for (var r in this) "t" === r.charAt(0) && n.call(this, r) && !isNaN(+r.slice(1)) && (this[r] = t); }, stop: function stop() { this.done = !0; var t = this.tryEntries[0].completion; if ("throw" === t.type) throw t.arg; return this.rval; }, dispatchException: function dispatchException(e) { if (this.done) throw e; var r = this; function handle(n, o) { return a.type = "throw", a.arg = e, r.next = n, o && (r.method = "next", r.arg = t), !!o; } for (var o = this.tryEntries.length - 1; o >= 0; --o) { var i = this.tryEntries[o], a = i.completion; if ("root" === i.tryLoc) return handle("end"); if (i.tryLoc <= this.prev) { var c = n.call(i, "catchLoc"), u = n.call(i, "finallyLoc"); if (c && u) { if (this.prev < i.catchLoc) return handle(i.catchLoc, !0); if (this.prev < i.finallyLoc) return handle(i.finallyLoc); } else if (c) { if (this.prev < i.catchLoc) return handle(i.catchLoc, !0); } else { if (!u) throw Error("try statement without catch or finally"); if (this.prev < i.finallyLoc) return handle(i.finallyLoc); } } } }, abrupt: function abrupt(t, e) { for (var r = this.tryEntries.length - 1; r >= 0; --r) { var o = this.tryEntries[r]; if (o.tryLoc <= this.prev && n.call(o, "finallyLoc") && this.prev < o.finallyLoc) { var i = o; break; } } i && ("break" === t || "continue" === t) && i.tryLoc <= e && e <= i.finallyLoc && (i = null); var a = i ? i.completion : {}; return a.type = t, a.arg = e, i ? (this.method = "next", this.next = i.finallyLoc, y) : this.complete(a); }, complete: function complete(t, e) { if ("throw" === t.type) throw t.arg; return "break" === t.type || "continue" === t.type ? this.next = t.arg : "return" === t.type ? (this.rval = this.arg = t.arg, this.method = "return", this.next = "end") : "normal" === t.type && e && (this.next = e), y; }, finish: function finish(t) { for (var e = this.tryEntries.length - 1; e >= 0; --e) { var r = this.tryEntries[e]; if (r.finallyLoc === t) return this.complete(r.completion, r.afterLoc), resetTryEntry(r), y; } }, "catch": function _catch(t) { for (var e = this.tryEntries.length - 1; e >= 0; --e) { var r = this.tryEntries[e]; if (r.tryLoc === t) { var n = r.completion; if ("throw" === n.type) { var o = n.arg; resetTryEntry(r); } return o; } } throw Error("illegal catch attempt"); }, delegateYield: function delegateYield(e, r, n) { return this.delegate = { iterator: values(e), resultName: r, nextLoc: n }, "next" === this.method && (this.arg = t), y; } }, e; }
function _slicedToArray(r, e) { return _arrayWithHoles(r) || _iterableToArrayLimit(r, e) || _unsupportedIterableToArray(r, e) || _nonIterableRest(); }
function _nonIterableRest() { throw new TypeError("Invalid attempt to destructure non-iterable instance.\nIn order to be iterable, non-array objects must have a [Symbol.iterator]() method."); }
function _unsupportedIterableToArray(r, a) { if (r) { if ("string" == typeof r) return _arrayLikeToArray(r, a); var t = {}.toString.call(r).slice(8, -1); return "Object" === t && r.constructor && (t = r.constructor.name), "Map" === t || "Set" === t ? Array.from(r) : "Arguments" === t || /^(?:Ui|I)nt(?:8|16|32)(?:Clamped)?Array$/.test(t) ? _arrayLikeToArray(r, a) : void 0; } }
function _arrayLikeToArray(r, a) { (null == a || a > r.length) && (a = r.length); for (var e = 0, n = Array(a); e < a; e++) n[e] = r[e]; return n; }
function _iterableToArrayLimit(r, l) { var t = null == r ? null : "undefined" != typeof Symbol && r[Symbol.iterator] || r["@@iterator"]; if (null != t) { var e, n, i, u, a = [], f = !0, o = !1; try { if (i = (t = t.call(r)).next, 0 === l) { if (Object(t) !== t) return; f = !1; } else for (; !(f = (e = i.call(t)).done) && (a.push(e.value), a.length !== l); f = !0); } catch (r) { o = !0, n = r; } finally { try { if (!f && null != t["return"] && (u = t["return"](), Object(u) !== u)) return; } finally { if (o) throw n; } } return a; } }
function _arrayWithHoles(r) { if (Array.isArray(r)) return r; }
function asyncGeneratorStep(n, t, e, r, o, a, c) { try { var i = n[a](c), u = i.value; } catch (n) { return void e(n); } i.done ? t(u) : Promise.resolve(u).then(r, o); }
function _asyncToGenerator(n) { return function () { var t = this, e = arguments; return new Promise(function (r, o) { var a = n.apply(t, e); function _next(n) { asyncGeneratorStep(a, r, o, _next, _throw, "next", n); } function _throw(n) { asyncGeneratorStep(a, r, o, _next, _throw, "throw", n); } _next(void 0); }); }; }
// Convertir funciones zlib basadas en callbacks a Promesas
var gunzip = (0, _util.promisify)(_zlib["default"].gunzip);
var gzip = (0, _util.promisify)(_zlib["default"].gzip);
var getContingencia = /*#__PURE__*/function () {
  var _ref = _asyncToGenerator(/*#__PURE__*/_regeneratorRuntime().mark(function _callee2(request, response) {
    var _json_creado$receptor, _json_creado$receptor2, solicitados, con, fecha_token, token, urlFirma, sqlDte, resultado, fechaEmisonOriginal, anio, mes, diaLimpio, carpetaDestino, bufferComprimido, bufferDescomprimido, contenidoTexto, json_creado, codigoGeneracion, momentoActual, json_anular, sqlCredenciales, credenciales, jsonFirmar, data, XMLHttpRequest, xhr;
    return _regeneratorRuntime().wrap(function _callee2$(_context2) {
      while (1) switch (_context2.prev = _context2.next) {
        case 0:
          _context2.prev = 0;
          //Leyendo parametros enviados por get
          solicitados = request.query; //console.log("Parametros: "+solicitados.codigo_generado);
          //Seteando conexion a la base de datos
          _context2.next = 4;
          return (0, _database.getConnection)();
        case 4:
          con = _context2.sent;
          //Fecha para solicitar o consultar el token a utilizar
          fecha_token = new Date(); //console.log("Hora tokan: "+("0" + fecha_token.getHours()).slice(-2) + ":" + ("0" + fecha_token.getMinutes()).slice(-2) + ":" + ("0" + fecha_token.getSeconds()).slice(-2));
          //Solicitando token
          _context2.next = 8;
          return (0, _getTokenMh.getTokenMh)(fecha_token.getFullYear() + "-" + (fecha_token.getMonth() + 1) + "-" + fecha_token.getDate());
        case 8:
          token = _context2.sent;
          _context2.next = 11;
          return (0, _getUrlServicio.getUrlServicio)("FIRMAR", "sccsv_2017");
        case 11:
          urlFirma = _context2.sent;
          //Consulta para extraer firma de dte a invalidar
          sqlDte = "SELECT codigo_generado," + "codigo_control," + "tipo_dte," + "fecha_emision, " + "IFNULL(tipo_dte, '" + solicitados.tipo_dte + "') AS tipo_dte, " + "sello_recibido " + "FROM scc_dtes_creados " + "WHERE codigo_generado = '" + solicitados.codigo_generado + "' " + "AND codigo_control = '" + solicitados.codigo_control + "' " + "AND tipo_dte = '" + solicitados.tipo_dte + "'"; //console.log("Sql: " + sqlDte);
          //Ejecutando query
          _context2.next = 15;
          return con.query(sqlDte);
        case 15:
          resultado = _context2.sent;
          fechaEmisonOriginal = new Date(resultado[0].fecha_emision); // 3. Extraer los componentes de la fecha de forma segura y limpia
          anio = fechaEmisonOriginal.getFullYear().toString(); // El mes inicia en 0 (Enero), sumamos 1 y aseguramos los dos dígitos (ej: "07")
          mes = ("0" + (fechaEmisonOriginal.getMonth() + 1)).slice(-2); // Aseguramos los dos dígitos para el día (ej: "25")
          diaLimpio = ("0" + fechaEmisonOriginal.getDate()).slice(-2); // 4. Construir la ruta exacta del archivo generado por PHP en Linux
          carpetaDestino = _path["default"].join("/srv/http/huella/jsonDTEs", anio, mes, diaLimpio, "".concat(solicitados.codigo_generado, ".json.gz")); // 1. Leer el archivo binario comprimido de PHP utilizando await de forma segura
          _context2.next = 23;
          return _fs.promises.readFile(carpetaDestino);
        case 23:
          bufferComprimido = _context2.sent;
          _context2.next = 26;
          return gunzip(bufferComprimido);
        case 26:
          bufferDescomprimido = _context2.sent;
          contenidoTexto = bufferDescomprimido.toString('utf-8');
          json_creado = JSON.parse(contenidoTexto);
          codigoGeneracion = _config["default"].generarCodigoUid4();
          if (solicitados.tipo_dte === "03") {
            json_creado.receptor.tipoDocumento = "36";
            json_creado.receptor.numDocumento = json_creado.receptor.nit;
          }
          if (solicitados.tipo_dte === "14") {
            json_creado.receptor = json_creado.sujetoExcluido;
            json_creado.emisor.nomEstablecimiento = json_creado.emisor.nombre;
            json_creado.emisor.tipoEstablecimiento = "02";
          }
          if (json_creado.receptor == null) {
            json_creado.receptor = {
              tipoDocumento: null,
              numDocumento: null,
              nombre: null
            };
          }
          momentoActual = new Date();
          json_anular = {
            identificacion: {
              fecAnula: momentoActual.getFullYear() + "-" + ("0" + (momentoActual.getMonth() + 1)).slice(-2) + "-" + ("0" + momentoActual.getDate()).slice(-2),
              horAnula: ("0" + momentoActual.getHours()).slice(-2) + ":" + ("0" + momentoActual.getMinutes()).slice(-2) + ":" + ("0" + momentoActual.getSeconds()).slice(-2),
              version: 2,
              ambiente: json_creado.identificacion.ambiente,
              codigoGeneracion: codigoGeneracion
            },
            emisor: {
              nit: json_creado.emisor.nit,
              nombre: json_creado.emisor.nombre,
              tipoEstablecimiento: json_creado.emisor.tipoEstablecimiento,
              telefono: json_creado.emisor.telefono.replace("-", ""),
              correo: json_creado.emisor.correo,
              codEstable: json_creado.emisor.codEstable,
              codPuntoVenta: json_creado.emisor.codPuntoVenta,
              nomEstablecimiento: json_creado.emisor.nombre
            },
            documento: {
              tipoDte: json_creado.identificacion.tipoDte,
              codigoGeneracion: json_creado.identificacion.codigoGeneracion,
              codigoGeneracionR: null,
              tipoDocumento: json_creado.receptor.tipoDocumento,
              numDocumento: json_creado.receptor.numDocumento,
              nombre: json_creado.receptor.nombre,
              selloRecibido: resultado[0].sello_recibido,
              numeroControl: json_creado.identificacion.numeroControl,
              fecEmi: json_creado.identificacion.fecEmi,
              montoIva: parseFloat(json_creado.resumen.totalIva),
              correo: (_json_creado$receptor = json_creado.receptor.correo) !== null && _json_creado$receptor !== void 0 ? _json_creado$receptor : null,
              telefono: (_json_creado$receptor2 = json_creado.receptor.telefono) !== null && _json_creado$receptor2 !== void 0 ? _json_creado$receptor2 : null
            },
            motivo: {
              tipoAnulacion: 2,
              motivoAnulacion: decodeURIComponent(solicitados.motivo),
              nombreResponsable: decodeURIComponent(solicitados.nombre),
              tipDocResponsable: "37",
              numDocResponsable: json_creado.emisor.nit,
              nombreSolicita: json_creado.emisor.nombre,
              tipDocSolicita: "37",
              numDocSolicita: json_creado.emisor.nit
            }
          };
          if (!(token != "")) {
            _context2.next = 41;
            break;
          }
          //Solicitar credenciales
          sqlCredenciales = "SELECT nit, " + "password_privado AS psw " + "FROM empresas.sccsv_2017" +
          //+ process.env.DB_PRESTAN
          " WHERE nombre_db = 'sccsv_2017'"; // + process.env.DB_PRESTAN + "'";
          _context2.next = 39;
          return con.query(sqlCredenciales);
        case 39:
          credenciales = _context2.sent;
          try {
            jsonFirmar = json_anular;
            data = JSON.stringify({
              nit: credenciales[0].nit,
              passwordPri: credenciales[0].psw,
              activo: true,
              dteJson: jsonFirmar
            });
            XMLHttpRequest = require("xmlhttprequest").XMLHttpRequest;
            xhr = new XMLHttpRequest();
            xhr.withCredentials = true;
            xhr.open("POST", urlFirma);
            xhr.setRequestHeader("Accept", "application/json");
            xhr.setRequestHeader("Content-Type", "application/json");
            //xhr.responseText = 'json';
            //console.log("Token enviado: "+token);
            xhr.send(data);
            xhr.onload = function () {
              //console.log("Entrando en onload");
              if (xhr.readyState == 4 && xhr.status == 200) {
                var respuesta = JSON.parse(xhr.responseText);

                //console.log("JSON:"+JSON.stringify(jsonFirmar));
                //response.json(respuesta);
                /* let fechaProcesado = respuesta.fhProcesamiento.split(' ');
                             let fechaHora = fechaProcesado[0].split('/');*/

                var anulacion = (0, _getAnulacion.getAnulacion)(token, respuesta.body, jsonFirmar.identificacion.ambiente, solicitados.tipo_dte, solicitados.codigo_control, jsonFirmar.identificacion.version, solicitados.codigo_generado, codigoGeneracion);
                anulacion.then(/*#__PURE__*/function () {
                  var _ref2 = _asyncToGenerator(/*#__PURE__*/_regeneratorRuntime().mark(function _callee(value) {
                    var insAnulacion, insertandoAnulacion, fechaEmi, _fechaEmi$split, _fechaEmi$split2, _anio, _mes, dia, _carpetaDestino, nombreArchivo, rutaCompletaArchivo;
                    return _regeneratorRuntime().wrap(function _callee$(_context) {
                      while (1) switch (_context.prev = _context.next) {
                        case 0:
                          //Insercion y creacion de DTE
                          //Insertar fila en registro de anulaciones
                          insAnulacion = "INSERT INTO " + "scc_dtes_anulados(" + "codG_anulacion, " + "codG_factura, " + "codC_factura, " + "tipoDte_factura, " + "motivo, " + "createdBy, " + "createdDate, " + "firma, " + "sello_anulacion, " + "fecha_procesado) " + "VALUES('" + codigoGeneracion + "','" + solicitados.codigo_generado + "', '" + solicitados.codigo_control + "', '" + solicitados.tipo_dte + "','" + decodeURIComponent(solicitados.motivo) + "', '" + decodeURIComponent(solicitados.nombre) + "', '" + momentoActual.getFullYear() + "-" + ("0" + (momentoActual.getMonth() + 1)).slice(-2) + "-" + ("0" + momentoActual.getDate()).slice(-2) + " " + (" 0" + momentoActual.getHours()).slice(-2) + ":" + ("0" + momentoActual.getMinutes()).slice(-2) + ":" + ("0" + momentoActual.getSeconds()).slice(-2) + "', '" + respuesta.body + "', '" + value + "', '" + momentoActual.getFullYear() + "-" + ("0" + (momentoActual.getMonth() + 1)).slice(-2) + "-" + ("0" + momentoActual.getDate()).slice(-2) + " " + (" 0" + momentoActual.getHours()).slice(-2) + ":" + ("0" + momentoActual.getMinutes()).slice(-2) + ":" + ("0" + momentoActual.getSeconds()).slice(-2) + "')";
                          _context.next = 3;
                          return con.query(insAnulacion);
                        case 3:
                          insertandoAnulacion = _context.sent;
                          if (!insertandoAnulacion) {
                            _context.next = 18;
                            break;
                          }
                          //Funcion para crear y guardar DTE firmado y sellado
                          //Agregando sello a objeto json
                          json_anular.sello = value;
                          json_anular.firma = respuesta.body;
                          // 1. Extraer año, mes y día desde fecEmi (Formato esperado: "YYYY-MM-DD")
                          console.log("Se inserto en tabla de anulaciones");
                          fechaEmi = json_anular.documento.fecEmi;
                          _fechaEmi$split = fechaEmi.split("-"), _fechaEmi$split2 = _slicedToArray(_fechaEmi$split, 3), _anio = _fechaEmi$split2[0], _mes = _fechaEmi$split2[1], dia = _fechaEmi$split2[2]; // 2. Construir la ruta de carpetas dinámicas de forma absoluta
                          _carpetaDestino = _path["default"].join("/srv/http/huella/jsonDTEs", _anio, _mes, dia); // 3. Crear las carpetas si no existen (recursive: true maneja todo el árbol automáticamente)
                          _context.next = 13;
                          return _fs.promises.mkdir(_carpetaDestino, {
                            recursive: true
                          });
                        case 13:
                          // 4. Definir el nombre del archivo y guardarlo
                          nombreArchivo = "anulacion-".concat(codigoGeneracion, ".json");
                          rutaCompletaArchivo = _path["default"].join(_carpetaDestino, nombreArchivo);
                          _context.next = 17;
                          return _fs.promises.writeFile(rutaCompletaArchivo, JSON.stringify(json_anular, null, 2), "utf8");
                        case 17:
                          console.log("Se registro archivo anulacion");
                        case 18:
                          response.json({
                            selloAnulacion: value
                          });
                        case 19:
                        case "end":
                          return _context.stop();
                      }
                    }, _callee);
                  }));
                  return function (_x3) {
                    return _ref2.apply(this, arguments);
                  };
                }())["catch"](function (err) {
                  console.log(err);
                  console.log("JsonAnulacion:", jsonFirmar);
                  response.send(err);
                });
              } else {
                console.log("Rechazado: " + xhr.response);
                response.send("Error tambien: " + xhr);
              }
            };
          } catch (error) {
            console.log("Error: " + error.message);
            console.log(json_anular);
            response.status(500);
            response.send("No se parsear json a firmar: " + error.message);
          }
        case 41:
          _context2.next = 49;
          break;
        case 43:
          _context2.prev = 43;
          _context2.t0 = _context2["catch"](0);
          response.status(500);
          response.send("Error: " + _context2.t0.message);
          console.log("Error creando json: " + _context2.t0);
          console.log("Json creado: " + json_creado);
        case 49:
        case "end":
          return _context2.stop();
      }
    }, _callee2, null, [[0, 43]]);
  }));
  return function getContingencia(_x, _x2) {
    return _ref.apply(this, arguments);
  };
}();
var methods = exports.methods = {
  getContingencia: getContingencia
};