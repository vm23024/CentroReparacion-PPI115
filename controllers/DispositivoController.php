<?php
// controllers/DispositivoController.php
require_once './models/Dispositivo.php';
require_once './config/AuthMiddleware.php';

class DispositivoController {
    private $dispositivoModel;

    public function __construct() {
        // Bloqueo de seguridad: Requiere token válido para cualquier operación del CRUD
        AuthMiddleware::verificar();
        $this->dispositivoModel = new Dispositivo();
    }

    // GET /dispositivos o /dispositivos?id=X
    public function listar() {
        if (isset($_GET['id']) && !empty($_GET['id'])) {
            $id = (int)$_GET['id'];
            $dispositivo = $this->dispositivoModel->obtenerPorId($id);

            if ($dispositivo) {
                http_response_code(200);
                echo json_encode(["status" => "success", "data" => $dispositivo]);
            } else {
                http_response_code(404);
                echo json_encode(["status" => "error", "message" => "Dispositivo no encontrado."]);
            }
            return;
        }

        $dispositivos = $this->dispositivoModel->leer();
        http_response_code(200);
        echo json_encode(["status" => "success", "data" => $dispositivos]);
    }

    // POST /dispositivos
    public function guardar() {
        $data = json_decode(file_get_contents("php://input"));

        if (empty($data->id_cliente) || empty($data->marca) || empty($data->modelo)) {
            http_response_code(400);
            echo json_encode(["status" => "error", "message" => "Los campos id_cliente, marca y modelo son obligatorios."]);
            return;
        }

        $resultado = $this->dispositivoModel->crear(
            $data->id_cliente, $data->marca, $data->modelo,
            $data->imei_serie ?? null, $data->color ?? null,
            $data->estado_fisico_inicial ?? null, $data->observaciones ?? null
        );

        if ($resultado['status']) {
            http_response_code(201);
            echo json_encode(["status" => "success", "message" => "Dispositivo registrado", "id_dispositivo" => $resultado['id']]);
        } else {
            http_response_code(500);
            echo json_encode(["status" => "error", "message" => $resultado['message']]);
        }
    }

    // PUT /dispositivos
    public function actualizar() {
        $data = json_decode(file_get_contents("php://input"));

        if (empty($data->id_dispositivo) || empty($data->id_cliente) || empty($data->marca) || empty($data->modelo)) {
            http_response_code(400);
            echo json_encode(["status" => "error", "message" => "Faltan datos requeridos (id_dispositivo, id_cliente, marca, modelo)."]);
            return;
        }

        $resultado = $this->dispositivoModel->actualizar(
            $data->id_dispositivo, $data->id_cliente, $data->marca, $data->modelo,
            $data->imei_serie ?? null, $data->color ?? null,
            $data->estado_fisico_inicial ?? null, $data->observaciones ?? null
        );

        if ($resultado['status']) {
            http_response_code(200);
            echo json_encode(["status" => "success", "message" => $resultado['message']]);
        } else {
            $code = ($resultado['message'] === "El dispositivo especificado no existe.") ? 404 : 500;
            http_response_code($code);
            echo json_encode(["status" => "error", "message" => $resultado['message']]);
        }
    }

    // DELETE /dispositivos
    public function eliminar() {
        $data = json_decode(file_get_contents("php://input"));

        if (empty($data->id_dispositivo)) {
            http_response_code(400);
            echo json_encode(["status" => "error", "message" => "El campo id_dispositivo es requerido."]);
            return;
        }

        $resultado = $this->dispositivoModel->eliminar($data->id_dispositivo);

        if ($resultado['status']) {
            http_response_code(200);
            echo json_encode(["status" => "success", "message" => $resultado['message']]);
        } else {
            $code = ($resultado['message'] === "El dispositivo especificado no existe.") ? 404 : 500;
            http_response_code($code);
            echo json_encode(["status" => "error", "message" => $resultado['message']]);
        }
    }
}
?>