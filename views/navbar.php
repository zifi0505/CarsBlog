<div class="header_main">
  <div class="container-fluid px-4">
    <nav class="navbar navbar-expand-lg w-100 d-flex align-items-center">

      <!-- LOGO -->
      <div class="logo me-3">
        <a href="login-admin.php" title="Acceso administrador">
          <img src="images/logoCars1.png" alt="Logo CarsBlog" style="max-height: 45px; cursor: pointer;">
        </a>
      </div>

      <!-- BOTÓN HAMBURGUESA -->
      <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent"
        aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
        <i class="fa fa-bars"></i>
      </button>

      <!-- MENÚ NAVEGACIÓN -->
      <div class="collapse navbar-collapse justify-content-end" id="navbarSupportedContent">
        <ul class="navbar-nav">
          <li class="nav-item mx-3">
            <a class="btn btn-primary nav-link" href="index.php"><i class="bi bi-house"></i> Inicio</a>
          </li>

          <?php if (!isset($_SESSION["rol"])) { ?>
            <li class="nav-item mx-3">
              <a class="btn nav-link" href="login.php"><i class="bi bi-door-closed-fill"></i> Iniciar sesión</a>
            </li>
            <li class="nav-item mx-3">
              <a class="btn nav-link" href="registro.php"><i class="bi bi-person-plus-fill"></i> Registrarse</a>
            </li>
            <li class="nav-item mx-3">
              <a class="nav-link" href="About-us.html"><i class="bi bi-people-fill"></i> Sobre Nosotros</a>
            </li>
          <?php } else { ?>
            <li class="nav-item mx-3">
              <a class="nav-link" href="../controlls/cerrarSesion.php"><i class="bi bi-door-open-fill"></i> Cerrar sesión</a>
            </li>
            <li class="nav-item mx-3">
              <span class="nav-link">Bienvenido <?php echo htmlspecialchars($_SESSION['name']); ?></span>
            </li>
          <?php } ?>
        </ul>
      </div>
    </nav>
  </div>
</div>
