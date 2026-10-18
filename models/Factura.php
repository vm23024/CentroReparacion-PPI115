<?php
// models/Factura.php
require_once './config/Database.php';

class Factura {
    private $conn;
    private $table_name = "Factura";

    public function __construct() {
        $database = new Database();
        $this->conn = $database->getConnection();
    }

    // LISTAR TODAS
    public function leer() {
        $query = "SELECT * FROM " . $this->table_name . " ORDER BY id_factura DESC";
        $stmt = $this->conn->prepare($query);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    // OBTENER UNA POR ID
    public function obtenerPorId($id) {
        $query = "SELECT * FROM " . $this->table_name . " WHERE id_factura = :id LIMIT 0,1";
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(':id', $id, PDO::PARAM_INT);
        $stmt->execute();
        return $stmt->fetch(PDO::FETCH_ASSOC) ?: null;
    }

    // CREAR FACTURA
    public function crear($id_orden, $subtotal, $impuesto, $total, $metodo_pago, $estado_pago, $garantia_dias, $observaciones) {
        $query = "INSERT INTO " . $this->table_name . " (id_orden, fecha_emision, subtotal, impuesto, total, metodo_pago, estado_pago, garantia_dias, observaciones) 
                  VALUES (:id_orden, NOW(), :subtotal, :impuesto, :total, :metodo_pago, :estado_pago, :garantia_dias, :observaciones)";
        try {
            $stmt = $this->conn->prepare($query);

            $id_ord_int  = (int)$id_orden;
            $sub_dec     = (float)$subtotal;
            $imp_dec     = (float)$impuesto;
            $tot_dec     = (float)$total;
            $met_limpio  = htmlspecialchars(strip_tags($metodo_pago));
            $est_limpio  = htmlspecialchars(strip_tags($estado_pago));
            $gar_int     = !empty($garantia_dias) ? (int)$garantia_dias : 0;
            $obs_limpio  = !empty($observaciones) ? htmlspecialchars(strip_tags($observaciones)) : null;

            $stmt->bindParam(':id_orden', $id_ord_int, PDO::PARAM_INT);
            $stmt->bindParam(':subtotal', $sub_dec);
            $stmt->bindParam(':impuesto', $imp_dec);
            $stmt->bindParam(':total', $tot_dec);
            $stmt->bindParam(':metodo_pago', $met_limpio);
            $stmt->bindParam(':estado_pago', $est_limpio);
            $stmt->bindParam(':garantia_dias', $gar_int, PDO::PARAM_INT);
            $stmt->bindParam(':observaciones', $obs_limpio);

            if ($stmt->execute()) {
                return ["status" => true, "id" => $this->conn->lastInsertId()];
            }
            return ["status" => false, "message" => "No se pudo emitir la factura."];
        } catch (PDOException $e) {
            // Capturar de forma elegante si la orden no existe en la base de datos
            if ($e->getCode() == 23000) {
                return ["status" => false, "message" => "Error de integridad: El id_orden especificado no existe."];
            }
            return ["status" => false, "message" => "Error interno: " . $e->getMessage()];
        }
    }
}
?>