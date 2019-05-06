<link rel="stylesheet" type="text/css" href="<?php echo asset_url(); ?>grocery_crud/themes/datatables/css/jquery.dataTables_1.10.19.css">
 
<?php
  if(isset($data_revisados))
  {
      if($data_revisados['success'])
      {
          if(count($data_revisados['result']) > 0 )
          {//pr($data_revisados);
?>
            <br><br>

            <table class="table" id="tabla_lista_aceptados_dic">
           
              <thead>
                  <tr >
                    <!--<th scope="col"><?php // echo $opciones_secciones['col_nivel'];?></th>-->
                  <th scope="col"><?php echo $opciones_secciones['col_matricula'];?></th>
                  <th scope="col"><?php echo $opciones_secciones['col_nombre'];?></th>
                  <th scope="col"><?php echo $opciones_secciones['col_apellido_paterno'];?></th>
                  <th scope="col"><?php echo $opciones_secciones['col_apellido_materno'];?></th>
                  <th scope="col"><?php echo $opciones_secciones['col_delegacion'];?></th>
                  <th scope="col"><?php echo $opciones_secciones['col_fecha_registro'];?></th>
                  <!--th scope="col"><?php echo $opciones_secciones['col_no_revisiones'];?></th>
                  <th scope="col"><?php echo $opciones_secciones['col_revisor'];?></th-->
                </tr>
              </thead>
              <tbody>
<?php
              $lenguaje = obtener_lenguaje_actual();
              $h=1;
              $num = 0;
              foreach ($data_revisados['result'] as $row)
              {
                  /*$num++;
                  if($num==5){
                    break;
                  }*/
                      
                  $row['id_solicitud'];
                  /**$nivel = 'Sin nivel';
                  if($h<=$configuracion['nivel_1']){
                        $nivel = 'Nivel 1';
                  } elseif($h<=($configuracion['nivel_1']+$configuracion['nivel_2'])){
                        $nivel = 'Nivel 2';
                    } elseif($h<=($configuracion['nivel_1']+$configuracion['nivel_2']+$configuracion['nivel_3'])){
                        $nivel = 'Nivel 3';
                  }*/
                  $check_gano_premio='';
                  $value_nivel='';
                  $dictaminado_style='';
                  if(isset($data_dictamen[$row['id_solicitud']])){
                    if($data_dictamen[$row['id_solicitud']]['premio_anterior']){
                        $check_gano_premio = 'checked="checked"';
                    }
                    $dictaminado_style = '';
                    $value_nivel = $data_dictamen[$row['id_solicitud']]['id_nivel'];
                  }
?>
              <input type="hidden" name="solicitud[]" value="<?php echo $row['id_solicitud'];?>">
              <tr <?php echo $dictaminado_style; ?>>
                      <!--<td scope="row"><?php // echo $nivel; ?></td>-->
                    <td><?php echo $row['matricula'];?></td>
                    <td><?php echo $row['nombre'];?></td>
                    <td><?php  echo $row['apellido_paterno'];?></td>
                    <td><?php  echo $row['apellido_materno'];?></td>
                    <td><?php  echo $row['delegacion'];?></td>
                    <td><?php  echo $row['fecha'];?></td>
                    <!--td><?php  echo $row['total'];?></td>
                    <td><?php echo $row['revisor']; ?></td-->
                    <td>

                      <a href="<?php echo site_url().'/revision/index/'.$row['id_solicitud']; ?>/detalle" type="button"><?php echo $opciones_secciones['btn_ver'];?> <span class="glyphicon glyphicon-new-window"/></a>
                    </td>
                  </tr>
<?php
                $h++;
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
              console.log(ruta_language_datatable);
      $('#tabla_lista_aceptados_dic').DataTable({
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
  $("#revisados").removeClass()
  $("#rechazados").removeClass()
  $("#candidatos").removeClass()
  $("#aceptados").addClass("active")
  </script>
<?php echo js('trabajo_investigacion/control_dictamen.js'); ?>