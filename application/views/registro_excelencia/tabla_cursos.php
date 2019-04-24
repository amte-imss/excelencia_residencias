<table class="table">
    <thead>
        <tr>
            <th><?php echo $language_text['registro_excelencia']['reg_exc_curso_nombre']; ?></th>
            <th><?php echo $language_text['registro_excelencia']['reg_exc_curso_categoria']; ?></th>
            <th><?php echo $language_text['registro_excelencia']['reg_exc_curso_anios']; ?></th>
            <th><?php echo $language_text['registro_excelencia']['reg_exc_curso_archivo']; ?></th>
            <th><?php echo $language_text['registro_excelencia']['reg_exc_curso_pnpc']; ?></th>
            <?php // if (isset($solicitud['estado']) && $solicitud['estado'] != 2) {
                if(isset($estado_solicitud['config']['btn_elimina_curso']) or isset($estado_solicitud['config']['btn_editar_curso']) ){ ?>
                  <th><?php echo $language_text['registro_excelencia']['reg_exc_acciones']; ?></th>
            <?php } ?> 
        </tr>
    <thead>
    <tbody>
        <?php foreach ($cursos as $key => $curso) { ?>
            <tr>
                <td><?php echo $curso['especialidades']; ?></td>
                <td><?php echo $categoria_docente[$curso['id_tipo_docente']]; ?></td>
                <td><?php echo $curso['anios']; ?></td>
                <td><a href="<?php echo base_url() . trim($curso['ruta'], '.'); ?>" target="_blank"><?php echo $language_text['registro_excelencia']['reg_liga_descarga']; ?></a></td>
                <td><?php echo ($curso['obtuvo_pnpc']) ? 'Si' : 'No'; ?></td>
                            <!--<td><input type="button" value="X" class="btn animated flipInY visible" tooltip="<?php // echo $language_text['registro_excelencia']['reg_exc_curso_eliminar'];         ?>" onclick="eliminar_curso('<?php // echo $curso['id_curso'];         ?>', '#curso_msg');" style="color:red;" /><i class="far fa-edit" color:red></i></td>-->
                <?php if((isset($estado_solicitud['config']['btn_elimina_curso']) && $estado_solicitud['config']['btn_elimina_curso'] == 'true') or (isset($estado_solicitud['config']['btn_editar_curso']) && $estado_solicitud['config']['btn_editar_curso'] == 'true')){ ?>
                <td>
                    <?php // pr($estado_solicitud['config']);?>
                    <?php if(isset($estado_solicitud['config']['btn_elimina_curso']) && $estado_solicitud['config']['btn_elimina_curso']=="true"){ ?>
                        <input type="button" value="X" class="fa fa-edit btn animated flipInY visible" tooltip="<?php echo $language_text['registro_excelencia']['reg_exc_curso_eliminar']; ?>" onclick="eliminar_curso('<?php echo $curso['id_curso']; ?>', '#curso_msg');" style="color:red;" />
                    <?php } if (isset($estado_solicitud['config']['btn_editar_curso']) && $estado_solicitud['config']['btn_editar_curso'] == "true") { ?>
                        <button type="button" class="btn animated flipInY visible"  onclick="editar_curso('<?php echo $curso['id_curso']; ?>');"><i class="fa fa-edit" style="color:red;" ></i></button>
                        <?php } ?>
                </td>
                <?php } ?> 
            </tr>
        <?php } ?>
    </tbody>
</table>