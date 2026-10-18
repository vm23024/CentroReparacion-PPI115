<?php
//Modelo de tabla usuario
require_once './config/Database.php';

class Usuario
{
    private $conn;
    private $table_name = "Usuario";

    public function __construct()
    {
        $database = new Database();
        $this->conn = $database->getConnection();
    }

    // Buscar usuario por su nick/username
    public function obtenerPorUsuario($usuario)
    {
        $query = "SELECT id_usuario, usuario, password_hash, rol, activo 
                  FROM " . $this->table_name . " 
                  WHERE usuario = :usuario LIMIT 0,1";

        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(':usuario', $usuario);
        $stmt->execute();

        if ($stmt->rowCount() > 0) {
            return $stmt->fetch(PDO::FETCH_ASSOC);
        }
        return null;
    }

    public function crear(
        $usuario,
        $password,
        $nombreUsuario,
        $apellidoUsuario,
        $rol,
        $activo = 1,
        $emailUsuario = null,
        $telefonoUsuario = null
    ) //Metodo para crear usuarios
    {
        // 1. Verificar si el nombre de usuario ya existe para evitar duplicados
        if ($this->obtenerPorUsuario($usuario)) {
            return ["status" => false, "message" => "El nombre de usuario ya está registrado."];
        }

        // 2. Encriptar la contraseña de forma segura usando bcrypt
        $password_hash = password_hash($password, PASSWORD_BCRYPT);

        // 3. Preparar la consulta SQL
        $query = "INSERT INTO " . $this->table_name . " (usuario, password_hash, nombreUsuario, apellidoUsuario, rol, activo, emailUsuario, telefonoUsuario) 
              VALUES (:usuario, :password_hash, :nombreUsuario, :apellidoUsuario, :rol, :activo, :emailUsuario, :telefonoUsuario)";

        try {
            $stmt = $this->conn->prepare($query);

            // Limpiar datos (XSS prevention básica)
            $usuario = htmlspecialchars(strip_tags($usuario));
            $rol = htmlspecialchars(strip_tags($rol));
            $nombre = htmlspecialchars($nombreUsuario);
            $apellido = htmlspecialchars($apellidoUsuario);
            $email = isset($emailUsuario)?htmlspecialchars($emailUsuario):NULL;
            $telefono = isset($telefonoUsuario)?htmlspecialchars($telefonoUsuario):NULL;

            // Vincular parámetros
            $stmt->bindParam(':usuario', $usuario);
            $stmt->bindParam(':password_hash', $password_hash);
            $stmt->bindParam(':nombreUsuario', $nombre);
            $stmt->bindParam(':apellidoUsuario', $apellido);
            $stmt->bindParam(':rol', $rol);
            $stmt->bindParam(':activo', $activo);
            $stmt->bindParam(':emailUsuario', $email);
            $stmt->bindParam(':telefonoUsuario', $telefono);

            if ($stmt->execute()) {
                return ["status" => true, "id" => $this->conn->lastInsertId()];
            }

            return ["status" => false, "message" => "No se pudo crear el usuario."];
        } catch (PDOException $e) {
            return ["status" => false, "message" => "Error interno: " . $e->getMessage()];
        }
    }
}
