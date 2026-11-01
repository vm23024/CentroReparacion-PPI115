<?php
require_once __DIR__ . '/../config/Database.php';

class Repuesto
{
    private $conn;
    private $table_name = "Repuesto";

    public function __construct()
    {
        $database = new Database();
        $this->conn = $database->getConnection();
    }

    public function leer()
    {
        $query = "SELECT * FROM " . $this->table_name . " ORDER BY id_repuesto DESC";
        $stmt = $this->conn->prepare($query);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function obtenerPorId($id)
    {
        $query = "SELECT * FROM " . $this->table_name . " WHERE id_repuesto = :id LIMIT 0,1";
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(':id', $id, PDO::PARAM_INT);
        $stmt->execute();
        return $stmt->fetch(PDO::FETCH_ASSOC) ?: null;
    }

    public function crear($tipo_repuesto, $marca, $modelo, $stock_actual, $stock_minimo, $precio_unitario, $numero_serie, $id_usuario, $nombre_empleado, $imagen, $descripcion, $observaciones, $activo = 1)
    {
        $query = "INSERT INTO " . $this->table_name . " 
              (tipo_repuesto, marca, modelo, stock_actual, stock_minimo, precio_unitario, numero_serie, id_usuario, nombre_empleado, imagen, descripcion, observaciones, activo) 
              VALUES 
              (:tipo_repuesto, :marca, :modelo, :stock_actual, :stock_minimo, :precio_unitario, :numero_serie, :id_usuario, :nombre_empleado, :imagen, :descripcion, :observaciones, :activo)";

        try {
            $stmt = $this->conn->prepare($query);

            $tipo_limp = htmlspecialchars(strip_tags($tipo_repuesto));
            $marca_limp = htmlspecialchars(strip_tags($marca));
            $modelo_limp = htmlspecialchars(strip_tags($modelo));
            $stk_act_int = (int) $stock_actual;
            $stk_min_int = isset($stock_minimo) ? (int) $stock_minimo : 3;
            $precio_dec = isset($precio_unitario) ? (float) $precio_unitario : 0.00;
            $num_serie_limp = !empty($numero_serie) ? htmlspecialchars(strip_tags($numero_serie)) : null;
            $id_usu_int = !empty($id_usuario) ? (int) $id_usuario : null;
            $nom_emp_limp = !empty($nombre_empleado) ? htmlspecialchars(strip_tags($nombre_empleado)) : null;
            $img_limp = !empty($imagen) ? htmlspecialchars(strip_tags($imagen)) : null;
            $desc_limpia = !empty($descripcion) ? htmlspecialchars(strip_tags($descripcion)) : null;
            $obs_limpia = !empty($observaciones) ? htmlspecialchars(strip_tags($observaciones)) : null;
            $act_int = (int) $activo;

            $stmt->bindParam(':tipo_repuesto', $tipo_limp);
            $stmt->bindParam(':marca', $marca_limp);
            $stmt->bindParam(':modelo', $modelo_limp);
            $stmt->bindParam(':stock_actual', $stk_act_int, PDO::PARAM_INT);
            $stmt->bindParam(':stock_minimo', $stk_min_int, PDO::PARAM_INT);
            $stmt->bindParam(':precio_unitario', $precio_dec);
            $stmt->bindParam(':numero_serie', $num_serie_limp);
            $stmt->bindParam(':id_usuario', $id_usu_int, PDO::PARAM_INT);       
            $stmt->bindParam(':nombre_empleado', $nom_emp_limp);                
            $stmt->bindParam(':imagen', $img_limp);
            $stmt->bindParam(':descripcion', $desc_limpia);
            $stmt->bindParam(':observaciones', $obs_limpia);
            $stmt->bindParam(':activo', $act_int, PDO::PARAM_INT);

            if ($stmt->execute()) {
                return ["status" => true, "id" => $this->conn->lastInsertId()];
            }
            return ["status" => false, "message" => "No se pudo registrar el repuesto."];
        } catch (PDOException $e) {
            return ["status" => false, "message" => "Error interno: " . $e->getMessage()];
        }
    }

    public function eliminar($id_repuesto) {
        try {
            $query = "DELETE FROM repuesto WHERE id_repuesto = :id_repuesto";
            
            $stmt = $this->conn->prepare($query);
            $stmt->bindParam(':id_repuesto', $id_repuesto, PDO::PARAM_INT);
            
            if ($stmt->execute()) {
                return true;
            }
            return false;
        } catch (PDOException $e) {
            echo "Error al eliminar: " . $e->getMessage();
            exit();
        }
    }

    public function disminuirStock($id_repuesto) {
    try {
        // 1. Consultar el stock actual del repuesto
        $queryCheck = "SELECT stock_actual FROM repuesto WHERE id_repuesto = :id_repuesto";
        $stmtCheck = $this->conn->prepare($queryCheck);
        $stmtCheck->bindParam(':id_repuesto', $id_repuesto, PDO::PARAM_INT);
        $stmtCheck->execute();
        $repuesto = $stmtCheck->fetch(PDO::FETCH_ASSOC);

        if ($repuesto) {
            $stockActual = intval($repuesto['stock_actual']);

            if ($stockActual > 1) {
                // Si hay más de 1, restamos uno al stock actual
                $queryUpdate = "UPDATE repuesto SET stock_actual = stock_actual - 1 WHERE id_repuesto = :id_repuesto";
                $stmtUpdate = $this->conn->prepare($queryUpdate);
                $stmtUpdate->bindParam(':id_repuesto', $id_repuesto, PDO::PARAM_INT);
                return $stmtUpdate->execute();
            } else {
                // Si solo queda 1, se elimina el registro de la bd 
                $queryDelete = "DELETE FROM repuesto WHERE id_repuesto = :id_repuesto";
                $stmtDelete = $this->conn->prepare($queryDelete);
                $stmtDelete->bindParam(':id_repuesto', $id_repuesto, PDO::PARAM_INT);
                return $stmtDelete->execute();
            }
        }
        return false;
    } catch (PDOException $e) {
        echo "Error: " . $e->getMessage();
        exit();
    }
}
}
?>