<link rel="stylesheet" type="text/css" href="<?php echo asset_url(); ?>grocery_crud/themes/datatables/css/jquery.dataTables_1.10.19.css">
 
<?php
  if(isset($data_revisados))
  {
      if($data_revisados['success'])
      {
          if(count($data_revisados['result']) > 0)
          {
?>
            <!--h4> <?php //echo $opciones_secciones['nota_fecha_limite'];?> </h4-->
            <br>
            <table class="table" id="table_revisados">
              <thead>
                <tr>
                  <th scope="col"><?php echo $opciones_secciones['col_matricula'];?></th>
                  <th scope="col"><?php echo $opciones_secciones['col_nombre'];?></th>
                  <th scope="col"><?php echo $opciones_secciones['col_apellido_paterno'];?></th>
                  <th scope="col"><?php echo $opciones_secciones['col_apellido_materno'];?></th>
                  <th scope="col"><?php echo $opciones_secciones['col_delegacion'];?></th>
                  <th scope="col"><?php echo $opciones_secciones['col_fecha_registro'];?></th>
                  <th scope="col"><?php echo $opciones_secciones['col_revisor'];?></th>
                  <th scope="col"><?php echo $opciones_secciones['col_estatus_curso'];?></th>
                  <th scope="col"><?php echo $opciones_secciones['col_estatus_documentacion'];?></th>
                  <th scope="col"><?php echo $opciones_secciones['col_opciones'];?></th>
                </tr>
              </thead>
              <tbody>
<?php
              $lenguaje = obtener_lenguaje_actual();
              foreach ($data_revisados['result'] as $row)
              {
?>
                  <tr>
                    <td scope="row"><?php echo $row['matricula'];?></td>
                    <td><?php echo $row['nombre'];?></td>
                    <td><?php  echo $row['apellido_paterno'];?></td>
                    <td><?php  echo $row['apellido_materno'];?></td>
                    <td><?php  echo $row['delegacion'];?></td>
                    <td><?php  echo $row['fecha'];?></td>
                    <td><?php echo $row['revisor']; ?></td>
                    <td><?php foreach ($opcion_curso as $key_c => $curso) {
                        echo '<label><input type="checkbox" disabled="disabled" '.((array_key_exists($key_c, $row['estatus_curso'])) ? 'checked="checked"' : '').' >'.$curso.'</label><br>'; 
                    } ?></td>
                    <td><?php foreach ($opcion_documento as $key_d => $documento) {
                        echo '<label><input type="checkbox" disabled="disabled" '.((array_key_exists($key_d, $row['estatus_documentos'])) ? 'checked="checked"' : '').' >'.$documento.'</label><br>'; 
                    } ?></td>
                    <td>
                      <a href="<?php echo site_url().'/revision/index/'.$row['id_solicitud'].'/detalle'; ?>" type="button"><?php echo $opciones_secciones['btn_ver'];?> <span class="glyphicon glyphicon-new-window"/></a>
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
    <h3><?php echo $mensajes['er_no_datos'];?></h3>
<?php
  }
?>
    
    <?php echo js("jquery.dataTables.min.js"); ?>

  <script>
  $(document).ready(function () {
    <?php if($super===true){ ?>
      var ruta_language_datatable = url + "assets/spanish_table.json";
      $('#table_revisados').DataTable({
          "language": {
    //                    "url": "//cdn.datatables.net/plug-ins/1.10.15/i18n/Spanish.json"
                    "url": ruta_language_datatable
                }
      });
    <?php } ?>
  });
  $("#comite").removeClass()
  $("#atencion").removeClass()
  $("#revision").removeClass()
  $("#revisados").addClass("active")
  $("#aceptados").removeClass()
  $("#rechazados").removeClass()
  </script>
