<?php
namespace models;
use PDO;

class publicaciones extends conexion {
    private $fecha_creacion;
    private $strtitulo;
    private $strcontenido;
    private $fecha_edicion;
    private $id_admin;
    private $dir_img;

    public function __construct() {
        parent::__construct();
    }

    public function insertar(string $fecha_creacion, string $titulo, string $contenido, int $id_admin, $img = null) {
        $this->fecha_creacion = $fecha_creacion;
        $this->strtitulo = $titulo;
        $this->strcontenido = $contenido;
        $this->id_admin = $id_admin;
        $this->dir_img = $img;

        $sql = "INSERT INTO publicaciones (fecha_creacion, titulo, contenido, id_admin, dir_img) VALUES (?, ?, ?, ?, ?)";
        $insert = $this->conn->prepare($sql);
        $arrData = array($this->fecha_creacion, $this->strtitulo, $this->strcontenido, $this->id_admin, $this->dir_img);
        $insert->execute($arrData);
        return $this->conn->lastInsertId();
    }

    public function getPublicaciones() {
        $sql = "SELECT * FROM publicaciones ORDER BY fecha_creacion DESC";
        $execute = $this->conn->query($sql);
        return $execute->fetchAll(PDO::FETCH_ASSOC);
    }

    public function getPublicacionesWithPublisher() {
        $sql = "SELECT p.id_publicaciones, p.titulo, p.fecha_creacion, p.fecha_edicion, p.dir_img, a.username
                FROM publicaciones p
                INNER JOIN admin a ON p.id_admin = a.id
                ORDER BY p.fecha_creacion DESC";
        $execute = $this->conn->query($sql);
        return $execute->fetchAll(PDO::FETCH_ASSOC);
    }

    public function getPublicacionesByAutor($id_admin) {
        $sql = "SELECT * FROM publicaciones WHERE id_admin = ? ORDER BY fecha_creacion DESC";
        $stmt = $this->conn->prepare($sql);
        $stmt->execute([$id_admin]);
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function getPublicacionById($id) {
        $sql = "SELECT * FROM publicaciones WHERE id_publicaciones = ?";
        $stmt = $this->conn->prepare($sql);
        $stmt->execute([$id]);
        return $stmt->fetch();
    }

    public function updatePublicaciones(int $id, string $titulo, string $contenido, string $fecha_edicion, $img = null) {
        $this->fecha_edicion = $fecha_edicion;
        $this->strtitulo = $titulo;
        $this->strcontenido = $contenido;
        $this->dir_img = $img;

        if ($img) {
            $sql = "UPDATE publicaciones SET fecha_edicion = ?, titulo = ?, contenido = ?, dir_img = ? WHERE id_publicaciones = ?";
            $update = $this->conn->prepare($sql);
            $arrdatos = array($this->fecha_edicion, $this->strtitulo, $this->strcontenido, $this->dir_img, $id);
        } else {
            $sql = "UPDATE publicaciones SET fecha_edicion = ?, titulo = ?, contenido = ? WHERE id_publicaciones = ?";
            $update = $this->conn->prepare($sql);
            $arrdatos = array($this->fecha_edicion, $this->strtitulo, $this->strcontenido, $id);
        }

        return $update->execute($arrdatos);
    }

    public function deletePublicaciones(int $id) {
        $sql = "DELETE FROM publicaciones WHERE id_publicaciones = ?";
        $stmt = $this->conn->prepare($sql);
        return $stmt->execute([$id]);
    }

    public function insertarImg($name_images) {
        if (isset($_FILES['img'])) {
            $file = $_FILES['img'];
            $file_name = $file['name'];
            $mimetype = $file['type'];

            $ext_formatos = ["image/jpeg", "image/jpg", "image/png"];
            if (!in_array($mimetype, $ext_formatos)) {
                header("location:../views/administrador-Crear.php");
                die();
            }

            $directorio = "imagenes_publicaciones/";

            if (in_array($directorio . $file_name, $name_images)) {
                header("location:../views/administrador-Crear.php");
                die("Esta imagen ha sido usada anteriormente. Escoge otra.");
            }

            if (!is_dir("../views/" . $directorio)) {
                mkdir("../views/" . $directorio, 0777);
            }

            move_uploaded_file($file['tmp_name'], "../views/" . $directorio . $file_name);
            return $directorio . $file_name;
        } else {
            header("location:../views/administrador-Crear.php");
        }
    }

    public function borrarImg($idPost) {
        $post = $this->getPublicacionById($idPost);
        if ($post && $post['dir_img']) {
            unlink("../views/" . $post['dir_img']);
        }
    }

    public function getDirImgs() {
        $sql = "SELECT dir_img FROM publicaciones WHERE dir_img IS NOT NULL";
        $execute = $this->conn->query($sql);
        return $execute->fetchAll(PDO::FETCH_COLUMN, 0);
    }

    public function adminExiste(int $id_admin): bool {
        $sql = "SELECT id FROM admin WHERE id = ?";
        $stmt = $this->conn->prepare($sql);
        $stmt->execute([$id_admin]);
        return $stmt->rowCount() > 0;
    }
    public function GetDirImg() {
    $sql = "SELECT dir_img FROM publicaciones WHERE dir_img IS NOT NULL";
    $execute = $this->conn->query($sql);
    return $execute->fetchAll(PDO::FETCH_COLUMN, 0);
}

}
