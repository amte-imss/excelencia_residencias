<div class="form-group" id="curso_<?php echo $curso['id_curso']; ?>" style="border: 1px solid #aaaaaa;padding: 2px;border-radius: 5px;">'
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
</div>'