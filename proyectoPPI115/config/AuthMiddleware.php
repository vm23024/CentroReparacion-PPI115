<?php
// Archivo encargado de interceptar cabeceras para proteger endpoints
require_once __DIR__ . '/JWT.php';

class AuthMiddleware {
    
    // Verifica que exista un token válido
    public static function verificar() {
        $headers = apache_request_headers();
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

        $arr = explode(" ", $authHeader);
        $token = isset($arr[1]) ? $arr[1] : null;

        if (!$token) {
            http_response_code(401);
            echo json_encode(["status" => "error", "message" => "Formato de token inválido (Debe ser Bearer TOKEN)."]);
            exit();
        }

        $datosUsuario = JWT::validar($token);

        if (!$datosUsuario) {
            http_response_code(401);
            echo json_encode(["status" => "error", "message" => "Token inválido o expirado."]);
            exit();
        }

        return $datosUsuario;
    }

    // Verifica token y además comprueba si el rol del usuario está permitido
    public static function verificarRol($rolesPermitidos = []) {
        $datosUsuario = self::verificar();

        // Asegúrate de que el objeto o array contenga el rol
        $rolUsuario = $datosUsuario->rol ?? $datosUsuario['rol'] ?? null;

        if (!$rolUsuario || !in_array($rolUsuario, $rolesPermitidos)) {
            http_response_code(403);
            echo json_encode([
                "status" => "error", 
                "message" => "Acceso denegado. No tienes permisos para esta acción."
            ]);
            exit();
        }

        return $datosUsuario;
    }
}
?>