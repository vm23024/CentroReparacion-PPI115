import {Router} from "express";
import {methods as statusController} from "./../controllers/status.controller";

const router = Router();

router.get("/",statusController.getStatusApi);

export default router;