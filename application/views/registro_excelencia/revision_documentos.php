<!--Sección 3-->
<div class="panel-heading"><h2>Documentación</h2></div>
<div class="panel-body">
    <br>
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
                            <input type="radio" name="opcion_documento_<?php echo $value['id_tipo_documento']; ?>[]" value="<?php echo $opciones['id_opcion']; ?>" ><?php echo $opciones['opcion']; ?><br>
                            <?php
                        }
                        ?>
                    </td>
                </tr>
            <?php } ?>
        </tbody>
    </table>

    <div class="text-center"> 
        <button class="btn btn-theme animated flipInY visible" id="btn_envio_general" name="btn_envio_general" type="button">Guardar opciones</button>
    </div>
    <br>
</div>
