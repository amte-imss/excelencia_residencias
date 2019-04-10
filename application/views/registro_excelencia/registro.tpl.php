<?php echo js('trabajo_investigacion/registro.js'); ?>
<?php // pr($language_text);  ?>
<style type="text/css">
	/*#div_carrera_categoria{
		display: none;
	}
	#div_pnpc_anio {
		display: none;
	}*/
</style>

<div class="panel panel-default from-trabajos">
    <h3 class="page-head-line text-center"><?php echo $language_text['registro_excelencia']['titulo_registro']; ?></h3>
    <div class="panel-body">
    	<div class="container">
    		<div class="row">
    			<div class="col-sm-offset-1 col-sm-10">
    				<?php
    				if(isset($msg))
    				{
    					echo '<div class="alert alert-'.$msg_type.'">';
    					echo $msg.' <strong>'.$folio.'</strong>';
						?>
						<button type="button" class="close" data-dismiss="alert" aria-label="Close">
					    <span aria-hidden="true">&times;</span>
					  </button>
					  <?php
					  echo '</div>';
						} pr($solicitud);
					?>
    			</div>
    		</div><!--row-->
    		<div class="row">
    			<div class="col-sm-offset-2 col-sm-8">
    				<strong><?php echo $language_text['registro_excelencia']['rt_leyenda_au']; ?></strong>
    			</div>
    		</div><!--row-->
    		<br>
    		<?php echo form_open_multipart('registro/solicitud', array('id' => 'form_registro_solicitud', 'class'=>'form-horizontal', 'data-toggle'=>"validator", 'role'=>"form", 'accept-charset'=>"utf-8")); ?>
    		<div class="row">
    			<div class="col-sm-offset-2 col-sm-8">
    				<div class="form-group">
						<label class="col-sm-3 control-label"><?php echo $language_text['registro_excelencia']['reg_matricula'];?></label>
						<div class="col-sm-9">
							<label class="control-label"><?php echo $solicitud[0]['username'];?></label>
						</div>
					</div>

					<div class="form-group">
						<label  class="col-sm-3 control-label"><?php echo $language_text['registro_excelencia']['reg_delegacion'];?></label>
						<div class="col-sm-9">
							<label  class="control-label"><?php echo $solicitud[0]['delegacion'];?></label>
						</div>
					</div>

					<div class="form-group">
						<label  class="col-sm-3 control-label"><?php echo $language_text['registro_excelencia']['reg_nombre'];?></label>
						<div class="col-sm-9">
							<label  class="control-label"><?php echo $solicitud[0]['nombre']." ".$solicitud[0]['apellido_paterno']." ".$solicitud[0]['apellido_materno'];?></label>
						</div>
					</div>

    				<div class="form-group">
						<label for="carrera" class="col-sm-3 control-label"><?php echo $language_text['registro_excelencia']['carrera_tiene'];?>*</label>
						<div class="col-sm-9">
							<input type="radio" name="carrera" value="1" <?php //if(isset($trabajo)){ if($trabajo['carrera_tiene']=='true') echo 'checked';}?>><?php echo $language_text['template_general']['si_op'];?><br>
	  						<input type="radio" name="carrera" value="0" <?php //if(isset($trabajo)){ if($trabajo['carrera_tiene']=='false') echo 'checked';} else { echo 'checked'; }?>><?php echo $language_text['template_general']['no_op'];?><br>
						</div><div style="clear:both;"></div>
						<?php echo form_error_format('carrera');?>
					</div>

					<div id="div_carrera_categoria" class="form-group">
				      <label for="tipo_categoria" class="col-sm-3 control-label"><?php echo $language_text['registro_excelencia']['tipo_categoria'];?>*:</label>
				      <div class="col-sm-9">
				      <select id="tipo_categoria" name="tipo_categoria" class="form-control">
	  						<?php
	  						echo '<option value="">'.$language_text['template_general']['sin_op'].'</option>';
	  						foreach ($tipo_categoria as $key => $value) {
	  							if(isset($trabajo)){
	  								if($trabajo['tipo_categoria'] == $key){
	  									echo '<option value="'.$key.'" selected>'.$value.'</option>';
	  								} else {
	  									echo '<option value="'.$key.'">'.$value.'</option>';
	  								}
	  							} else {
	  								echo '<option value="'.$key.'">'.$value.'</option>';
	  							}
	  						}
	  						?>
	  					</select>
	  					<?php echo form_error_format('tipo_categoria');?>
				      </div>
				    </div>

				    <div class="form-group">
						<label for="pnpc" class="col-sm-3 control-label"><?php echo $language_text['registro_excelencia']['pnpc_tiene'];?>*</label>
						<div class="col-sm-9">
							<input type="radio" name="pnpc" value="1" <?php //if(isset($trabajo)){ if($trabajo['pnpc_tiene']=='true') echo 'checked';}?>><?php echo $language_text['template_general']['si_op'];?><br>
	  						<input type="radio" name="pnpc" value="0" <?php //if(isset($trabajo)){ if($trabajo['pnpc_tiene']=='false') echo 'checked';} else { echo 'checked'; }?>><?php echo $language_text['template_general']['no_op'];?><br>
						</div><div style="clear:both;"></div>
						<?php echo form_error_format('pnpc');?>
					</div>

					<div id="div_pnpc_anio" class="form-group">
					      <label for="pnpc_anio" class="col-sm-3 control-label"><?php echo $language_text['registro_excelencia']['pnpc_anio'];?>*:</label>
					      <div class="col-sm-9">
					      <select id="pnpc_anio" name="pnpc_anio" class="form-control">
		  						<?php
		  						echo '<option value="">'.$language_text['template_general']['sin_op'].'</option>';
		  						foreach ($pnpc_anio as $key => $value) {
		  							if(isset($trabajo)){
		  								if($trabajo['tipo_categoria'] == $key){
		  									echo '<option value="'.$key.'" selected>'.$value.'</option>';
		  								} else {
		  									echo '<option value="'.$key.'">'.$value.'</option>';
		  								}
		  							} else {
		  								echo '<option value="'.$key.'">'.$value.'</option>';
		  							}
		  						}
		  						?>
		  					</select>
		  					<?php echo form_error_format('pnpc_anio');?>
					      </div>
				    </div>
						
						<hr style="border:1px solid;">

						<div class="panel panel-default">
							<div class="panel-body">
									<div class="form-group">
										<label for="curso" class="col-sm-12 control-label"><?php echo $language_text['registro_excelencia']['cursos_participado'];?>*:</label>
									</div>
									<div class="form-group">
										<label for="curso" class="col-sm-6 control-label">Nombre del curso</label>
										<label for="curso" class="col-sm-6 control-label">Categoría del docente</label>
									</div>
									<div class="form-group">
											<div class="col-sm-6">
												<select id="curso" name="curso" class="form-control">
													<?php
													echo '<option value="">'.$language_text['template_general']['sin_op'].'</option>';
													foreach ($curso as $key => $value) {
														if(isset($trabajo)){
															if($trabajo['curso'] == $key){
																echo '<option value="'.$key.'" selected>'.$value.'</option>';
															} else {
																echo '<option value="'.$key.'">'.$value.'</option>';
															}
														} else {
															echo '<option value="'.$key.'">'.$value.'</option>';
														}
													}
													?>
												</select>
												<?php echo form_error_format('curso');?>
											</div>
											<div class="col-sm-5">
													<select id="categoria_docente" name="categoria_docente" class="form-control">
													<?php
													echo '<option value="">'.$language_text['template_general']['sin_op'].'</option>';
													foreach ($categoria_docente as $key => $value) {
														if(isset($trabajo)){
															if($trabajo['categoria_docente'] == $key){
																echo '<option value="'.$key.'" selected>'.$value.'</option>';
															} else {
																echo '<option value="'.$key.'">'.$value.'</option>';
															}
														} else {
															echo '<option value="'.$key.'">'.$value.'</option>';
														}
													}
													?>
												</select>
												<?php echo form_error_format('curso');?>
											</div>
											<div class="col-sm-1">
												<input type="button" value="+" class="btn btn-theme animated flipInY visible" id="btn_agregar_curso" />
											</div>
									</div>
									
									<div id="curso_msg" class="form-group"></div>
									<div id="curso_capa" class="form-group"></div>
							</div>
						</div>

						<hr style="border:1px solid;">

						<div class="form-group">
							<label for="curso" class="col-sm-12 control-label">Documentación</label>
						</div>
												
						<?php foreach ($tipo_documentos as $key => $value) { ?>
							<div class="form-group">
								<label for="trabajo_archivo" class="col-sm-7 control-label"><?php echo (++$key).") ". $value['nombre'];?></label>
								<input type="file" id="archivo[<?php echo $value['id_tipo_documento']; ?>]" name="archivo[<?php echo $value['id_tipo_documento']; ?>]" accept="application/pdf, application/msword">
							</div>
						<?php }
						?>
					</div><!--col-->
				</div> <!--row-->
				
			  <div class="row">
			  	<div class="col-sm-offset-2 col-sm-8" id="msg">

			  	</div>
			  </div><!--row-->
			  <div class="row">
          <br><br>
			  	<div class="col-sm-offset-2 col-sm-8">
			  	<center>
			  		<button class="btn btn-theme animated flipInY visible" id="btn_envio" name="btn_envio" type="button"><?php echo $language_text['registro_excelencia']['registrar_solicitud'];?></button>
			  		<a href="<?php echo site_url('registro_investigacion');?>" class="btn btn-theme animated flipInY visible"><?php echo $language_text['template_general']['cancelar'];?></a>
			  	</center>
			  	</div>
			  </div><!--row-->
				<?php echo form_close(); ?>
    	</div>
    </div>
