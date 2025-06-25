<?php
ini_set('display_errors', 1);
error_reporting(E_ALL);

// Conexión a la base de datos
$conexion = new mysqli("localhost", "root", "", "carsblog");
if ($conexion->connect_error) {
    die("Error de conexión: " . $conexion->connect_error);
}

$mensaje = "";
$estado = "pedir_correo";

// 1. ENVÍA TOKEN AL CORREO
if ($_SERVER["REQUEST_METHOD"] === "POST" && isset($_POST["correo"])) {
    $correo = trim($_POST["correo"]);

    if (empty($correo)) {
        $mensaje = "Debes ingresar un correo.";
    } else {
        $stmt = $conexion->prepare("SELECT id FROM users WHERE email = ?");
        $stmt->bind_param("s", $correo);
        $stmt->execute();
        $result = $stmt->get_result();

        if ($result->num_rows === 1) {
            $user = $result->fetch_assoc();
            $token = bin2hex(random_bytes(32));
            $expira = date("Y-m-d H:i:s", time() + 3600); // 1 hora

            $stmt = $conexion->prepare("UPDATE users SET reset_token = ?, token_expira = ? WHERE id = ?");
            $stmt->bind_param("ssi", $token, $expira, $user["id"]);
            $stmt->execute();

            $enlace = "http://localhost/recuperar.php?token=$token";

            // ENVÍO DEL CORREO (reemplaza con PHPMailer en producción)
            mail($correo, "Recuperar contraseña", "Haz clic en este enlace para restablecer tu contraseña: $enlace");

            $mensaje = "Se ha enviado un enlace de recuperación a tu correo.";
            $estado = "enviado";
        } else {
            $mensaje = "Correo no encontrado.";
        }
    }
}

// 2. MOSTRAR FORMULARIO SI SE ENVIÓ TOKEN
if ($_SERVER["REQUEST_METHOD"] === "GET" && isset($_GET["token"])) {
    $token = $_GET["token"];
    $estado = "nueva_pass";
}

// 3. ACTUALIZA LA CONTRASEÑA SI EL TOKEN ES VÁLIDO
if ($_SERVER["REQUEST_METHOD"] === "POST" && isset($_POST["token"])) {
    $token = $_POST["token"];
    $nueva = $_POST["nueva"] ?? '';
    $confirmar = $_POST["confirmar"] ?? '';

    if ($nueva !== $confirmar || empty($nueva)) {
        $mensaje = "Las contraseñas no coinciden o están vacías.";
        $estado = "nueva_pass";
    } else {
        $stmt = $conexion->prepare("SELECT id FROM users WHERE reset_token = ? AND token_expira > NOW()");
        $stmt->bind_param("s", $token);
        $stmt->execute();
        $res = $stmt->get_result();

        if ($res->num_rows === 1) {
            $user = $res->fetch_assoc();
            $hash = password_hash($nueva, PASSWORD_DEFAULT);

            $stmt = $conexion->prepare("UPDATE users SET password = ?, reset_token = NULL, token_expira = NULL WHERE id = ?");
            $stmt->bind_param("si", $hash, $user["id"]);
            $stmt->execute();

            $mensaje = "Contraseña actualizada correctamente.";
            $estado = "finalizado";
        } else {
            $mensaje = "Token inválido o expirado.";
        }
    }
}
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Restablecer contraseña</title>
</head>
<body>
    <h2>Restablecer contraseña</h2>

    <?php if ($mensaje): ?>
        <p><strong><?= htmlspecialchars($mensaje) ?></strong></p>
    <?php endif; ?>

    <?php if ($estado === "pedir_correo"): ?>
        <form method="POST">
            <label for="correo">Correo electrónico:</label>
            <input type="email" name="correo" required>
            <button type="submit">Enviar enlace</button>
        </form>

    <?php elseif ($estado === "nueva_pass"): ?>
        <form method="POST">
            <input type="hidden" name="token" value="<?= htmlspecialchars($_GET["token"]) ?>">
            <label>Nueva contraseña:</label>
            <input type="password" name="nueva" required>
            <label>Confirmar contraseña:</label>
            <input type="password" name="confirmar" required>
            <button type="submit">Guardar nueva contraseña</button>
        </form>

    <?php elseif ($estado === "finalizado"): ?>
        <p><a href="login.php">Volver al login</a></p>
    <?php endif; ?>
</body>
</html>


<!-- Olas decorativas -->
<section>
    <div class="wave wave1"></div>
    <div class="wave wave2"></div>
    <div class="wave wave3"></div>
    <div class="wave wave4"></div>
</section>

</body>
</html>
