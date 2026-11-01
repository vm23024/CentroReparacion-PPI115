<?php
// models/Cliente.php
require_once __DIR__ . '/../config/Database.php';

class Cliente
{
    private $conn;
    private $table_name = "cliente"; 

    public function __construct()
    {
        $database = new Database();
        $this->conn = $database->getConnection();
    }

    public function obtenerPorCorreo($correo)
    {
        
        $query = "SELECT * FROM " . $this->table_name . " WHERE email = :correo LIMIT 1";
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(':correo', $correo);
        $stmt->execute();

        if ($stmt->rowCount() > 0) {
            return $stmt->fetch(PDO::FETCH_ASSOC);
        }
        return null;
    }

    public function registrar($nombre, $apellido, $telefono, $correo, $password)
    {
        if ($this->obtenerPorCorreo($correo)) {
            return ["status" => false, "message" => "El correo ya está registrado."];
        }

        $password_hash = password_hash($password, PASSWORD_BCRYPT);

        
        $query = "INSERT INTO " . $this->table_name . " (nombre, apellido, telefono, email, password) 
                  VALUES (:nombre, :apellido, :telefono, :correo, :password)";

        try {
            $stmt = $this->conn->prepare($query);

            $nombre = htmlspecialchars(strip_tags($nombre));
            $apellido = htmlspecialchars(strip_tags($apellido));
            $telefono = htmlspecialchars(strip_tags($telefono));
            $correo = htmlspecialchars(strip_tags($correo));

            $stmt->bindParam(':nombre', $nombre);
            $stmt->bindParam(':apellido', $apellido);
            $stmt->bindParam(':telefono', $telefono);
            $stmt->bindParam(':correo', $correo);
            $stmt->bindParam(':password', $password_hash);

            if ($stmt->execute()) {
                return ["status" => true, "id" => $this->conn->lastInsertId()];
            }

            return ["status" => false, "message" => "No se pudo registrar el cliente."];
        } catch (PDOException $e) {
            return ["status" => false, "message" => "Error interno: " . $e->getMessage()];
        }
    }

    public function obtenerPorId($id_cliente)
    {
        
        $query = "SELECT id_cliente, nombre, apellido, telefono, email FROM " . $this->table_name . " WHERE id_cliente = :id_cliente LIMIT 1";
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(':id_cliente', $id_cliente, PDO::PARAM_INT);
        $stmt->execute();

        return $stmt->fetch(PDO::FETCH_ASSOC);
    }
}
?>