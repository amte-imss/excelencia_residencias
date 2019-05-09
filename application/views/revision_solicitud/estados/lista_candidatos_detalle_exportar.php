<?php
if (isset($data_revisados)) {
    if ($data_revisados['success']) {
        if (count($data_revisados['result']) > 0) { ?>
            <table>
                <thead>
                    <tr >
                        <th><?php echo $opciones_secciones['lbl_nivel_1']; ?></th>
                        <th><?php echo $opciones_secciones['lbl_nivel_2']; ?></th>
                        <th><?php echo $opciones_secciones['lbl_nivel_3']; ?></th>
                        <th><?php echo $opciones_secciones['total_revisados']; ?></th>
                        <th><?php echo $opciones_secciones['total_rechazados']; ?></th>
                        <th><?php echo $opciones_secciones['total_sin_asignar']; ?></th>
                    </tr>
                </thead>
                <tbody>
                    <tr>
                        <td><?php echo "'".$total_registrados_nivel['nivel_1'] . '/' . $configuracion['nivel_1']; ?></td>
                        <td><?php echo "'".$total_registrados_nivel['nivel_2'] . '/' . $configuracion['nivel_2']; ?></td>
                        <td><?php echo "'".$total_registrados_nivel['nivel_3'] . '/' . $configuracion['nivel_3']; ?></td>
                        <td><?php echo $totales['total']; ?></td>
                        <td><?php echo $totales['rechazados']; ?></td>
                        <td><?php echo $totales['sin_asignar']; ?></td>
                    </tr>
                </tbody>
            </table>

            <table class="table">
                <thead>
                    <tr >
                        <th scope="col"><?php echo $opciones_secciones['col_matricula']; ?></th>
                        <th scope="col"><?php echo $opciones_secciones['col_nombre']; ?></th>
                        <th scope="col"><?php echo $opciones_secciones['col_apellido_paterno']; ?></th>
                        <th scope="col"><?php echo $opciones_secciones['col_apellido_materno']; ?></th>
                        <th scope="col"><?php echo $opciones_secciones['col_delegacion']; ?></th>
                        <th scope="col"><?php echo $opciones_secciones['col_fecha_registro']; ?></th>
                        <th scope="col"><?php echo $opciones_secciones['col_tipo_contratacion']; ?></th>
                        <th scope="col"><?php echo $opciones_secciones['col_revisor']; ?></th>
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
                    </tr>
                </thead>
                <tbody>
                    <?php
                    $lenguaje = obtener_lenguaje_actual();
                    $h = 1;
                    foreach ($data_revisados['result'] as $row) {
                        //$row['id_solicitud'];
                        $check_gano_premio = 'No';
                        $value_nivel = '';
                        $dictaminado_style = 'style="background: #c8c8c8"';
                        if (isset($data_dictamen[$row['id_solicitud']])) {
                            if ($data_dictamen[$row['id_solicitud']]['premio_anterior']) {
                                $check_gano_premio = 'Si';
                                $dictaminado_style = 'style="background: #ffc6c6"';
                            } else {
                                $dictaminado_style = 'style="background: #cce9cc"';
                            }
                            $value_nivel = $data_dictamen[$row['id_solicitud']]['id_nivel'];
                        }
                        ?>
                    <input type="hidden" name="solicitud[]" value="<?php echo $row['id_solicitud']; ?>">
                    <tr <?php echo $dictaminado_style; ?>>
                        <td><?php echo $row['matricula']; ?></td>
                        <td><?php echo $row['nombre']; ?></td>
                        <td><?php echo $row['apellido_paterno']; ?></td>
                        <td><?php echo $row['apellido_materno']; ?></td>
                        <td><?php echo $row['delegacion']; ?></td>
                        <td><?php echo $row['fecha']; ?></td>
                        <td><?php echo ($row['tipo_contratacion'] == 1) ? $opciones_secciones['lbl_es_base'] : ''; ?></td>
                        <td><?php echo $row['revisor']; ?></td>
                        <td><?php echo $row['puntaje_pnpc']; ?></td>
                        <td><?php echo ($row['puntaje_sa_et'] + $row['puntaje_sa_satisfaccion']); ?></td>
                        <td><?php echo $row['puntaje_carrera_docente']; ?></td>
                        <td><?php echo $row['puntaje_anios_docente']; ?></td>
                        <!--<td><?php // echo ($row['puntaje_pnpc'] + $row['puntaje_sa_et'] + $row['puntaje_sa_satisfaccion'] + $row['puntaje_carrera_docente'] + $row['total_puntos_anios_cursos']);    ?></td>-->
                        <td><?php echo $row['total_suma_puntos']; ?></td>
                        
                        <td align="center"><?php echo $check_gano_premio; ?></td>
                        <td align="center"> 
                            <?php
                            /* echo $this->form_complete->create_element(
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
                            );*/
                            echo (isset($niveles[$value_nivel])) ? $niveles[$value_nivel] : '';
                            ?>
                        </td>
                        <td><?php $str_c = $str_d = '';
                        foreach ($opcion_curso as $key_c => $curso) {
                            $str_c .= (array_key_exists($key_c, $row['estatus_curso'])) ? $curso.', ' : ''; 
                        } 
                        echo trim($str_c, ', ');
                        ?></td>
                        <td><?php foreach ($opcion_documento as $key_d => $documento) {
                            $str_d .= (array_key_exists($key_d, $row['estatus_documentos'])) ? $documento.', ' : ''; 
                        }
                        echo trim($str_d, ', '); 
                        ?></td>
                        <td><?php echo $row['observacion']; ?></td>
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
</script>
<?php echo js('trabajo_investigacion/control_dictamen.js'); ?>