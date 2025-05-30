<div class="header_main">
  <div class="container">
    <nav class="navbar navbar-expand-lg w-100 d-flex align-items-center">
      <div class="logo me-4">
        <a href="#"><img src="images/logoCars1.png" alt="Logo" style="max-height: 60px;"></a>
      </div>
      <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent"
        aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
        <i class="fa fa-bars"></i>
      </button>
      <div class="collapse navbar-collapse justify-content-end" id="navbarSupportedContent">
        <ul class="navbar-nav">
          <li class="nav-item active"><a class="btn btn-primary nav-link" href="#"><i class="bi bi-house"></i> Inicio</a></li>
          <?php if (!isset($_SESSION["rol"])) { ?>
            <li class="nav-item"><a class="btn nav-link" href="login.php"><i class="bi bi-door-closed-fill"></i> Iniciar sesión</a></li>
            <li class="nav-item"><a class="nav-link" href="About-us.html"><i class="bi bi-people-fill"></i> Sobre Nosotros</a></li>
          <?php } else { ?>
            <li class="nav-item"><a class="nav-link" href="administrador.php"><i class="bi bi-person-bounding-box"></i> Administrador</a></li>
            <li class="nav-item"><a class="nav-link" href="../controlls/cerrarSesion.php"><i class="bi bi-door-open-fill"></i> Cerrar sesión</a></li>
            <li class="nav-item"><a class="nav-link">| Bienvenido <?php echo $_SESSION['name']; ?></a></li>
          <?php } ?>
        </ul>
      </div>
    </nav>
  </div>
</div>
