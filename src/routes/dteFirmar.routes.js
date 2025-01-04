import { Router } from "express";
import { methods as getFirma } from './../controllers/dteFirmar.controller';

const router = Router();

router.get("/", getFirma.getFirma);

export default router;