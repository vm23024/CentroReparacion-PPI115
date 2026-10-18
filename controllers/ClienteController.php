<?php
// Entidad Cliente
require_once './models/Cliente.php';
require_once './config/AuthMiddleware.php';

class ClienteController
{
    private $clienteModel;

    public function __construct()
    {
        // PROTEGER TODO EL CRUD: Si el token falla, detiene la ejecución aquí
        AuthMiddleware::verificar();
        $this->clienteModel = new Cliente();
    }

    // GET /clientes
    public function listar()
    {
        if (isset($_GET['id']) && !empty($_GET['id'])) {
            $id = (int)$_GET['id'];
            $cliente = $this->clienteModel->obtenerPorId($id);

            if ($cliente) {
                http_response_code(200);
                echo json_encode(["status" => "success", "data" => $cliente]);
            } else {
                http_response_code(404);
                echo json_encode(["status" => "error", "message" => "Cliente no encontrado."]);
            }
            return; // Detiene la ejecución aquí
        }
        $clientes = $this->clienteModel->leer();
        http_response_code(200);
        echo json_encode(["status" => "success", "data" => $clientes]);
    }

    // POST /clientes
    public function guardar()
    {
        $data = json_decode(file_get_contents("php://input"));

        if (empty($data->nombreCliente) || empty($data->apellidoCliente)) {
            http_response_code(400);
            echo json_encode(["status" => "error", "message" => "Nombre y Apellido son obligatorios."]);
            return;
        }

        $email = $data->emailCliente ?? null;
        $telefono = $data->telefonoCliente ?? null;
        $fecha_nacimiento = $data->fecha_nacimiento ?? null;

        $resultado = $this->clienteModel->crear($data->nombreCliente, $data->apellidoCliente, $email, $telefono, $fecha_nacimiento);

        if ($resultado['status']) {
            http_response_code(201);
            echo json_encode(["status" => "success", "message" => "Cliente creado", "id_cliente" => $resultado['id']]);
        } else {
            http_response_code(500);
            echo json_encode(["status" => "error", "message" => $resultado['message']]);
        }
    }
    //PUT /clientes
    public function actualizar()
    {
        // Leer el flujo de datos de la petición PUT
        $data = json_decode(file_get_contents("php://input"));

        // Validar los campos mínimos obligatorios para poder actualizar
        if (empty($data->id_cliente) || empty($data->nombreCliente) || empty($data->apellidoCliente)) {
            http_response_code(400);
            echo json_encode(["status" => "error", "message" => "Faltan datos obligatorios (id_cliente, nombreCliente, apellidoCliente)."]);
            return;
        }

        $email = $data->emailCliente ?? null;
        $telefono = $data->telefonoCliente ?? null;
        $fecha_nacimiento = $data->fecha_nacimiento ?? null;

        // Invocar el método del modelo
        $resultado = $this->clienteModel->actualizar(
            $data->id_cliente,
            $data->nombreCliente,
            $data->apellidoCliente,
            $email,
            $telefono,
            $fecha_nacimiento
        );

        if ($resultado['status']) {
            http_response_code(200);
            echo json_encode(["status" => "success", "message" => $resultado['message']]);
        } else {
            // Si el cliente no existe devolvemos 404, de lo contrario un 500
            $code = ($resultado['message'] === "El cliente especificado no existe.") ? 404 : 500;
            http_response_code($code);
            echo json_encode(["status" => "error", "message" => $resultado['message']]);
        }
    }

    //DELETE /clientes
    public function eliminar()
    {
        // Leer el JSON de la petición DELETE
        $data = json_decode(file_get_contents("php://input"));

        // Validar el campo obligatorio
        if (empty($data->id_cliente)) {
            http_response_code(400);
            echo json_encode(["status" => "error", "message" => "El campo id_cliente es obligatorio para eliminar."]);
            return;
        }

        // Invocar el método del modelo
        $resultado = $this->clienteModel->eliminar($data->id_cliente);

        if ($resultado['status']) {
            http_response_code(200);
            echo json_encode(["status" => "success", "message" => $resultado['message']]);
        } else {
            // Si no existe lanzamos 404, si hay restricción de integridad un 400, si no un 500
            if ($resultado['message'] === "El cliente especificado no existe.") {
                $code = 404;
            } elseif (strpos($resultado['message'], 'registros asociados') !== false) {
                $code = 400;
            } else {
                $code = 500;
            }
            http_response_code($code);
            echo json_encode(["status" => "error", "message" => $resultado['message']]);
        }
    }
}
