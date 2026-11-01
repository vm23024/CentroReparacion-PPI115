<?php
require_once './models/Usuario.php';
require_once './config/JWT.php';

class AuthController
{ 

    public function login()
    { 
        $data = json_decode(file_get_contents("php://input"));

        // Validar que vengan los datos obligatorios
        if (empty($data->usuario) || empty($data->password)) {
            http_response_code(400);
            echo json_encode(["status" => "error", "message" => "Faltan datos (usuario o password)"]);
            exit();
            return;
        }

        $usuarioModel = new Usuario();
        $user = $usuarioModel->obtenerPorUsuario($data->usuario);

        // Verificar si el usuario existe
        if (!$user) {
            http_response_code(401);
            echo json_encode(["status" => "error", "message" => "Credenciales incorrectas"]);
            exit();
            return;
        }

        // Verificar si está activo
        if ($user['activo'] == 0) {
            http_response_code(403);
            echo json_encode(["status" => "error", "message" => "El usuario se encuentra inactivo"]);
            exit();
            return;
        }
        

        // Verificar contraseña hash
        if (password_verify($data->password, $user['password_hash'])) {

            
            $payloadData = [
                "id_usuario" => $user['id_usuario'],
                "usuario"    => $user['usuario'],
                "rol"        => $user['rol']
            ];

            
            $jwt_token = JWT::generar($payloadData);

            http_response_code(200);
            echo json_encode([
                "status"  => "success",
                "message" => "Login exitoso",
                "token"   => $jwt_token,
                "rol"     => $user['rol'],
                "nombre"  => trim(($user['nombreUsuario'] ?? '') . ' ' . ($user['apellidoUsuario'] ?? '')) ?: $user['usuario']
            ]);
            exit();
        } else {
            http_response_code(401);
            echo json_encode(["status" => "error", "message" => "Credenciales incorrectas"]);
            exit();
        }
    }
    public function registro() //Metodo para registrar usuarios
    {
        // Leer el JSON de la petición
        $data = json_decode(file_get_contents("php://input"));

        // Validar campos requeridos
        if (empty($data->usuario) || empty($data->password) || empty($data->rol)) {
            http_response_code(400);
            echo json_encode(["status" => "error", "message" => "Faltan datos obligatorios (usuario, password, rol)"]);
            return;
        }

        $usuarioModel = new Usuario();

        // Intentar registrar el usuario (por defecto activo = 1)
        $resultado = $usuarioModel->crear(
            $data->usuario,
            $data->password,
            $data->nombreUsuario,
            $data->apellidoUsuario,
            $data->rol,
            $data->activo ?? 1,
            $data->emailUsuario ?? NULL,
            $data->telefonoUsuario ?? NULL
        );

        if ($resultado['status']) {
            http_response_code(201); 
            echo json_encode([
                "status" => "success",
                "message" => "Usuario creado exitosamente",
                "data" => [
                    "id_usuario" => $resultado['id']
                ]
            ]);
            exit();
        } else {
            http_response_code(400); 
            echo json_encode([
                "status" => "error",
                "message" => $resultado['message']
            ]);
            exit();
        }
    }

    //obtener datos de bd

    public function perfil()
{
    // Obtener los headers de la petición
    $headers = getallheaders();
    $authHeader = $headers['Authorization'] ?? $headers['authorization'] ?? '';

    if (!$authHeader || !preg_match('/Bearer\s(\S+)/', $authHeader, $matches)) {
        http_response_code(401);
        echo json_encode(["status" => "error", "message" => "Token no proporcionado"]);
        exit();
    }

    $jwt = $matches[1];

    try {
        // Validar y decodificar el token usando tu clase JWT
        $payload = JWT::validar($jwt); 

        if (!$payload) {
            http_response_code(401);
            echo json_encode(["status" => "error", "message" => "Token inválido"]);
            exit();
        }

        $id_usuario = $payload['id_usuario'];

        // Buscar los datos completos del usuario en la BD
        $usuarioModel = new Usuario();
        $user = $usuarioModel->obtenerPorId($id_usuario); 

        if (!$user) {
            http_response_code(404);
            echo json_encode(["status" => "error", "message" => "Usuario no encontrado"]);
            exit();
        }

        // Responder con los datos limpios 
        http_response_code(200);
        echo json_encode([
            "status" => "success",
            "data" => [
                "usuario"          => $user['usuario'],
                "nombreUsuario"    => $user['nombreUsuario'],
                "apellidoUsuario"  => $user['apellidoUsuario'],
                "emailUsuario"     => $user['emailUsuario'],
                "telefonoUsuario"  => $user['telefonoUsuario'],
                "rol"              => $user['rol']
            ]
        ]);
        exit();

    } catch (Exception $e) {
        http_response_code(500);
        echo json_encode(["status" => "error", "message" => "Error en el servidor: " . $e->getMessage()]);
        exit();
    }
}
}
