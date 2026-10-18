<?php
// controllers/RepuestoController.php
require_once './models/Repuesto.php';
require_once './config/AuthMiddleware.php';

class RepuestoController {
    private $repuestoModel;

    public function __construct() {
        AuthMiddleware::verificar(); // Protección de Token JWT activa
        $this->repuestoModel = new Repuesto();
    }

    // GET /repuestos o /repuestos?id=X
    public function listar() {
        if (isset($_GET['id']) && !empty($_GET['id'])) {
            $id = (int)$_GET['id'];
            $repuesto = $this->repuestoModel->obtenerPorId($id);

            if ($repuesto) {
                http_response_code(200);
                echo json_encode(["status" => "success", "data" => $repuesto]);
            } else {
                http_response_code(404);
                echo json_encode(["status" => "error", "message" => "Repuesto no encontrado."]);
            }
            return;
        }

        $repuestos = $this->repuestoModel->leer();
        http_response_code(200);
        echo json_encode(["status" => "success", "data" => $repuestos]);
    }

    // POST /repuestos
    public function guardar() {
        $data = json_decode(file_get_contents("php://input"));

        // Validaciones requeridas de los campos NOT NULL según phpMyAdmin
        if (empty($data->nombreRepuesto) || !isset($data->stock_actual) || !isset($data->stock_minimo) || !isset($data->precio_unitario)) {
            http_response_code(400);
            echo json_encode(["status" => "error", "message" => "Faltan datos obligatorios (nombreRepuesto, stock_actual, stock_minimo, precio_unitario)."]);
            return;
        }

        $resultado = $this->repuestoModel->crear(
            $data->nombreRepuesto,
            $data->descripcion ?? null,
            $data->stock_actual,
            $data->stock_minimo,
            $data->precio_unitario,
            $data->activo ?? 1
        );

        if ($resultado['status']) {
            http_response_code(201);
            echo json_encode(["status" => "success", "message" => "Repuesto registrado con éxito", "id_repuesto" => $resultado['id']]);
        } else {
            http_response_code(500);
            echo json_encode(["status" => "error", "message" => $resultado['message']]);
        }
    }
}
?>