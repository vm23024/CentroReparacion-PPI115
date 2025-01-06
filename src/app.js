import express from "express";
import morgan from "morgan";
import cors from "cors";

import languageRoutes from "./routes/language.routes";
import dtesRoutes from "./routes/dtes.routes";
import statusRoutes from "./routes/status.routes";
import contingenciaRoutes from "./routes/contingenciaDte.routes";
import dteFirmarRoutes from "./routes/dteFirmar.routes";
import consultarEstadoDteRoutes from "./routes/consultaDteReporte.routes";

const config = {
    application:{
        cors:{
            server: [
                {
                    origin: "*",
                    credentials: false
                }
            ]
        }
    }
};

const app = express();
const PORT = process.env.PORT || 4002

app.set("port", PORT);

app.use(morgan("dev"));
app.use(express.json());
app.use(cors(
    config.application.cors.server
));

app.use("/api/languages", languageRoutes);
app.use("/api/dtes", dtesRoutes);
app.use("/api/statusApi", statusRoutes);
app.use("/api/contingenciaAnular", contingenciaRoutes);
app.use("/api/dteFirma", dteFirmarRoutes);
app.use("/api/consultarDte", consultarEstadoDteRoutes);

export default app;

