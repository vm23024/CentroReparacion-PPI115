<?php
// models/OrdenReparacion.php
require_once __DIR__ . '/../config/Database.php';

class OrdenReparacion {
    private $conn;
    private $table_name = "ordenReparacion";

    public function __construct() {
        $database = new Database();
        $this->conn = $database->getConnection();
    }

    // OBTENER TODAS LAS ÓRDENES CON DATOS DEL DISPOSITIVO, CLIENTE Y REPUESTO
    public function obtenerTodasConDetalles() {
        $query = "SELECT o.*, 
                         CONCAT(c.nombre, ' ', c.apellido) AS nombre_cliente,
                         c.telefono,
                         d.imagen, d.marca AS marca_dispositivo, d.modelo AS modelo_dispositivo, d.imei_serie AS numero_imei, d.observaciones AS falla_cliente,
                         r.tipo_repuesto AS nombre_repuesto, r.marca AS marca_repuesto, or_rel.cantidad AS cantidad_repuesto
                  FROM " . $this->table_name . " o
                  LEFT JOIN Dispositivo d ON o.id_dispositivo = d.id_dispositivo
                  LEFT JOIN Cliente c ON d.id_cliente = c.id_cliente
                  LEFT JOIN orden_repuestos or_rel ON o.id_orden = or_rel.id_orden
                  LEFT JOIN repuesto r ON or_rel.id_repuesto = r.id_repuesto  
                  ORDER BY o.id_orden DESC";
        try {
            $stmt = $this->conn->prepare($query);
            $stmt->execute();
            return $stmt->fetchAll(PDO::FETCH_ASSOC);
        } catch (PDOException $e) {
            return [];
        }
    }

    // ACTUALIZAR ESTADO Y DIAGNÓSTICO DE LA ORDEN
    public function actualizarEstadoYDiagnostico($id_orden, $estado_dispositivo, $diagnostico, $tipo_servicio) {
        $query = "UPDATE " . $this->table_name . " 
                  SET estado_dispositivo = :estado_dispositivo, 
                      diagnostico = :diagnostico, 
                      tipo_servicio = :tipo_servicio 
                  WHERE id_orden = :id_orden";
        try {
            $stmt = $this->conn->prepare($query);
            
            $id_ord_int   = (int)$id_orden;
            $est_limpio   = htmlspecialchars(strip_tags($estado_dispositivo));
            $diag_limpio  = !empty($diagnostico) ? htmlspecialchars(strip_tags($diagnostico)) : null;
            $serv_limpio  = !empty($tipo_servicio) ? htmlspecialchars(strip_tags($tipo_servicio)) : null;
    
            $stmt->bindParam(':estado_dispositivo', $est_limpio);
            $stmt->bindParam(':diagnostico', $diag_limpio);
            $stmt->bindParam(':tipo_servicio', $serv_limpio);
            $stmt->bindParam(':id_orden', $id_ord_int, PDO::PARAM_INT);
    
            if ($stmt->execute()) {
                return ["status" => true, "message" => "Orden actualizada con éxito."];
            }
            return ["status" => false, "message" => "No se pudo actualizar la orden."];
        } catch (PDOException $e) {
            return ["status" => false, "message" => "Error interno: " . $e->getMessage()];
        }
    }

