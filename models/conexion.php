<?php
namespace models;
use PDO;
use PDOException;

class conexion {
    protected $conn;

    public function __construct($dbname = "carsblog") {
        $servername = "localhost";
        $username = "root";
        $password = "";

        try {
            $this->conn = new PDO(
                "mysql:host=$servername;dbname=$dbname;charset=utf8",
                $username,
                $password
            );
            $this->conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        } catch(PDOException $e) {
            die("Error de conexión: " . $e->getMessage());
        }
    }

    public function getConexion(): PDO {
        return $this->conn;
    }
}
