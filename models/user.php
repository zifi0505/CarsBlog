<?php
namespace models;
use PDO;

class user extends conexion {
    private $id_user;
    private $user;
    private $pass;
    private $role;
    private $select_user;
    private $create_user;

    public function __construct($user = "", $pass = "", $role = null) {
        parent::__construct();
        $this->user = $user;
        $this->pass = $pass;

        if (!empty($user)) {
            $this->select_user = $this->conn->prepare("SELECT * FROM users WHERE username = :nombre");
        }

        if (!is_null($role)) {
            $this->role = $role;
            $this->create_user = $this->conn->prepare("INSERT INTO users(rol, username, password) VALUES (?, ?, ?)");
        }
    }

    public function getUser_db() {
        if (!$this->select_user) return null;

        $this->select_user->execute([':nombre' => $this->user]);
        $datos = $this->select_user->fetch();

        if ($datos && password_verify($this->pass, $datos['password'])) {
            $this->id_user = $datos['id'];
            $this->role = $datos['rol'];
            return $datos;
        }

        return null;
    }

    public function getUserById($id) {
        $sql = "SELECT * FROM users WHERE id = ?";
        $stmt = $this->conn->prepare($sql);
        $stmt->execute([$id]);
        $datos = $stmt->fetch();

        if ($datos) {
            $this->id_user = $datos['id'];
            $this->user = $datos['username'];
            $this->pass = $datos['password'];
            $this->role = $datos['rol'];
        }

        return $datos;
    }

    public function getUsers() {
        $sql = "SELECT u.id, r.rol AS rol_nombre, u.rol, u.username 
                FROM users AS u 
                INNER JOIN roles AS r ON u.rol = r.id";
        return $this->conn->query($sql)->fetchAll(PDO::FETCH_ASSOC);
    }

    public function createUser() {
        return $this->create_user->execute([$this->role, $this->user, $this->pass])
            ? $this->conn->lastInsertId()
            : false;
    }

    public function editUser($id, $id_controll) {
        if ($this->getCountAdmin() == 1 && $this->role != 0 && $id == $id_controll) {
            return false;
        }

        $sql = "UPDATE users SET username = ?, password = ?, rol = ? WHERE id = ?";
        $stmt = $this->conn->prepare($sql);
        return $stmt->execute([$this->user, $this->pass, $this->role, $id]);
    }

    public function deleteUser($id) {
        if ($this->getCountUser() > 1) {
            $stmt = $this->conn->prepare("DELETE FROM users WHERE id = ?");
            return $stmt->execute([$id]);
        }
        return false;
    }

    public function getCountUser() {
        return $this->conn->query("SELECT COUNT(*) FROM users")->fetchColumn();
    }

    public function getCountAdmin() {
        return $this->conn->query("SELECT COUNT(*) FROM users WHERE rol = 0")->fetchColumn();
    }

    public function userExists($username) {
        $stmt = $this->conn->prepare("SELECT id FROM users WHERE username = ?");
        $stmt->execute([$username]);
        return $stmt->rowCount() > 0;
    }

    public function getUserByUsername($username) {
        $stmt = $this->conn->prepare("SELECT * FROM users WHERE username = ?");
        $stmt->execute([$username]);
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    // Getters
    public function getRole() { return $this->role; }
    public function getUser() { return $this->user; }
    public function getPass() { return $this->pass; }
    public function getId() { return $this->id_user; }
}
?>
