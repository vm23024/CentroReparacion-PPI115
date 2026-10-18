<?php

require_once './config/Database.php';

class Repuesto {
    private $conn;
    private $table_name = "Repuesto";

    public function __construct() {
        $database = new Database();
        $this->conn = $database->getConnection();
    }

    // 1. LISTAR TODOS
    public function leer() {
        $query = "SELECT * FROM " . $this->table_name . " ORDER BY id_repuesto DESC";
        $stmt = $this->conn->prepare($query);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    // 2. OBTENER UNO POR ID
    public function obtenerPorId($id) {
        $query = "SELECT * FROM " . $this->table_name . " WHERE id_repuesto = :id LIMIT 0,1";
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(':id', $id, PDO::PARAM_INT);
        $stmt->execute();
        return $stmt->fetch(PDO::FETCH_ASSOC) ?: null;
    }

    // 3. CREAR REPUESTO
    public function crear($nombreRepuesto, $descripcion, $stock_actual, $stock_minimo, $precio_unitario, $activo = 1) {
        $query = "INSERT INTO " . $this->table_name . " (nombreRepuesto, descripcion, stock_actual, stock_minimo, precio_unitario, activo) 
                  VALUES (:nombreRepuesto, :descripcion, :stock_actual, :stock_minimo, :precio_unitario, :activo)";
        try {
            $stmt = $this->conn->prepare($query);

            // Guardar en variables independientes para bindParam
            $nom_limpio  = htmlspecialchars(strip_tags($nombreRepuesto));
            $desc_limpia = !empty($descripcion) ? htmlspecialchars(strip_tags($descripcion)) : null;
            $stk_act_int = isset($stock_actual) ? (int)$stock_actual : 0;
            $stk_min_int = isset($stock_minimo) ? (int)$stock_minimo : 3;
            $precio_dec  = (float)$precio_unitario;
            $act_int     = (int)$activo;

            $stmt->bindParam(':nombreRepuesto', $nom_limpio);
            $stmt->bindParam(':descripcion', $desc_limpia);
            $stmt->bindParam(':stock_actual', $stk_act_int, PDO::PARAM_INT);
            $stmt->bindParam(':stock_minimo', $stk_min_int, PDO::PARAM_INT);
            $stmt->bindParam(':precio_unitario', $precio_dec);
            $stmt->bindParam(':activo', $act_int, PDO::PARAM_INT);

            if ($stmt->execute()) {
                return ["status" => true, "id" => $this->conn->lastInsertId()];
            }
            return ["status" => false, "message" => "No se pudo registrar el repuesto."];
        } catch (PDOException $e) {
            return ["status" => false, "message" => "Error interno: " . $e->getMessage()];
        }
    }
}
