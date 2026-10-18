<?php
// models/OrdenReparacion.php
require_once './config/Database.php';

class OrdenReparacion {
    private $conn;
    private $table_name = "OrdenReparacion";

    public function __construct() {
        $database = new Database();
        $this->conn = $database->getConnection();
    }

    // LISTAR TODAS
    public function leer() {
        $query = "SELECT * FROM " . $this->table_name . " ORDER BY id_orden DESC";
        $stmt = $this->conn->prepare($query);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    // OBTENER UNA POR ID
    public function obtenerPorId($id) {
        $query = "SELECT * FROM " . $this->table_name . " WHERE id_orden = :id LIMIT 0,1";
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(':id', $id, PDO::PARAM_INT);
        $stmt->execute();
        return $stmt->fetch(PDO::FETCH_ASSOC) ?: null;
    }

    // CREAR ORDEN DE REPARACIÓN
    public function crear($id_dispositivo, $id_tecnico, $fecha_estimada, $descripcion_problema, $diagnostico, $observaciones, $estado = 'Recibido') {
        $query = "INSERT INTO " . $this->table_name . " (id_dispositivo, id_tecnico, fecha_ingreso, fecha_estimada, estado, descripcion_problema, diagnostico, observaciones) 
                  VALUES (:id_dispositivo, :id_tecnico, NOW(), :fecha_estimada, :estado, :descripcion_problema, :diagnostico, :observaciones)";
        try {
            $stmt = $this->conn->prepare($query);

            // Mapeo seguro guardando variables independientes
            $id_disp_int = (int)$id_dispositivo;
            $id_tec_int  = !empty($id_tecnico) ? (int)$id_tecnico : null;
            $f_est_limp  = !empty($fecha_estimada) ? htmlspecialchars(strip_tags($fecha_estimada)) : null;
            $est_limp    = htmlspecialchars(strip_tags($estado));
            $desc_limp   = htmlspecialchars(strip_tags($descripcion_problema));
            $diag_limp   = !empty($diagnostico) ? htmlspecialchars(strip_tags($diagnostico)) : null;
            $obs_limp    = !empty($observaciones) ? htmlspecialchars(strip_tags($observaciones)) : null;

            $stmt->bindParam(':id_dispositivo', $id_disp_int, PDO::PARAM_INT);
            $stmt->bindParam(':id_tecnico', $id_tec_int);
            $stmt->bindParam(':fecha_estimada', $f_est_limp);
            $stmt->bindParam(':estado', $est_limp);
            $stmt->bindParam(':descripcion_problema', $desc_limp);
            $stmt->bindParam(':diagnostico', $diag_limp);
            $stmt->bindParam(':observaciones', $obs_limp);

            if ($stmt->execute()) {
                return ["status" => true, "id" => $this->conn->lastInsertId()];
            }
            return ["status" => false, "message" => "No se pudo crear la orden de reparación."];
        } catch (PDOException $e) {
            if ($e->getCode() == 23000) {
                return ["status" => false, "message" => "Error de llave foránea: Verifique si el id_dispositivo o id_tecnico existen."];
            }
            return ["status" => false, "message" => "Error interno: " . $e->getMessage()];
        }
    }
}
?>