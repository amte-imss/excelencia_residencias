<?php
  if(isset($data_revisados))
  {
      if($data_revisados['success'])
      {
          if(count($data_revisados['result']) > 0 && count($data_dictamen))
          {
?>
            <table class="table">
           
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
                </tr>
              </thead>
              <tbody>
<?php
              $lenguaje = obtener_lenguaje_actual();
              $h=1;
              foreach ($data_revisados['result'] as $row)
              {
                  if(isset($data_dictamen[$row['id_solicitud']])){
                  $check_gano_premio='No';
                  $value_nivel='';
                  $dictaminado_style='style="background: #F3E9D1"';
                  if(isset($data_dictamen[$row['id_solicitud']])){
                    if($data_dictamen[$row['id_solicitud']]['premio_anterior']){
                        $check_gano_premio = 'Si';
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
                    <td><?php  echo $row['total_puntos_anios_cursos'];?></td>
                    <td><?php  echo ($row['puntaje_pnpc']+$row['puntaje_sa_et']+$row['puntaje_sa_satisfaccion']+$row['puntaje_carrera_docente']+$row['total_puntos_anios_cursos']);?></td>
                    <td><?php echo $check_gano_premio; ?></td>
                    <td> 
                        <?php echo $niveles[$value_nivel]; ?>
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