</div>
<script>
$( document ).ready(function() {
	$('#btn_agregar_curso').click(function() {
		agregar_curso();
	});

	/*$( "#btn_envio" ).submit(function( event ) {
		alert('alo');
		console.log($("#carrera"));
		event.preventDefault();
	});*/

	$( "#btn_envio" ).click(function() {
		mostrar_loader();
		$("form#form_registro_solicitud").submit();
		$("#msg").html('');
		var msg = '';
		if( $('[name="carrera"]:checked').length <= 0 || $('[name="pnpc"]:checked').length <= 0){
			msg += 'Debe contestar los campos marcados como obligatorios.<br>';
		}
		if($('[name="carrera"]:checked').val()=="true" && $('#tipo_categoria').val()==''){
			msg += 'Debe seleccionar que categoría tiene.<br>';
		}
		if($('[name="pnpc"]:checked').val()=="true" && $('#pnpc_anio').val()==''){
			msg += 'Debe seleccionar de que año es el PNPC.<br>';
		}
		if (($('.curso_class').length <= 0)){
			msg += 'Debe registrar los cursos en los que ha participado.<br>';
		}
		var validar_archivo=0;
		$("input[type=file]").each(function() {
			if($(this).val()==''){
				validar_archivo++;
			}
		});
		if(validar_archivo>0){
			msg += 'Debe cargar la documentación solicitada.<br>';
		}
		if(msg==''){
			$("form#form_registro_solicitud").submit();
		} else {
			$("#msg").html('<div class="alert alert-danger" role="alert">'+msg+'</div>');
		}
		
		
		ocultar_loader();
	});
});

