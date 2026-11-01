<?php
// models/Factura.php
require_once __DIR__ . '/../config/Database.php';

class Factura {
    private $conn;
    private $table_name = "factura";

    public function __construct() {
        $database = new Database();
        $this->conn = $database->getConnection();
    }

    public function crear($datos) {
        $query = "INSERT INTO " . $this->table_name . " 
                  (id_orden, codigo_factura, metodo_pago, referencia_pago, total) 
                  VALUES 
                  (:id_orden, :codigo_factura, :metodo_pago, :referencia_pago, :total)";
        
        try {
            $stmt = $this->conn->prepare($query);

            $stmt->bindParam(':id_orden', $datos['id_orden'], PDO::PARAM_INT);
            $stmt->bindParam(':codigo_factura', $datos['codigo_factura']);
            $stmt->bindParam(':metodo_pago', $datos['metodo_pago']);
            $stmt->bindParam(':referencia_pago', $datos['referencia_pago']);
            $stmt->bindParam(':total', $datos['total']);

            if ($stmt->execute()) {
                return ["status" => true, "id_factura" => $this->conn->lastInsertId()];
            }
            return ["status" => false, "message" => "No se pudo registrar la factura."];
        } catch (PDOException $e) {
            return ["status" => false, "message" => "Error interno: " . $e->getMessage()];
        }
    }
}
?>