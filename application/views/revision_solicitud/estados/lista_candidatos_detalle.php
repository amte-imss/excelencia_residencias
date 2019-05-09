<style>
.tab-content.lv2 .tab-pane {
  padding: 20px 20px;
}
.timeline {
  overflow: scroll;
  height: 800px;
}
</style>
<?php
if (isset($data_revisados)) {
    if ($data_revisados['success']) {
        if (count($data_revisados['result']) > 0) {
            if ($super === true) {
                ?>
                <div class="col-sm-12">
                    <button 
                        id="btn_cerrar_proceso" 
                        name="btn_cerrar_proceso" 
                        type="button"
                        data-divmsg="msg_cerrar_proceso"
                        class="col-sm-12 btn btn-theme animated flipInY visible" 
                        style="" 
                        type="button"><?php echo $opciones_secciones['btn_cerrar_proceso']; ?>
                    </button> 
                    <br><br><br>
                </div>
                <div class="col-sm-12" id="msg_cerrar_proceso"></div><br>
            <?php } ?>

                                                            <!--h4> <?php //echo $opciones_secciones['nota_fecha_limite'];    ?> </h4-->
            <div class="col-md-2"><h4 class="text-center"><?php echo $opciones_secciones['lbl_nivel_1']; ?></h4><h4 class="text-center"><?php echo $total_registrados_nivel['nivel_1'] . '/' . $configuracion['nivel_1']; ?></h4></div>
            <div class="col-md-2"><h4 class="text-center"><?php echo $opciones_secciones['lbl_nivel_2']; ?></h4><h4 class="text-center"><?php echo $total_registrados_nivel['nivel_2'] . '/' . $configuracion['nivel_2']; ?></h4></div>
            <div class="col-md-2"><h4 class="text-center"><?php echo $opciones_secciones['lbl_nivel_3']; ?></h4><h4 class="text-center"><?php echo $total_registrados_nivel['nivel_3'] . '/' . $configuracion['nivel_3']; ?></h4></div>
            <div class="col-md-2"><h4 class="text-center"><?php echo $opciones_secciones['total_revisados']; ?></h4><h4 class="text-center"><?php echo $totales['total']; ?></h4></div>
            <div class="col-md-2"><h4 class="text-center"><?php echo $opciones_secciones['total_rechazados']; ?></h4><h4 class="text-center"><?php echo $totales['rechazados']; ?></h4></div>
            <div class="col-md-2"><h4 class="text-center"><?php echo $opciones_secciones['total_sin_asignar']; ?></h4><h4 class="text-center"><?php echo $totales['sin_asignar']; ?></h4></div>
            <div class="col-md-2 text-center"></div>
            <div class="col-md-4 text-center">
                <button class="btn btn-theme animated flipInY visible" 
                        id="btn_guardar_informacion_dictamen" 
                        data-formulario="form_informacion_dictamen"
                        data-divmsg="msg_guarda_dictamen"
                        name="btn_guardar_informacion_dictamen" type="button">
                            <?php echo $opciones_secciones['btn_guardar_seleccion']; ?>
                </button>
            </div>
            <div class="col-md-2 text-center"></div>
            <div class="col-md-4 text-center">
                <a href="<?php echo site_url('/gestion_revision/listado_control/'.strtolower(En_estado_solicitud::CANDIDATOS)."_e"); ?>" class=" btn btn-theme animated flipInY visible"><?php echo $opciones_secciones['btn_exportar_aceptados']; ?></a>
            </div>
            <br>
            <div class="col-sm-12" id="msg_guarda_dictamen"></div>

            <br><br>
            <div class="col-sm-12" >
                <label><?php echo $opciones_secciones['lbl_notas']; ?></label>
            </div>

            <?php // pr($opciones_secciones['lbl_notas']); ?>
            <?php echo form_open('gestion_revision/guarda_informacion_dictamen', array('id' => 'form_informacion_dictamen', 'class' => 'form-horizontal')); ?>

            <table class="table">

                <thead>
                    <tr >
                        <!--th scope="col"><?php echo $opciones_secciones['col_nivel']; ?></th-->
                        <th scope="col"><?php echo $opciones_secciones['col_matricula']; ?></th>
                        <th scope="col"><?php echo $opciones_secciones['col_nombre']; ?></th>
                        <!--th scope="col"><?php echo $opciones_secciones['col_apellido_paterno']; ?></th>
                        <th scope="col"><?php echo $opciones_secciones['col_apellido_materno']; ?></th-->
                        <th scope="col"><?php echo $opciones_secciones['col_delegacion']; ?></th>
                        <th scope="col"><?php echo $opciones_secciones['col_fecha_registro']; ?></th>
                        <th scope="col"><?php echo $opciones_secciones['col_tipo_contratacion']; ?></th>
                        <!--th scope="col"><?php echo $opciones_secciones['col_no_revisiones']; ?></th>
                        <th scope="col"><?php echo $opciones_secciones['col_revisor']; ?></th-->
                        <th scope="col"><?php echo $opciones_secciones['col_pun_pnpv']; ?></th>
                        <th scope="col"><?php echo $opciones_secciones['col_pun_sede']; ?></th>
                        <th scope="col"><?php echo $opciones_secciones['col_pun_carrera']; ?></th>
                        <th scope="col"><?php echo $opciones_secciones['col_pun_permanencia']; ?></th>
                        <th scope="col"><?php echo $opciones_secciones['col_pun_excelencia']; ?></th>
                        <th scope="col"><?php echo $opciones_secciones['col_gano_premio']; ?></th>
                        <th scope="col"><?php echo $opciones_secciones['col_nivel']; ?></th>
                        <th scope="col"><?php echo $opciones_secciones['col_estatus_curso'];?></th>
                        <th scope="col"><?php echo $opciones_secciones['col_estatus_documentacion'];?></th>
                        <th scope="col"><?php echo $opciones_secciones['btn_observacion'];?></th>
                        <th scope="col"><?php echo $opciones_secciones['col_opciones']; ?></th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                    $lenguaje = obtener_lenguaje_actual();
                    $h = 1;
                    foreach ($data_revisados['result'] as $row) {
                        $row['id_solicitud'];
                        /* $nivel = 'Sin nivel';
                          if ($h <= $configuracion['nivel_1']) {
                          $nivel = 'Nivel 1';
                          } elseif ($h <= ($configuracion['nivel_1'] + $configuracion['nivel_2'])) {
                          $nivel = 'Nivel 2';
                          } elseif ($h <= ($configuracion['nivel_1'] + $configuracion['nivel_2'] + $configuracion['nivel_3'])) {
                          $nivel = 'Nivel 3';
                          } */
                        $check_gano_premio = '';
                        $value_nivel = '';
                        $dictaminado_style = 'style="background: #c8c8c8"';
                        if (isset($data_dictamen[$row['id_solicitud']])) {
                            if ($data_dictamen[$row['id_solicitud']]['premio_anterior']) {
                                $check_gano_premio = 'checked="checked"';
                                $dictaminado_style = 'style="background: #ffc6c6"';
                            } else {
                                $dictaminado_style = 'style="background: #cce9cc"';
                            }
                            $value_nivel = $data_dictamen[$row['id_solicitud']]['id_nivel'];
                        }
                        ?>
                    <input type="hidden" name="solicitud[]" value="<?php echo $row['id_solicitud']; ?>">
                    <tr <?php echo $dictaminado_style; ?>>
                        <!--td scope="row"><?php echo $nivel; ?></td-->
                        <td><?php echo $row['matricula']; ?></td>
                        <!--td><?php echo $row['nombre']; ?></td>
                        <td><?php echo $row['apellido_paterno']; ?></td>
                        <td><?php echo $row['apellido_materno']; ?></td-->
                        <td><?php  echo $row['nombre']." ".$row['apellido_paterno']." ".$row['apellido_materno'];?></td>
                        <td><?php echo $row['delegacion']; ?></td>
                        <td><?php echo $row['fecha']; ?></td>
                        <td><?php echo ($row['tipo_contratacion'] == 1) ? $opciones_secciones['lbl_es_base'] : ''; ?></td>
                        <td><?php echo $row['puntaje_pnpc']; ?></td>
                        <td><?php echo ($row['puntaje_sa_et'] + $row['puntaje_sa_satisfaccion']); ?></td>
                        <td><?php echo $row['puntaje_carrera_docente']; ?></td>
                        <td><?php echo $row['puntaje_anios_docente']; ?></td>
                        <!--<td><?php // echo ($row['puntaje_pnpc'] + $row['puntaje_sa_et'] + $row['puntaje_sa_satisfaccion'] + $row['puntaje_carrera_docente'] + $row['total_puntos_anios_cursos']);    ?></td>-->
                        <td><?php echo $row['total_suma_puntos']; ?></td>
                        <!--td><?php // echo $row['total'];    ?></td>
                        <td><?php echo $row['revisor']; ?></td-->
                        <td align="center"><input type="checkbox" <?php echo $check_gano_premio; ?> class="form-check-input"  name="con_premio[<?php echo $row['id_solicitud']; ?>]"></td>
                        <td align="center"> 
                            <?php
                            echo $this->form_complete->create_element(
                                    array(
//                                'id' => 'nivel'.$row['id_solicitud'], 
                                        'id' => 'nivel[' . $row['id_solicitud'] . ']',
                                        'type' => 'dropdown',
//                                'name'=>'nivel[]'.$row['id_solicitud'].']',
                                        'name' => 'nivel[]',
                                        'options' => $niveles,
                                        'first' => array('' => 'Selecciona nivel'),
                                        'value' => $value_nivel,
                                        //                'value' => (isset($value['valor'])) ? $value['valor'] : '',
                                        'attributes' => [
                                            "class" => "form-control"
                                        ],
                                    )
                            );
                            ?>
                        </td>
                        <td><?php foreach ($opcion_curso as $key_c => $curso) {
                            echo '<label><input type="checkbox" disabled="disabled" '.((array_key_exists($key_c, $row['estatus_curso'])) ? 'checked="checked"' : '').' >'.$curso.'</label><br>'; 
                        } ?></td>
                        <td><?php foreach ($opcion_documento as $key_d => $documento) {
                            echo '<label><input type="checkbox" disabled="disabled" '.((array_key_exists($key_d, $row['estatus_documentos'])) ? 'checked="checked"' : '').' >'.$documento.'</label><br>'; 
                        } ?></td>
                        <td><?php echo $row['observacion']; ?></td>
                        <td>
                            <a href="<?php echo site_url() . '/revision/index/' . $row['id_solicitud']; ?>/detalle" type="button"><?php echo $opciones_secciones['btn_ver']; ?> <span class="glyphicon glyphicon-new-window"/></a>
                        </td>
                    </tr>
                    <?php
                    $h++;
                }
                echo form_close();
            } else {
                ?>
                <h3><?php echo $opciones_secciones['er_mensaje']; ?></h3>
                <?php
            }
        } else {
            ?>
            <h3><?php echo $mensajes['ern_mensaje']; ?></h3>
            <?php
        }
        ?>

    </tbody>
    </table>

    <?php
} else {
    ?>
    <h3><?php echo $mensajes['er_no_datos']; ?></h3>
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
    $("#rechazados").removeClass();
    var texto_confirmacion_guardado = "<?php echo $opciones_secciones['texto_confirmacion_guardado']; ?>";
    var texto_confirmacion_cierre = "<?php echo $opciones_secciones['texto_confirmacion_cierre']; ?>";
    $(document).ready(function(){
      $('[data-toggle="tooltip"]').tooltip(); 
    });
</script>
<?php echo js('trabajo_investigacion/control_dictamen.js'); ?>