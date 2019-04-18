<!-- <div class="form-group" id="curso_<?php echo $curso['id_curso']; ?>" style="border: 1px solid #aaaaaa;padding: 2px;border-radius: 5px;">'
    <label for="curso" class="col-sm-6 control-label"><?php echo $curso['especialidades']; ?>
        <input type="hidden" name="curso_ls[]" class="curso_class" value="<?php echo $curso['id_curso']; ?>" />
    </label>'
    <label for="curso" class="col-sm-5 control-label"><?php echo $categoria_docente[$curso['id_tipo_docente']]; ?>
        <input type="hidden" name="categoria_docente_ls[]" value="<?php echo $curso['id_tipo_docente']; ?>" />
    </label>'
    <label for="curso" class="col-sm-5 control-label"><?php echo $curso['anios']; ?></label>'
    <label for="curso" class="col-sm-5 control-label"><?php echo $curso['ruta']; ?></label>'
    <label for="curso" class="col-sm-5 control-label"><?php echo ($curso['obtuvo_pnpc']) ? 'Si' : 'No'; ?></label>'
    <div class="col-sm-1"><input type="button" value="X" class="btn animated flipInY visible" onclick="eliminar_curso('<?php echo $curso['id_curso']; ?>');" style="color:red;" />
    </div>'
</div>' -->
<table class="table">
    <thead>
        <tr>
            <th><?php echo $language_text['registro_excelencia']['reg_exc_curso_nombre']; ?></th>
            <th><?php echo $language_text['registro_excelencia']['reg_exc_curso_categoria']; ?></th>
            <th><?php echo $language_text['registro_excelencia']['reg_exc_curso_anios']; ?></th>
            <th><?php echo $language_text['registro_excelencia']['reg_exc_curso_archivo']; ?></th>
            <th><?php echo $language_text['registro_excelencia']['reg_exc_curso_pnpc']; ?></th>
            <th><?php echo $language_text['registro_excelencia']['reg_exc_acciones']; ?></th> 
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
                <td>
                    <?php if (isset($estado['config']['btn_elimina_curso']) && $estado['config']['btn_elimina_curso'] == 'true') { ?>
                        <input type="button" value="X" class="fa fa-edit btn animated flipInY visible" tooltip="<?php echo $language_text['registro_excelencia']['reg_exc_curso_eliminar']; ?>" onclick="eliminar_curso('<?php echo $curso['id_curso']; ?>', '#curso_msg');" style="color:red;" />
                    <?php } ?>
                    <?php if (isset($estado['config']['btn_editar_curso']) && $estado['config']['btn_editar_curso'] == 'true') { ?>
                        <button type="button" class="btn animated flipInY visible"  onclick="editar_curso('<?php echo $curso['id_curso']; ?>');"><i class="fa fa-edit" style="color:red;" ></i></button>
                        <?php } ?>
                </td> 
            </tr>
        <?php } ?>
    </tbody>
</table>