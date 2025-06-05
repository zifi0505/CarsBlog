<?php
ini_set('display_errors', 1);
error_reporting(E_ALL);

$host = "localhost";
$db = "carsblog";
$user = "root";
$pass = "";
$mensaje = "";

try {
    $conn = new PDO("mysql:host=$host;dbname=$db;charset=utf8", $user, $pass);
    $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    if ($_SERVER["REQUEST_METHOD"] === "POST") {
        $nombre = $_POST["nombre"];
        $email = $_POST["email"];
        $contenido = $_POST["mensaje"];

        $stmt = $conn->prepare("INSERT INTO soporte (nombre, email, mensaje) VALUES (?, ?, ?)");
        $stmt->execute([$nombre, $email, $contenido]);

        $mensaje = "Tu mensaje fue enviado correctamente.";
    }
} catch (PDOException $e) {
    $mensaje = "Error al enviar mensaje: " . $e->getMessage();
}
?>
<!DOCTYPE html>
<html lang="es">
<head>
  <meta charset="UTF-8">
  <title>Soporte - CarsBlog</title>
  <link rel="stylesheet" href="css/Diseño.css">
  <link rel="shortcut icon" href="images/cars.jpeg" />
  <script src="https://kit.fontawesome.com/a076d05399.js" crossorigin="anonymous"></script>
</head>
<body>

<section class="form-main">
  <div class="form-content">
    <div class="box">
      <h3>Contacto al Soporte</h3>
      
      <?php if ($mensaje): ?>
        <p class="successMsg"><?= $mensaje ?></p>
      <?php endif; ?>

      <form method="post">
        <div class="input-box">
          <i class="fas fa-user"></i>
          <input type="text" name="nombre" placeholder="Tu nombre" class="input-control" required>
        </div>

        <div class="input-box">
          <i class="fas fa-envelope"></i>
          <input type="email" name="email" placeholder="Tu correo electrónico" class="input-control" required>
        </div>

        <div class="input-box">
          <i class="fas fa-comment"></i>
          <textarea name="mensaje" placeholder="Escribe tu mensaje..." class="input-control" rows="4" required></textarea>
        </div>

        <button type="submit" class="btn">Enviar</button>
        <button type="button" onclick="window.location.href='index.php'" class="btn btn1" style="margin-top: 20px;">Volver</button>
      </form>
    </div>
  </div>
</section>

<!-- Olas decorativas al fondo -->
<section>
  <div class="wave wave1"></div>
  <div class="wave wave2"></div>
  <div class="wave wave3"></div>
  <div class="wave wave4"></div>
</section>

</body>
</html>
