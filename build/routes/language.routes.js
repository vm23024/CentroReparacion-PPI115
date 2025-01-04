"use strict";

Object.defineProperty(exports, "__esModule", {
  value: true
});
exports["default"] = void 0;
var _express = require("express");
var _language = require("./../controllers/language.controller");
var router = (0, _express.Router)();
router.get("/", _language.methods.getLanguages);
router.get("/:nombreCampoId", _language.methods.getLanguage);
router.post("/", _language.methods.addLanguages);
var _default = exports["default"] = router;