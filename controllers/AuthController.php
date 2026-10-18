<?php
//Controlador para la autenticacion recibiendo datos a traves de POST
require_once './models/Usuario.php';
require_once './config/JWT.php';

class AuthController
{ //Definiendo clase

    public function login()
    { //Metodo para leer parametros a recibir
        // Leer el JSON recibido en el cuerpo de la petición POST
        $data = json_decode(file_get_contents("php://input"));

        // Validar que vengan los datos obligatorios
        if (empty($data->usuario) || empty($data->password)) {
            http_response_code(400);
            echo json_encode(["status" => "error", "message" => "Faltan datos (usuario o password)"]);
            return;
        }

        $usuarioModel = new Usuario();
        $user = $usuarioModel->obtenerPorUsuario($data->usuario);

        // Verificar si el usuario existe
        if (!$user) {
            http_response_code(401);
            echo json_encode(["status" => "error", "message" => "Credenciales incorrectas"]);
            return;
        }

        // Verificar si está activo (según tu atributo 'activo' en el diagrama)
        if ($user['activo'] == 0) {
            http_response_code(403);
            echo json_encode(["status" => "error", "message" => "El usuario se encuentra inactivo"]);
            return;
        }

        // Verificar contraseña hash
        if (password_verify($data->password, $user['password_hash'])) {

            // Datos del usuario que viajan seguros dentro del JWT
            $payloadData = [
                "id_usuario" => $user['id_usuario'],
                "usuario"    => $user['nombreUsuario'],
                "rol"        => $user['rol']
            ];

            // Generar el Token usando nuestra clase
            $jwt_token = JWT::generar($payloadData);

            http_response_code(200);
            echo json_encode([
                "status"  => "success",
                "message" => "Login exitoso",
                "token"   => $jwt_token 
            ]);
        } else {
            http_response_code(401);
            echo json_encode(["status" => "error", "message" => "Credenciales incorrectas"]);
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
            $data->activo,
            $data->emailUsuario ?? NULL,
            $data->telefonoUsuario ?? NULL
        );

        if ($resultado['status']) {
            http_response_code(201); // 201 Created
            echo json_encode([
                "status" => "success",
                "message" => "Usuario creado exitosamente",
                "data" => [
                    "id_usuario" => $resultado['id']
                ]
            ]);
        } else {
            http_response_code(400); // 400 Bad Request
            echo json_encode([
                "status" => "error",
                "message" => $resultado['message']
            ]);
        }
    }
}
