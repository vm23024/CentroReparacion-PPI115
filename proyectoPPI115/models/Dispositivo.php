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

    // OBTENER DISPOSITIVOS POR ID DE CLIENTE
    public function obtenerPorCliente($id_cliente) {
        $query = "SELECT * FROM " . $this->table_name . " WHERE id_cliente = :id_cliente ORDER BY id_dispositivo DESC";
        try {
            $stmt = $this->conn->prepare($query);
            $id_cli_int = (int)$id_cliente;
            $stmt->bindParam(':id_cliente', $id_cli_int, PDO::PARAM_INT);
            $stmt->execute();
            return $stmt->fetchAll(PDO::FETCH_ASSOC);
        } catch (PDOException $e) {
            return [];
        }
    }

    // OBTENER TODOS LOS DISPOSITIVOS CON EL NOMBRE DEL CLIENTE
    public function obtenerTodosConCliente() {
        $query = "SELECT d.*, CONCAT(c.nombre, ' ', c.apellido) AS nombre_cliente 
                  FROM " . $this->table_name . " d
                  LEFT JOIN Cliente c ON d.id_cliente = c.id_cliente
                  ORDER BY d.id_dispositivo DESC";
        try {
            $stmt = $this->conn->prepare($query);
            $stmt->execute();
            return $stmt->fetchAll(PDO::FETCH_ASSOC);
        } catch (PDOException $e) {
            return [];
        }
    }

    // ACTUALIZAR ESTADO DE REPARACIÓN
    public function actualizarEstado($id_dispositivo, $estado_reparacion) {
        $query = "UPDATE " . $this->table_name . " SET estado_reparacion = :estado_reparacion WHERE id_dispositivo = :id_dispositivo";
        try {
            $stmt = $this->conn->prepare($query);
            $id_disp_int = (int)$id_dispositivo;
            $est_limpio  = htmlspecialchars(strip_tags($estado_reparacion));

            $stmt->bindParam(':estado_reparacion', $est_limpio);
            $stmt->bindParam(':id_dispositivo', $id_disp_int, PDO::PARAM_INT);
            
            if ($stmt->execute()) {
                return ["status" => true, "message" => "Estado actualizado con éxito"];
            }
            return ["status" => false, "message" => "No se pudo actualizar el estado."];
        } catch (PDOException $e) {
            return ["status" => false, "message" => "Error interno: " . $e->getMessage()];
        }
    }

    // CREAR DISPOSITIVO CON IMAGEN Y FECHA DE CITA
    public function crearConImagen($id_cliente, $marca, $modelo, $imei_serie, $observaciones, $imagen, $fecha_cita, $accesorios) {
        $query = "INSERT INTO " . $this->table_name . " (id_cliente, marca, modelo, imei_serie, observaciones, imagen, fecha_cita, accesorios) 
                  VALUES (:id_cliente, :marca, :modelo, :imei_serie, :observaciones, :imagen, :fecha_cita, :accesorios)";
        try {
            $stmt = $this->conn->prepare($query);

            $id_cli_int  = (int)$id_cliente;
            $m_limpio    = htmlspecialchars(strip_tags($marca));
            $mod_limpio  = htmlspecialchars(strip_tags($modelo));
            $i_limpio    = !empty($imei_serie) ? htmlspecialchars(strip_tags($imei_serie)) : null;
            $o_limpio    = !empty($observaciones) ? htmlspecialchars(strip_tags($observaciones)) : null;
            $img_limpia  = !empty($imagen) ? htmlspecialchars(strip_tags($imagen)) : null;
            $f_limpia    = !empty($fecha_cita) ? htmlspecialchars(strip_tags($fecha_cita)) : null;
            $acc_limpio  = !empty($accesorios) ? htmlspecialchars(strip_tags($accesorios)) : null;

            $stmt->bindParam(':id_cliente', $id_cli_int, PDO::PARAM_INT);
            $stmt->bindParam(':marca', $m_limpio);
            $stmt->bindParam(':modelo', $mod_limpio);
            $stmt->bindParam(':imei_serie', $i_limpio);
            $stmt->bindParam(':observaciones', $o_limpio);
            $stmt->bindParam(':imagen', $img_limpia);
            $stmt->bindParam(':fecha_cita', $f_limpia);
            $stmt->bindParam(':accesorios', $acc_limpio);

            if ($stmt->execute()) {
                return ["status" => true, "id" => $this->conn->lastInsertId()];
            }
            return ["status" => false, "message" => "No se pudo registrar el dispositivo."];
        } catch (PDOException $e) {
            return ["status" => false, "message" => "Error interno: " . $e->getMessage()];
        }
    }
}
?>