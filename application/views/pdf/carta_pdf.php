<!DOCTYPE html>
<html lang="es">
  <head>
    <meta charset="UTF-8">
    <title></title>
  </head>
  <style>
    .fondo{
      /* background-image: url(../../../assets/img/dictamen/fondo.png); */
    }
    .cabecera{
        padding-left: 60px;
    }
    .pie{
      /* background-image: url(../../../assets/img/dictamen/fondo.png); */
    }
  </style>

  <body>
    <div class="col-sm-12">
        <img class="cabecera" src="<?php echo $this->config->item('upload_header_carta') ?>">
    </div>
    <div class="col-sm-12">
      <h3>Estimado <?php// echo $language_text['asunto_recuperar_contrasenia'];?> : </h3>
      <p class="text-justify"> <?php echo $language_text['asunto_recuperar_contrasenia'];?> </p>
    </div>
    <footer>
      <!-- <img class="cabecera" src="C:\xampp\htdocs\foro_v2\assets\img\dictamen\footer.png" alt=""> -->
      <img class="cabecera" src="<?php echo $this->config->item('upload_footer_carta') ?>" >
    </footer>
  </body>
</html>
