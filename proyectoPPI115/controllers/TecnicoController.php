<?php
require_once __DIR__ . '/../config/Database.php';

class TecnicoController {

    public function listarTecnicosConReparaciones() {
        $database = new Database();
        $db = $database->getConnection();

        try {
            $query = "SELECT u.id_usuario, u.nombreUsuario, u.apellidoUsuario, u.emailUsuario, u.telefonoUsuario, u.rol,
                             o.id_orden, o.marca_dispositivo, o.modelo_dispositivo, o.tipo_servicio, o.falla_cliente, o.reparacion_prometida_para, o.estado_dispositivo
                      FROM usuario u
                      LEFT JOIN ordenreparacion o ON u.id_usuario = o.id_empleado
                      ORDER BY u.id_usuario DESC";

            $stmt = $db->prepare($query);
            $stmt->execute();
            $registros = $stmt->fetchAll(PDO::FETCH_ASSOC);

            $tecnicosAgrupados = [];
            foreach ($registros as $row) {
                $id = $row['id_usuario'];
                if (!isset($tecnicosAgrupados[$id])) {
                    $nombreCompleto = trim(($row['nombreUsuario'] ?? '') . ' ' . ($row['apellidoUsuario'] ?? ''));
                    
                    $tecnicosAgrupados[$id] = [
                        "id_tecnico" => $row['id_usuario'],
                        "nombre_tecnico" => empty($nombreCompleto) ? 'Técnico sin nombre' : $nombreCompleto,
                        "correo" => $row['emailUsuario'] ?? 'correo@email.com',
                        "telefono" => $row['telefonoUsuario'] ?? '0000-0000',
                        "foto_tecnico" => "", 
                        "reparaciones" => []
                    ];
                }

                // Si el técnico tiene órdenes asociadas
                if (!empty($row['id_orden'])) {
                    $tecnicosAgrupados[$id]["reparaciones"][] = [
                        "id_orden" => $row['id_orden'],
                        "tipo_reparacion" => $row['tipo_servicio'] ?? 'Reparación general',
                        "descripcion" => $row['falla_cliente'] ?? 'Sin descripción',
                        "dispositivo" => trim(($row['marca_dispositivo'] ?? '') . ' ' . ($row['modelo_dispositivo'] ?? '')) ?: 'Dispositivo general',
                        "tiempo_estimado" => $row['reparacion_prometida_para'] ? 'Entrega: ' . $row['reparacion_prometida_para'] : 'Pendiente'
                    ];
                }
            }

            http_response_code(200);
            echo json_encode([
                "status" => "success",
                "data" => array_values($tecnicosAgrupados)
            ]);
            exit();

        } catch (PDOException $e) {
            http_response_code(500);
            echo json_encode([
                "status" => "error", 
                "message" => "Error al obtener los datos: " . $e->getMessage()
            ]);
            exit();
        }
    }

    public function eliminarTecnico($id) {
    $database = new Database();
    $db = $database->getConnection();

    try {
        $query = "DELETE FROM usuario WHERE id_usuario = :id";
        $stmt = $db->prepare($query);
        
        if ($stmt->execute([':id' => $id])) {
            http_response_code(200);
            echo json_encode(["status" => "success", "message" => "Técnico eliminado correctamente"]);
        } else {
            http_response_code(400);
            echo json_encode(["status" => "error", "message" => "No se pudo eliminar el técnico"]);
        }
        exit();
    } catch (PDOException $e) {
        http_response_code(500);
        echo json_encode(["status" => "error", "message" => $e->getMessage()]);
        exit();
    }
}
}
?>