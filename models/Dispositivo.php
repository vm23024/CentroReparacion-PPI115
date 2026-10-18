<?php
// models/Dispositivo.php
require_once './config/Database.php';

class Dispositivo {
    private $conn;
    private $table_name = "Dispositivo";

    public function __construct() {
        $database = new Database();
        $this->conn = $database->getConnection();
    }

    // 1. LISTAR TODOS
    public function leer() {
        $query = "SELECT * FROM " . $this->table_name . " ORDER BY id_dispositivo DESC";
        $stmt = $this->conn->prepare($query);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    // 2. OBTENER UNO POR ID
    public function obtenerPorId($id) {
        $query = "SELECT * FROM " . $this->table_name . " WHERE id_dispositivo = :id LIMIT 0,1";
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(':id', $id, PDO::PARAM_INT);
        $stmt->execute();
        return $stmt->fetch(PDO::FETCH_ASSOC) ?: null;
    }

    // 3. CREAR DISPOSITIVO
    public function crear($id_cliente, $marca, $modelo, $imei_serie, $color, $estado, $observaciones) {
        $query = "INSERT INTO " . $this->table_name . " (id_cliente, marca, modelo, imei_serie, color, estado_fisico_inicial, observaciones) 
                  VALUES (:id_cliente, :marca, :modelo, :imei_serie, :color, :estado, :observaciones)";
        try {
            $stmt = $this->conn->prepare($query);

            // Guardar en variables independientes para la referencia estricta de bindParam
            $id_cli_int = (int)$id_cliente;
            $m_limpio   = htmlspecialchars(strip_tags($marca));
            $mod_limpio = htmlspecialchars(strip_tags($modelo));
            $i_limpio   = !empty($imei_serie) ? htmlspecialchars(strip_tags($imei_serie)) : null;
            $c_limpio   = !empty($color) ? htmlspecialchars(strip_tags($color)) : null;
            $e_limpio   = !empty($estado) ? htmlspecialchars(strip_tags($estado)) : null;
            $o_limpio   = !empty($observaciones) ? htmlspecialchars(strip_tags($observaciones)) : null;

            $stmt->bindParam(':id_cliente', $id_cli_int, PDO::PARAM_INT);
            $stmt->bindParam(':marca', $m_limpio);
            $stmt->bindParam(':modelo', $mod_limpio);
            $stmt->bindParam(':imei_serie', $i_limpio);
            $stmt->bindParam(':color', $c_limpio);
            $stmt->bindParam(':estado', $e_limpio);
            $stmt->bindParam(':observaciones', $o_limpio);

            if ($stmt->execute()) {
                return ["status" => true, "id" => $this->conn->lastInsertId()];
            }
            return ["status" => false, "message" => "No se pudo registrar el dispositivo."];
        } catch (PDOException $e) {
            return ["status" => false, "message" => "Error interno: " . $e->getMessage()];
        }
    }

    // 4. ACTUALIZAR DISPOSITIVO
    public function actualizar($id, $id_cliente, $marca, $modelo, $imei_serie, $color, $estado, $observaciones) {
        if (!$this->obtenerPorId($id)) {
            return ["status" => false, "message" => "El dispositivo especificado no existe."];
        }

        $query = "UPDATE " . $this->table_name . " 
                  SET id_cliente = :id_cliente, marca = :marca, modelo = :modelo, 
                      imei_serie = :imei_serie, color = :color, 
                      estado_fisico_inicial = :estado, observaciones = :observaciones 
                  WHERE id_dispositivo = :id";
        try {
            $stmt = $this->conn->prepare($query);

            $id_int     = (int)$id;
            $id_cli_int = (int)$id_cliente;
            $m_limpio   = htmlspecialchars(strip_tags($marca));
            $mod_limpio = htmlspecialchars(strip_tags($modelo));
            $i_limpio   = !empty($imei_serie) ? htmlspecialchars(strip_tags($imei_serie)) : null;
            $c_limpio   = !empty($color) ? htmlspecialchars(strip_tags($color)) : null;
            $e_limpio   = !empty($estado) ? htmlspecialchars(strip_tags($estado)) : null;
            $o_limpio   = !empty($observaciones) ? htmlspecialchars(strip_tags($observaciones)) : null;

            $stmt->bindParam(':id', $id_int, PDO::PARAM_INT);
            $stmt->bindParam(':id_cliente', $id_cli_int, PDO::PARAM_INT);
            $stmt->bindParam(':marca', $m_limpio);
            $stmt->bindParam(':modelo', $mod_limpio);
            $stmt->bindParam(':imei_serie', $i_limpio);
            $stmt->bindParam(':color', $c_limpio);
            $stmt->bindParam(':estado', $e_limpio);
            $stmt->bindParam(':observaciones', $o_limpio);

            if ($stmt->execute()) {
                return ["status" => true, "message" => "Dispositivo actualizado con éxito."];
            }
            return ["status" => false, "message" => "No se realizaron modificaciones."];
        } catch (PDOException $e) {
            return ["status" => false, "message" => "Error interno: " . $e->getMessage()];
        }
    }

    // 5. ELIMINAR DISPOSITIVO
    public function eliminar($id) {
        if (!$this->obtenerPorId($id)) {
            return ["status" => false, "message" => "El dispositivo especificado no existe."];
        }

        $query = "DELETE FROM " . $this->table_name . " WHERE id_dispositivo = :id";
        try {
            $stmt = $this->conn->prepare($query);
            $id_int = (int)$id;
            $stmt->bindParam(':id', $id_int, PDO::PARAM_INT);

            if ($stmt->execute()) {
                return ["status" => true, "message" => "Dispositivo eliminado exitosamente."];
            }
            return ["status" => false, "message" => "No se pudo eliminar."];
        } catch (PDOException $e) {
            return ["status" => false, "message" => "Error interno: " . $e->getMessage()];
        }
    }
}
?>