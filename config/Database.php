<?php
// conexion a la base de datos

class Database {
    private $host;
    private $db_name;
    private $username;
    private $password;
    public $conn;


    //usamos los datos de la base de datos y xammp
    public function __construct() {
        $this->host = 'localhost';
        $this->db_name = 'proyectoppi'; 
        $this->username = 'root';
        $this->password = ''; 
    }

    public function getConnection() {
        $this->conn = null;
        try {
            $this->conn = new PDO(
                "mysql:host=" . $this->host . ";dbname=" . $this->db_name, 
                $this->username, 
                $this->password
            );
            $this->conn->exec("set names utf8");
            $this->conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        } catch(PDOException $exception) {
            http_response_code(500);
            echo json_encode(["status" => "error", "message" => "Error de conexión interna."]);
            exit();
        }
        return $this->conn;
    }
}
?>