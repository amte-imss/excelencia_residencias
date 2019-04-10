<?php
  if(isset($data_aceptados))
  {
      if($data_aceptados['success'])
      {
          if(count($data_aceptados['result']) > 0)
          {
?>
            <!-- aceptados -->
            <table class="table">
              <thead>
                <tr>
                  <th scope="col"><?php echo $opciones_secciones['col_folio'];?></th>
                  <th scope="col"><?php echo $opciones_secciones['col_titulo'];?></th>
                  <th scope="col"><?php echo $opciones_secciones['col_metodologia'];?></th>
                  <th scope="col"><?php echo $opciones_secciones['col_tipo'];?></th>
                  <th scope="col"><?php echo $opciones_secciones['col_puntaje'];?></th>
                  <th scope="col"><?php echo $opciones_secciones['col_opciones'];?></th>
                </tr>
              </thead>
              <tbody>
<?php
              foreach ($data_aceptados['result'] as $row)
              {
                  $folio_enc = encrypt_base64($row['folio']);
?>
                  <tr>
                    <td scope="row"><?php echo $row['folio'];?></td>
                    <td><?php echo $row['titulo'];?></td>
                    <td><?php echo $row['metodologia'];?></td>
                    <td><?php echo $row['tipo_exposicion'];?></td>
                    <td><?php echo $row['promedio_revision'];?></td>
                    <td>
                      <a href="<?php echo base_url('index.php/gestion_revision/ver_resumen/'.$folio_enc); ?>" type="button" data-animation="flipInY" data-animation-delay="100" data-toggle="modal" data-target="#exampleModal"><?php echo $opciones_secciones['btn_revision'];?> <span class="glyphicon glyphicon-new-window"></a>
                    </td>
                  </tr>
<?php
              }
          }
          else
          {
?>
          <h3><?php echo $opciones_secciones['ac_mensaje'];?></h3>
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
$("#revision").removeClass()
$("#revisados").removeClass()
$("#aceptados").addClass("active")
$("#rechazados").removeClass()
</script>
