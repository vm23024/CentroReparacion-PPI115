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
function _regeneratorRuntime() { "use strict"; /*! regenerator-runtime -- Copyright (c) 2014-present, Facebook, Inc. -- license (MIT): https://github.com/facebook/regenerator/blob/main/LICENSE */ _regeneratorRuntime = function _regeneratorRuntime() { return e; }; var t, e = {}, r = Object.prototype, n = r.hasOwnProperty, o = Object.defineProperty || function (t, e, r) { t[e] = r.value; }, i = "function" == typeof Symbol ? Symbol : {}, a = i.iterator || "@@iterator", c = i.asyncIterator || "@@asyncIterator", u = i.toStringTag || "@@toStringTag"; function define(t, e, r) { return Object.defineProperty(t, e, { value: r, enumerable: !0, configurable: !0, writable: !0 }), t[e]; } try { define({}, ""); } catch (t) { define = function define(t, e, r) { return t[e] = r; }; } function wrap(t, e, r, n) { var i = e && e.prototype instanceof Generator ? e : Generator, a = Object.create(i.prototype), c = new Context(n || []); return o(a, "_invoke", { value: makeInvokeMethod(t, r, c) }), a; } function tryCatch(t, e, r) { try { return { type: "normal", arg: t.call(e, r) }; } catch (t) { return { type: "throw", arg: t }; } } e.wrap = wrap; var h = "suspendedStart", l = "suspendedYield", f = "executing", s = "completed", y = {}; function Generator() {} function GeneratorFunction() {} function GeneratorFunctionPrototype() {} var p = {}; define(p, a, function () { return this; }); var d = Object.getPrototypeOf, v = d && d(d(values([]))); v && v !== r && n.call(v, a) && (p = v); var g = GeneratorFunctionPrototype.prototype = Generator.prototype = Object.create(p); function defineIteratorMethods(t) { ["next", "throw", "return"].forEach(function (e) { define(t, e, function (t) { return this._invoke(e, t); }); }); } function AsyncIterator(t, e) { function invoke(r, o, i, a) { var c = tryCatch(t[r], t, o); if ("throw" !== c.type) { var u = c.arg, h = u.value; return h && "object" == _typeof(h) && n.call(h, "__await") ? e.resolve(h.__await).then(function (t) { invoke("next", t, i, a); }, function (t) { invoke("throw", t, i, a); }) : e.resolve(h).then(function (t) { u.value = t, i(u); }, function (t) { return invoke("throw", t, i, a); }); } a(c.arg); } var r; o(this, "_invoke", { value: function value(t, n) { function callInvokeWithMethodAndArg() { return new e(function (e, r) { invoke(t, n, e, r); }); } return r = r ? r.then(callInvokeWithMethodAndArg, callInvokeWithMethodAndArg) : callInvokeWithMethodAndArg(); } }); } function makeInvokeMethod(e, r, n) { var o = h; return function (i, a) { if (o === f) throw Error("Generator is already running"); if (o === s) { if ("throw" === i) throw a; return { value: t, done: !0 }; } for (n.method = i, n.arg = a;;) { var c = n.delegate; if (c) { var u = maybeInvokeDelegate(c, n); if (u) { if (u === y) continue; return u; } } if ("next" === n.method) n.sent = n._sent = n.arg;else if ("throw" === n.method) { if (o === h) throw o = s, n.arg; n.dispatchException(n.arg); } else "return" === n.method && n.abrupt("return", n.arg); o = f; var p = tryCatch(e, r, n); if ("normal" === p.type) { if (o = n.done ? s : l, p.arg === y) continue; return { value: p.arg, done: n.done }; } "throw" === p.type && (o = s, n.method = "throw", n.arg = p.arg); } }; } function maybeInvokeDelegate(e, r) { var n = r.method, o = e.iterator[n]; if (o === t) return r.delegate = null, "throw" === n && e.iterator["return"] && (r.method = "return", r.arg = t, maybeInvokeDelegate(e, r), "throw" === r.method) || "return" !== n && (r.method = "throw", r.arg = new TypeError("The iterator does not provide a '" + n + "' method")), y; var i = tryCatch(o, e.iterator, r.arg); if ("throw" === i.type) return r.method = "throw", r.arg = i.arg, r.delegate = null, y; var a = i.arg; return a ? a.done ? (r[e.resultName] = a.value, r.next = e.nextLoc, "return" !== r.method && (r.method = "next", r.arg = t), r.delegate = null, y) : a : (r.method = "throw", r.arg = new TypeError("iterator result is not an object"), r.delegate = null, y); } function pushTryEntry(t) { var e = { tryLoc: t[0] }; 1 in t && (e.catchLoc = t[1]), 2 in t && (e.finallyLoc = t[2], e.afterLoc = t[3]), this.tryEntries.push(e); } function resetTryEntry(t) { var e = t.completion || {}; e.type = "normal", delete e.arg, t.completion = e; } function Context(t) { this.tryEntries = [{ tryLoc: "root" }], t.forEach(pushTryEntry, this), this.reset(!0); } function values(e) { if (e || "" === e) { var r = e[a]; if (r) return r.call(e); if ("function" == typeof e.next) return e; if (!isNaN(e.length)) { var o = -1, i = function next() { for (; ++o < e.length;) if (n.call(e, o)) return next.value = e[o], next.done = !1, next; return next.value = t, next.done = !0, next; }; return i.next = i; } } throw new TypeError(_typeof(e) + " is not iterable"); } return GeneratorFunction.prototype = GeneratorFunctionPrototype, o(g, "constructor", { value: GeneratorFunctionPrototype, configurable: !0 }), o(GeneratorFunctionPrototype, "constructor", { value: GeneratorFunction, configurable: !0 }), GeneratorFunction.displayName = define(GeneratorFunctionPrototype, u, "GeneratorFunction"), e.isGeneratorFunction = function (t) { var e = "function" == typeof t && t.constructor; return !!e && (e === GeneratorFunction || "GeneratorFunction" === (e.displayName || e.name)); }, e.mark = function (t) { return Object.setPrototypeOf ? Object.setPrototypeOf(t, GeneratorFunctionPrototype) : (t.__proto__ = GeneratorFunctionPrototype, define(t, u, "GeneratorFunction")), t.prototype = Object.create(g), t; }, e.awrap = function (t) { return { __await: t }; }, defineIteratorMethods(AsyncIterator.prototype), define(AsyncIterator.prototype, c, function () { return this; }), e.AsyncIterator = AsyncIterator, e.async = function (t, r, n, o, i) { void 0 === i && (i = Promise); var a = new AsyncIterator(wrap(t, r, n, o), i); return e.isGeneratorFunction(r) ? a : a.next().then(function (t) { return t.done ? t.value : a.next(); }); }, defineIteratorMethods(g), define(g, u, "Generator"), define(g, a, function () { return this; }), define(g, "toString", function () { return "[object Generator]"; }), e.keys = function (t) { var e = Object(t), r = []; for (var n in e) r.push(n); return r.reverse(), function next() { for (; r.length;) { var t = r.pop(); if (t in e) return next.value = t, next.done = !1, next; } return next.done = !0, next; }; }, e.values = values, Context.prototype = { constructor: Context, reset: function reset(e) { if (this.prev = 0, this.next = 0, this.sent = this._sent = t, this.done = !1, this.delegate = null, this.method = "next", this.arg = t, this.tryEntries.forEach(resetTryEntry), !e) for (var r in this) "t" === r.charAt(0) && n.call(this, r) && !isNaN(+r.slice(1)) && (this[r] = t); }, stop: function stop() { this.done = !0; var t = this.tryEntries[0].completion; if ("throw" === t.type) throw t.arg; return this.rval; }, dispatchException: function dispatchException(e) { if (this.done) throw e; var r = this; function handle(n, o) { return a.type = "throw", a.arg = e, r.next = n, o && (r.method = "next", r.arg = t), !!o; } for (var o = this.tryEntries.length - 1; o >= 0; --o) { var i = this.tryEntries[o], a = i.completion; if ("root" === i.tryLoc) return handle("end"); if (i.tryLoc <= this.prev) { var c = n.call(i, "catchLoc"), u = n.call(i, "finallyLoc"); if (c && u) { if (this.prev < i.catchLoc) return handle(i.catchLoc, !0); if (this.prev < i.finallyLoc) return handle(i.finallyLoc); } else if (c) { if (this.prev < i.catchLoc) return handle(i.catchLoc, !0); } else { if (!u) throw Error("try statement without catch or finally"); if (this.prev < i.finallyLoc) return handle(i.finallyLoc); } } } }, abrupt: function abrupt(t, e) { for (var r = this.tryEntries.length - 1; r >= 0; --r) { var o = this.tryEntries[r]; if (o.tryLoc <= this.prev && n.call(o, "finallyLoc") && this.prev < o.finallyLoc) { var i = o; break; } } i && ("break" === t || "continue" === t) && i.tryLoc <= e && e <= i.finallyLoc && (i = null); var a = i ? i.completion : {}; return a.type = t, a.arg = e, i ? (this.method = "next", this.next = i.finallyLoc, y) : this.complete(a); }, complete: function complete(t, e) { if ("throw" === t.type) throw t.arg; return "break" === t.type || "continue" === t.type ? this.next = t.arg : "return" === t.type ? (this.rval = this.arg = t.arg, this.method = "return", this.next = "end") : "normal" === t.type && e && (this.next = e), y; }, finish: function finish(t) { for (var e = this.tryEntries.length - 1; e >= 0; --e) { var r = this.tryEntries[e]; if (r.finallyLoc === t) return this.complete(r.completion, r.afterLoc), resetTryEntry(r), y; } }, "catch": function _catch(t) { for (var e = this.tryEntries.length - 1; e >= 0; --e) { var r = this.tryEntries[e]; if (r.tryLoc === t) { var n = r.completion; if ("throw" === n.type) { var o = n.arg; resetTryEntry(r); } return o; } } throw Error("illegal catch attempt"); }, delegateYield: function delegateYield(e, r, n) { return this.delegate = { iterator: values(e), resultName: r, nextLoc: n }, "next" === this.method && (this.arg = t), y; } }, e; }
function asyncGeneratorStep(n, t, e, r, o, a, c) { try { var i = n[a](c), u = i.value; } catch (n) { return void e(n); } i.done ? t(u) : Promise.resolve(u).then(r, o); }
function _asyncToGenerator(n) { return function () { var t = this, e = arguments; return new Promise(function (r, o) { var a = n.apply(t, e); function _next(n) { asyncGeneratorStep(a, r, o, _next, _throw, "next", n); } function _throw(n) { asyncGeneratorStep(a, r, o, _next, _throw, "throw", n); } _next(void 0); }); }; }
var getContingencia = /*#__PURE__*/function () {
  var _ref = _asyncToGenerator(/*#__PURE__*/_regeneratorRuntime().mark(function _callee(request, response) {
    var solicitados, con, fecha_token, token, urlFirma, sqlDte, resultado, json_creado, json_anular, sqlCredenciales, credenciales, jsonFirmar, data, XMLHttpRequest, xhr;
    return _regeneratorRuntime().wrap(function _callee$(_context) {
      while (1) switch (_context.prev = _context.next) {
        case 0:
          _context.prev = 0;
          //Leyendo parametros enviados por get
          solicitados = request.query; //console.log("Parametros: "+solicitados.codigo_generado);
          //Seteando conexion a la base de datos
          _context.next = 4;
          return (0, _database.getConnection)();
        case 4:
          con = _context.sent;
          //Fecha para solicitar o consultar el token a utilizar
          fecha_token = new Date(); //console.log("Fecha tokan: "+fecha_token.getFullYear() + "-" + (fecha_token.getMonth() + 1) + "-" + fecha_token.getDate());
          //Solicitando token
          _context.next = 8;
          return (0, _getTokenMh.getTokenMh)(fecha_token.getFullYear() + "-" + (fecha_token.getMonth() + 1) + "-" + fecha_token.getDate());
        case 8:
          token = _context.sent;
          _context.next = 11;
          return (0, _getUrlServicio.getUrlServicio)('FIRMAR', 'sccsv_2017');
        case 11:
          urlFirma = _context.sent;
          //Consulta para extraer firma de dte a invalidar
          sqlDte = "SELECT codigo_generado," + "codigo_control," + "tipo_dte," + "firma_recibida, " + "IFNULL(JSON_UNQUOTE(JSON_EXTRACT(json_creado, '$.identificacion.ambiente')), '01') AS ambiente," + "IFNULL(JSON_UNQUOTE(JSON_EXTRACT(json_creado, '$.identificacion.version')), 1) AS version, " + "IFNULL(JSON_UNQUOTE(JSON_EXTRACT(json_creado, '$.identificacion.tipoDte')), '" + solicitados.tipo_dte + "') AS tipo_dte, " + "json_creado, " + "sello_recibido " + "FROM scc_dtes_creados " + "WHERE codigo_generado = '" + solicitados.codigo_generado + "' " + "AND codigo_control = '" + solicitados.codigo_control + "' " + "AND tipo_dte = '" + solicitados.tipo_dte + "'"; //console.log("Sql: " + sqlDte);
          //Ejecutando query 
          _context.next = 15;
          return con.query(sqlDte);
        case 15:
          resultado = _context.sent;
          json_creado = JSON.parse(resultado[0].json_creado);
          json_anular = {
            "identificacion": {
              "fecAnula": fecha_token.getFullYear() + "-" + ("0" + (fecha_token.getMonth() + 1)).slice(-2) + "-" + fecha_token.getDate(),
              "horAnula": ("0" + fecha_token.getHours()).slice(-2) + ":" + ("0" + fecha_token.getMinutes()).slice(-2) + ":" + ("0" + fecha_token.getSeconds()).slice(-2),
              "version": 2,
              "ambiente": resultado[0].ambiente,
              "codigoGeneracion": solicitados.codigo_generado
            },
            "emisor": {
              "nit": json_creado.emisor.nit,
              "nombre": json_creado.nombre,
              "tipoEstablecimiento": json_creado.emisor.tipoEstablecimiento,
              "telefono": json_creado.emisor.telefono.replace('-', ''),
              "correo": json_creado.emisor.correo,
              "codEstable": json_creado.emisor.codEstable,
              "codPuntoVenta": json_creado.emisor.codPuntoVenta,
              "nomEstablecimiento": json_creado.emisor.nomEstablecimiento
            },
            "documento": {
              "tipoDte": json_creado.identificacion.tipoDte,
              "codigoGeneracion": json_creado.identificacion.codigoGeneracion,
              "codigoGeneracionR": null,
              "tipoDocumento": json_creado.receptor.tipoDocumento,
              "numDocumento": json_creado.receptor.numDocumento,
              "nombre": json_creado.receptor.nombre,
              "selloRecibido": resultado[0].sello_recibido,
              "numeroControl": json_creado.identificacion.numeroControl,
              "fecEmi": json_creado.identificacion.fecEmi,
              "montoIva": parseFloat(json_creado.resumen.totalIva)
            },
            "motivo": {
              "tipoAnulacion": 2,
              "motivoAnulacion": solicitados.motivo,
              "nombreResponsable": solicitados.nombre,
              "tipDocResponsable": "37",
              "numDocResponsable": json_creado.emisor.nit,
              "nombreSolicita": json_creado.emisor.nombre,
              "tipDocSolicita": "37",
              "numDocSolicita": json_creado.emisor.nit
            }
          };
          if (!(token != '')) {
            _context.next = 24;
            break;
          }
          //Solicitar credenciales
          sqlCredenciales = "SELECT nit, " + "password_privado AS psw " + "FROM empresas.sccsv_2017" //+ process.env.DB_PRESTAN
          + " WHERE nombre_db = 'sccsv_2017'"; // + process.env.DB_PRESTAN + "'";
          _context.next = 22;
          return con.query(sqlCredenciales);
        case 22:
          credenciales = _context.sent;
          try {
            jsonFirmar = JSON.stringify(json_anular);
            data = JSON.stringify({
              "nit": credenciales[0].nit,
              "passwordPri": credenciales[0].psw,
              "activo": true,
              "dteJson": jsonFirmar
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

                //console.log("Firmas:"+Object.values(respuesta));
                //response.json(respuesta);
                /* let fechaProcesado = respuesta.fhProcesamiento.split(' ');
                 let fechaHora = fechaProcesado[0].split('/');*/
                try {
                  var update = "UPDATE scc_dtes_creados " + "SET firma_recibida = '" + respuesta.body + "' " + "WHERE codigo_generado = '" + solicitados.codigo_generado + "' AND " + "codigo_control = '" + solicitados.codigo_control + "' AND " + "tipo_dte = '" + solicitados.tipo_dte + "'";
                  //console.log("update: "+update);
                  //Guardar json firmado
                  var actualizado = con.query(update, function (err, result) {
                    if (err) {
                      console.log("Errores: " + err);
                      response.status(500);
                      response.send("Errores: " + err);
                    } else {
                      //Solicitar anulacion.
                      console.log("update: " + Object.keys(respuesta.body));
                      response.send("No se pudo actualizar");
                      /*let anulacion = getAnulacion(
                          token,
                          respuesta.body,
                          jsonFirmar.identificacion.ambiente,
                          jsonFirmar.identificacion.tipoDte,
                          solicitados.codigo_control,
                          jsonFirmar.identificacion.version,
                          jsonFirmar.identificacion.codigoGeneracion
                      );
                      anulacion.then((value) => {
                          console.log(value);
                          response.json(value);
                      }).catch((err) => {
                          console.console(err);
                          response.send(err);
                      })*/
                      //console.log("Respuesta anulacion: "+anulacion);
                    }
                  });
                  //console.log("Insertado: "+insertado);
                  //Solicitar sello

                  //Actualizar json guardado en base de datos
                } catch (e) {
                  response.status(500);
                  response.send("Error al guardar firma: " + e);
                  console.log("Respuesta: " + xhr.responseText);
                }
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
        case 24:
          response.json(json_anular);

          /*
          //Preparando invocacion api externa 
          const urlInvalidacion = "https://apitest.dtes.mh.gob.sv/fesv/anulardte";//await getUrlServicio('CONTANULAR');
          //console.log("url destino: "+urlInvalidacion);
          var XMLHttpRequest = require("xmlhttprequest").XMLHttpRequest;
          var xhr = new XMLHttpRequest();
          let data = JSON.stringify({
              "ambiente": resultado[0].ambiente,
              "idEnvio": 1,
              "version": parseInt(resultado[0].version),
              "tipoDte": resultado[0].tipo_dte,
              "documento": resultado[0].firma_recibida
          });
          xhr.withCredentials = true;
          xhr.open("POST", urlInvalidacion);
          xhr.setRequestHeader("Authorization", token);
          xhr.setRequestHeader("Content-Type", "application/json");
          xhr.setRequestHeader("Accept", "application/json")
          xhr.responseType = 'json';
          xhr.send(data);
          xhr.onload = () => {
              //console.log("Entrando en onload");
              if (xhr.readyState == 4 && xhr.status == 200) {
                  let respuesta = JSON.parse(xhr.responseText);
                  let fechaProcesado = respuesta.fhProcesamiento.split(' ');
                  let fechaHora = fechaProcesado[0].split('/');
                  try {
                      let actualizar = "UPDATE scc_dtes_creados "
                          + "SET sello_recibido = '" + respuesta.selloRecibido + "'"
                          + ", estado = CONCAT(estado, '(ANULADO)')"
                          + ", fecha_procesado = '" + fechaHora[2] + "-" + fechaHora[1] + "-" + fechaHora[0] + " " + fechaProcesado[1] + "'"
                          + ", observaciones = 'codigo: " + respuesta.codigoMsg
                          + "\n\rdescripcionMensaje: " + respuesta.descripcionMsg
                          + "\n\robservaciones: " + respuesta.observaciones + "'"
                          + " WHERE codigo_generado = '" + resultado[0].codigo_generado + "'"
                          + " AND tipo_dte = '" + resultado[0].tipo_dte + "'"
                          + " AND codigo_control = '" + resultado[0].codigo_control + "'";
                      let actualizado = con.query(actualizar);
                      console.log("Respuesta: " + xhr.responseText);
                     // resolve("ok");
                  } catch (e) {
                      //reject("Error: " + e);
                      console.log("Respuesta: " + xhr.responseText);
                  }
              } else {
                  try {
                      let respuesta2 = JSON.parse(xhr.responseText);
                      //let fechaProcesado = respuesta2.fhProcesamiento.split(' ');
                      //let fechaHora = fechaProcesado[0].split('/');
                      let actualizar = "UPDATE scc_dtes_creados "
                          + "SET observaciones = 'codigo: " + respuesta2.codigoMsg
                          + "\n\rdescripcionMensaje: " + respuesta2.descripcionMsg
                          + "\n\rObservaciones: " + respuesta2.observaciones + "'"
                          + " WHERE codigo_generado = '" + solicitados.codigo_generado + "'"
                          + " AND tipo_dte = '" + solicitados.tipo_dte + "'"
                          + " AND codigo_control = '" + solicitados.codigo_control + "'";
                      let actualizado = con.query(actualizar);
                      console.log("Se actualizo en base de datos: " + respuesta2.estado);
                      //response.json("Json Actualizado pero rechazado:"+Object.keys(respuesta2));
                  }catch(e){
                      console.log("Errores de json: "+xhr.response);
                      console.log("Errores json catcheado: "+e);
                     // response.send("Errores de json: "+Object.keys(xhr));
                  }
                  
              }
          }*/
          _context.next = 32;
          break;
        case 27:
          _context.prev = 27;
          _context.t0 = _context["catch"](0);
          response.status(500);
          response.send("Error: " + _context.t0.message);
          console.log("Error creando json: " + _context.t0);
        case 32:
        case "end":
          return _context.stop();
      }
    }, _callee, null, [[0, 27]]);
  }));
  return function getContingencia(_x, _x2) {
    return _ref.apply(this, arguments);
  };
}();
var methods = exports.methods = {
  getContingencia: getContingencia
};