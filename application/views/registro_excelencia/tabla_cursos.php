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
            <th>Nombre del curso</th>
            <th>Categoría del docente</th>
            <th>Años</th>
            <th>Archivo</th>
            <th>Obtuvo PNPC</th>
            <!--th>Eliminar</th-->
        </tr>
    <thead>
    <tbody>
        <?php foreach ($cursos as $key => $curso) { ?>
            <tr>
                <td><?php echo $curso['especialidades']; ?></td>
                <td><?php echo $categoria_docente[$curso['id_tipo_docente']]; ?></td>
                <td><?php echo $curso['anios']; ?></td>
                <td><a href="<?php echo base_url().trim($curso['ruta'], '.'); ?>" target="_blank">Liga de descarga</a></td>
                <td><?php echo ($curso['obtuvo_pnpc'])?'Si':'No'; ?></td>
                <!--td><input type="button" value="X" class="btn animated flipInY visible" onclick="eliminar_curso('<?php echo $curso['id_curso']; ?>');" style="color:red;" /></td-->
            </tr>
        <?php } ?>
    </tbody>
</table>