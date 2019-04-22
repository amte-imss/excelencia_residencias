<!--Sección 3-->
<div class="panel-heading"><h2>Documentación</h2></div>
<div class="panel-body">
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
            <?php foreach ($tipo_documentos as $key => $value) {
                ?>
                <tr>
                    <td><?php echo $value['nombre'] ?></td>
                    <td><?php echo str_replace('||X||', base_url() . $documento[$value['id_tipo_documento']]['ruta'], $language_text['registro_excelencia']['reg_liga_msg_descarga']); ?></td>
                    <td><?php
                        foreach ($opciones_curso as $opciones) {
                            ?>
                            <input type="radio" name="opcion_documento_<?php echo $value['id_tipo_documento']; ?>" value="<?php echo $opciones['id_opcion']; ?>" ><?php echo $opciones['opcion']; ?><br>
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
    <div id="documentos_msg" class="form-group"></div>
    <br>
    <div class="text-center"> 
        <button class="btn btn-theme animated flipInY visible" id="btn_guardar_validaion_documentos" 
                name="btn_guardar_validaion_documentos" type="button" 
                data-formulario = "form_guardar_validacion_documentos"
                data-divmsg = "documentos_msg"
                onclick="javascript:guardar_validacion_doc(this);">
            Guardar validación
        </button>
    </div>
    <br>
</div>
