<?php
ini_set('display_errors', 1);
error_reporting(E_ALL);
session_start();

// Redirige si ya hay sesión activa
if (isset($_SESSION["rol"])) {
    header("Location: index.php");
    exit;
}

// Conexión
$host = "localhost";
$db = "carsblog";
$user = "root";
$pass = "";
$mensaje = "";

try {
    $conn = new PDO("mysql:host=$host;dbname=$db;charset=utf8", $user, $pass);
    $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    if ($_SERVER["REQUEST_METHOD"] === "POST") {
        $username = trim($_POST["username"]);
        $email = trim($_POST["email"]);
        $password = password_hash($_POST["password"], PASSWORD_BCRYPT);

        // Verifica duplicado
        $check = $conn->prepare("SELECT COUNT(*) FROM admin WHERE username = ? OR email = ?");
        $check->execute([$username, $email]);
        if ($check->fetchColumn() > 0) {
            $mensaje = "⚠️ El nombre de usuario o correo ya está registrado.";
        } else {
            $stmt = $conn->prepare("INSERT INTO admin (username, email, password) VALUES (?, ?, ?)");
            $stmt->execute([$username, $email, $password]);
            $mensaje = "✅ Administrador registrado correctamente.";
        }
    }
} catch (PDOException $e) {
    $mensaje = "Error: " . $e->getMessage();
}
?>
<!DOCTYPE html>
<html lang="es">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <title>Registrar Administrador - CarsBlog</title>
  <link rel="stylesheet" href="css/Diseño.css" />
  <link rel="shortcut icon" href="images/cars.jpeg" />
  <script src="https://kit.fontawesome.com/a076d05399.js" crossorigin="anonymous"></script>
</head>
<body>

<section class="form-main">
  <div class="form-content">
    <div class="box">
      <h3>Registrar Administrador</h3>

      <?php if ($mensaje): ?>
        <p class="errorMsg"><?= $mensaje ?></p>
      <?php endif; ?>

      <form method="post">
        <div class="input-box">
          <i class="fas fa-user"></i>
          <input type="text" name="username" placeholder="Nombre de usuario" class="input-control" required />
        </div>
        <div class="input-box">
          <i class="fas fa-envelope"></i>
          <input type="email" name="email" placeholder="Correo electrónico" class="input-control" required />
        </div>
        <div class="input-box">
          <i class="fas fa-lock"></i>
          <input type="password" name="password" placeholder="Contraseña" class="input-control" required />
        </div>

        <button type="submit" class="btn">Registrar</button>
        <button type="button" onclick="window.location.href='index.php'" class="btn btn1" style="margin-top: 20px;">Cancelar</button>
      </form>

      <div class="register-link" style="margin-top: 20px;">
        ¿Ya tienes cuenta? <a href="login-admin.php">Inicia sesión</a>
      </div>
    </div>
  </div>
</section>

<section>
  <div class="wave wave1"></div>
  <div class="wave wave2"></div>
  <div class="wave wave3"></div>
  <div class="wave wave4"></div>
</section>

</body>
</html>
