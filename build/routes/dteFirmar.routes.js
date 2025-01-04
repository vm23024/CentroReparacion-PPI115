"use strict";

Object.defineProperty(exports, "__esModule", {
  value: true
});
exports["default"] = void 0;
var _express = require("express");
var _dteFirmar = require("./../controllers/dteFirmar.controller");
var router = (0, _express.Router)();
router.get("/", _dteFirmar.methods.getFirma);
var _default = exports["default"] = router;