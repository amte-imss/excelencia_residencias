<link rel="stylesheet" type="text/css" href="<?php echo asset_url(); ?>grocery_crud/themes/datatables/css/jquery.dataTables_1.10.19.css">
 
<!--<script type="text/javascript" charset="utf8" src="<?php echo asset_url(); ?>grocery_crud/themes/datatables/js/jquery.dataTables.js"></script>-->
<?php
  if(isset($data_revisados))
  {
      if($data_revisados['success'])
      {
          if(count($data_revisados['result']) > 0 && count($data_dictamen))
          {
?>
            <br><br>
            <div class="col-sm-12" >
                <label><?php echo $opciones_secciones['lbl_notas_aceptados']; ?></label><br>
            </div>
            <div class="col-sm-12 text-right">
                    
                    <a href="<?php echo site_url('/gestion_revision/listado_control/'.strtolower(En_estado_solicitud::ACEPTADOS)."_e"); ?>" class=" btn btn-theme animated flipInY visible"><?php echo $opciones_secciones['btn_exportar_aceptados']; ?></a> 
                    <br><br><br>
                </div><div style="clear:both;"></div>

            <table class="table" id="table_aceptados">
           
              <thead>
                  <tr >
                    <!--<th scope="col"><?php // echo $opciones_secciones['col_nivel'];?></th>-->
                  <th scope="col"><?php echo $opciones_secciones['col_matricula'];?></th>
                  <th scope="col"><?php echo $opciones_secciones['col_nombre'];?></th>
                  <th scope="col"><?php echo $opciones_secciones['col_apellido_paterno'];?></th>
                  <th scope="col"><?php echo $opciones_secciones['col_apellido_materno'];?></th>
                  <th scope="col"><?php echo $opciones_secciones['col_delegacion'];?></th>
                  <th scope="col"><?php echo $opciones_secciones['col_correo'];?></th>
                  <th scope="col"><?php echo $opciones_secciones['col_fecha_registro'];?></th>
                  <th scope="col"><?php echo $opciones_secciones['col_tipo_contratacion']; ?></th>
                  <!--th scope="col"><?php echo $opciones_secciones['col_no_revisiones'];?></th>
                  <th scope="col"><?php echo $opciones_secciones['col_revisor'];?></th-->
                  <th scope="col"><?php echo $opciones_secciones['col_pun_pnpv'];?></th>
                  <th scope="col"><?php echo $opciones_secciones['col_pun_sede'];?></th>
                  <th scope="col"><?php echo $opciones_secciones['col_pun_carrera'];?></th>
                  <th scope="col"><?php echo $opciones_secciones['col_pun_permanencia'];?></th>
                  <th scope="col"><?php echo $opciones_secciones['col_pun_excelencia'];?></th>
                  <th scope="col"><?php echo $opciones_secciones['col_gano_premio'];?></th>
                  <th scope="col"><?php echo $opciones_secciones['col_nivel'];?></th>
                  <th scope="col"><?php echo $opciones_secciones['col_opciones'];?></th>
                </tr>
              </thead>
              <tbody>
<?php
              $lenguaje = obtener_lenguaje_actual();
              $h=1;
              foreach ($data_revisados['result'] as $row)
              {
                  if(isset($data_dictamen[$row['id_solicitud']])){
                      
                  $row['id_solicitud'];
                  $nivel = 'Sin nivel';
                  if($h<=$configuracion['nivel_1']){
                        $nivel = 'Nivel 1';
                  } elseif($h<=($configuracion['nivel_1']+$configuracion['nivel_2'])){
                        $nivel = 'Nivel 2';
                    } elseif($h<=($configuracion['nivel_1']+$configuracion['nivel_2']+$configuracion['nivel_3'])){
                        $nivel = 'Nivel 3';
                  }
                  $check_gano_premio='';
                  $value_nivel='';
                  $dictaminado_style='style="background: #F3E9D1"';
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
                    <td><?php  echo $row['email'];?></td>
                    <td><?php  echo $row['fecha'];?></td>
                    <td><?php echo ($row['tipo_contratacion']==1) ? $opciones_secciones['lbl_es_base'] : ''; ?></td>  
                    <td><?php  echo $row['puntaje_pnpc'];?></td>
                    <td><?php  echo ($row['puntaje_sa_et']+$row['puntaje_sa_satisfaccion']);?></td>
                    <td><?php  echo $row['puntaje_carrera_docente'];?></td>
                    <td><?php  echo $row['puntaje_anios_docente'];?></td>
                    <td><?php  echo ($row['total_suma_puntos']);?></td>
                    <!--td><?php  echo $row['total'];?></td>
                    <td><?php echo $row['revisor']; ?></td-->
                    <td align="center"><input disabled="disabled" type="checkbox" <?php echo $check_gano_premio; ?> class="form-check-input"  name="con_premio[<?php echo $row['id_solicitud'];?>]"></td>
                    <td align="center"> 
                        <?php echo $this->form_complete->create_element(
                            array(
//                                'id' => 'nivel'.$row['id_solicitud'], 
                                'id' => 'nivel['.$row['id_solicitud'].']',
                                'type' => 'dropdown',
//                                'name'=>'nivel[]'.$row['id_solicitud'].']',
                                'name'=>'nivel[]',
                                'options' => $niveles,
                                'first' => array('' => 'Selecciona nivel'),
                                'value' => $value_nivel,
                    //                'value' => (isset($value['valor'])) ? $value['valor'] : '',
                                'attributes' => [
                                    "class"=>"form-control",
                                    "disabled"=>'disabled'
                                ],
                            )
                        );?>
                    </td>
                    <td>

                      <a href="<?php echo site_url().'/revision/index/'.$row['id_solicitud']; ?>/detalle" type="button"><?php echo $opciones_secciones['btn_ver'];?> <span class="glyphicon glyphicon-new-window"/></a>
                    </td>
                  </tr>
<?php
                $h++;
                  }
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
      $('#table_aceptados').DataTable({
                "language": {
    //                    "url": "//cdn.datatables.net/plug-ins/1.10.15/i18n/Spanish.json"
                    "url": ruta_language_datatable
                },
                "ordering": false
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