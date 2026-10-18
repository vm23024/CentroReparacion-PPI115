<?php
// controllers/FacturaController.php
require_once './models/Factura.php';
require_once './config/AuthMiddleware.php';

class FacturaController {
    private $facturaModel;

    public function __construct() {
        AuthMiddleware::verificar(); // Protección JWT activa
        $this->facturaModel = new Factura();
    }

    // GET /facturas o /facturas?id=X
    public function listar() {
        if (isset($_GET['id']) && !empty($_GET['id'])) {
            $id = (int)$_GET['id'];
            $factura = $this->facturaModel->obtenerPorId($id);

            if ($factura) {
                http_response_code(200);
                echo json_encode(["status" => "success", "data" => $factura]);
            } else {
                http_response_code(404);
                echo json_encode(["status" => "error", "message" => "Factura no encontrada."]);
            }
            return;
        }

        $facturas = $this->facturaModel->leer();
        http_response_code(200);
        echo json_encode(["status" => "success", "data" => $facturas]);
    }

    // POST /facturas
    public function guardar() {
        $data = json_decode(file_get_contents("php://input"));

        // Validaciones requeridas de los campos NOT NULL
        if (empty($data->id_orden) || !isset($data->subtotal) || !isset($data->total) || empty($data->metodo_pago) || empty($data->estado_pago)) {
            http_response_code(400);
            echo json_encode(["status" => "error", "message" => "Faltan datos obligatorios para facturar."]);
            return;
        }

        // Validar tipos ENUM según tu estructura de tabla
        $metodos_permitidos = ['Efectivo', 'Tarjeta', 'Transferencia'];
        $estados_permitidos = ['Pendiente', 'Pagado'];

        if (!in_array($data->metodo_pago, $metodos_permitidos) || !in_array($data->estado_pago, $estados_permitidos)) {
            http_response_code(400);
            echo json_encode(["status" => "error", "message" => "Valores de método o estado de pago no válidos."]);
            return;
        }

        $resultado = $this->facturaModel->crear(
            $data->id_orden, $data->subtotal, $data->impuesto ?? 0.00, $data->total,
            $data->metodo_pago, $data->estado_pago, $data->garantia_dias ?? 0, $data->observaciones ?? null
        );

        if ($resultado['status']) {
            http_response_code(201);
            echo json_encode(["status" => "success", "message" => "Factura generada con éxito", "id_factura" => $resultado['id']]);
        } else {
            $code = (strpos($resultado['message'], 'id_orden') !== false) ? 400 : 500;
            http_response_code($code);
            echo json_encode(["status" => "error", "message" => $resultado['message']]);
        }
    }
}
?>