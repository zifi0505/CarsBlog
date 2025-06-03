<?php
if ($_SERVER["REQUEST_METHOD"] === "POST") {
    $username = trim($_POST["username"] ?? '');
    $password = $_POST["password"] ?? '';
    $confirm_password = $_POST["confirm_password"] ?? '';

    if (!$username || !$password || !$confirm_password) {
        setcookie("errorregistro", "Completa todos los campos.", time() + 5, "/");
        header("Location: registro.php");
        exit;
    }

    if ($password !== $confirm_password) {
        setcookie("errorregistro", "Las contraseñas no coinciden.", time() + 5, "/");
        header("Location: registro.php");
        exit;
    }

    // Conexión corregida a la base de datos carsblog
    $conexion = new mysqli("localhost", "root", "", "carsblog");
    if ($conexion->connect_error) {
        die("Error de conexión: " . $conexion->connect_error);
    }

    // Verificar si el usuario ya existe
    $stmt = $conexion->prepare("SELECT id FROM users WHERE username = ?");
    $stmt->bind_param("s", $username);
    $stmt->execute();
    $stmt->store_result();

    if ($stmt->num_rows > 0) {
        setcookie("errorregistro", "El nombre de usuario ya existe.", time() + 5, "/");
        header("Location: registro.php");
        exit;
    }
    $stmt->close();

    // Crear usuario nuevo (rol por defecto: 3 -> Usuario)
    $hashed = password_hash($password, PASSWORD_DEFAULT);
    $rol = 3;
    $stmt = $conexion->prepare("INSERT INTO users (rol, username, password) VALUES (?, ?, ?)");
    $stmt->bind_param("iss", $rol, $username, $hashed);
    $stmt->execute();
    $stmt->close();
    $conexion->close();

    header("Location: login.php");
    exit;
}
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8" />
    <title>Registro - CarsBlog</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <link rel="stylesheet" href="css/Diseño.css" />
    <link rel="shortcut icon" href="images/cars.jpeg" />
</head>
<body>
    <section class="form-main">
        <div class="form-content">
            <div class="box">
                <img src="images/logoCarsMini.png" alt="Logo CarsBlog" width="70%" height="70%" />
                <h3>Registro</h3>
                <form method="post" action="">
                    <div class="input-box">
                        <label for="username">Usuario</label>
                        <input type="text" id="username" name="username" placeholder="Nombre de usuario" class="input-control" required />
                    </div>
                    <div class="input-box">
                        <label for="password">Contraseña</label>
                        <input type="password" id="password" name="password" placeholder="Contraseña" class="input-control" required />
                    </div>
                    <div class="input-box">
                        <label for="confirm_password">Confirmar Contraseña</label>
                        <input type="password" id="confirm_password" name="confirm_password" placeholder="Repite la contraseña" class="input-control" required />
                    </div>

                    <?php if (isset($_COOKIE["errorregistro"])): ?>
                        <p class="errorMsg"><?= htmlspecialchars($_COOKIE["errorregistro"]) ?></p>
                        <?php setcookie("errorregistro", "", time() - 3600, "/"); ?>
                    <?php endif; ?>

                    <button type="submit" class="btn">Registrarse</button>
                    <div class="input-link">
                        <a href="login.php" class="recuperar-link">¿Ya tienes cuenta? Inicia sesión</a>
                    </div>
                </form>
                <button onclick="gotohome()" class="btn btn1">Regresar Como Visitante</button>
            </div>
        </div>
    </section>

    <!-- Olas animadas -->
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
