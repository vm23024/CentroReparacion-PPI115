<?php
// controllers/DispositivoController.php
require_once __DIR__ . '/../models/Dispositivo.php';
require_once __DIR__ . '/../config/JWT.php';

class DispositivoController {
    private $dispositivoModel;

    public function __construct() {
        $this->dispositivoModel = new Dispositivo();
    }

    // 1. Listar dispositivos del cliente autenticado
    public function listar() {
        $payload = $this->validarTokenHeader();
        if (!$payload) return;

        // Extraer el id del cliente 
        $id_cliente = $payload['id_cliente'] ?? $payload['data']['id_cliente'] ?? null;

        if (!$id_cliente) {
            http_response_code(400);
            echo json_encode(["status" => "error", "message" => "No se pudo identificar al cliente en el token."]);
            exit;
        }

        $dispositivos = $this->dispositivoModel->obtenerPorCliente($id_cliente);

        http_response_code(200);
        echo json_encode([
            "status" => "success",
            "data" => $dispositivos
        ]);
        exit;
    }

    
    public function listarPorCliente() {
        $this->listar();
    }

    // Listar todos los dispositivos del sistema 
    public function listarTodos() {
        $payload = $this->validarTokenHeader();
        if (!$payload) return;

        $dispositivos = $this->dispositivoModel->obtenerTodosConCliente();

        http_response_code(200);
        echo json_encode([
            "status" => "success",
            "data" => $dispositivos
        ]);
        exit;
    }

    // 2. Registrar dispositivo con Imagen, Fecha y Accesorios para el cliente autenticado
    public function guardar() {
        $payload = $this->validarTokenHeader();
        if (!$payload) return;

        $id_cliente = $payload['id_cliente'] ?? $payload['data']['id_cliente'] ?? null;
        $marca = $_POST['marca'] ?? '';
        $modelo = $_POST['modelo'] ?? '';
        $imei_serie = $_POST['imei_serie'] ?? null;
        $observaciones = $_POST['observaciones'] ?? null;
        $fecha_cita = $_POST['fecha_cita'] ?? null;
        $accesorios = $_POST['accesorios'] ?? null;
        $imagenNombre = null;

        if (empty($marca) || empty($modelo)) {
            http_response_code(400);
            echo json_encode(["status" => "error", "message" => "La marca y el modelo son obligatorios."]);
            exit;
        }

        // Procesar la subida de la imagen 
        if (isset($_FILES['imagen']) && $_FILES['imagen']['error'] === UPLOAD_ERR_OK) {
            $fileTmpPath = $_FILES['imagen']['tmp_name'];
            $fileName = $_FILES['imagen']['name'];
            $fileExtension = strtolower(pathinfo($fileName, PATHINFO_EXTENSION));
            
            $allowedExtensions = ['jpg', 'jpeg', 'png', 'webp'];
            if (in_array($fileExtension, $allowedExtensions)) {
                $newFileName = md5(time() . $fileName) . '.' . $fileExtension;
                $uploadFileDir = __DIR__ . '/../IMG/dispositivos/';
                
                if (!is_dir($uploadFileDir)) {
                    mkdir($uploadFileDir, 0755, true);
                }
                
                $dest_path = $uploadFileDir . $newFileName;
                if (move_uploaded_file($fileTmpPath, $dest_path)) {
                    $imagenNombre = 'IMG/dispositivos/' . $newFileName;
                }
            }
        }

        
        $resultado = $this->dispositivoModel->crearConImagen(
            $id_cliente, 
            $marca, 
            $modelo,
            $imei_serie, 
            $observaciones,
            $imagenNombre,
            $fecha_cita,
            $accesorios 
        );

        if ($resultado['status']) {
            http_response_code(201);
            echo json_encode(["status" => "success", "message" => "Dispositivo registrado con éxito", "id_dispositivo" => $resultado['id']]);
            exit;
        } else {
            http_response_code(500);
            echo json_encode(["status" => "error", "message" => $resultado['message']]);
            exit;
        }
    }

    // 3. Actualizar el estado de reparación al crear la orden
    public function actualizarEstado() {
        $payload = $this->validarTokenHeader();
        if (!$payload) return;

        $data = json_decode(file_get_contents("php://input"), true);

        $id_dispositivo = $data['id_dispositivo'] ?? null;
        $estado_reparacion = $data['estado_reparacion'] ?? null;

        if (empty($id_dispositivo) || empty($estado_reparacion)) {
            http_response_code(400);
            echo json_encode(["status" => "error", "message" => "El ID del dispositivo y el estado son obligatorios."]);
            exit;
        }

        $resultado = $this->dispositivoModel->actualizarEstado($id_dispositivo, $estado_reparacion);

        if ($resultado['status']) {
            http_response_code(200);
            echo json_encode(["status" => "success", "message" => "Estado de reparación actualizado correctamente."]);
            exit;
        } else {
            http_response_code(500);
            echo json_encode(["status" => "error", "message" => $resultado['message']]);
            exit;
        }
    }

    // Función auxiliar privada para validar el token JWT
    private function validarTokenHeader() {
        $headers = apache_request_headers();
        $authHeader = $headers['Authorization'] ?? ($headers['authorization'] ?? null);

        if (!$authHeader) {
            http_response_code(401);
            echo json_encode(["status" => "error", "message" => "Token no proporcionado."]);
            exit;
            return false;
        }

        list($jwt) = sscanf($authHeader, 'Bearer %s');
        $payload = JWT::validar($jwt);

        if (!$payload) {
            http_response_code(401);
            echo json_encode(["status" => "error", "message" => "Token inválido o expirado."]);
            exit;
            return false;
        }

        return $payload;
    }
}
?>