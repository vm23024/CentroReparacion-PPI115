<?php

require_once './config/Database.php';

class Cliente
{
    private $conn;
    private $table_name = "Cliente";

    public function __construct()
    {
        $database = new Database();
        $this->conn = $database->getConnection();
    }

    // LISTAR TODOS
    public function leer()
    {
        $query = "SELECT * FROM " . $this->table_name . " ORDER BY id_cliente DESC";
        $stmt = $this->conn->prepare($query);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    // OBTENER UNO POR ID
    public function obtenerPorId($id)
    {
        $query = "SELECT * FROM " . $this->table_name . " WHERE id_cliente = :id LIMIT 0,1";
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(':id', $id, PDO::PARAM_INT);
        $stmt->execute();
        return $stmt->fetch(PDO::FETCH_ASSOC) ?: null;
    }

    // CREAR
    public function crear($nombre, $apellido, $email, $telefono, $fecha_nacimiento)
    {
        $query = "INSERT INTO " . $this->table_name . " (nombreCliente, apellidoCliente, emailCliente, telefonoCliente, fecha_nacimiento) 
                  VALUES (:nombre, :apellido, :email, :telefono, :fecha_nacimiento)";
        try {
            $stmt = $this->conn->prepare($query);
            $stmt->bindParam(':nombre', htmlspecialchars(strip_tags($nombre)));
            $stmt->bindParam(':apellido', htmlspecialchars(strip_tags($apellido)));
            $stmt->bindParam(':email', htmlspecialchars(strip_tags($email)));
            $stmt->bindParam(':telefono', htmlspecialchars(strip_tags($telefono)));
            $fecha_limpia = !empty($fecha_nacimiento) ? htmlspecialchars(strip_tags($fecha_nacimiento)) : null;
            $stmt->bindParam(':fecha_nacimiento', $fecha_limpia);
            if ($stmt->execute()) {
                return ["status" => true, "id" => $this->conn->lastInsertId()];
            }
            return ["status" => false, "message" => "No se pudo insertar el cliente."];
        } catch (PDOException $e) {
            return ["status" => false, "message" => $e->getMessage()];
        }
    }
    //ACTUALIZAR 
    public function actualizar($id, $nombre, $apellido, $email, $telefono, $fecha_nacimiento)
    {
        // 1. Verificar primero si el cliente existe en la base de datos
        if (!$this->obtenerPorId($id)) {
            return ["status" => false, "message" => "El cliente especificado no existe."];
        }

        // 2. Preparar la consulta de actualización
        $query = "UPDATE " . $this->table_name . " 
              SET nombreCliente = :nombre, 
                  apellidoCliente = :apellido, 
                  emailCliente = :email, 
                  telefonoCliente = :telefono, 
                  fecha_nacimiento = :fecha_nacimiento 
              WHERE id_cliente = :id";

        try {
            $stmt = $this->conn->prepare($query);

            // 3. Limpieza estricta de datos guardando en variables independientes
            $n_limpio = htmlspecialchars(strip_tags($nombre));
            $a_limpio = htmlspecialchars(strip_tags($apellido));
            $e_limpio = !empty($email) ? htmlspecialchars(strip_tags($email)) : null;
            $t_limpio = !empty($telefono) ? htmlspecialchars(strip_tags($telefono)) : null;
            $f_limpia = !empty($fecha_nacimiento) ? htmlspecialchars(strip_tags($fecha_nacimiento)) : null;
            $id_int   = (int)$id;

            // 4. Vincular todos los parámetros
            $stmt->bindParam(':nombre', $n_limpio);
            $stmt->bindParam(':apellido', $a_limpio);
            $stmt->bindParam(':email', $e_limpio);
            $stmt->bindParam(':telefono', $t_limpio);
            $stmt->bindParam(':fecha_nacimiento', $f_limpia);
            $stmt->bindParam(':id', $id_int, PDO::PARAM_INT);

            if ($stmt->execute()) {
                return ["status" => true, "message" => "Cliente actualizado con éxito."];
            }
            return ["status" => false, "message" => "No se realizaron cambios en el registro."];
        } catch (PDOException $e) {
            return ["status" => false, "message" => "Error interno: " . $e->getMessage()];
        }
    }

    //ELIMINAR /clientes
    public function eliminar($id)
    {
        // 1. Verificar primero si el cliente realmente existe
        if (!$this->obtenerPorId($id)) {
            return ["status" => false, "message" => "El cliente especificado no existe."];
        }

        // 2. Preparar la consulta de eliminación
        $query = "DELETE FROM " . $this->table_name . " WHERE id_cliente = :id";

        try {
            $stmt = $this->conn->prepare($query);
            $id_int = (int)$id;
            $stmt->bindParam(':id', $id_int, PDO::PARAM_INT);

            if ($stmt->execute()) {
                return ["status" => true, "message" => "Cliente eliminado exitosamente."];
            }
            return ["status" => false, "message" => "No se pudo eliminar el cliente."];
        } catch (PDOException $e) {
            // En caso de que el cliente ya tenga dispositivos u órdenes asociadas (Llave foránea)
            if ($e->getCode() == 23000) {
                return ["status" => false, "message" => "No se puede eliminar el cliente porque tiene registros asociados en el sistema."];
            }
            return ["status" => false, "message" => "Error interno: " . $e->getMessage()];
        }
    }
}
