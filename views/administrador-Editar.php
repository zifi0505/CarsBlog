<?php
require_once("../autoload.php");
session_start();
if (!isset($_SESSION["rol"])) {
    header("location:index.php");
}
use models\publicaciones;
$publicacion = new publicaciones();
$post = $publicacion->getpublicacionById($_POST['id']);
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>CarsBlog</title>
    <link rel="shortcut icon" href="images/cars.jpeg"/>
    <link rel="stylesheet" href="css/bootstrap.min.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css">
    <link rel="stylesheet" href="css/style-edit.css">
    <link rel="stylesheet" href="css/admin.css">
    <link rel="stylesheet" href="css/responsive.css">
    <link rel="stylesheet" href="css/jquery.mCustomScrollbar.min.css">
    <link rel="stylesheet" href="https://netdna.bootstrapcdn.com/font-awesome/4.0.3/css/font-awesome.css">
    <link rel="stylesheet" href="css/owl.carousel.min.css">
    <link rel="stylesheet" href="css/owl.theme.default.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/fancybox/2.1.5/jquery.fancybox.min.css" media="screen">

    <style>
        .form-wrapper {
            background: rgba(255, 255, 255, 0.9);
            border-radius: 20px;
            padding: 30px;
            box-shadow: 0 0 25px rgba(0, 0, 0, 0.3);
            max-width: 600px;
            margin: auto;
        }

        .form-wrapper h1 {
            text-align: center;
            margin-bottom: 30px;
            font-weight: bold;
        }

        .button {
            border: none;
            padding: 10px 20px;
            background: #2c3e50;
            color: white;
            border-radius: 12px;
            font-weight: bold;
            position: relative;
            overflow: hidden;
            margin-top: 10px;
            margin-right: 10px;
        }

        .button:hover {
            background: #1a252f;
            transition: background 0.3s ease;
        }

        .button__horizontal, .button__vertical {
            display: none;
        }
    </style>
</head>

<body>
    <div class="header">
        <div class="container">
            <div class="col-sm-12">
                <div class="menu-area">
                    <nav class="navbar navbar-expand-lg">
                        <button class="navbar-toggler collapsed" type="button" data-toggle="collapse" data-target="#navbarSupportedContent">
                            <i class="fa fa-bars"></i>
                        </button>
                        <div class="collapse navbar-collapse" id="navbarSupportedContent">
                            <ul class="navbar-nav mr-auto">
                                <li class="nav-item active"><a class="nav-link" href="index.php"><i class="bi bi-house"></i> Inicio</a></li>
                                <li class="nav-item"><a class="nav-link" href="administrador.php"><i class="bi bi-eye"></i> Ver publicaciones</a></li>
                                <?php if ($_SESSION['rol'] == 0) {
                                    echo '<li class="nav-item"><a class="nav-link" href="administrador-usuarios.php"><i class="bi bi-person-gear"></i> Administrar Usuarios</a></li>';
                                } ?>
                                <li class="nav-item"><a class="btn btn-primary nav-link" href="../controlls/cerrarSesion.php"><i class="bi bi-door-open-fill"></i> Cerrar Sesión</a></li>
                                <li class="nav-item"><a class="btn nav-link">| Bienvenido <?php echo $_SESSION['name']; ?></a></li>
                            </ul>
                        </div>
                    </nav>
                </div>
            </div>
        </div>
    </div>

    <div><br><br><br><br><br></div>

    <div class="services_main">
        <div class="container">
            <div class="creative_taital">
                <h1 class="creative_text"><i class="bi bi-pencil-square"></i> Editar Publicación</h1>
            </div>
            <div class="form-wrapper">
                <form action="../controlls/EditarPublicacion.php" method="post" enctype="multipart/form-data">
                    <input type="hidden" name="id" value="<?php echo $_POST['id']; ?>">

                    <label for="titulo">TÍTULO:</label>
                    <input type="text" name="titulo" required class="form-control mb-3" value="<?php echo $post['titulo']; ?>">

                    <label for="contenido">DESCRIPCIÓN:</label>
                    <input type="text" name="contenido" required class="form-control mb-3" value="<?php echo $post['contenido']; ?>">

                    <?php if ($post['dir_img']) : ?>
                        <p><strong>Imagen actual:</strong> <?php echo basename($post['dir_img']); ?></p>
                    <?php endif; ?>

                    <label for="custom-file-input" class="btn btn-primary">Cambiar imagen</label>
                    <input type="file" accept="image/*" name="img" id="custom-file-input" hidden>

                    <div class="mt-4">
                        <button type="submit" class="button"><i class="bi bi-arrow-repeat"></i> Actualizar</button>
                        <button type="button" class="button" onclick="gotoadmin()"><i class="bi bi-x-circle"></i> Cancelar</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <div class="quote_section">
        <div class="container">
            <div class="row">
                <div class="col-md-6">
                    <h1 class="quote_text">Universidad De Colima</h1>
                    <p class="loan_text">Ingeniería en Software 2E<br>Facultad de Ingeniería Electromecánica</p>
                </div>
            </div>
        </div>
    </div>

    <!-- JS -->
    <script src="js/jquery.min.js"></script>
    <script src="js/popper.min.js"></script>
    <script src="js/bootstrap.bundle.min.js"></script>
    <script>
        function gotoadmin() {
            window.location.href = "administrador.php";
        }
    </script>
</body>
</html>
