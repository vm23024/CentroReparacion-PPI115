<?php
// generador de token nativo

class JWT {
    private static $secret;

    private static function init() {
        self::$secret = getenv('JWT_SECRET') ?: 'default_secret_key_123';
    }

    // Codificación Base64URL requerida por el estándar JWT
    private static function base64UrlEncode($data) {
        return str_replace(['+', '/', '='], ['-', '_', ''], base64_encode($data));
    }

    // Decodificación Base64URL
    private static function base64UrlDecode($data) {
        $remainder = strlen($data) % 4;
        if ($remainder) {
            $padlen = 4 - $remainder;
            $data .= str_repeat('=', $padlen);
        }
        return base64_decode(str_replace(['-', '_'], ['+', '/'], $data));
    }

    // 1. GENERAR EL TOKEN
    public static function generar($payload) {
        self::init();

        $header = json_encode(['typ' => 'JWT', 'alg' => 'HS256']);
        
        // Agregar tiempos de emisión y expiración al payload
        $expiration = getenv('JWT_EXPIRATION') ?: 14400;
        $payload['iat'] = time();
        $payload['exp'] = time() + (int)$expiration;
        $payload_json = json_encode($payload);

        $base64UrlHeader = self::base64UrlEncode($header);
        $base64UrlPayload = self::base64UrlEncode($payload_json);

        // Crear la firma criptográfica
        $signature = hash_hmac('sha256', $base64UrlHeader . "." . $base64UrlPayload, self::$secret, true);
        $base64UrlSignature = self::base64UrlEncode($signature);

        return $base64UrlHeader . "." . $base64UrlPayload . "." . $base64UrlSignature;
    }

    // 2. VALIDAR EL TOKEN RECIBIDO
    public static function validar($token) {
        self::init();

        $partes = explode('.', $token);
        if (count($partes) !== 3) {
            return false; // Token mal formado
        }

        list($base64UrlHeader, $base64UrlPayload, $base64UrlSignature) = $partes;

        // Re-calcular la firma para comprobar que el token no ha sido alterado
        $signature = hash_hmac('sha256', $base64UrlHeader . "." . $base64UrlPayload, self::$secret, true);
        $base64UrlSignatureCheck = self::base64UrlEncode($signature);

        if ($base64UrlSignature !== $base64UrlSignatureCheck) {
            return false; // Firma inválida (token manipulado o secreto incorrecto)
        }

        $payload = json_encode(self::base64UrlDecode($base64UrlPayload));
        $data = json_decode(self::base64UrlDecode($base64UrlPayload), true);

        // Verificar si el token ya expiró
        if (isset($data['exp']) && $data['exp'] < time()) {
            return false; // Token expirado
        }

        return $data; // Token válido, retorna los datos del usuario contenidos dentro
    }
}
