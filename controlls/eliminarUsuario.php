<?php
require_once("../autoload.php");
session_start();

// Validación de acceso solo para administradores
if (!isset($_SESSION["rol"]) || $_SESSION["rol"] != 0) {
    header("Location: ../public/index.php");
    exit;
}

use models\user;

$objUser = new user();

// Procesar eliminación
if ($_SERVER["REQUEST_METHOD"] === "POST" && isset($_POST["id"])) {
    $id = $_POST["id"];
    $objUser->deleteUser($id);
}

// Redirigir al panel de administración
header("Location: ../views/administrador-usuarios.php");
exit;
