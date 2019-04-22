<?php
// pr($data_rechazados);
if(!empty($data_rechazados))

{
  if($data_rechazados['success'])
  {
    if(count($data_rechazados['result']) > 0)
    {
?>
      <!-- lista_rechazados -->
      <table class="table">
        <thead>
          <tr>
            <th scope="col"><?php echo $language_text['col_folio'];?></th>
            <th scope="col"><?php echo $language_text['col_titulo'];?></th>
            <th scope="col"><?php echo $language_text['col_metodologia'];?></th>
            <th scope="col"><?php echo $language_text['col_opciones'];?></th>
          </tr>
        </thead>
        <tbody>
          <?php
              $lenguaje = obtener_lenguaje_actual();
              foreach ($data_rechazados['result'] as $row)
                {
          ?>
                  <tr>
                      <td scope="row"><?php echo $row['folio'];?></td>
                      <td><?php echo $row['titulo'];?></td>
                      <td><?php echo $row['metodologia']; ?></td>
                      <td>
                          <a href="" type="button" data-animation="flipInY" data-animation-delay="100" >Ver trabajo <span class="glyphicon glyphicon-new-window"></a>
                      </td>
                  </tr>
                  <?php
                }
                }else
                    {
                  ?>
                            <h3><?php echo $opciones_secciones['rz_mensaje'];?></h3>
                  <?php

                     }
                  }else
                    {
                  ?>
                        <h3><?php echo $mensajes['ern_mensaje'];?></h3>
                  <?php
                    }
                  ?>

          </tbody>
          </table>
                  <?php
                    }else
                      {
                  ?>
                        <h3><?php echo $mensajes['ern_mensaje'];?></h3>
                  <?php
                      }
                  ?>
      <!-- END lista_rechazados -->
      <script>
      $("#comite").removeClass()
      $("#atencion").removeClass()
      $("#revision").removeClass()
      $("#revisados").removeClass()
      $("#aceptados").removeClass()
      $("#rechazados").addClass("active")
    </script>
