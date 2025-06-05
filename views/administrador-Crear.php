<?php
require_once("../autoload.php");
session_start();
if(!isset($_SESSION["rol"])){ header("location:index.php"); }
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <!-- basic -->
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">

    <!-- mobile metas -->
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="viewport" content="initial-scale=1, maximum-scale=1">

    <!-- site metas -->
    <title>CarsBlog</title>
    <link rel="shortcut icon" href="images/cars.jpeg"/>
    <meta name="keywords" content="">
    <meta name="description" content="">
    <meta name="author" content="">    

    <!-- bootstrap css -->
    <link rel="stylesheet" type="text/css" href="css/bootstrap.min.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css">

    <!-- style css -->
    <link rel="stylesheet" type="text/css" href="css/style-edit.css">
    <link rel="stylesheet" type="text/css" href="css/admin.css">

    <!-- Responsive-->
    <link rel="stylesheet" href="css/responsive.css">

    <!-- Scrollbar Custom CSS -->
    <link rel="stylesheet" href="css/jquery.mCustomScrollbar.min.css">
    <!-- Tweaks for older IEs-->
    <link rel="stylesheet" href="https://netdna.bootstrapcdn.com/font-awesome/4.0.3/css/font-awesome.css">
    <!-- owl stylesheets --> 
    <link rel="stylesheet" href="css/owl.carousel.min.css">
    <link rel="stylesheet" href="css/owl.theme.default.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/fancybox/2.1.5/jquery.fancybox.min.css" media="screen">

    <!-- Estilo para el recuadro blanco -->
   
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

</head>

<body>
    <div class="header">
        <div class="container">
            <div class="col-sm-12">
                <div class="menu-area">
                    <nav class="navbar navbar-expand-lg">
                        <button class="navbar-toggler collapsed" type="button" data-toggle="collapse" data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
                            <i class="fa fa-bars"></i>
                        </button>
                        <div class="collapse navbar-collapse" id="navbarSupportedContent">
                            <ul class="navbar-nav mr-auto">
                                <li class="nav-item active"><a class="nav-link" href="index.php"><i class="bi bi-house"></i> Inicio</a></li>
                                <li class="nav-item"><a class="nav-link" href="administrador.php"><i class="bi bi-eye"></i> Ver publicaciones</a></li>
                                <?php if($_SESSION['rol'] == 0){ echo '<li class="nav-item"><a class="nav-link" href="administrador-usuarios.php"><i class="bi bi-person-gear"></i> Administrar Usuarios</a></li>'; } ?>
                                <li class="nav-item"><a class="btn btn-primary nav-link" href="../controlls/cerrarSesion.php"><i class="bi bi-door-open-fill"></i> Cerrar Sesión</a></li>
                                <li class="nav-item"><a class="btn nav-link">| Bienvenido <?php echo $_SESSION['name'];?></a></li>
                            </ul>
                        </div>
                    </nav>
                </div>
            </div>
        </div> 
    </div>


    <div>
        <br><br><br><br><br>
    </div>

    <!-- Sección principal -->
    <div class="services_main">
        <div class="container">
            <div class="creative_taital">
                <h1 class="creative_text"><i class="bi bi-file-plus"></i> Crear Publicación</h1>
            </div>
            <div class="form-wrapper">
                <form action="../controlls/insertarPublicaciones.php" method="post" enctype="multipart/form-data">
                    <label for="titulo">TÍTULO:</label><br>
                    <input type="text" name="titulo" required class="form-control mb-3"><br>

                    <label for="contenido">DESCRIPCIÓN:</label><br>
                    <input type="text" name="contenido" required class="form-control mb-3"><br>

                    <label for="custom-file-input" class="btn btn-primary">Elige la imagen</label>
                    <input type="file" accept="image/*" name="img" id="custom-file-input" hidden><br><br>

                    <button type="submit" class="button"><i class="bi bi-save"></i> Guardar
                        <div class="button__horizontal"></div>
                        <div class="button__vertical"></div>
                    </button>
                    <button type="button" class="button" onclick="gotoadmin()"><i class="bi bi-x-circle"></i> Cancelar
                        <div class="button__horizontal"></div>
                        <div class="button__vertical"></div>
                    </button>
                </form>
            </div>
        </div>
    </div>

    <!-- Pie de página -->
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

    <!-- Javascript -->
    <script src="js/jquery.min.js"></script>
    <script src="js/popper.min.js"></script>
    <script src="js/bootstrap.bundle.min.js"></script>
    <script src="js/app.js"></script>
    <script>
        function gotoadmin(){
            window.location.href = "administrador.php";
        }
    </script>
</body>
</html>
