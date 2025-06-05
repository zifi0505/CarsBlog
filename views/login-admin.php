<?php
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

session_start();
if (isset($_SESSION["rol"])) {
    if ($_SESSION["rol"] == 0) {
        header("Location: administrador.php");
    } else {
        header("Location: index.php");
    }
    exit;
}
?>
<!DOCTYPE html>
<html lang="es">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <title>Login Admin - CarsBlog</title>
  <link rel="stylesheet" href="css/Diseño.css" />
  <link rel="shortcut icon" href="images/cars.jpeg" />
  <script src="https://kit.fontawesome.com/a076d05399.js" crossorigin="anonymous"></script>
  <style>
    .options a, .admin-register a {
      color: #007bff;
      text-decoration: none;
      margin-top: 10px;
      display: inline-block;
    }

    .options a:hover, .admin-register a:hover {
      text-decoration: underline;
    }
  </style>
</head>
<body>

<section class="form-main">
  <div class="form-content">
    <div class="box">
      <h3>Login Administrador</h3>
      <form action="login-admin-handler.php" method="post">
        <div class="input-box">
          <i class="fas fa-user"></i>
          <input type="text" name="username" placeholder="Usuario o Email" class="input-control" required />
        </div>
        <div class="input-box">
          <i class="fas fa-lock"></i>
          <input type="password" name="password" placeholder="Contraseña" class="input-control" required />
        </div>

        <?php if (isset($_COOKIE["erroradmin"])): ?>
          <p class="errorMsg">Credenciales inválidas o sin permisos de administrador</p>
          <?php setcookie("erroradmin", "", time() - 3600, "/"); ?>
        <?php endif; ?>

        <div class="options">
          <a href="soporte.php">¿Necesitas ayuda?</a>
        </div>

        <div class="admin-register">
          <a href="registro-admin.php">¿Eres nuevo administrador? Crear cuenta</a>
        </div>

        <button type="submit" class="btn">Iniciar Sesión</button>

        <div class="register-link" style="margin-top: 20px;">
          ¿No eres administrador? <a href="login.php">Volver a login de usuarios</a>
        </div>

        <button type="button" onclick="gotohome()" class="btn btn1" style="margin-top: 25px;">Regresar al inicio</button>
      </form>
    </div>
  </div>
</section>

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
