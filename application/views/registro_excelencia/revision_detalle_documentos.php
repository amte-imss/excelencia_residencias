<?php // pr($documento);    ?> 

<!--Sección 3-->
<div class=""><h4>Documentación</h4></div>
<div class="">
    <br>
    <?php echo form_open('revision/guardar_validacion_cursos', array('id' => 'form_guardar_validacion_documentos', 'class' => 'form-horizontal')); ?>
    <?php if (isset($revision)) { ?> 
        <input type="hidden" id="revision_doc" name="revision_doc" value="<?php echo $revision['id_revision']; ?>">
    <?php } ?>
    <input type="hidden" id="id_solicitud" name="id_solicitud" value="<?php echo $solicitud['id_solicitud']; ?>">
    <table class="table ">

        <tbody>
            <?php ?>
            <?php ?>
            <?php foreach ($tipo_documentos as $key => $value) { ?>
            <input type="hidden" id="cursos_rev" name="documento_rev[]" value="<?php echo $documento[$value['id_tipo_documento']]['id_documento']; ?>">
            <tr>
                <td><?php echo $value['nombre'] ?></td>
                <td><?php echo str_replace('||X||', base_url() . $documento[$value['id_tipo_documento']]['ruta'], $language_text['registro_excelencia']['reg_liga_msg_descarga']); ?></td>
            </tr>
        <?php } ?>
        </tbody>
    </table>

    <?php echo form_close(); ?>
</div>
