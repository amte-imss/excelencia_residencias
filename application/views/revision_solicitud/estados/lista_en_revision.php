<?php
  if(isset($data_en_revision))
  {
      if($data_en_revision['success'])
      {
          if(count($data_en_revision['result']) > 0)
          {
?>
            <h4> <?php echo $opciones_secciones['nota_fecha_limite'];?> </h4>
            <br>
            <table class="table">
              <thead>
                <tr>
                  <th scope="col"><?php echo $opciones_secciones['col_folio'];?></th>
                  <th scope="col"><?php echo $opciones_secciones['col_titulo'];?></th>
                  <th scope="col"><?php echo $opciones_secciones['col_metodologia'];?></th>
                  <th scope="col">Estado</th>
                  <th scope="col"><?php echo $opciones_secciones['col_r1'];?></th>
                  <th scope="col"><?php echo $opciones_secciones['col_r2'];?></th>
                  <th scope="col"><?php echo $opciones_secciones['col_r3'];?></th>
                  <th scope="col"><?php echo $opciones_secciones['col_opciones'];?></th>
                </tr>
              </thead>
              <tbody>
<?php
              $lenguaje = obtener_lenguaje_actual();
              foreach ($data_en_revision['result'] as $row)
              {
?>
                  <tr>
                    <td scope="row"><?php echo $row['folio'];?></td>
                    <td><?php echo $row['titulo'];?></td>
                    <td><?php  echo $row['metodologia'];?></td>
                    <td><?php  echo $row['clave_estado'];?></td>
                      <?php
                          foreach ($row['revisores'] as $revisor) {
                      ?>
                              <td><?php echo (isset($revisor['revisor'])) ? $revisor['revisor'] : '';?><br>
                                <?php echo (isset($revisor['clave_estado'])) ? '<b>'.$revisor['clave_estado'].'</b>' : '';?><br>
                                <?php echo (isset($revisor['fecha_limite_revision'])) ? $revisor['fecha_limite_revision'] : '';?>
                              </td>
                      <?php
                          }
                          if(count($row['revisores']) < 3){
                      ?>
                          <td></td>
                      <?php
                          }
                      ?>
                    <td>
                      <!-- <a href="" type="button" data-animation="flipInY" data-animation-delay="100" data-toggle="modal" data-target="#exampleModal"><?php echo $opciones_secciones['btn_ver'];?> <span class="glyphicon glyphicon-new-window"></a> -->
                      <a href="<?php echo site_url().'/registro_investigacion/ver/'.$row['folio']; ?>" type="button"><?php echo $opciones_secciones['btn_ver'];?> <span class="glyphicon glyphicon-new-window"/></a>
                    </td>
                  </tr>
<?php
              }
          }
          else
          {
?>
          <h3><?php echo $opciones_secciones['er_mensaje'];?></h3>
<?php

          }
      }
      else
      {
?>
      <h3><?php echo $mensajes['ern_mensaje'];?></h3>
<?php
      }
?>

    </tbody>
  </table>
<?php
  }
  else
  {
?>
    <h3><?php echo $mensajes['ern_mensaje'];?></h3>
<?php
  }
?>

  <script>
  $("#comite").removeClass()
  $("#atencion").removeClass()
  $("#revision").addClass("active")
  $("#revisados").removeClass()
  $("#aceptados").removeClass()
  $("#rechazados").removeClass()
  </script>
