<section class="form-main">
  <div class="form-content">
    <?php foreach ($posts as $post) { ?>
      <div class="box">
        <h4><?php echo $post['titulo'];?></h4>
        <h5><?php echo $post['contenido'];?></h5>
        <?php if($post['dir_img'] != null) { ?>
          <img src="<?php echo $post['dir_img']; ?>" alt="imagen de publicación" class="img-post">
        <?php } ?>
        <h6><?php echo $post['fecha_creacion'];?></h6>
      </div>
    <?php } ?>
  </div>
</section>
