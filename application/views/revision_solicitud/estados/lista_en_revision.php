<link rel="stylesheet" type="text/css" href="<?php echo asset_url(); ?>grocery_crud/themes/datatables/css/jquery.dataTables_1.10.19.css">
 
<script type="text/javascript" charset="utf8" src="<?php echo asset_url(); ?>grocery_crud/themes/datatables/js/jquery.dataTables.js"></script>
<?php
  if(isset($data_en_revision))
  {
      if($data_en_revision['success'])
      {
          if(count($data_en_revision['result']) > 0)
          {
?>
            <!--h4> <?php //echo $opciones_secciones['nota_fecha_limite'];?> </h4-->
            <br>
            <table class="table" id="table_en_revision">
              <thead>
                <tr>
                  <th scope="col"><?php echo $opciones_secciones['col_matricula'];?></th>
                  <th scope="col"><?php echo $opciones_secciones['col_nombre'];?></th>
                  <th scope="col"><?php echo $opciones_secciones['col_apellido_paterno'];?></th>
                  <th scope="col"><?php echo $opciones_secciones['col_apellido_materno'];?></th>
                  <th scope="col"><?php echo $opciones_secciones['col_delegacion'];?></th>
                  <th scope="col"><?php echo $opciones_secciones['col_fecha_registro'];?></th>
                  <th scope="col"><?php echo $opciones_secciones['col_no_revisiones'];?></th>
                  <th scope="col"><?php echo $opciones_secciones['col_revisor'];?></th>
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
                    <td scope="row"><?php echo $row['matricula'];?></td>
                    <td><?php echo $row['nombre'];?></td>
                    <td><?php  echo $row['apellido_paterno'];?></td>
                    <td><?php  echo $row['apellido_materno'];?></td>
                    <td><?php  echo $row['delegacion'];?></td>
                    <td><?php  echo $row['fecha'];?></td>
                    <td><?php  echo $row['total'];?></td>
                    <td><?php echo $row['revisor']; ?></td>
                    <td>
                      <a href="<?php echo site_url().'/revision/index/'.$row['id_solicitud']; ?>" type="button"><?php echo $opciones_secciones['btn_ver'];?> <span class="glyphicon glyphicon-new-window"/></a>
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

  <script>
  $(document).ready(function () {
    <?php if($super===true){ ?>
      $('#table_en_revision').DataTable();
    <?php } ?>
  });
  $("#comite").removeClass()
  $("#atencion").removeClass()
  $("#revision").addClass("active")
  $("#revisados").removeClass()
  $("#aceptados").removeClass()
  $("#rechazados").removeClass()
  </script>
