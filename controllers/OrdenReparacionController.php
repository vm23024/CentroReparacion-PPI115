<?php
require_once __DIR__ . '/../models/OrdenReparacion.php';
require_once __DIR__ . '/../models/Dispositivo.php';
require_once __DIR__ . '/../config/JWT.php';

class OrdenReparacionController {
    
    public function guardarOrden() {
        // Validar token JWT del usuario logueado
        $headers = apache_request_headers();
        $authHeader = $headers['Authorization'] ?? ($headers['authorization'] ?? null);

        if (!$authHeader) {
            http_response_code(401);
            echo json_encode(["status" => "error", "message" => "Token no proporcionado."]);
            exit;
        }

        list($jwt) = sscanf($authHeader, 'Bearer %s');
        $payload = JWT::validar($jwt);

        if (!$payload) {
            http_response_code(401);
            echo json_encode(["status" => "error", "message" => "Token inválido o expirado."]);
            exit;
        }

        
        $data = json_decode(file_get_contents("php://input"), true);

        if (empty($data['id_dispositivo'])) {
            http_response_code(400);
            echo json_encode(["status" => "error", "message" => "Debe seleccionar un dispositivo de la lista."]);
            exit;
        }

        // Asignar id del empleado logueado 
        $id_empleado = $payload['id_usuario'] ?? null;

        // Captura el ID del repuesto 
        $id_repuesto = $data['id_repuesto'] ?? null; 
        $cantidad_repuesto = $data['cantidad_repuesto'] ?? 1;

        $ordenModel = new OrdenReparacion();
        $resultadoOrden = $ordenModel->crear([
            'id_dispositivo' => $data['id_dispositivo'],
            'id_empleado' => $id_empleado,
            'ingreso_orden' => $data['ingreso_orden'] ?? date('Y-m-d'),
            'marca_dispositivo' => $data['marca'] ?? '',
            'modelo_dispositivo' => $data['modelo'] ?? '',
            'numero_imei' => $data['imei'] ?? null,
            'nombre_cliente' => $data['nombre'] ?? null,
            'accesorios' => $data['accesorios'] ?? null,
            'estado_dispositivo' => $data['estadoDispositivo'] ?? 'En diagnostico',
            'costo_reparacion' => $data['costo'] ?? 0.00,
            'falla_cliente' => $data['falla'] ?? null,
            'motivo_reparacion' => $data['motivo'] ?? null,
            'reparacion_prometida_para' => $data['fechaEntrega'] ?? null
        ]);

        if ($resultadoOrden['status']) {
            $id_orden = $resultadoOrden['id_orden'];

            if (!empty($id_repuesto)) {
                $ordenModel->agregarRepuestoAOrden($id_orden, $id_repuesto, $cantidad_repuesto);
            }

            // Actualizar también el estado en la tabla Dispositivos
            $dispositivoModel = new Dispositivo();
            $dispositivoModel->actualizarEstado($data['id_dispositivo'], $data['estadoDispositivo']);

            http_response_code(201);
            echo json_encode([
                "status" => "success", 
                "message" => "Orden de reparación registrada con éxito", 
                "id_orden" => $id_orden
            ]);
            exit;
        } else {
            http_response_code(500);
            echo json_encode(["status" => "error", "message" => $resultadoOrden['message']]);
            exit;
        }
    }

    // Listar todas las órdenes para el panel de cambios de estado
    public function listarTodas() {
        $headers = apache_request_headers();
        $authHeader = $headers['Authorization'] ?? ($headers['authorization'] ?? null);

        if (!$authHeader) {
            http_response_code(401);
            echo json_encode(["status" => "error", "message" => "Token no proporcionado."]);
            exit;
        }

        list($jwt) = sscanf($authHeader, 'Bearer %s');
        $payload = JWT::validar($jwt);

        if (!$payload) {
            http_response_code(401);
            echo json_encode(["status" => "error", "message" => "Token inválido o expirado."]);
            exit;
        }

       
        $ordenModel = new OrdenReparacion();
        $ordenes = $ordenModel->obtenerTodasConDetalles();

        http_response_code(200);
        echo json_encode([
            "status" => "success",
            "data" => $ordenes
        ]);
        exit;
    }

