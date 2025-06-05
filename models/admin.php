<?php
namespace models;

use PDO;
use models\conexion;

class admin extends Conexion {
    private $id_admin;
    private $username;
    private $password;
    private $rol;
    private $create_admin;
    private $select_admin;

    public function __construct($username = "", $password = "", $rol = null) {
        $this->conn = Conexion::getConexion();
        $this->username = $username;
        $this->password = $password;

        if (!empty($username)) {
            $this->select_admin = $this->conn->prepare("SELECT * FROM admin WHERE username = :username");
        }

        if (!is_null($rol)) {
            $this->rol = $rol;
            $this->create_admin = $this->conn->prepare("INSERT INTO admin (rol, username, password) VALUES (?, ?, ?)");
        }
    }

    public function getAdmin_db() {
        if (!$this->select_admin) return null;

        $this->select_admin->execute([':username' => $this->username]);
        $datos = $this->select_admin->fetch();

        if ($datos && password_verify($this->password, $datos['password'])) {
            $this->id_admin = $datos['id'];
            $this->rol = $datos['rol'];
            return $datos;
        }

        return null;
    }

    public function getAdminById($id) {
        $sql = "SELECT * FROM admin WHERE id = ?";
        $stmt = $this->conn->prepare($sql);
        $stmt->execute([$id]);
        $datos = $stmt->fetch();

        if ($datos) {
            $this->id_admin = $datos['id'];
            $this->username = $datos['username'];
            $this->password = $datos['password'];
            $this->rol = $datos['rol'];
        }

        return $datos;
    }

    public function getAdmins() {
        $sql = "SELECT a.id, r.rol AS rol_nombre, a.rol, a.username 
                FROM admin AS a 
                INNER JOIN roles AS r ON a.rol = r.id";
        return $this->conn->query($sql)->fetchAll(PDO::FETCH_ASSOC);
    }

    public function createAdmin() {
        return $this->create_admin->execute([$this->rol, $this->username, $this->password])
            ? $this->conn->lastInsertId()
            : false;
    }

    public function editAdmin($id) {
        $sql = "UPDATE admin SET username = ?, password = ?, rol = ? WHERE id = ?";
        $stmt = $this->conn->prepare($sql);
        return $stmt->execute([$this->username, $this->password, $this->rol, $id]);
    }

    public function deleteAdmin($id) {
        if ($this->getCountAdmin() > 1) {
            $stmt = $this->conn->prepare("DELETE FROM admin WHERE id = ?");
            return $stmt->execute([$id]);
        }
        return false;
    }

    public function getCountAdmin() {
        return $this->conn->query("SELECT COUNT(*) FROM admin")->fetchColumn();
    }

    public function adminExists($username) {
        $stmt = $this->conn->prepare("SELECT id FROM admin WHERE username = ?");
        $stmt->execute([$username]);
        return $stmt->rowCount() > 0;
    }

    public function getAdminByUsername($username) {
        $stmt = $this->conn->prepare("SELECT * FROM admin WHERE username = ?");
        $stmt->execute([$username]);
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    // Getters
    public function getRol() { return $this->rol; }
    public function getUsername() { return $this->username; }
    public function getPassword() { return $this->password; }
    public function getId() { return $this->id_admin; }
}
