<?php
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

session_start();
require_once("../autoload.php");

// Conexión a la base de datos "carsblog"
$host = "localhost";
$db = "carsblog";
$user = "root"; // Ajusta según tu configuración
$pass = "";     // Ajusta según tu configuración

try {
    $conn = new PDO("mysql:host=$host;dbname=$db;charset=utf8", $user, $pass);
    $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch (PDOException $e) {
    die("Error de conexión: " . $e->getMessage());
}

// Recibe usuario y contraseña
$username = $_POST["username"];
$password = $_POST["password"];

// Busca usuario en tabla de administradores
$stmt = $conn->prepare("SELECT * FROM admin WHERE (username = :user OR email = :user) LIMIT 1");
$stmt->bindParam(":user", $username);
$stmt->execute();
$admin = $stmt->fetch(PDO::FETCH_ASSOC);

// Verifica si encontró usuario y si la contraseña es correcta
if ($admin && password_verify($password, $admin["password"])) {
    $_SESSION["id_user"] = $admin["id"];
    $_SESSION["name"] = $admin["username"];
    $_SESSION["rol"] = 0; // 0 = admin
    $_SESSION["admin_login"] = true; // ✅ LÍNEA CLAVE PARA VALIDACIÓN

    header("Location: administrador.php");
    exit;
} else {
    setcookie("erroradmin", "1", time() + 5, "/");
    header("Location: login-admin.php");
    exit;
}
