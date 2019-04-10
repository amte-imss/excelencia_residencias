<?php echo js('trabajo_investigacion/registro.js'); ?>
<?php // pr($language_text);  ?>
<style type="text/css">
	#div_carrera_categoria{
		display: none;
	}
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
						}
					?>
    			</div>
    		</div><!--row-->
    		<div class="row">
    			<div class="col-sm-offset-2 col-sm-8">
    				<strong><?php echo $language_text['registro_excelencia']['rt_leyenda_au']; pr($solicitud);?></strong>
    			</div>
    		</div><!--row-->
    		<br>
    		<?php echo form_open_multipart('registro_investigacion/nuevo', array('id' => 'form_registro_investigacion', 'class'=>'form-horizontal', 'data-toggle'=>"validator", 'role'=>"form", 'accept-charset'=>"utf-8")); ?>
    		<div class="row">
    			<div class="col-sm-offset-2 col-sm-8">
    				<div class="form-group">
						<label for="carrera" class="col-sm-3 control-label"><?php echo $language_text['registro_excelencia']['reg_matricula'];?></label>
						<div class="col-sm-9">
							<label for="carrera" class="control-label"><?php echo $solicitud[0]['username'];?></label>
						</div>
					</div>

					<div class="form-group">
						<label for="carrera" class="col-sm-3 control-label"><?php echo $language_text['registro_excelencia']['reg_delegacion'];?></label>
						<div class="col-sm-9">
							<label for="carrera" class="control-label"><?php echo $solicitud[0]['delegacion'];?></label>
						</div>
					</div>

					<div class="form-group">
						<label for="carrera" class="col-sm-3 control-label"><?php echo $language_text['registro_excelencia']['reg_nombre'];?></label>
						<div class="col-sm-9">
							<label for="carrera" class="control-label"><?php echo $solicitud[0]['nombre']." ".$solicitud[0]['apellido_paterno']." ".$solicitud[0]['apellido_materno'];?></label>
						</div>
					</div>

    				<div class="form-group">
						<label for="carrera" class="col-sm-3 control-label"><?php echo $language_text['registro_excelencia']['carrera_tiene'];?>*</label>
						<div class="col-sm-9">
							<input type="radio" name="carrera" value="true" <?php if(isset($trabajo)){ if($trabajo['carrera_tiene']=='true') echo 'checked';}?>><?php echo $language_text['template_general']['si_op'];?><br>
	  						<input type="radio" name="carrera" value="false" <?php if(isset($trabajo)){ if($trabajo['carrera_tiene']=='false') echo 'checked';} else { echo 'checked'; }?>><?php echo $language_text['template_general']['no_op'];?><br>
						</div>
					</div>

					<div id="div_carrera_categoria" class="form-group">
				      <label for="tipo_categoria" class="col-sm-3 control-label"><?php echo $language_text['registro_excelencia']['tipo_categoria'];?>*:</label>
				      <div class="col-sm-9">
				      <select id="tipo_categoria" name="tipo_categoria" class="form-control">
	  						<?php
	  						echo '<option value="">'.$language_text['template_general']['sin_op'].'</option>';
	  						foreach ($tipos_metodologias as $key => $value) {
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
							<input type="radio" name="pnpc" value="true" <?php if(isset($trabajo)){ if($trabajo['pnpc_tiene']=='true') echo 'checked';}?>><?php echo $language_text['template_general']['si_op'];?><br>
	  						<input type="radio" name="pnpc" value="false" <?php if(isset($trabajo)){ if($trabajo['pnpc_tiene']=='false') echo 'checked';} else { echo 'checked'; }?>><?php echo $language_text['template_general']['no_op'];?><br>
						</div>
					</div>

					<div id="div_pnpc_anio" class="form-group">
					      <label for="pnpc_anio" class="col-sm-3 control-label"><?php echo $language_text['registro_excelencia']['pnpc_anio'];?>*:</label>
					      <div class="col-sm-9">
					      <select id="pnpc_anio" name="tipo_categoria" class="form-control">
		  						<?php
		  						echo '<option value="">'.$language_text['template_general']['sin_op'].'</option>';
		  						foreach ($tipos_metodologias as $key => $value) {
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

				    <div class="form-group">
				      	<label for="curso" class="col-sm-12 control-label"><?php echo $language_text['registro_excelencia']['cursos_participado'];?>*:</label>
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
		  						foreach ($curso as $key => $value) {
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
							<input type="button" value="+" class="btn btn-theme animated flipInY visible" />
						</div>
				    </div>
						
						<?php foreach ($tipo_documentos as $key => $value) { ?>
							<div class="form-group">
								<label for="trabajo_archivo" class="col-sm-3 control-label"><?php echo $value['nombre'];?></label>
								<input type="file" id="trabajo_archivo" name="trabajo_archivo" accept="application/pdf, application/msword">
							</div>
						<?php }
						?>
					</div><!--col-->
				</div> <!--row-->
				
			  <div class="row">
			  	<div class="col-sm-offset-2 col-sm-8">

			  	</div>
			  </div><!--row-->
			  <div class="row">
          <br><br>
			  	<div class="col-sm-offset-2 col-sm-8">
			  	<center>
			  		<button class="btn btn-theme animated flipInY visible" type="submit" onclick="mostrar_loader();"><?php echo $language_text['registro_excelencia']['registrar_solicitud'];?></button>
			  		<a href="<?php echo site_url('registro_investigacion');?>" class="btn btn-theme animated flipInY visible"><?php echo $language_text['template_general']['cancelar'];?></a>
			  	</center>
			  	</div>
			  </div><!--row-->
				<?php echo form_close(); ?>
    	</div>
    </div>
</div>
