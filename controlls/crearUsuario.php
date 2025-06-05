<?php
require_once("../autoload.php");
session_start();

use models\user;

if ($_SERVER["REQUEST_METHOD"] === "POST") {
    $rol = $_POST["role"] ?? null;
    $username = trim($_POST["username"] ?? "");
    $password = $_POST["password"] ?? "";

    // Validación de campos
    if (!is_null($rol) && $username !== "" && $password !== "") {
        $userCheck = new user();

        // Verifica si el usuario ya existe
        if ($userCheck->userExists($username)) {
            echo "<script>alert('El usuario ya existe'); window.location.href='../views/administrador-usuarios-Crear.php';</script>";
            exit();
        }

        // Encriptar la contraseña de forma segura
        $hashedPassword = password_hash($password, PASSWORD_DEFAULT);

        // Crear usuario
        $newUser = new user($username, $hashedPassword, $rol);
        $newUser->createUser();

        // Redirigir al listado actualizado
        header("Location: ../views/administrador-usuarios.php");
        exit();
    } else {
        echo "<script>alert('Faltan datos requeridos'); window.history.back();</script>";
        exit();
    }
}
