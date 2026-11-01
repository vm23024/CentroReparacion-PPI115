<?php
//Autor: VM223024

// Obtener la URL y el método HTTP
$method = $_SERVER['REQUEST_METHOD'];
$uri = parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH);
$uri = str_replace('/index.php', '', $uri); // Para quitar index.php a la peticion

$base_path = '/ProyectoPPI';

// --- ENRUTADOR DE VISTAS ---
if ($uri === $base_path || $uri === $base_path . '/') {
    require_once __DIR__ . '/views/index.php';
    exit();
}

$archivo_solicitado = __DIR__ . '/views' . str_replace($base_path, '', $uri);
if (file_exists($archivo_solicitado) && pathinfo($archivo_solicitado, PATHINFO_EXTENSION) === 'php') {
    require_once $archivo_solicitado;
    exit();
}

// Cargar el lector de entorno y el archivo .env para las APIs
require_once './config/Env.php';
Env::load(__DIR__);

// Configuración de cabeceras para responder en JSON y permitir CORS (Solo para APIs)
header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json; charset=UTF-8");
header("Access-Control-Allow-Methods: POST, GET, PUT, DELETE, OPTIONS");
header("Access-Control-Allow-Headers: Content-Type, Access-Control-Allow-Headers, Authorization, X-Requested-With");

if ($_SERVER['REQUEST_METHOD'] == 'OPTIONS') {
    http_response_code(200);
    exit();
}


// Autenticación Empleados
if ($uri === $base_path . '/login' || $uri === $base_path . '/registro' || $uri === $base_path . '/perfil') {
    require_once './controllers/AuthController.php';
    $controller = new AuthController();
    if ($uri === $base_path . '/login') { $controller->login(); }
    if ($uri === $base_path . '/registro') { $controller->registro(); }
    if ($uri === $base_path . '/perfil') { $controller->perfil(); }
    exit();
}

// Autenticación Clientes
if ($uri === $base_path . '/api/clientes/registrarse' || $uri === $base_path . '/api/clientes/login' || $uri === $base_path . '/api/clientes/perfil') {
    require_once './controllers/ClienteController.php';
    $controller = new ClienteController();
    if ($uri === $base_path . '/api/clientes/registrarse') { $controller->registrar(); }
    elseif ($uri === $base_path . '/api/clientes/login') { $controller->login(); }
    elseif ($uri === $base_path . '/api/clientes/perfil') { $controller->perfil(); }
    exit();
}

// Dispositivos de Clientes
if ($uri === $base_path . '/api/clientes/dispositivos') {
    require_once './controllers/DispositivoController.php';
    $controller = new DispositivoController();
    if ($method === 'GET') { $controller->listarPorCliente(); }
    elseif ($method === 'POST') { $controller->guardar(); }
    exit();
}

// Repuestos
if ($uri === $base_path . '/api/repuestos/registrar') {
    require_once './controllers/RepuestoController.php';
    $controller = new RepuestoController();
    $controller->guardar(); 
    exit();
}

// Repuestos listar todos los respuestos
if ($uri === $base_path . '/api/repuestos/todos') {
    require_once './controllers/RepuestoController.php';
    $controller = new RepuestoController();
    $datos = $controller->listar();
    
    // Asegurarnos de limpiar y formatear cada repuesto para que el JS los lea sin error
    $listaFormateada = [];
    if (is_array($datos)) {
        foreach ($datos as $rep) {
            $listaFormateada[] = [
                "id_repuesto" => $rep['id_repuesto'] ?? $rep['id'] ?? null,
                "nombre" => $rep['tipo_repuesto'] ?? $rep['nombre'] ?? $rep['descripcion'] ?? 'Repuesto sin nombre',
                "stock" => $rep['stock_actual'] ?? $rep['stock'] ?? 0
            ];
        }
    }

    http_response_code(200);
    echo json_encode([
        "status" => "success",
        "data" => $listaFormateada
    ]);
    exit();
}

// Dispositivos (General / Todos)
if ($uri === $base_path . '/api/dispositivos/todos') {
    require_once './controllers/DispositivoController.php';
    $controller = new DispositivoController();
    $controller->listarTodos();
    exit();
}

// Órdenes de Reparación (Guardar)
if ($uri === $base_path . '/api/ordenes/guardar') {
    require_once './controllers/OrdenReparacionController.php';
    $controller = new OrdenReparacionController();
    $controller->guardarOrden();
    exit();
}

