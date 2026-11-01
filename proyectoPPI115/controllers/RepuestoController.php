<?php
require_once __DIR__ . '/../models/Repuesto.php';
require_once __DIR__ . '/../config/AuthMiddleware.php';

class RepuestoController {
    private $repuestoModel;

    public function __construct() {
        $this->repuestoModel = new Repuesto();
    }

    public function guardar() {
        $payload = AuthMiddleware::verificar();
        if (!$payload) return;

        // Capturar los datos enviados 
        $tipo_repuesto = $_POST['tipoRepuesto'] ?? null;
        $marca = $_POST['marcaRepuesto'] ?? null;
        $modelo = $_POST['modeloRepuesto'] ?? null;
        $stock_actual = $_POST['cantidadStock'] ?? null;
        $precio_unitario = $_POST['precioUnitario'] ?? 0.00; 
        $numero_serie = $_POST['numeroSerie'] ?? null;
        $descripcion = $_POST['descripcionRepuesto'] ?? null;
        $observaciones = $_POST['observacionesRepuesto'] ?? null;

        // Validar campos obligatorios
        if (empty($tipo_repuesto) || empty($marca) || empty($modelo) || !isset($stock_actual)) {
            http_response_code(400);
            echo json_encode(["status" => "error", "message" => "Faltan campos obligatorios."]);
            return;
        }

        // Manejo de la imagen adjunta 
        $rutaImagen = null;
        if (isset($_FILES['imagenRepuesto']) && $_FILES['imagenRepuesto']['error'] === UPLOAD_ERR_OK) {
            $nombreArchivo = time() . '_' . basename($_FILES['imagenRepuesto']['name']);
            $carpetaDestino = __DIR__ . '/../uploads/';
            
            if (!file_exists($carpetaDestino)) {
                mkdir($carpetaDestino, 0777, true);
            }
            
            $rutaDestino = $carpetaDestino . $nombreArchivo;
            if (move_uploaded_file($_FILES['imagenRepuesto']['tmp_name'], $rutaDestino)) {
                $rutaImagen = 'uploads/' . $nombreArchivo;
            }
        }

        // Obtener id y nombre del empleado autenticado
        $id_usuario = $payload['id_usuario'] ?? $payload['id'] ?? null;
        $nombre_empleado = trim(($payload['nombre'] ?? '') . ' ' . ($payload['apellido'] ?? ''));
        if (empty($nombre_empleado)) {
            $nombre_empleado = $payload['usuario'] ?? $payload['nombre_usuario'] ?? 'Empleado';
        }

        $resultado = $this->repuestoModel->crear(
            $tipo_repuesto,
            $marca,
            $modelo,
            $stock_actual,
            3,                  
            $precio_unitario,   
            $numero_serie,
            $id_usuario,        
            $nombre_empleado,   
            $rutaImagen,
            $descripcion,
            $observaciones,
            1                   
        );

        if ($resultado['status']) {
            http_response_code(201);
            echo json_encode([
                "status" => "success", 
                "message" => "¡Repuesto registrado con éxito!", 
                "id_repuesto" => $resultado['id']
            ]);
        } else {
            http_response_code(500);
            echo json_encode(["status" => "error", "message" => $resultado['message']]);
        }
    }


    // Obtiene todos los repuestos 
    public function listar() {
        return $this->repuestoModel->leer();
    }


    //disminuye un stock
    public function eliminar() {
        $id_repuesto = $_POST['id_repuesto_seleccionado'] ?? null;

        if (!empty($id_repuesto)) {
            // Llamamos a la función que descuenta stock o borra si llega a 0
            $this->repuestoModel->disminuirStock($id_repuesto);
        }

        // Recarga la página para mostrar el catálogo actualizado
        header("Location: ../respuestosDisponibles.php");
        exit();
    }

}


if (isset($_GET['accion']) && $_GET['accion'] === 'listarJson') {
    header('Content-Type: application/json');
    $controller = new RepuestoController();
    $datos = $controller->listar();
    echo json_encode($datos); 
    exit();
}

if (isset($_POST['accion']) && $_POST['accion'] === 'eliminar') {
    $controller = new RepuestoController();
    $controller->eliminar();
}
?>