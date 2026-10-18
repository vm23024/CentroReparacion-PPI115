<?php
//Archivo encargado de interceptar cabeceras 
//para proteger endpoints
require_once './config/JWT.php';

class AuthMiddleware {
    public static function verificar() {
        // Obtener todas las cabeceras de la petición
        $headers = apache_request_headers();

        // Buscar la cabecera Authorization (insensible a mayúsculas)
        $authHeader = null;
        foreach ($headers as $key => $value) {
            if (strtolower($key) === 'authorization') {
                $authHeader = $value;
                break;
            }
        }

        if (!$authHeader) {
            http_response_code(401);
            echo json_encode(["status" => "error", "message" => "Acceso denegado. Token requerido."]);
            exit();
        }

        // Extraer el token quitando la palabra 'Bearer '
        $arr = explode(" ", $authHeader);
        $token = isset($arr[1]) ? $arr[1] : null;

        if (!$token) {
            http_response_code(401);
            echo json_encode(["status" => "error", "message" => "Formato de token inválido (Debe ser Bearer TOKEN)."]);
            exit();
        }

        // Validar el token usando nuestra clase criptográfica
        $datosUsuario = JWT::validar($token);

        if (!$datosUsuario) {
            http_response_code(401);
            echo json_encode(["status" => "error", "message" => "Token inválido o expirado."]);
            exit();
        }

        // Retorna los datos que guardamos en el login (id_usuario, rol, etc.) si es válido
        return $datosUsuario;
    }
}
?>