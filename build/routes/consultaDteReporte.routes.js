"use strict";

Object.defineProperty(exports, "__esModule", {
  value: true
});
exports["default"] = void 0;
var _express = require("express");
var _consultarEstadoDte = require("./../controllers/consultarEstadoDte.controller");
var router = (0, _express.Router)();
router.get("/", _consultarEstadoDte.methods.consultarDte);
var _default = exports["default"] = router;