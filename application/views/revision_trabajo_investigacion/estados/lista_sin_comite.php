<?php
  echo form_open('gestion_revision/asignar_revisor/', array('id' => 'asignar_form', 'name' => 'asignar_form', 'autocomplete' => 'off'));
  if(isset($data_sn_comite))
  {
      if($data_sn_comite['success'])
      {
          if(count($data_sn_comite['result']) > 0)
          {
?>
            <button type="button" data-animation="flipInY" data-animation-delay="100" class="btn btn-theme btn-block submit-button btn-asignar-multiple" data-toggle="modal" data-target="#exampleModal"> <a  style="color:#fff;"><?php echo $opciones_secciones['btn_asignar'];?></a> </button>
            <br>
            <!-- lista sin comité -->
            <table class="table">
              <thead>
                <tr>
                  <th scope="col"></th>
                  <th scope="col"><?php echo $opciones_secciones['col_folio'];?></th>
                  <th scope="col"><?php echo $opciones_secciones['col_titulo'];?></th>
                  <th scope="col"><?php echo $opciones_secciones['col_metodologia'];?></th>
                  <th scope="col"><?php echo $opciones_secciones['col_opciones'];?></th>
                </tr>
              </thead>
              <tbody>
              <?php
              foreach ($data_sn_comite['result'] as $row)
              {
                $folio_enc = encrypt_base64($row['folio']);
                ?>
                  <tr>
                    <td>
                      <div class="form-check">
                        <?php echo $this->form_complete->create_element(array('id'=>'check_'.$folio_enc, 'type'=>'checkbox', 'value'=>$folio_enc, 'attributes'=>array('class'=>'check_asignar'))); ?>
                      </div>
                    </td>
                    <td scope="row"><?php echo $row['folio'];?></td>
                    <td><?php echo $row['titulo'];?></td>
                    <td><?php echo $row['metodologia'];?></td>
                    <td>
                      <a href="<?php echo site_url().'/registro_investigacion/ver/'.$row['folio']; ?>" type="button"><?php echo $opciones_secciones['btn_ver'];?> <span class="glyphicon glyphicon-new-window"/></a>
                        <a type="button" data-f="<?php echo $folio_enc; ?>" data-toggle="modal" class="btn-asignar" data-target="#exampleModal" href=""><?php echo $opciones_secciones['btn_asignar'];?> <span class="glyphicon glyphicon-log-in"></a>
                      <!-- <a type="button" data-f="<?php echo $folio_enc; ?>" data-toggle="modal" data-target="#exampleModal" href=""><?php echo $opciones_secciones['btn_ver'];?> <span class="glyphicon glyphicon-new-window"></a> -->
                    </td>
                  </tr>
                  <?php
              }
          }
          else
          {
  ?>
          <h3><?php echo $opciones_secciones['sc_mensaje'];?></h3>
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
  }else
  {
  ?>
    <h3><?php echo $mensajes['ern_mensaje'];?></h3>
  <?php
  }
echo form_close();
?>
<!-- END lista sin comité -->

<script>
$(document).ready(function () {
    $(".btn-asignar").on('click', function (e) {
        var f = $(this).data('f'); //Obtener datos para realizar envío
        $('.check_asignar').prop( "checked", false );
        $("#modal_contenido").html('');
        $('#check_'+f).prop( "checked", true );
        data_ajax(site_url + '/gestion_revision/asignar_revisor/', "#asignar_form", "#modal_contenido");
    });

    $(".btn-asignar-multiple").on('click', function (e) {
        var numberOfChecked = $('.check_asignar:checked').length; ///Validar número de usuarios seleccionadas
        if(numberOfChecked==0){
            e.stopPropagation(); //Evitar envío
            alert('Debe seleccionar al menos un folio para poder asignar revisores.');
        } else {
            $("#modal_contenido").html('');
            data_ajax(site_url + '/gestion_revision/asignar_revisor/', "#asignar_form", "#modal_contenido");
        }
    });
});
  $("#comite").addClass("active");
  $("#atencion").removeClass();
  $("#revision").removeClass();
  $("#revisados").removeClass();
  $("#aceptados").removeClass();
  $("#rechazados").removeClass();
</script>
