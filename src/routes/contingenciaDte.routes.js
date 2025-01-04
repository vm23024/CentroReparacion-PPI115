import { Router } from "express";
import { methods as contingenciaDte } from '../controllers/contingenciaDte.controller';

const router = Router();

router.get("/", contingenciaDte.getContingencia);

export default router;