    public function crear($datos) {
        $query = "INSERT INTO " . $this->table_name . " 
                  (id_dispositivo, id_empleado, ingreso_orden, marca_dispositivo, modelo_dispositivo, numero_imei, nombre_cliente, accesorios, estado_dispositivo, costo_reparacion, falla_cliente, motivo_reparacion, reparacion_prometida_para) 
                  VALUES 
                  (:id_dispositivo, :id_empleado, :ingreso_orden, :marca_dispositivo, :modelo_dispositivo, :numero_imei, :nombre_cliente, :accesorios, :estado_dispositivo, :costo_reparacion, :falla_cliente, :motivo_reparacion, :reparacion_prometida_para)";
        
        try {
            $stmt = $this->conn->prepare($query);

            $stmt->bindParam(':id_dispositivo', $datos['id_dispositivo'], PDO::PARAM_INT);
            $stmt->bindParam(':id_empleado', $datos['id_empleado'], PDO::PARAM_INT);
            $stmt->bindParam(':ingreso_orden', $datos['ingreso_orden']);
            $stmt->bindParam(':marca_dispositivo', $datos['marca_dispositivo']);
            $stmt->bindParam(':modelo_dispositivo', $datos['modelo_dispositivo']);
            $stmt->bindParam(':numero_imei', $datos['numero_imei']);
            $stmt->bindParam(':nombre_cliente', $datos['nombre_cliente']);
            $stmt->bindParam(':accesorios', $datos['accesorios']);
            $stmt->bindParam(':estado_dispositivo', $datos['estado_dispositivo']);
            $stmt->bindParam(':costo_reparacion', $datos['costo_reparacion']);
            $stmt->bindParam(':falla_cliente', $datos['falla_cliente']);
            $stmt->bindParam(':motivo_reparacion', $datos['motivo_reparacion']);
            $stmt->bindParam(':reparacion_prometida_para', $datos['reparacion_prometida_para']);

            if ($stmt->execute()) {
                return ["status" => true, "id_orden" => $this->conn->lastInsertId()];
            }
            return ["status" => false, "message" => "No se pudo registrar la orden de reparación."];
        } catch (PDOException $e) {
            return ["status" => false, "message" => "Error interno: " . $e->getMessage()];
        }
    }

    // OBTENER ÓRDENES FILTRADAS POR ID DE CLIENTE
    public function obtenerPorCliente($id_cliente) {
        $query = "SELECT o.*, 
                         CONCAT(c.nombre, ' ', c.apellido) AS nombre_cliente,
                         c.telefono,
                         d.imagen, d.marca AS marca_dispositivo, d.modelo AS modelo_dispositivo, d.imei_serie AS numero_imei, d.observaciones AS falla_cliente 
                  FROM " . $this->table_name . " o
                  LEFT JOIN Dispositivo d ON o.id_dispositivo = d.id_dispositivo
                  LEFT JOIN Cliente c ON d.id_cliente = c.id_cliente
                  WHERE d.id_cliente = :id_cliente
                  ORDER BY o.id_orden DESC";
        try {
            $stmt = $this->conn->prepare($query);
            $stmt->bindParam(':id_cliente', $id_cliente, PDO::PARAM_INT);
            $stmt->execute();
            return $stmt->fetchAll(PDO::FETCH_ASSOC);
        } catch (PDOException $e) {
            return [];
        }
    }

    public function obtenerPorId($id_orden) {
        $query = "SELECT o.*, 
                         d.imagen, d.marca AS marca_dispositivo, d.modelo AS modelo_dispositivo, d.imei_serie AS numero_imei, d.observaciones AS falla_cliente,
                         c.nombre, c.apellido, c.telefono
                  FROM " . $this->table_name . " o
                  LEFT JOIN Dispositivo d ON o.id_dispositivo = d.id_dispositivo
                  LEFT JOIN Cliente c ON d.id_cliente = c.id_cliente
                  WHERE o.id_orden = :id_orden
                  LIMIT 1";
        try {
            $stmt = $this->conn->prepare($query);
            $stmt->bindParam(':id_orden', $id_orden, PDO::PARAM_INT);
            $stmt->execute();
            return $stmt->fetch(PDO::FETCH_ASSOC);
        } catch (PDOException $e) {
            return null;
        }
    }

    // Método para asociar un repuesto a una orden de reparación y descontar del stock real
    public function agregarRepuestoAOrden($id_orden, $id_repuesto, $cantidad = 1) {
        try {
            // 1. Insertar el registro en la tabla intermedia orden_repuestos
            $sql = "INSERT INTO orden_repuestos (id_orden, id_repuesto, cantidad) VALUES (?, ?, ?)";
            $stmt = $this->conn->prepare($sql);
            $stmt->execute([$id_orden, $id_repuesto, $cantidad]);

            // 2. descontar
            $sqlStock = "UPDATE repuesto SET stock_actual = stock_actual - ? WHERE id_repuesto = ?";
            $stmtStock = $this->conn->prepare($sqlStock);
            $stmtStock->execute([$cantidad, $id_repuesto]);

            return [
                "status" => true, 
                "message" => "Repuesto asociado correctamente y stock actualizado."
            ];
        } catch (Exception $e) {
            return [
                "status" => false, 
                "message" => "Error al asociar el repuesto: " . $e->getMessage()
            ];
        }
    }
}
?>