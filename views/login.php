<?php
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

session_start();
if (isset($_SESSION["rol"])) {
    header("location:index.php");
    exit;
}
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Login - CarsBlog</title>
    <link rel="stylesheet" href="css/Diseño.css" />
    <link rel="shortcut icon" href="images/cars.jpeg" />
    <script src="https://kit.fontawesome.com/a076d05399.js" crossorigin="anonymous"></script>
</head>
<body>

<section class="form-main">
    <div class="form-content">
        <div class="box">
            <h3>Login</h3>

            <form action="../controlls/sesion.php" method="post">
                <div class="input-box">
                    <i class="fas fa-user"></i>
                    <input type="text" id="username" name="username" placeholder="Usuario o Email" class="input-control" required />
                </div>

                <div class="input-box">
                    <i class="fas fa-lock"></i>
                    <input type="password" id="password" name="password" placeholder="Contraseña" class="input-control" required />
                </div>

                <?php if (isset($_COOKIE["errorlogin"])): ?>
                    <p class="errorMsg">Datos incorrectos</p>
                    <?php setcookie("errorlogin", "", time() - 3600, "/"); ?>
                <?php endif; ?>

                <div class="options">
                    <label><input type="checkbox" name="remember"> Recordarme</label>
                    <a href="recuperar.php">¿Olvidaste tu contraseña?</a>
                </div>

                <button type="submit" class="btn">Iniciar Sesión</button>

                <div class="register-link">
                    ¿No tienes cuenta? <a href="registro.php">Regístrate</a>
                </div>
            </form>

            <button onclick="gotohome()" class="btn btn1" style="margin-top: 20px;">Regresar Como Visitante</button>
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
        window.location.href = "index.php";
    }
</script>
</body>
</html>
