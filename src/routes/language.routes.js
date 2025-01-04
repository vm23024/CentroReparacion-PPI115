import { Router } from "express";
import { methods as languageController} from "./../controllers/language.controller";
const router=Router();

router.get("/", languageController.getLanguages);
router.get("/:nombreCampoId", languageController.getLanguage);
router.post("/", languageController.addLanguages);

export default router;