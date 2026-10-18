<?php
// controllers/OrdenReparacionController.php
require_once './models/OrdenReparacion.php';
require_once './config/AuthMiddleware.php';

class OrdenReparacionController {
    private $ordenModel;

    public function __construct() {
        AuthMiddleware::verificar(); // Validación del token JWT activo
        $this->ordenModel = new OrdenReparacion();
    }

    // GET /ordenreparacion o /ordenreparacion?id=X
    public function listar() {
        if (isset($_GET['id']) && !empty($_GET['id'])) {
            $id = (int)$_GET['id'];
            $orden = $this->ordenModel->obtenerPorId($id);

            if ($orden) {
                http_response_code(200);
                echo json_encode(["status" => "success", "data" => $orden]);
            } else {
                http_response_code(404);
                echo json_encode(["status" => "error", "message" => "Orden de reparación no encontrada."]);
            }
            return;
        }

        $ordenes = $this->ordenModel->leer();
        http_response_code(200);
        echo json_encode(["status" => "success", "data" => $ordenes]);
    }

    // POST /ordenreparacion
    public function guardar() {
        $data = json_decode(file_get_contents("php://input"));

        // Campos mínimos obligatorios según la estructura de la tabla (NOT NULL)
        if (empty($data->id_dispositivo) || empty($data->descripcion_problema)) {
            http_response_code(400);
            echo json_encode(["status" => "error", "message" => "Los campos id_dispositivo y descripcion_problema son obligatorios."]);
            return;
        }

        $resultado = $this->ordenModel->crear(
            $data->id_dispositivo,
            $data->id_tecnico ?? null,
            $data->fecha_estimada ?? null,
            $data->descripcion_problema,
            $data->diagnostico ?? null,
            $data->observaciones ?? null,
            $data->estado ?? 'Recibido'
        );

        if ($resultado['status']) {
            http_response_code(201);
            echo json_encode(["status" => "success", "message" => "Orden de reparación creada con éxito", "id_orden" => $resultado['id']]);
        } else {
            $code = (strpos($resultado['message'], 'llave foránea') !== false) ? 400 : 500;
            http_response_code($code);
            echo json_encode(["status" => "error", "message" => $resultado['message']]);
        }
    }
}
?>