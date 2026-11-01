<?php
// controllers/FacturaController.php
require_once __DIR__ . '/../models/Factura.php';
require_once __DIR__ . '/../models/OrdenReparacion.php';
require_once __DIR__ . '/../config/JWT.php';

class FacturaController
{

    public function guardarFactura()
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

        $data = json_decode(file_get_contents("php://input"), true);

        if (empty($data['id_orden']) || empty($data['total'])) {
            http_response_code(400);
            echo json_encode(["status" => "error", "message" => "Datos incompletos para procesar la factura."]);
            exit;
        }

        $facturaModel = new Factura();
        $resultado = $facturaModel->crear([
            'id_orden' => $data['id_orden'],
            'codigo_factura' => $data['codigo_factura'] ?? 'FAC-' . date('Y') . '-' . rand(1000, 9999),
            'metodo_pago' => $data['metodo_pago'] ?? 'efectivo',
            'referencia_pago' => !empty($data['referencia_pago']) ? $data['referencia_pago'] : null,
            'total' => $data['total']
        ]);

        if ($resultado['status']) {
            $ordenModel = new OrdenReparacion();
            $ordenModel->actualizarEstadoYDiagnostico($data['id_orden'], 'Pagado / Finalizado', null, null);

            http_response_code(201);
            echo json_encode([
                "status" => "success",
                "message" => "Pago procesado y factura guardada con éxito",
                "id_factura" => $resultado['id_factura']
            ]);
            exit;
        } else {
            http_response_code(500);
            echo json_encode(["status" => "error", "message" => $resultado['message']]);
            exit;
        }
    }
}
?>