<?php
namespace controlls;
require_once("../autoload.php");

use models\user;
session_start();

if ($_SERVER["REQUEST_METHOD"] === "POST") {
    $username = trim($_POST["username"] ?? "");
    $password = $_POST["password"] ?? "";

    if ($username === "" || $password === "") {
        setcookie("errorlogin", "1", time() + 2, "/");
        header("Location: ../views/login.php");
        exit;
    }

    // Buscar usuario por username
    $objUser = new user();
    $datos = $objUser->getUserByUsername($username);

    // Verificar si existe y la contraseña es correcta
    if ($datos && password_verify($password, $datos["password"])) {
        $_SESSION["rol"] = $datos["rol"];
        $_SESSION["name"] = $datos["username"];
        $_SESSION["id_user"] = $datos["id"];

        // Redirigir según el rol
        if ($_SESSION["rol"] == 0) {
            header("Location: ../views/administrador.php");
        } else {
            header("Location: ../views/index.php");
        }
        exit;
    } else {
        setcookie("errorlogin", "1", time() + 2, "/");
        header("Location: ../views/login.php");
        exit;
    }
}
