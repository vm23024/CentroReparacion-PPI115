import { Router } from "express";
import { methods as consultaDte } from './../controllers/consultarEstadoDte.controller';

const router = Router();

router.get("/", consultaDte.consultarDte);

export default router;