<?php
  if(isset($data_req_atencion))
  {
      if($data_req_atencion['success'])
      {
          if(count($data_req_atencion['result']) > 0)
          {
?>
              <!-- lista_requiere_atencion -->
              <table class="table">
                <thead>
                  <tr>
                    <th scope="col"><?php echo $opciones_secciones['col_folio'];?></th>
                    <th scope="col"><?php echo $opciones_secciones['col_titulo'];?></th>
                    <th scope="col"><?php echo $opciones_secciones['col_metodologia'];?></th>
                    <th scope="col"><?php echo $opciones_secciones['col_r1'];?></th>
                    <th scope="col"><?php echo $opciones_secciones['col_r2'];?></th>
                    <th scope="col"><?php echo $opciones_secciones['col_r3'];?></th>
                    <th scope="col"><?php echo $opciones_secciones['col_num_asignaciones'];?></th>
                    <th scope="col"><?php echo $opciones_secciones['col_opciones'];?></th>
                  </tr>
                </thead>
                <tbody>
              <?php
              foreach ($data_req_atencion['result'] as $row)
              {
                $bandera=false;
                foreach ($row['mostrar'] as $key_m => $incidencias) { ///Validar incidencias
                  if($incidencias>0){
                    $bandera=true;
                  }
                }
                if($bandera){ //En caso de ocurrir alguna incidencia se muestra el registro
                  $folio_enc = encrypt_base64($row['folio']);
                  ?>
                  <tr>
                    <td scope="row"><?php echo $row['folio'];?></td>
                    <td><?php echo $row['titulo'];?></td>
                    <td><?php echo $row['metodologia'];?></td>
                    <?php
                        foreach ($row['revisores'] as $revisor) {
                    ?>
                            <td><?php echo (isset($revisor['revisor'])) ? $revisor['revisor'] : '';?><br>
                                <?php echo (isset($revisor['clave_estado'])) ? '<b>'.$revisor['clave_estado'].'</b>' : '';?><br>
                                <?php echo (isset($revisor['fecha_limite_revision'])) ? nice_date($revisor['fecha_limite_revision'], 'd-m-Y h:i') : '';?>
                            </td>
                    <?php
                        }
                        if(count($row['revisores']) < 3){
                    ?>
                        <td></td>
                    <?php
                        }
                    ?>
                    <td><?php echo $row['numero_revisiones'];?></td>
                    <td>
                      <!-- <a href="" type="button" data-animation="flipInY" data-animation-delay="100" data-toggle="modal" data-target="#exampleModal"><?php echo $opciones_secciones['btn_ver'];?> <span class="glyphicon glyphicon-new-window"></a>  -->
                      <a href="<?php echo site_url().'/registro_investigacion/ver/'.$row['folio']; ?>" type="button" style="display:inline-table;"><?php echo $opciones_secciones['btn_ver'];?> <span class="glyphicon glyphicon-new-window"/></a>
                      <a href="" type="button" data-animation="flipInY" data-animation-delay="100" data-f="<?php echo $folio_enc; ?>" class="btn-asignar" data-toggle="modal" data-target="#exampleModal" style="display:inline-table;"><?php echo $opciones_secciones['btn_asignar'];?> <span class="glyphicon glyphicon-log-in"></a>
                    </td
                  </tr>
                <?php
                }
              }
          }
          else
          {
?>
          <h3><?php echo $opciones_secciones['ra_mensaje'];?></h3>
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
<!-- END lista_requiere_atencion -->

<script>
$(document).ready(function () {
    $(".btn-asignar").on('click', function (e) {
        var f = $(this).data('f'); //Obtener datos para realizar envío
        $("#modal_contenido").html('');
        data_ajax(site_url + '/gestion_revision/asignar_revisor_requiere_atencion/'+f, null, "#modal_contenido");
    });
});
$("#comite").removeClass();
$("#atencion").addClass("active");
$("#revision").removeClass();
$("#revisados").removeClass();
$("#aceptados").removeClass();
$("#rechazados").removeClass();
</script>
