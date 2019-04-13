<?php echo js('trabajo_investigacion/registro.js'); ?>
<?php echo js('trabajo_investigacion/control_curso.js'); ?>
<style type="text/css">
	#div_carrera_categoria{
		display: none;
	}
</style>
<?php $deshabilitar = ''; $ocultar = '';
if(isset($solicitud_excelencia['estado']) && $solicitud_excelencia['estado']==2) { $deshabilitar = 'disabled="disabled"'; $ocultar = 'display:none;'; } ?>
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
						}
					?>
    			</div>
    		</div><!--row-->
    		<div class="row">
    			<div class="col-sm-offset-2 col-sm-8">
    				<strong><?php echo $language_text['registro_excelencia']['rt_leyenda_au']; ?></strong>
    			</div>
    		</div><!--row-->
    		<br>
    		<div class="row">
						<div class="col-sm-offset-1 col-sm-10 panel">
						<?php echo form_open('registro/solicitud', array('id' => 'form_registro_solicitud_general', 'class'=>'form-horizontal')); ?>
								<div class="panel-heading"><h2><?php echo $language_text['registro_excelencia']['reg_titulo_general'];?></h2></div>
								<div class="panel-body">
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
										<label  class="col-sm-3 control-label"><?php echo $language_text['registro_excelencia']['reg_unidad'];?></label>
										<div class="col-sm-9">
											<label  class="control-label"><?php echo $solicitud[0]['unidad'];?></label>
										</div>
									</div>

									<div class="form-group">
										<label  class="col-sm-3 control-label"><?php echo $language_text['registro_excelencia']['reg_categoria'];?></label>
										<div class="col-sm-9">
											<label  class="control-label"><?php echo $solicitud[0]['categoria'];?></label>
										</div>
									</div>

									<div class="form-group">
										<label  class="col-sm-3 control-label"><?php echo $language_text['registro_excelencia']['reg_nombre'];?></label>
										<div class="col-sm-9">
											<label  class="control-label"><?php echo $solicitud[0]['nombre']." ".$solicitud[0]['apellido_paterno']." ".$solicitud[0]['apellido_materno'];?></label>
										</div>
									</div>
								</div>

								<div class="form-group">
									<label for="carrera" class="col-sm-3 control-label"><?php echo $language_text['registro_excelencia']['carrera_tiene'];?>*</label>
									<div class="col-sm-9">
										<input type="radio" name="carrera" value="1" onclick="javascript:habilitar_categoria();"<?php if(isset($solicitud_excelencia['carrera'])){ if($solicitud_excelencia['carrera']=='1') echo 'checked';}?> <?php if(isset($solicitud_excelencia['id_solicitud'])) { echo 'disabled'; } ?>><?php echo $language_text['template_general']['si_op'];?><br>
										<input type="radio" name="carrera" value="0" onclick="javascript:habilitar_categoria();" <?php if(isset($solicitud_excelencia['carrera'])){ if($solicitud_excelencia['carrera']=='0') echo 'checked';}?> <?php if(isset($solicitud_excelencia['id_solicitud'])) { echo 'disabled'; } ?>><?php echo $language_text['template_general']['no_op'];?><br>
									</div><div style="clear:both;"></div>
									<?php echo form_error_format('carrera');?>
								</div>

								<div id="div_carrera_categoria" class="form-group">
									<label for="tipo_categoria" class="col-sm-3 control-label"><?php echo $language_text['registro_excelencia']['tipo_categoria'];?>*:</label>
									<div class="col-sm-9">
										<select id="tipo_categoria" name="tipo_categoria" class="form-control" <?php if(isset($solicitud_excelencia['id_solicitud'])) { echo 'disabled'; } ?>>
											<?php
											echo '<option value="">'.$language_text['template_general']['sin_op'].'</option>';
											foreach ($tipo_categoria as $key => $value) {
												if(isset($solicitud_excelencia)){
													if($solicitud_excelencia['carrera_categoria'] == $key){
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

								<!--div class="form-group">
									<label for="pnpc" class="col-sm-3 control-label"><?php //echo $language_text['registro_excelencia']['pnpc_tiene'];?>*</label>
									<div class="col-sm-9">
											<input type="radio" name="pnpc" value="1" <?php //if(isset($solicitud_excelencia['pnpc'])){ if($solicitud_excelencia['pnpc']=='1') echo 'checked';}?>><?php //echo $language_text['template_general']['si_op'];?><br>
											<input type="radio" name="pnpc" value="0" <?php //if(isset($solicitud_excelencia['pnpc'])){ if($solicitud_excelencia['pnpc']=='0') echo 'checked';}?>><?php //echo $language_text['template_general']['no_op'];?><br>
									</div><div style="clear:both;"></div>
									<?php //echo form_error_format('pnpc');?>
								</div -->
								
								<?php if(!isset($solicitud_excelencia['id_solicitud'])){ ?>
									<div class="panel-footer text-right">
										<button class="btn btn-theme animated flipInY visible" id="btn_envio_general" name="btn_envio_general" type="button"><?php echo $language_text['registro_excelencia']['guardar_solicitud'];?></button>
									</div>
								<?php } ?>
						</div>
						
						<?php echo form_close(); ?>
						


						<?php if(isset($solicitud_excelencia['id_solicitud']) && !empty($solicitud_excelencia['id_solicitud'])){ ?>


							<?php // echo form_open_multipart('registro/solicitud', array('id' => 'form_registro_solicitud_curso', 'class'=>'form-horizontal', 'data-toggle'=>"validator", 'role'=>"form", 'accept-charset'=>"utf-8")); ?>
							<?php echo form_open('', array('id' => 'form_registro_solicitud_curso', 'class'=>'form-horizontal', 'data-toggle'=>"validator", 'role'=>"form", 'accept-charset'=>"utf-8")); ?>
                                                        <div style="clear:both;"></div>
							<hr class="col-sm-11" style="border:1px solid;">
                                                            
							<div class="col-sm-offset-1 col-sm-10 panel">
								<div class="panel-heading"><h2><?php echo $language_text['registro_excelencia']['cursos_participado'];?></h2></div>
								<div class="table-responsive" style="<?php echo $ocultar; ?>">
                                                                    <input type="hidden" id="solicitud_cur" name="solicitud_cur" value="<?php echo $solicitud_excelencia['id_solicitud']; ?>">
									<div id="" class="form-group">
										<label for="curso" class="col-sm-3 control-label"><?php echo $language_text['registro_excelencia']['reg_exc_curso_nombre'];?></label>
										<div class="col-sm-9">
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
										</div>
									</div>

									<div id="" class="form-group">
										<label for="categoria_docente" class="col-sm-3 control-label"><?php echo $language_text['registro_excelencia']['reg_exc_curso_categoria'];?></label>
										<div class="col-sm-9">
										<select id="categoria_docente" name="categoria_docente" class="form-control" style="min-width: 200px;">
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
										</div>
									</div>

									<div id="" class="form-group">
										<label for="anios_docente" class="col-sm-3 control-label"><?php echo $language_text['registro_excelencia']['reg_exc_curso_anios'];?></label>
										<div class="col-sm-9">
											<input type="text" name="anios_docente" id="anios_docente" value="" />
										</div>
									</div>

									<div id="" class="form-group">
										<label for="archivo_curso" class="col-sm-3 control-label"><?php echo $language_text['registro_excelencia']['reg_exc_curso_archivo'];?></label>
										<div class="col-sm-9">
											<input type="file" name="archivo_curso" id="archivo_curso" value=""  accept="application/pdf" />
										</div>
									</div>
									<div id="" class="form-group">
										<label for="pncp_curso" class="col-sm-3 control-label"><?php echo $language_text['registro_excelencia']['reg_exc_curso_pnpc'];?></label>
										<div class="col-sm-9">
											<select id="pncp_curso" name="pncp_curso" class="form-control" style="min-width: 200px;">
														<?php
														echo '<option value="">'.$language_text['template_general']['sin_op'].'</option>';
														foreach ($pncp_curso as $key => $value) {
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
										</div>
									</div>

									<div class="col-sm-12 text-right">
										<input type="button" value="<?php echo $language_text['registro_excelencia']['reg_btn_agregar'];?>" class="btn btn-theme animated flipInY visible" id="btn_agregar_curso" />
									</div>

								</div>
								<?php echo form_close(); ?> <div style="clear:both;"></div>
								<div id="curso_msg" class="form-group"></div>
								<div id="curso_capa" class="form-group"></div>
							</div>


							<div style="clear:both;"></div>
							<hr class="col-sm-11" style="border:1px solid;">

							<div class="col-sm-offset-1 col-sm-10 panel">
								<div class="panel-heading"><h2><?php echo $language_text['registro_excelencia']['reg_titulo_documentacion'];?></h2></div>

								<?php echo form_open_multipart('registro/solicitud', array('id' => 'form_registro_solicitud_documentacion', 'class'=>'form-horizontal', 'data-toggle'=>"validator", 'role'=>"form", 'accept-charset'=>"utf-8")); ?>
														
								<?php foreach ($tipo_documentos as $key => $value) { ?>
									<div class="form-group" style="background-color: #EEE;">
										<label for="trabajo_archivo" class="col-sm-5 control-label"><?php echo (++$key).") ". $value['nombre'];?></label>
										<div id="capa_archivo_<?php echo $value['id_tipo_documento']; ?>">
											<?php if(isset($documento) && isset($documento[$value['id_tipo_documento']]) ){ ?>
												<div class="col-sm-7">
														<label class="control-label"><?php echo str_replace('||X||',base_url().$documento[$value['id_tipo_documento']]['ruta'],$language_text['registro_excelencia']['reg_liga_msg_descarga']);?></label>
												</div>
											<?php } else { ?>
												<div class="text-right col-sm-4">
													<input type="file" id="archivo_<?php echo $value['id_tipo_documento']; ?>" name="archivo_<?php echo $value['id_tipo_documento']; ?>" accept="application/pdf"> <!-- application/pdf, application/mswor -->
												</div>
												<div class="text-right col-sm-3">
													<button class="btn btn-theme animated flipInY visible" id="btn_envio_doctos" name="btn_envio_doctos" type="button" onclick="javascript:carga_archivos('form_registro_solicitud_documentacion','#capa_archivo_<?php echo $value['id_tipo_documento']; ?>', '<?php echo $value['id_tipo_documento']; ?>');"><?php echo $language_text['registro_excelencia']['reg_btn_cargar_archivos'];?></button>
												</div>
											<?php } ?>
										</div>
									</div>
						
								<?php } ?>
								<div id="div_respuesta"></div>
								<?php echo form_close(); ?>
							</div>
						</div><!--col-->
					</div> <!--row-->
					
					<div class="row">
						<div class="col-sm-offset-2 col-sm-8" id="msg"></div>
					</div><!--row-->
					<div class="row">
						<br><br>
						<div class="col-sm-offset-2 col-sm-8" style="<?php echo $ocultar; ?>">
						<center>
							<button class="btn btn-theme animated flipInY visible" id="btn_envio" name="btn_envio" type="button"><?php echo $language_text['registro_excelencia']['registrar_solicitud'];?></button>
							<!--a href="<?php echo site_url('registro_investigacion');?>" class="btn btn-theme animated flipInY visible"><?php echo $language_text['template_general']['cancelar'];?></a-->
						</center>
						</div>
					</div><!--row-->

				<?php } ?>
				
    	</div>
    </div>
</div>
<script>
$( document ).ready(function() {
	habilitar_categoria();
	
	$('#btn_envio').click(function() {
		enviar_solicitud('#msg');
	});
	$('#btn_agregar_curso').click(function() {
		agregar_curso();
	});
        <?php if( isset($solicitud_excelencia['id_solicitud']) ){?>
        get_listado_cursos(<?php echo $solicitud_excelencia['id_solicitud']; ?>);
        <?php } ?>
	$( "#btn_envio_general" ).click(function() {
		mostrar_loader();
		$("form#form_registro_solicitud_general").submit();
		$("#msg").html('');
		var msg = '';
		if( $('[name="carrera"]:checked').length <= 0){
			msg += 'Debe contestar los campos marcados como obligatorios.<br>';
		}
		if($('[name="carrera"]:checked').val()=="true" && $('#tipo_categoria').val()==''){
			msg += 'Debe seleccionar que categoría tiene.<br>';
		}
		/*if($('[name="pnpc"]:checked').val()=="true" && $('#pnpc_anio').val()==''){
			msg += 'Debe seleccionar de que año es el PNPC.<br>';
		}*/
		/*if (($('.curso_class').length <= 0)){
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
		}*/
		if(msg==''){
			$("form#form_registro_solicitud_general").submit();
		} else {
			$("#msg").html('<div class="alert alert-danger" role="alert">'+msg+'</div>');
		}		
		ocultar_loader();
	});
});



/*function eliminar_curso(elemento){
	if (($("#curso_"+elemento).length > 0)){
		$("#curso_"+elemento).remove();
	}
}*/

function habilitar_categoria(){
	if($('[name="carrera"]:checked').length > 0){
		if($('[name="carrera"]:checked').val()==1){
			$('#div_carrera_categoria').show();
		} else {
			$('#div_carrera_categoria').hide();
		}
	}
}

function carga_archivos(formulario, div_respuesta, id_tipo_documento){
	//alert($("#archivo_"+id_tipo_documento).val());
	if($("#archivo_"+id_tipo_documento).val()!=''){
		var formData = new FormData($('#' + formulario)[0]);
		formData.append('id_tipo_documento', id_tipo_documento);
		formData.append('id_solicitud', '<?php if(isset($solicitud_excelencia['id_solicitud'])){ echo $solicitud_excelencia['id_solicitud']; } ?>');
		$.ajax({
		//url: site_url + '/actividad_docente/datos_actividad',
				url: site_url + '/registro/cargar_archivo',
				data: formData,
				type: 'POST',
				mimeType: "multipart/form-data",
				contentType: false,
				cache: true,
				processData: false,
		//                dataType: 'JSON',
				beforeSend: function (xhr) {
		//            $('#tabla_actividades_docente').html(create_loader());
						mostrar_loader();
				}
		})
		.done(function (data) {
				try {//Cacha el error
						$(div_respuesta).empty();
						//var resp = $.parseJSON(data);
						//if (typeof resp.html !== 'undefined') {
								//if (resp.tp_msg === 'success') {
										$(div_respuesta).html(data);
										//reinicia_monitor();
										//actaliza_data_table(url_actualiza_tabla);
								/*} else {
										$(div_respuesta).html(resp.html);
								}
								if (typeof resp.mensaje !== 'undefined') {//Muestra mensaje al usuario si este existe
										get_mensaje_general(resp.mensaje, resp.tp_msg, 5000);
								}
						}*/
				} catch (e) {
						$(div_respuesta).html(data);
				}

		})
		.fail(function (jqXHR, response) {
        //$(div_respuesta).html(response);
				get_mensaje_general('Ocurrió un error durante el proceso, inténtelo más tarde.', 'warning', 5000);
		})
		.always(function () {
				ocultar_loader();
		});
	} else {
		alert('Debe seleccionar el archivo a cargar');
	}
}

function enviar_solicitud(div_respuesta){
		$(div_respuesta).html('');
		$.ajax({
				//url: site_url + '/actividad_docente/datos_actividad',
				url: site_url + '/registro/enviar_solicitud/<?php if(isset($solicitud_excelencia['id_solicitud'])){ echo $solicitud_excelencia['id_solicitud']; } ?>',
				data: null,
				type: 'POST',
				//mimeType: "multipart/form-data",
				//contentType: false,
				cache: true,
				processData: false,
				beforeSend: function (xhr) {
						mostrar_loader();
				}
		})
		.done(function (data) {
				$(div_respuesta).html(data);
				/*try {//Cacha el error
						$(div_respuesta).empty();
				} catch (e) {
						$(div_respuesta).html(data);
				}*/

		})
		.fail(function (jqXHR, response) {
        //$(div_respuesta).html(response);
				get_mensaje_general('Ocurrió un error durante el proceso, inténtelo más tarde.', 'warning', 5000);
		})
		.always(function () {
				ocultar_loader();
		});
}

function eliminar_curso(elemento, div_respuesta){
		var path = site_url + "/registro/eliminar_curso/" + elemento;
		var r = confirm("¿Desea eliminar el curso?");
		if (r == true) {
			$.ajax({
					type: "POST",
					url: path,
					data: null,
					dataType: "json"
			})
			.done(function (resultado) {
					//$('#curso_msg').html(result);
					try {//Captha el error
							console.log(resultado);
							$(div_respuesta).empty();
							if (typeof resultado.result !== 'undefined') {
									if(resultado.result==true){
											get_listado_cursos(<?php if(isset($solicitud_excelencia['id_solicitud'])){ echo $solicitud_excelencia['id_solicitud']; } ?>);
											$(div_respuesta).html('<div class="alert alert-success" role="alert">' + resultado.msg + '</div>');
											setTimeout("$('#curso_msg').html('')", 5000);
									} else {
											$(div_respuesta).html('<div class="alert alert-danger" role="alert">' + resultado.msg + '</div>');
									}
							}
					} catch (e) {
							$(div_respuesta).html('<div class="alert alert-danger" role="alert">' + resultado + '</div>');
					}
			}).fail(function () {

			});
		}    
}

</script>