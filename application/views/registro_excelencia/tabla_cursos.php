<!-- <div class="form-group" id="curso_<?php echo $curso['id_curso']; ?>" style="border: 1px solid #aaaaaa;padding: 2px;border-radius: 5px;">'
    <label for="curso" class="col-sm-6 control-label"><?php echo $curso['especialidades']; ?>
        <input type="hidden" name="curso_ls[]" class="curso_class" value="<?php echo $curso['id_curso']; ?>" />
    </label>'
    <label for="curso" class="col-sm-5 control-label"><?php echo $categoria_docente[$curso['id_tipo_docente']]; ?>
        <input type="hidden" name="categoria_docente_ls[]" value="<?php echo $curso['id_tipo_docente']; ?>" />
    </label>'
    <label for="curso" class="col-sm-5 control-label"><?php echo $curso['anios']; ?></label>'
    <label for="curso" class="col-sm-5 control-label"><?php echo $curso['ruta']; ?></label>'
    <label for="curso" class="col-sm-5 control-label"><?php echo ($curso['obtuvo_pnpc'])?'Si':'No'; ?></label>'
    <div class="col-sm-1"><input type="button" value="X" class="btn animated flipInY visible" onclick="eliminar_curso('<?php echo $curso['id_curso']; ?>');" style="color:red;" />
    </div>'
</div>' -->
<table class="table">
    <thead>
        <tr>
            <th><?php echo $language_text['registro_excelencia']['reg_exc_curso_nombre'];?></th>
            <th><?php echo $language_text['registro_excelencia']['reg_exc_curso_categoria'];?></th>
            <th><?php echo $language_text['registro_excelencia']['reg_exc_curso_anios'];?></th>
            <th><?php echo $language_text['registro_excelencia']['reg_exc_curso_archivo'];?></th>
            <th><?php echo $language_text['registro_excelencia']['reg_exc_curso_pnpc'];?></th>
            <?php if(isset($solicitud['estado']) && $solicitud['estado']!=2) { ?><th><?php echo $language_text['registro_excelencia']['reg_exc_curso_eliminar'];?></th> <?php } ?>
        </tr>
    <thead>
    <tbody>
        <?php foreach ($cursos as $key => $curso) { ?>
            <tr>
                <td><?php echo $curso['especialidades']; ?></td>
                <td><?php echo $categoria_docente[$curso['id_tipo_docente']]; ?></td>
                <td><?php echo $curso['anios']; ?></td>
                <td><a href="<?php echo base_url().trim($curso['ruta'], '.'); ?>" target="_blank"><?php echo $language_text['registro_excelencia']['reg_liga_descarga'];?></a></td>
                <td><?php echo ($curso['obtuvo_pnpc'])?'Si':'No'; ?></td>
                <?php if(isset($solicitud['estado']) && $solicitud['estado']!=2) { ?><td><input type="button" value="X" class="btn animated flipInY visible" onclick="eliminar_curso('<?php echo $curso['id_curso']; ?>','#curso_msg');" style="color:red;" /></td> <?php } ?>
            </tr>
        <?php } ?>
    </tbody>
</table>