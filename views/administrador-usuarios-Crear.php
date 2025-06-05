<?php
require_once("../autoload.php");
session_start();

if (!isset($_SESSION["rol"]) || $_SESSION["rol"] != 0) {
    header("location:../public/index.php");
    exit;
}
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Crear Usuario - CarsBlog</title>
    <link rel="stylesheet" href="css/Diseño.css" />
    <link rel="shortcut icon" href="images/logoCarsMini.png" />
    <script src="https://kit.fontawesome.com/a076d05399.js" crossorigin="anonymous"></script>
</head>
<body>

<section class="form-main">
    <div class="form-content">
        <div class="box">
            <h3>Crear Usuario</h3>

            <form action="../controlls/crearUsuario.php" method="post">
                <div class="input-box">
                    <i class="fas fa-user-plus"></i>
                    <input type="text" name="username" placeholder="Nombre de usuario" class="input-control" required />
                </div>

                <div class="input-box">
                    <i class="fas fa-lock"></i>
                    <input type="password" name="password" placeholder="Contraseña" class="input-control" required />
                </div>

                <div class="input-box">
                    <i class="fas fa-user-shield"></i>
                    <select name="role" class="input-control" required>
                        <option value="0">Administrador</option>
                        <option value="1" selected>Publicador</option>
                    </select>
                </div>

                <?php if (isset($_COOKIE["erroruser"])): ?>
                    <p class="errorMsg">El usuario ya existe</p>
                    <?php setcookie("erroruser", "", time() - 3600, "/"); ?>
                <?php endif; ?>

                <button type="submit" class="btn">Crear Usuario</button>
            </form>

            <button onclick="gotohome()" class="btn btn1" style="margin-top: 20px;">Cancelar</button>
        </div>
    </div>
</section>

<!-- Olas decorativas -->
<section>
    <div class="wave wave1"></div>
    <div class="wave wave2"></div>
    <div class="wave wave3"></div>
    <div class="wave wave4"></div>
</section>

<script>
    function gotohome() {
        window.location.href = "administrador-usuarios.php";
    }
</script>
</body>
</html>
