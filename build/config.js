"use strict";

Object.defineProperty(exports, "__esModule", {
  value: true
});
exports["default"] = void 0;
var _dotenv = require("dotenv");
(0, _dotenv.config)();
console.log("Usuario: " + process.env.USER_HDO);
console.log("Puerto: " + process.env.PORT);
var _default = exports["default"] = {
  host: process.env.HOST || "",
  database: process.env.DB_HDO || "",
  user: process.env.USER_HDO || "",
  password: process.env.PASSWORD_HDO || "",
  application: {
    cors: {
      server: [{
        origin: "localhost:" + process.env.PORT,
        credentials: false
      }]
    }
  }
};