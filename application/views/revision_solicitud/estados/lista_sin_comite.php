<link rel="stylesheet" type="text/css" href="<?php echo asset_url(); ?>grocery_crud/themes/datatables/css/jquery.dataTables_1.10.19.css">
 
<?php
  echo form_open('gestion_revision/asignar_revisor/', array('id' => 'asignar_form', 'name' => 'asignar_form', 'autocomplete' => 'off'));
  if(isset($data_sn_comite))
  {
      if($data_sn_comite['success'])
      {
          if(count($data_sn_comite['result']) > 0)
          {
?>
            <!--button type="button" data-animation="flipInY" data-animation-delay="100" class="btn btn-theme btn-block submit-button btn-asignar-multiple" data-toggle="modal" data-target="#exampleModal"> <a  style="color:#fff;"><?php //echo $opciones_secciones['btn_asignar'];?></a> </button>
            <br-->
            <!-- lista sin comité -->
            <table class="table display compact hover" id="table_sin_comite">
              <thead>
                <tr>
                  <!--th scope="col"></th-->
                  <th scope="col"><?php echo $opciones_secciones['col_matricula'];?></th>
                  <th scope="col"><?php echo $opciones_secciones['col_nombre'];?></th>
                  <th scope="col"><?php echo $opciones_secciones['col_apellido_paterno'];?></th>
                  <th scope="col"><?php echo $opciones_secciones['col_apellido_materno'];?></th>
                  <th scope="col"><?php echo $opciones_secciones['col_delegacion'];?></th>
                  <th scope="col"><?php echo $opciones_secciones['col_fecha_registro'];?></th>
                  <th scope="col"><?php echo $opciones_secciones['col_opciones'];?></th>
                </tr>
              </thead>
              <tbody>
              <?php
              foreach ($data_sn_comite['result'] as $row)
              {
                //$folio_enc = encrypt_base64($row['folio']);
                ?>
                  <tr>
                    <!--td>
                      <div class="form-check">
                        <?php echo $this->form_complete->create_element(array('id'=>'check_'.$folio_enc, 'type'=>'checkbox', 'value'=>$folio_enc, 'attributes'=>array('class'=>'check_asignar'))); ?>
                      </div>
                    </td -->
                    <td scope="row"><?php echo $row['matricula'];?> <?php echo $this->form_complete->create_element(array('id'=>'check_'.$row['id_solicitud'], 'type'=>'checkbox', 'value'=>$row['id_solicitud'], 'attributes'=>array('class'=>'check_asignar','style'=>'display:none;'))); ?></td>
                    <td><?php echo $row['nombre'];?></td>
                    <td><?php echo $row['apellido_paterno'];?></td>
                    <td><?php echo $row['apellido_materno'];?></td>
                    <td><?php echo $row['delegacion'];?></td>
                    <td><?php echo $row['fecha'];?></td>
                    <td>
                        <a type="button" data-f="<?php echo $row['id_solicitud']; ?>" data-toggle="modal" class="btn-asignar" data-target="#exampleModal" href=""><?php echo $opciones_secciones['btn_asignar'];?> <span class="glyphicon glyphicon-new-window"></a>
                      <a href="<?php echo site_url().'/revision/index/'.$row['id_solicitud']; ?>" type="button"><?php echo $opciones_secciones['btn_ver'];?> <span class="glyphicon glyphicon-new-window"/></a>
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
    <h3><?php echo $mensajes['er_no_datos'];?></h3>
  <?php
  }
echo form_close();
?>
<!-- END lista sin comité -->
<?php echo js("jquery.dataTables.min.js"); ?>
<script>
$(document).ready(function () {
    $(".btn-asignar").on('click', function (e) {
        var f = $(this).data('f'); //Obtener datos para realizar envío
        $('.check_asignar').prop( "checked", false );
        $("#modal_contenido").html('');
        $('#check_'+f).prop( "checked", true );
        data_ajax(site_url + '/gestion_revision/asignar_revisor/', "#asignar_form", "#modal_contenido");
    });

    /*$(".btn-asignar-multiple").on('click', function (e) {
        var numberOfChecked = $('.check_asignar:checked').length; ///Validar número de usuarios seleccionadas
        if(numberOfChecked==0){
            e.stopPropagation(); //Evitar envío
            alert('Debe seleccionar al menos un folio para poder asignar revisores.');
        } else {
            $("#modal_contenido").html('');
            data_ajax(site_url + '/gestion_revision/asignar_revisor/', "#asignar_form", "#modal_contenido");
        }
    });*/
    <?php if($super===true){ ?>
              var ruta_language_datatable = url + "assets/spanish_table.json";
      $('#table_sin_comite').DataTable({
          "language": {
    //                    "url": "//cdn.datatables.net/plug-ins/1.10.15/i18n/Spanish.json"
                    "url": ruta_language_datatable
                }
      });
    <?php } ?>
});
  $("#comite").addClass("active");
  $("#atencion").removeClass();
  $("#revision").removeClass();
  $("#revisados").removeClass();
  $("#aceptados").removeClass();
  $("#rechazados").removeClass();
</script>
