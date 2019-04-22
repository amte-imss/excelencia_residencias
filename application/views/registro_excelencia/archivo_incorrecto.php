<div class="text-right col-sm-4">
    <input type="file" id="archivo_<?php echo $id_tipo_documento; ?>" name="archivo_<?php echo $id_tipo_documento; ?>" accept="application/pdf"> <!-- application/pdf, application/mswor -->
</div>
<div class="text-right col-sm-3">
    <button class="btn btn-theme animated flipInY visible" id="btn_envio_doctos" name="btn_envio_doctos" type="button" onclick="javascript:carga_archivos('form_registro_solicitud_documentacion','#capa_archivo_<?php echo $id_tipo_documento; ?>', '<?php echo $id_tipo_documento; ?>');">Cargar archivos</button>
</div>
<div style="clear:both;"></div>
<div class="alert alert-danger" role="alert"><?php echo $error; ?></div>