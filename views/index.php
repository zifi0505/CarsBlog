<?php
  require_once("../autoload.php");
  use models\publicaciones;
  $publicacion = new publicaciones();
  $posts = $publicacion->getpublicaciones();
?>

<?php include("header.php"); ?>
<?php include("navbar.php"); ?>
<?php include("banner.php"); ?>
<?php include("slider.php"); ?>

<div class="services_main">
  <div class="container">
    <div class="creative_taital">
      <h1 class="creative_text">El Blogg de unos Estudiante</h1>
      <p style="color: #000000; text-align: center;">Esta es una página tipo blogger personal sobre nuestra opinión en algunas tecnologías que hemos probado o queremos probar...</p>
    </div>
    <div class="section_service_2">
      <h1 class="service_text">Publicaciones</h1>
    </div>
  </div>

  <?php include("publicaciones.php"); ?>
</div>

<?php include("footer.php"); ?>