// Órdenes de Reparación (Listar todas para cambio de estado)
if ($uri === $base_path . '/api/ordenes/todas') {
    require_once './controllers/OrdenReparacionController.php';
    $controller = new OrdenReparacionController();
    $controller->listarTodas();
    exit();
}

// Órdenes de Reparación (Actualizar estado y diagnóstico)
if ($uri === $base_path . '/api/ordenes/actualizar-estado') {
    require_once './controllers/OrdenReparacionController.php';
    $controller = new OrdenReparacionController();
    $controller->cambiarEstado();
    exit();
}

// Órdenes de Reparación filtradas por el cliente logueado
if ($uri === $base_path . '/api/ordenes/mis-ordenes') {
    require_once './controllers/OrdenReparacionController.php';
    $controller = new OrdenReparacionController();
    $controller->listarPorCliente();
    exit();
}

// Detalle de una orden de reparación por ID
if ($uri === $base_path . '/api/ordenes/detalle') {
    require_once './controllers/OrdenReparacionController.php';
    $controller = new OrdenReparacionController();
    $controller->verDetalle();
    exit();
}

// Guardar Factura y Procesar Pago
if ($uri === $base_path . '/api/facturas/guardar') {
    require_once './controllers/FacturaController.php';
    $controller = new FacturaController();
    $controller->guardarFactura();
    exit();
}

// Listar todos los clientes con sus dispositivos asociados
if ($uri === $base_path . '/api/clientes/dispositivos-todos') {
    require_once './controllers/ClienteController.php';
    $controller = new ClienteController();
    $controller->listarClientesConDispositivos();
    exit();
}

// Listar técnicos con sus órdenes de reparación asociadas
if ($uri === $base_path . '/api/tecnicos/reparaciones-todos') {
    require_once './controllers/TecnicoController.php';
    $controller = new TecnicoController();
    $controller->listarTecnicosConReparaciones();
    exit();
}

//diagnostico de dispositivos
if ($uri === $base_path . '/api/diagnostico/todos') {
    require_once './controllers/OrdenReparacionController.php';
    $controller = new OrdenReparacionController();
    $controller->listarTodas();
    exit();
}

//eliminar empleado
if (preg_match('/^\/ProyectoPPI\/api\/empleados\/eliminar\/(\d+)$/', $uri, $matches) && $method === 'DELETE') {
    require_once './controllers/TecnicoController.php';
    $controller = new TecnicoController();
    $controller->eliminarTecnico($matches[1]);
    exit();
}

//eliminar cliente
if (preg_match('/^\/ProyectoPPI\/api\/clientes\/eliminar\/(\d+)$/', $uri, $matches) && $method === 'DELETE') {
    require_once './controllers/ClienteController.php';
    $controller = new ClienteController();
    $controller->eliminarCliente($matches[1]);
    exit();
}

$rutaEntidades = explode('/', trim($uri, '/'));
$ultimaPalabra = end($rutaEntidades);

$id_registro = null;
if (is_numeric($ultimaPalabra)) {
    $id_registro = (int) $ultimaPalabra;
    prev($rutaEntidades);
    $ultimaPalabra = current($rutaEntidades);
}

if (substr($ultimaPalabra, -2) === 'es') {
    $entidadBase = substr($ultimaPalabra, 0, -2);
} else {
    $entidadBase = rtrim($ultimaPalabra, 's');
}

$entidadMap = ucwords($entidadBase, '-');
$entidad = str_replace('-', '', $entidadMap);
$controllerFile = './controllers/' . $entidad . 'Controller.php';
$controllerClass = $entidad . 'Controller';

if (file_exists($controllerFile)) {
    require_once $controllerFile;
    $controller = new $controllerClass();
    switch ($method) {
        case "POST": $controller->guardar(); break;
        case "GET": $controller->listar(); break;
        case "PUT": $controller->actualizar(); break;
        case "DELETE": $controller->eliminar(); break;
        default:
            http_response_code(405);
            echo json_encode(["status" => "error", "message" => "Método no permitido"]);
            break;
    }
} else {
    http_response_code(404);
    echo json_encode(["status" => "error", "message" => "La entidad o controlador '$entidad' no existe en el sistema."]);
}