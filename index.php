<?php
//Autor: VM223024

// Cargar el lector de entorno y el archivo .env
require_once './config/Env.php';
Env::load(__DIR__);

// Configuración de cabeceras para responder en JSON y permitir CORS
header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json; charset=UTF-8");
header("Access-Control-Allow-Methods: POST, GET, PUT, DELETE, OPTIONS");
header("Access-Control-Allow-Headers: Content-Type, Access-Control-Allow-Headers, Authorization, X-Requested-With");

// Manejo de peticiones preflight OPTIONS (CORS)
if ($_SERVER['REQUEST_METHOD'] == 'OPTIONS') {
    http_response_code(200);
    exit();
}

// Obtener la URL y el método HTTP
$method = $_SERVER['REQUEST_METHOD'];
$uri = parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH);
$uri = str_replace('/index.php', '', $uri); //Para quitar index.php a la peticion

// Enrutador básico manual
$base_path = '/proyectoPPI115';
//Lógica de Autenticación (Login / Registro)
if ($uri === $base_path . '/login' || $uri === $base_path . '/registro') {
    if ($method !== 'POST') {
        http_response_code(405);
        echo json_encode(["status" => "error", "message" => "Método no permitido para esta ruta."]);
        exit();
    }
    require_once './controllers/AuthController.php';
    $controller = new AuthController();

    if ($uri === $base_path . '/login') $controller->login();
    if ($uri === $base_path . '/registro') $controller->registro();
    exit(); // Finalizar ejecución tras resolver auth
}
//Enrutador por convencion para CRUDs de entidades
$rutaEntidades = explode('/', trim($uri, '/'));
$ultimaPalabra = end($rutaEntidades); //Se captura el ultimo pudiendo ser clientes, dispositivos, faacturas, etc.

$id_registro = null;
if (is_numeric($ultimaPalabra)) {
    $id_registro = (int)$ultimaPalabra;
    prev($rutaEntidades);
    $ultimaPalabra = current($rutaEntidades);
}

// Quitar la "s" final si la petición viene en plural (ej: "ordenes-reparacion")
// Para español, si termina en "es", removemos "es", si no, solo la "s"
if (substr($ultimaPalabra, -2) === 'es') {
    $entidadBase = substr($ultimaPalabra, 0, -2);
} else {
    $entidadBase = rtrim($ultimaPalabra, 's'); 
}

// SOPORTE CAMELCASE: Reemplazar guiones y capitalizar cada palabra
// Ejemplo: "orden-reparacion" -> "Orden-Reparacion" -> "OrdenReparacion"
$entidadMap = ucwords($entidadBase, '-');
$entidad = str_replace('-', '', $entidadMap); 
$controllerFile = './controllers/' . $entidad . 'Controller.php';
$controllerClass = $entidad . 'Controller';
if (file_exists($controllerFile)) { //Se verifica que exista el controlador solicitado
    require_once $controllerFile; //Se incluye el controlador
    $controller = new $controllerClass(); //Se genera un nuevo objeto del controlador
    //Evaluamos los metodos permitidos 
    switch ($method) {
        case "POST": //Metodo para crear registros de las entidades a excepcion de login() y registro para usuarios nuevos
            $controller->guardar();
            break;
        case "GET":
            $controller->listar(); //Todas las entidades deben tener un listador de registros
            break;
        case "PUT":
            $controller->actualizar(); //Todos las entidades deben tener un actualizador
            break;
        case "DELETE":
            $controller->eliminar(); //Todos las entidades deben tener un eliminador
            break;
        default:
            http_response_code(404);
            echo json_encode(["status" => "error", "message" => "Ruta no encontrada"]);
            break;
    }
} else {
    http_response_code(404);
    echo json_encode(["status" => "error", "message" => "La entidad o controlador '$entidad' no existe en el sistema."]);
}
