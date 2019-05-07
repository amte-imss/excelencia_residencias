<?php // pr($documento);     ?> 

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
            <input type="hidden" id="cursos_rev" name="documento_rev[]" value="<?php echo (isset($documento[$value['id_tipo_documento']]['id_documento'])) ? $documento[$value['id_tipo_documento']]['id_documento'] : ''; ?>">
            <tr>
                <td><?php echo $value['nombre'] ?></td>
                <td><?php echo (isset($documento[$value['id_tipo_documento']]['ruta'])) ? str_replace('||X||', base_url() . $documento[$value['id_tipo_documento']]['ruta'], $language_text['registro_excelencia']['reg_liga_msg_descarga']) : '-'; ?></td>
                <?php if ($mostrar_opciones_revision) { ?>
                    <td><?php
                        $aux = null;
                        if (isset($evaluacion[$documento[$value['id_tipo_documento']]['id_documento']])) {//Valida que exista el documento
                            $aux = $evaluacion[$documento[$value['id_tipo_documento']]['id_documento']];
                        }
//                    pr($aux);
                        foreach ($opciones_curso as $opciones) {
                            $check = '';
                            if (!is_null($aux) && $aux['id_opcion'] == $opciones['id_opcion']) {
                                $check = 'checked';
                            }
//                        pr($aux);
//                        pr($opciones);
//                        pr($check);
                            ?>
                        <input type="radio" disabled name="opcion_documento_<?php echo $documento[$value['id_tipo_documento']]['id_documento']; ?>" value="<?php echo $opciones['id_opcion']; ?>" <?php echo $check; ?> ><?php echo $opciones['opcion']; ?><br>
                            <?php
                        }
                        ?>
                    </td>
                <?php  } ?>
                </tr>
            <?php } ?>
            </tbody>
        </table>

        <?php echo form_close(); ?>
</div>