    // Actualizar estado y diagnóstico
    public function cambiarEstado() {
        $headers = apache_request_headers();
        $authHeader = $headers['Authorization'] ?? ($headers['authorization'] ?? null);
    
        if (!$authHeader) {
            http_response_code(401);
            echo json_encode(["status" => "error", "message" => "Token no proporcionado."]);
            exit;
        }
    
        list($jwt) = sscanf($authHeader, 'Bearer %s');
        $payload = JWT::validar($jwt);
    
        if (!$payload) {
            http_response_code(401);
            echo json_encode(["status" => "error", "message" => "Token inválido o expirado."]);
            exit;
        }
    
        $data = json_decode(file_get_contents("php://input"), true);
    
        $id_orden = $data['id_orden'] ?? null;
        $estado_dispositivo = $data['estado_dispositivo'] ?? null;
        $diagnostico = $data['diagnostico'] ?? null;
        $tipo_servicio = $data['tipo_servicio'] ?? null; 
    
        if (empty($id_orden) || empty($estado_dispositivo)) {
            http_response_code(400);
            echo json_encode(["status" => "error", "message" => "El ID de la orden y el estado son obligatorios."]);
            exit;
        }
    
        $ordenModel = new OrdenReparacion();
        $resultado = $ordenModel->actualizarEstadoYDiagnostico($id_orden, $estado_dispositivo, $diagnostico, $tipo_servicio);
    
        if ($resultado['status']) {
            http_response_code(200);
            echo json_encode(["status" => "success", "message" => $resultado['message']]);
            exit;
        } else {
            http_response_code(500);
            echo json_encode(["status" => "error", "message" => $resultado['message']]);
            exit;
        }
    }

    // Listar solo las órdenes del cliente logueado
    public function listarPorCliente() {
        $headers = apache_request_headers();
        $authHeader = $headers['Authorization'] ?? ($headers['authorization'] ?? null);

        if (!$authHeader) {
            http_response_code(401);
            echo json_encode(["status" => "error", "message" => "Token no proporcionado."]);
            exit;
        }

        list($jwt) = sscanf($authHeader, 'Bearer %s');
        $payload = JWT::validar($jwt);

        if (!$payload) {
            http_response_code(401);
            echo json_encode(["status" => "error", "message" => "Token inválido o expirado."]);
            exit;
        }

        // Extraemos el id del cliente del token 
        $id_cliente = $payload['id_cliente'] ?? ($payload['id_usuario'] ?? null);

        if (!$id_cliente) {
            http_response_code(400);
            echo json_encode(["status" => "error", "message" => "No se pudo identificar al cliente en el token."]);
            exit;
        }

        $ordenModel = new OrdenReparacion();
        $ordenes = $ordenModel->obtenerPorCliente($id_cliente);

        http_response_code(200);
        echo json_encode([
            "status" => "success",
            "data" => $ordenes
        ]);
        exit;
    }

    public function verDetalle() {
        $headers = apache_request_headers();
        $authHeader = $headers['Authorization'] ?? ($headers['authorization'] ?? null);

        if (!$authHeader) {
            http_response_code(401);
            echo json_encode(["status" => "error", "message" => "Token no proporcionado."]);
            exit;
        }

        list($jwt) = sscanf($authHeader, 'Bearer %s');
        $payload = JWT::validar($jwt);

        if (!$payload) {
            http_response_code(401);
            echo json_encode(["status" => "error", "message" => "Token inválido o expirado."]);
            exit;
        }

        $id_orden = $_GET['id'] ?? null;
        if (!$id_orden) {
            http_response_code(400);
            echo json_encode(["status" => "error", "message" => "ID de orden no especificado."]);
            exit;
        }

        $ordenModel = new OrdenReparacion();
        $orden = $ordenModel->obtenerPorId($id_orden);

        if (!$orden) {
            http_response_code(404);
            echo json_encode(["status" => "error", "message" => "Orden no encontrada."]);
            exit;
        }

        http_response_code(200);
        echo json_encode([
            "status" => "success",
            "data" => $orden
        ]);
        exit;
    }

}
?>