import { Router } from "express";
import {methods as dtesController} from "./../controllers/dtes.controller";

const router = Router();

router.get("/", dtesController.getDteEstados);

export default router;