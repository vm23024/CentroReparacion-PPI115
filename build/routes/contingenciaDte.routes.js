"use strict";

Object.defineProperty(exports, "__esModule", {
  value: true
});
exports["default"] = void 0;
var _express = require("express");
var _contingenciaDte = require("../controllers/contingenciaDte.controller");
var router = (0, _express.Router)();
router.get("/", _contingenciaDte.methods.getContingencia);
var _default = exports["default"] = router;