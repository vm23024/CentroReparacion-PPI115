"use strict";

Object.defineProperty(exports, "__esModule", {
  value: true
});
exports["default"] = void 0;
var _express = require("express");
var _status = require("./../controllers/status.controller");
var router = (0, _express.Router)();
router.get("/", _status.methods.getStatusApi);
var _default = exports["default"] = router;