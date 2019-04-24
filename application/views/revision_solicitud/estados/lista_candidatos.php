<?php
  if(isset($data_revisados))
  {
      if($data_revisados['success'])
      {
          if(count($data_revisados['result']) > 0)
          {
?>
            <!--h4> <?php //echo $opciones_secciones['nota_fecha_limite'];?> </h4-->
            <div class="col-md-4"><h3 class="text-center"><?php echo $opciones_secciones['lbl_nivel_1'];?></h3><h4 class="text-center"><?php echo $configuracion['nivel_1']; ?></h4></div>
            <div class="col-md-4"><h3 class="text-center"><?php echo $opciones_secciones['lbl_nivel_2'];?></h3><h4 class="text-center"><?php echo $configuracion['nivel_2']; ?></h4></div>
            <div class="col-md-4"><h3 class="text-center"><?php echo $opciones_secciones['lbl_nivel_3'];?></h3><h4 class="text-center"><?php echo $configuracion['nivel_3']; ?></h4></div>
            <br><br>
            <table class="table">
              <thead>
                <tr>
                    <th scope="col"><?php echo $opciones_secciones['col_nivel'];?></th>
                  <th scope="col"><?php echo $opciones_secciones['col_matricula'];?></th>
                  <th scope="col"><?php echo $opciones_secciones['col_nombre'];?></th>
                  <th scope="col"><?php echo $opciones_secciones['col_apellido_paterno'];?></th>
                  <th scope="col"><?php echo $opciones_secciones['col_apellido_materno'];?></th>
                  <th scope="col"><?php echo $opciones_secciones['col_delegacion'];?></th>
                  <th scope="col"><?php echo $opciones_secciones['col_fecha_registro'];?></th>
                  <!--th scope="col"><?php echo $opciones_secciones['col_no_revisiones'];?></th>
                  <th scope="col"><?php echo $opciones_secciones['col_revisor'];?></th-->
                  <th scope="col"><?php echo $opciones_secciones['col_pun_pnpv'];?></th>
                  <th scope="col"><?php echo $opciones_secciones['col_pun_sede'];?></th>
                  <th scope="col"><?php echo $opciones_secciones['col_pun_carrera'];?></th>
                  <th scope="col"><?php echo $opciones_secciones['col_pun_permanencia'];?></th>
                  <th scope="col"><?php echo $opciones_secciones['col_pun_excelencia'];?></th>
                  <th scope="col"><?php echo $opciones_secciones['col_opciones'];?></th>
                </tr>
              </thead>
              <tbody>
<?php
              $lenguaje = obtener_lenguaje_actual();
              $h=1;
              foreach ($data_revisados['result'] as $row)
              {
                  $nivel = 'Sin nivel';
                  if($h<=$configuracion['nivel_1']){
                        $nivel = 'Nivel 1';
                  } elseif($h<=($configuracion['nivel_1']+$configuracion['nivel_2'])){
                        $nivel = 'Nivel 2';
                    } elseif($h<=($configuracion['nivel_1']+$configuracion['nivel_2']+$configuracion['nivel_3'])){
                        $nivel = 'Nivel 3';
                  }
?>
                  <tr>
                      <td scope="row"><?php echo $nivel; ?></td>
                    <td><?php echo $row['matricula'];?></td>
                    <td><?php echo $row['nombre'];?></td>
                    <td><?php  echo $row['apellido_paterno'];?></td>
                    <td><?php  echo $row['apellido_materno'];?></td>
                    <td><?php  echo $row['delegacion'];?></td>
                    <td><?php  echo $row['fecha'];?></td>
                    <td><?php  echo $row['puntaje_pnpc'];?></td>
                    <td><?php  echo ($row['puntaje_sa_et']+$row['puntaje_sa_satisfaccion']);?></td>
                    <td><?php  echo $row['puntaje_carrera_docente'];?></td>
                    <td><?php  echo $row['total_puntos_anios_cursos'];?></td>
                    <td><?php  echo ($row['puntaje_pnpc']+$row['puntaje_sa_et']+$row['puntaje_sa_satisfaccion']+$row['puntaje_carrera_docente']+$row['total_puntos_anios_cursos']);?></td>
                    <!--td><?php  echo $row['total'];?></td>
                    <td><?php echo $row['revisor']; ?></td-->
                    <td>
                      <a href="<?php echo site_url().'/revision/index/'.$row['id_solicitud']; ?>" type="button"><?php echo $opciones_secciones['btn_ver'];?> <span class="glyphicon glyphicon-new-window"/></a>
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

  <script>
  $("#comite").removeClass()
  $("#atencion").removeClass()
  $("#revision").removeClass()
  $("#revisados").removeClass()
  $("#aceptados").removeClass()
  $("#candidatos").addClass("active")
  $("#rechazados").removeClass()
  </script>
