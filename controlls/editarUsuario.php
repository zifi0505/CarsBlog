<?php
require_once("../autoload.php");
session_start();

// Verifica si el usuario es administrador
if (!isset($_SESSION["rol"]) || $_SESSION["rol"] != 0) {
    header("Location: ../public/index.php");
    exit;
}

use models\user;

if ($_SERVER["REQUEST_METHOD"] === "POST") {
    $id = $_POST["id"] ?? null;
    $username = trim($_POST["username"] ?? "");
    $password = $_POST["password"] ?? "";
    $rol = $_POST["role"] ?? null;
    $id_control = $_SESSION["id"]; // ID del admin que edita

    if ($id && $username !== "" && $password !== "" && $rol !== null) {
        // Encriptar nueva contraseña
        $hashedPassword = password_hash($password, PASSWORD_DEFAULT);

        // Crear objeto con datos
        $objUser = new user($username, $hashedPassword, $rol);

        // Editar usuario
        $resultado = $objUser->editUser($id, $id_control);

        if ($resultado) {
            header("Location: ../admin/administrador-usuarios.php");
            exit;
        } else {
            echo "<script>alert('No se puede modificar ese usuario (puede ser el único administrador).'); window.history.back();</script>";
        }
    } else {
        echo "<script>alert('Todos los campos son obligatorios.'); window.history.back();</script>";
    }
}
