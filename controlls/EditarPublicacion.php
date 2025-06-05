<?php
namespace controlls;

require_once("../autoload.php");
use models\publicaciones;

$objpublicaciones = new publicaciones();
$today = date("Y-m-d H:i:s");

$id = $_POST['id'];
$titulo = $_POST['titulo'];
$contenido = $_POST['contenido'];

if (isset($_FILES['img']) && $_FILES['img']['error'] === 0) {
    // Borra la imagen anterior
    $objpublicaciones->BorrarImg($id);

    // Obtiene ruta donde se guardará la nueva imagen
    $nombreImagen = $objpublicaciones->GetDirImg();

    // Inserta la imagen nueva en esa ruta
    $dir_img = $objpublicaciones->InsertarImg($nombreImagen);

    // Actualiza incluyendo nueva imagen
    $objpublicaciones->updatepublicaciones($id, $titulo, $contenido, $today, $dir_img);
} else {
    // Actualiza sin tocar la imagen
    $objpublicaciones->updatepublicaciones($id, $titulo, $contenido, $today);
}

// Redirección al panel de publicaciones
header("Location: ../views/administrador.php");
exit;
?>
