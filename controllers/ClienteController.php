<?php
// controllers/ClienteController.php
require_once __DIR__ . '/../models/Cliente.php';
require_once __DIR__ . '/../config/JWT.php';
require_once __DIR__ . '/../config/Database.php';
class ClienteController
{
    private $clienteModel;

    public function __construct()
    {
        $this->clienteModel = new Cliente();
    }

    // 1. Registrar un nuevo cliente
    public function registrar()
    {
        $datos = json_decode(file_get_contents("php://input"), true) ?? $_POST;

        $nombre = $datos['nombre'] ?? '';
        $apellido = $datos['apellido'] ?? '';
        $telefono = $datos['telefono'] ?? '';
        $correo = $datos['correo'] ?? '';
        $password = $datos['password'] ?? '';

        if (empty($nombre) || empty($apellido) || empty($correo) || empty($password)) {
            http_response_code(400);
            echo json_encode(["status" => "error", "message" => "Todos los campos obligatorios deben llenarse."]);
            exit;
        }

        // Llamamos al modelo pasando todos los datos
        $resultado = $this->clienteModel->registrar($nombre, $apellido, $telefono, $correo, $password);

        if ($resultado['status']) {
            http_response_code(201);
            echo json_encode(["status" => "success", "message" => "Cliente registrado con éxito", "id" => $resultado['id']]);
            exit;
        } else {
            http_response_code(500);
            echo json_encode(["status" => "error", "message" => $resultado['message']]);
            exit;
        }
    }

    // 2. Iniciar sesión 
    public function login()
    {
        $rawInput = file_get_contents("php://input");
        $datos = json_decode($rawInput, true);

        if (empty($datos)) {
            $datos = $_POST;
        }

        if (empty($datos) && !empty($rawInput)) {
            parse_str($rawInput, $datos);
        }

        
        $correo = $datos['emailLogin'] ?? ($datos['correo'] ?? ($datos['email'] ?? ''));
        $password = $datos['passwordLogin'] ?? ($datos['password'] ?? ($datos['contrasena'] ?? ''));

        if (empty($correo) || empty($password)) {
            http_response_code(400);
            echo json_encode(["status" => "error", "message" => "El correo y la contraseña son obligatorios."]);
            exit;
        }

        $cliente = $this->clienteModel->obtenerPorCorreo($correo);

        if ($cliente && password_verify($password, $cliente['password'])) {
            $payload = [
                "id_cliente" => $cliente['id_cliente'],
                "correo" => $cliente['email'] 
            ];
            $token = JWT::generar($payload);

            http_response_code(200);
            echo json_encode([
                "status" => "success",
                "message" => "Login exitoso",
                "token" => $token
            ]);
            exit;
        } else {
            http_response_code(401);
            echo json_encode(["status" => "error", "message" => "Credenciales incorrectas."]);
            exit;
        }
    }

    // 3. Obtener perfil del cliente autenticado
    public function perfil()
    {
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

        $id_cliente = $payload['id_cliente'];
        $cliente = $this->clienteModel->obtenerPorId($id_cliente);

        if ($cliente) {
            http_response_code(200);
            echo json_encode(["status" => "success", "data" => $cliente]);
            exit;
        } else {
            http_response_code(404);
            echo json_encode(["status" => "error", "message" => "Cliente no encontrado."]);
            exit;
        }
    }

    public function listarClientesConDispositivos()
    {
        $database = new Database();
        $db = $database->getConnection();

        try {
            
            $query = "SELECT c.id_cliente, c.nombre, c.apellido, c.telefono, c.email,
                             d.id_dispositivo, d.marca, d.modelo, d.imei_serie, d.observaciones, d.fecha_registro AS fecha_disp, d.imagen, d.estado_reparacion
                      FROM cliente c
                      LEFT JOIN dispositivo d ON c.id_cliente = d.id_cliente
                      ORDER BY c.id_cliente DESC";

            $stmt = $db->prepare($query);
            $stmt->execute();
            $registros = $stmt->fetchAll(PDO::FETCH_ASSOC);

            // Agrupar los dispositivos por cliente
            $clientesAgrupados = [];
            foreach ($registros as $row) {
                $id = $row['id_cliente'];
                if (!isset($clientesAgrupados[$id])) {
                    $nombreCompleto = trim(($row['nombre'] ?? '') . ' ' . ($row['apellido'] ?? ''));

                    $clientesAgrupados[$id] = [
                        "id_cliente" => $row['id_cliente'],
                        "nombre_cliente" => empty($nombreCompleto) ? 'Cliente sin nombre' : $nombreCompleto,
                        "correo" => $row['email'] ?? '',
                        "telefono" => $row['telefono'] ?? '',
                        "foto_cliente" => "",
                        "fecha_registro" => "Reciente",
                        "dispositivos" => []
                    ];
                }

                // Si el cliente tiene un dispositivo registrado, lo agregamos 
                if (!empty($row['id_dispositivo'])) {
                    $clientesAgrupados[$id]["dispositivos"][] = [
                        "id_dispositivo" => $row['id_dispositivo'],
                        "marca" => $row['marca'],
                        "modelo" => $row['modelo'],
                        "tipo" => "Móvil / Dispositivo",
                        "numero_serie" => $row['imei_serie'],
                        "descripcion_reparacion" => $row['observaciones'],
                        "diagnostico" => $row['estado_reparacion'] ?? 'En proceso',
                        "fecha_entrega" => $row['fecha_disp'] ?? 'Pendiente',
                        "imagen" => $row['imagen']
                    ];
                }
            }

            http_response_code(200);
            echo json_encode([
                "status" => "success",
                "data" => array_values($clientesAgrupados)
            ]);
            exit();

        } catch (PDOException $e) {
            http_response_code(500);
            echo json_encode([
                "status" => "error",
                "message" => "Error al obtener los datos: " . $e->getMessage()
            ]);
            exit();
        }
    }

    public function eliminarCliente($id)
    {
        $database = new Database();
        $db = $database->getConnection();

        try {
            
            $query = "DELETE FROM cliente WHERE id_cliente = :id";
            $stmt = $db->prepare($query);

            if ($stmt->execute([':id' => $id])) {
                http_response_code(200);
                echo json_encode(["status" => "success", "message" => "Cliente eliminado correctamente"]);
            } else {
                http_response_code(400);
                echo json_encode(["status" => "error", "message" => "No se pudo eliminar el cliente"]);
            }
            exit();
        } catch (PDOException $e) {
            http_response_code(500);
            echo json_encode(["status" => "error", "message" => $e->getMessage()]);
            exit();
        }
    }
}
?>