<?php
header('Content-Type: application/json');

$host = "localhost";
$dbname = "proyectoppi"; 
$username = "root";
$password = "";

try {
    $conexion = new PDO("mysql:host=$host;dbname=$dbname;charset=utf8", $username, $password);
    $conexion->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    $imei = isset($_GET['imei']) ? trim($_GET['imei']) : '';

    if (empty($imei)) {
        echo json_encode(["status" => "error", "message" => "IMEI no proporcionado"]);
        exit;
    }

   
    $stmt = $conexion->prepare("SELECT * FROM ordenreparacion WHERE numero_imei = :imei LIMIT 1");
    $stmt->execute([':imei' => $imei]);
    $orden = $stmt->fetch(PDO::FETCH_ASSOC);

    if ($orden) {
        echo json_encode(["status" => "success", "data" => $orden]);
    } else {
        echo json_encode(["status" => "error", "message" => "No se encontró ninguna orden con este IMEI"]);
    }

} catch (Exception $e) {
    echo json_encode(["status" => "error", "message" => "Error de conexión: " . $e->getMessage()]);
}
?>