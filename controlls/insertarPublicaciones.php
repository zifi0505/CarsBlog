<?php
namespace controlls;

session_start();

if (!isset($_SESSION["rol"]) || !isset($_SESSION["id_user"])) {
    header("location:../views/index.php");
    exit;
}

require_once("../autoload.php");
use models\publicaciones;

$publicacion = new publicaciones();
$today = date("Y-m-d H:i:s");

// Verifica que se hayan enviado los datos requeridos
if (!isset($_POST['titulo']) || !isset($_POST['contenido'])) {
    header("location:../views/administrador-Editor.php");
    exit;
}

// Validar si el ID pertenece a un admin
if (!$publicacion->adminExiste($_SESSION["id_user"])) {
    header("location:../views/index.php");
    exit;
}

// Procesamiento de la imagen
if (isset($_FILES['img']) && $_FILES['img']['error'] === 0) {
    $name_images = $publicacion->getDirImgs();
    $dir_img = $publicacion->insertarImg($name_images);
    $publicacion->insertar($today, $_POST['titulo'], $_POST['contenido'], $_SESSION['id_user'], $dir_img);
} else {
    $publicacion->insertar($today, $_POST['titulo'], $_POST['contenido'], $_SESSION['id_user']);
}

// Redirige al panel administrador
header("location:../views/administrador.php");
exit;
?>