function agregar_curso(){
	var curso = $('#curso').val();
	var cat_doc = $('#categoria_docente').val();
	$('#curso_msg').html('');

	if(curso != '' && cat_doc != ''){
		html = '<div class="form-group" id="curso_'+$('#curso option:selected').val()+'" style="border: 1px solid #aaaaaa;padding: 2px;border-radius: 5px;">'
			+'<label for="curso" class="col-sm-6 control-label">'+$('#curso option:selected').text()+'<input type="hidden" name="curso[]" class="curso_class" value="'+$('#curso option:selected').val()+'" /></label>'
			+'<label for="curso" class="col-sm-5 control-label">'+$('#categoria_docente option:selected').text()+'<input type="hidden" name="categoria_docente[]" value="'+$('#categoria_docente option:selected').val()+'" /></label>'
			+'<div class="col-sm-1"><input type="button" value="X" class="btn animated flipInY visible" onclick="javascript: eliminar_curso('+$('#curso option:selected').val()+');" style="color:red;" /></div>'
		+'</div>';
		$('#curso_capa').append(html);
		$('#curso').val('');
		$('#categoria_docente').val('');
	} else {
		$('#curso_msg').html('<div class="alert alert-danger" role="alert">Debe seleccionar el curso y la categoría para poder agregar registros.</div>');
	}

}

function eliminar_curso(elemento){
	if (($("#curso_"+elemento).length > 0)){
		$("#curso_"+elemento).remove();
	}
}

</script>