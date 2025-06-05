<?php
session_start();
require_once '../models/conexion.php';  // Ajusta el path según tu estructura
require_once '../models/Users.php';    // Modelo para manejar usuarios (crea uno si no tienes)

// Verificar que llegue username y password
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $username = $_POST['username'] ?? '';
    $password = $_POST['password'] ?? '';

    if (empty($username) || empty($password)) {
        setcookie("errorlogin_usuario", "1", time() + 5, "/");
        header("Location: ../views/login_usuario.php");
        exit;
    }

    // Suponiendo que tienes una clase Users con método para obtener usuario por username/email
    $userModel = new \models\Users();

    // Buscar usuario por username o email
    $user = $userModel->getUserByUsernameOrEmail($username);

    if ($user && password_verify($password, $user['password'])) {
        if ($user['rol'] === 'usuario') {  // Solo usuarios normales
            // Guardar datos de sesión
            $_SESSION['id'] = $user['id'];
            $_SESSION['username'] = $user['username'];
            $_SESSION['rol'] = $user['rol'];

            header("Location: ../views/index.php");
            exit;
        } else {
            // No es usuario normal, no puede entrar por aquí
            setcookie("errorlogin_usuario", "1", time() + 5, "/");
            header("Location: ../views/login_usuario.php");
            exit;
        }
    } else {
        // Usuario no existe o contraseña incorrecta
        setcookie("errorlogin_usuario", "1", time() + 5, "/");
        header("Location: ../views/login_usuario.php");
        exit;
    }
} else {
    header("Location: ../views/login_usuario.php");
    exit;
}
