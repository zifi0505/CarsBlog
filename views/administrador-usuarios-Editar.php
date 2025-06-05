<?php
require_once("../autoload.php");
session_start();

if (!isset($_SESSION["rol"]) || $_SESSION["rol"] != 0) {
    header("location:../public/index.php");
    exit;
}

use models\user;
$objUser = new user();

$id = $_POST["id"] ?? null;

if (!$id) {
    header("location:administrador-usuarios.php");
    exit;
}

$usuario = $objUser->getUserById($id);

// Conexión para obtener todos los roles
try {
    $conn = new PDO("mysql:host=localhost;dbname=carsblog;charset=utf8", "root", "");
    $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    // Asegúrate de que haya más de un rol registrado
    $roles = $conn->query("SELECT * FROM roles ORDER BY id")->fetchAll(PDO::FETCH_ASSOC);

    // Si no hay roles suficientes, los insertamos
    if (count($roles) < 2) {
        $conn->exec("INSERT IGNORE INTO roles (id, rol) VALUES
            (0, 'Administrador'),
            (1, 'Editor'),
            (2, 'Usuario')");
        $roles = $conn->query("SELECT * FROM roles ORDER BY id")->fetchAll(PDO::FETCH_ASSOC);
    }

} catch (PDOException $e) {
    $roles = [];
}

if ($_SERVER["REQUEST_METHOD"] === "POST" && isset($_POST["username"], $_POST["rol"])) {
    $nuevoUsuario = new user($_POST["username"], $usuario["password"], $_POST["rol"]);
    $nuevoUsuario->editUser($id, $_SESSION["id_user"]);
    header("Location: administrador-usuarios.php");
    exit;
}
?>
<!DOCTYPE html>
<html lang="es">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <title>Editar Usuario - CarsBlog</title>
  <link rel="stylesheet" href="css/Diseño.css" />
  <link rel="shortcut icon" href="images/cars.jpeg" />
  <script src="https://kit.fontawesome.com/a076d05399.js" crossorigin="anonymous"></script>
</head>
<body>

<section class="form-main">
  <div class="form-content">
    <div class="box">
      <h3>Editar Usuario</h3>
      <form method="post">
        <input type="hidden" name="id" value="<?= htmlspecialchars($usuario['id']) ?>">

        <div class="input-box">
          <i class="fas fa-user"></i>
          <input type="text" name="username" value="<?= htmlspecialchars($usuario['username']) ?>" placeholder="Nombre de usuario" class="input-control" required>
        </div>

        <div class="input-box">
          <i class="fas fa-user-tag"></i>
          <select name="rol" required class="input-control" style="width: 100%; height: 40px; border-radius: 10px; padding: 5px 10px; font-size: 16px;">
            <?php foreach ($roles as $rol): ?>
              <option value="<?= $rol['id'] ?>" <?= $usuario['rol'] == $rol['id'] ? 'selected' : '' ?>>
                <?= htmlspecialchars($rol['rol']) ?>
              </option>
            <?php endforeach; ?>
          </select>
        </div>

        <button type="submit" class="btn">Guardar Cambios</button>
        <button type="button" onclick="window.location.href='administrador-usuarios.php'" class="btn btn1" style="margin-top: 20px;">Cancelar</button>
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

</body>
</html>
