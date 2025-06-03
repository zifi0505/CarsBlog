<?php
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

// Conexión a la base de datos
$conexion = new mysqli("localhost", "root", "", "carsblog");
if ($conexion->connect_error) {
    die("Error de conexión: " . $conexion->connect_error);
}

$mensaje = "";
$exito = false;

if ($_SERVER["REQUEST_METHOD"] === "POST") {
    $usuario = trim($_POST["usuario"] ?? '');
    $nueva = $_POST["nueva"] ?? '';
    $confirmar = $_POST["confirmar"] ?? '';

    if (empty($usuario) || empty($nueva) || empty($confirmar)) {
        $mensaje = "Todos los campos son obligatorios.";
    } elseif ($nueva !== $confirmar) {
        $mensaje = "Las contraseñas no coinciden.";
    } else {
        $stmt = $conexion->prepare("SELECT id FROM users WHERE username = ?");
        $stmt->bind_param("s", $usuario);
        $stmt->execute();
        $stmt->store_result();

        if ($stmt->num_rows === 1) {
            $hash = password_hash($nueva, PASSWORD_DEFAULT);
            $stmt->close();

            $stmt = $conexion->prepare("UPDATE users SET password = ? WHERE username = ?");
            $stmt->bind_param("ss", $hash, $usuario);
            if ($stmt->execute()) {
                $exito = true;
                $mensaje = "Contraseña actualizada correctamente.";
            } else {
                $mensaje = "Error al actualizar la contraseña.";
            }
        } else {
            $mensaje = "Usuario no encontrado.";
        }

        $stmt->close();
    }
}

$conexion->close();
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Restablecer Contraseña</title>
    <link rel="stylesheet" href="css/Diseño.css">
    <link rel="shortcut icon" href="images/cars.jpeg">
</head>
<body>

<section class="form-main">
    <div class="form-content">
        <div class="box">
            <img src="images/logoCarsMini.png" alt="Logo CarsBlog" style="width: 70%; height: auto; display: block; margin: 0 auto 20px;">
            <h3>Restablecer Contraseña</h3>

            <?php if ($mensaje): ?>
                <p class="errorMsg" style="background-color: <?= $exito ? 'rgba(0,180,100,0.3)' : 'rgba(230,83,37,0.4)' ?>;">
                    <?= htmlspecialchars($mensaje) ?>
                </p>
            <?php endif; ?>

            <form method="POST">
                <div class="input-box">
                    <input type="text" name="usuario" id="usuario" placeholder="Ingresa tu usuario" class="input-control" required>
                </div>
                <div class="input-box">
                    <input type="password" name="nueva" id="nueva" placeholder="Nueva contraseña" class="input-control" required>
                </div>
                <div class="input-box">
                    <input type="password" name="confirmar" id="confirmar" placeholder="Repite la contraseña" class="input-control" required>
                </div>

                <button type="submit" class="btn">Actualizar contraseña</button>

                <div class="input-link" style="margin-top: 20px;">
                    <a href="login.php" class="recuperar-link">¿Volver al inicio de sesión?</a>
                </div>
            </form>
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

</body>
</html>
