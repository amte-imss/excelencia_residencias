<?php // pr($cursos_participantes);
?>
<!--Sección del curso-->
<div class="panel-heading"><h2>Cursos en los que ha participado como docente</h2></div>
<div class="panel-body">
    <br>
    <?php echo form_open('revision/guardar_validacion_cursos', array('id' => 'form_guardar_validacion_cursos', 'class' => 'form-horizontal')); ?>
    <?php if (isset($revision)) { ?> 
        <input type="hidden" id="revision_cur" name="revision_cur" value="<?php echo $revision['id_revision']; ?>">
    <?php } ?> 
    <input type="hidden" id="id_solicitud" name="id_solicitud" value="<?php echo $solicitud['id_solicitud']; ?>">
    <table class="table">
        <thead>
            <tr>
                <th><?php echo $language_text['registro_excelencia']['reg_exc_curso_nombre']; ?></th>
                <th><?php echo $language_text['registro_excelencia']['reg_exc_curso_categoria']; ?></th>
                <th><?php echo $language_text['registro_excelencia']['reg_exc_curso_anios']; ?></th>
                <th><?php echo $language_text['registro_excelencia']['reg_exc_curso_archivo']; ?></th>
                <th><?php echo $language_text['registro_excelencia']['reg_exc_curso_pnpc']; ?></th>
                <th>Opciones</th>
            </tr>
        </thead>
        <tbody>
            <?php ?>
            <?php foreach ($cursos_participantes as $curso) { ?>
            <input type="hidden" id="documento_cursos_rev" name="documento_cursos_rev[]" value="<?php echo $curso['id_documento_curso']; ?>">
            <tr>
                <td><?php echo $curso['especialidades']; ?></td>
                <td><?php echo $categoria_docente[$curso['id_tipo_docente']]; ?></td>
                <td><?php echo $curso['anios']; ?></td>
                <td><a href="<?php echo base_url() . trim($curso['ruta'], '.'); ?>" target="_blank"><?php echo $language_text['registro_excelencia']['reg_liga_descarga']; ?></a></td>
                <td><?php echo ($curso['obtuvo_pnpc']) ? 'Si' : 'No'; ?></td>
                <td><?php
                    $aux = null;
                    if (isset($evaluacion[$curso['id_documento_curso']])) {//Valida que exista el documento
                        $aux = $evaluacion[$curso['id_documento_curso']];
                    }
                    foreach ($opciones_curso as $opciones) {
                        $check = '';
                        if (!is_null($aux) && $aux['id_opcion'] == $opciones['id_opcion']) {
                            $check = 'checked';
                        }
                        ?>
                        <input type="radio" name="opcion_curso_<?php echo $curso['id_documento_curso']; ?>" value="<?php echo $opciones['id_opcion']; ?>" <?php echo $check; ?> ><?php echo $opciones['opcion']; ?><br>
                        <?php
                    }
                    ?>
                </td>
            </tr>
        <?php } ?>
        </tbody>
    </table>
    <?php echo form_close(); ?>
    <br>
    <div id="cursos_msg" class="form-group"></div>
    <br>
    <?php if (isset($estado_solicitud['config']['btn_validar_cursos']) && $estado_solicitud['config']['btn_validar_cursos'] == 'true') { ?>
        <div class="text-center"> 
            <button class="btn btn-theme animated flipInY visible" id="btn_guardar_validaion_cursos" 
                    name="btn_guardar_validaion_cursos" type="button" 
                    data-formulario = "form_guardar_validacion_cursos"
                    data-divmsg = "cursos_msg"
                    onclick="javascript:guardar_validacion_cursos(this);">
                Guardar validación
            </button>
        </div>
    <?php } ?>
    <br>
</div>
