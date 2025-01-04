"use strict";

Object.defineProperty(exports, "__esModule", {
  value: true
});
exports["default"] = void 0;
var _express = require("express");
var _dtes = require("./../controllers/dtes.controller");
var router = (0, _express.Router)();
router.get("/", _dtes.methods.getDteEstados);
var _default = exports["default"] = router;