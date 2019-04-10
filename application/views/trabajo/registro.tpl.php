<?php echo js('trabajo_investigacion/registro.js'); ?>
<?php // pr($language_text);  ?>

<div class="panel panel-default from-trabajos">
    <h3 class="page-head-line text-center"><?php echo $language_text['registro_trabajo']['titulo_registro']; ?></h3>
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
    				<strong><?php echo $language_text['registro_trabajo']['rt_leyenda_au'];?></strong>
    			</div>
    		</div><!--row-->
    		<br>
    		<?php echo form_open_multipart('registro_investigacion/nuevo', array('id' => 'form_registro_investigacion', 'class'=>'form-horizontal', 'data-toggle'=>"validator", 'role'=>"form", 'accept-charset'=>"utf-8")); ?>
    		<div class="row">
    			<div class="col-sm-offset-2 col-sm-8">

				    <div class="form-group">
				      <label for="titulo_trabajo" class="col-sm-3 control-label"><?php echo $language_text['registro_trabajo']['titulo_trabajo'];?>*:</label>
				      <div class="col-sm-9">
				      	<input type="text" class="form-control" id="titulo_trabajo" name="titulo_trabajo" <?php if(isset($trabajo['titulo_trabajo'])) echo 'value="'.$trabajo['titulo_trabajo'].'"';?>>
				      <?php echo form_error_format('titulo_trabajo');?>
				      </div>
				    </div>

				     <div class="form-group">
				      <label for="pregunta_investigacion" class="col-sm-3 control-label"><?php echo $language_text['registro_trabajo']['pregunta_investigacion'];?>*:</label>
				      <div class="col-sm-9">
				      	<textarea class="form-control" rows="3" id="pregunta_investigacion" name="pregunta_investigacion" ><?php if(isset($trabajo['pregunta_investigacion'])) echo $trabajo['pregunta_investigacion'];?></textarea>
				      	<?php echo form_error_format('pregunta_investigacion');?>
				      </div>
				    </div>

				     <div class="form-group">
				      <label for="problema" class="col-sm-3 control-label"><?php echo $language_text['registro_trabajo']['problema'];?>*:</label>
				      <div class="col-sm-9">
				      	<textarea class="form-control" rows="3" id="problema" name="problema" ><?php if(isset($trabajo['problema'])) echo $trabajo['problema'];?></textarea>
				      	<?php echo form_error_format('problema');?>
				      </div>
				     </div>

				    <div class="form-group">
				      <label for="objetivo" class="col-sm-3 control-label" ><?php echo $language_text['registro_trabajo']['objetivo'];?>*:</label>
				      <div class="col-sm-9">
				      	<textarea class="form-control" rows="3" id="objetivo" name="objetivo" ><?php if(isset($trabajo['objetivo'])) echo $trabajo['objetivo'];?></textarea>
				      <?php echo form_error_format('objetivo');?>
				      </div>
				    </div>

				     <div class="form-group">
				      <label for="justificacion" class="col-sm-3 control-label"><?php echo $language_text['registro_trabajo']['justificacion'];?>*:</label>
				      <div class="col-sm-9">
				      	<textarea class="form-control" rows="3" id="justificacion" name="justificacion" ><?php if(isset($trabajo['justificacion'])) echo $trabajo['justificacion'];?></textarea>
				      <?php echo form_error_format('justificacion');?>
				      </div>
				    </div>

				    <div class="form-group">
				      <label for="antecedentes" class="col-sm-3 control-label"><?php echo $language_text['registro_trabajo']['antecedentes'];?>*:</label>
				      <div class="col-sm-9">
				      	<textarea class="form-control" rows="3" id="antecedentes" name="antecedentes" ><?php if(isset($trabajo['antecedentes'])) echo $trabajo['antecedentes'];?></textarea>
				      	<?php echo form_error_format('antecedentes');?>
				      </div>
				    </div>

				    <div class="form-group">
				      <label for="tipo_metodologia" class="col-sm-3 control-label"><?php echo $language_text['registro_trabajo']['tipo_metodologia'];?>*:</label>
				      <div class="col-sm-9">
				      <select id="tipo_metodologia" name="tipo_metodologia" class="form-control">
	  						<?php
	  						echo '<option value="">'.$language_text['template_general']['sin_op'].'</option>';
	  						foreach ($tipos_metodologias as $key => $value) {
	  							if(isset($trabajo)){
	  								if($trabajo['tipo_metodologia'] == $key){
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
	  					<?php echo form_error_format('tipo_metodologia');?>
				      </div>
				    </div>

				     <div class="form-group">
				      <label for="metodologia" class="col-sm-3 control-label"><?php echo $language_text['registro_trabajo']['metodologia'];?>*:</label>
				      <div class="col-sm-9">
				      	<textarea class="form-control" rows="3" id="metodologia" name="metodologia" ><?php if(isset($trabajo['metodologia'])) echo $trabajo['metodologia'];?></textarea>
				      	<?php echo form_error_format('metodologia');?>
				      </div>
				    </div>

				    <div class="form-group">
				      <label for="consideraciones_eticas" class="col-sm-3 control-label"><?php echo $language_text['registro_trabajo']['consideraciones_eticas'];?>*:</label>
				      <div class="col-sm-9">
				      	<textarea class="form-control" rows="3" id="consideraciones_eticas" name="consideraciones_eticas" ><?php if(isset($trabajo['consideraciones_eticas'])) echo $trabajo['consideraciones_eticas'];?></textarea>
				      	<?php echo form_error_format('consideraciones_eticas');?>
				      </div>
				    </div>

				    <div class="form-group">
				      <label for="hipotesis" class="col-sm-3 control-label"><?php echo $language_text['registro_trabajo']['hipotesis'];?>:</label>
				      <div class="col-sm-9">
				      	<textarea class="form-control" rows="3" id="hipotesis" name="hipotesis" ><?php if(isset($trabajo['hipotesis'])) echo $trabajo['hipotesis'];?></textarea>
				      </div>
				    </div>

				    <div class="form-group">
				      <label for="resultados" class="col-sm-3 control-label"><?php echo $language_text['registro_trabajo']['resultados'];?>*:</label>
				      <div class="col-sm-9">
				      	<textarea class="form-control" rows="3" id="resultados" name="resultados" ><?php if(isset($trabajo['resultados'])) echo $trabajo['resultados'];?></textarea>
				      	<?php echo form_error_format('resultados');?>
				      </div>
				    </div>

				    <div class="form-group">
				      <label for="conclusiones" class="col-sm-3 control-label"><?php echo $language_text['registro_trabajo']['conclusiones'];?>*:</label>
				      <div class="col-sm-9">
				      	<textarea class="form-control" rows="3" id="conclusiones" name="conclusiones" ><?php if(isset($trabajo['conclusiones'])) echo $trabajo['conclusiones'];?></textarea>
				      	<?php echo form_error_format('conclusiones');?>
				      </div>
				    </div>

						<div class="form-group">
							<label for="publicado" class="col-sm-3 control-label"><?php echo $language_text['registro_trabajo']['publicado'];?>*</label>
							<div class="col-sm-9">
								<input type="radio" name="publicado" value="true" <?php if(isset($trabajo)){ if($trabajo['publicado']=='true') echo 'checked';}?>><?php echo $language_text['template_general']['si_op'];?><br>
	  						<input type="radio" name="publicado" value="false" <?php if(isset($trabajo)){ if($trabajo['publicado']=='false') echo 'checked';} else { echo 'checked'; }?>><?php echo $language_text['template_general']['no_op'];?><br>
							</div>
						</div>

						<div class="form-group">
				      <label for="referencia" class="col-sm-3 control-label"><?php echo $language_text['registro_trabajo']['referencia'];?></label>
				      <div class="col-sm-9">
				      	<textarea class="form-control" rows="4" id="referencia" name="referencia" <?php if(isset($trabajo)){ if($trabajo['publicado']=='false') echo 'disabled';} else { echo 'disabled'; }?>><?php if(isset($trabajo['referencia'])) echo $trabajo['referencia'];?></textarea>
				      </div>
				    </div>

				    <div class="form-group">
							<label for="trabajo_archivo" class="col-sm-3 control-label"><?php echo $language_text['registro_trabajo']['rt_archivo'];?></label>
							<input type="file" id="trabajo_archivo" name="trabajo_archivo" accept="application/pdf, application/msword">
						</div>

					</div><!--col-->
				</div> <!--row-->
				<div class="row">
					<div class="col-sm-12">
					<?php echo $language_text['registro_trabajo']['autor_mensaje'];?>
				  	<br><br>
				  	<button id="btnAddRow" type="button"><?php echo $language_text['registro_trabajo']['autor_nuevo'];?></button>
				  	<br><br>
				  	<div class="table-responsive" style="overflow:scroll;">
				  	<table id="tabla_autores" class="table table-striped table-bordered">
				  		<thead>
				  			<tr>
				  				<th><?php echo $language_text['registro_trabajo']['autor_nombre'];?>*</th>
				  				<th><?php echo $language_text['registro_trabajo']['autor_app'];?>*</th>
				  				<th><?php echo $language_text['registro_trabajo']['autor_apm'];?></th>
				  				<th><?php echo $language_text['registro_trabajo']['autor_genero'];?>*</th>
				  				<th><?php echo $language_text['registro_trabajo']['autor_pais'];?>*</th>
				  				<th><?php echo $language_text['registro_trabajo']['autor_imss'];?></th>
				  				<th><?php echo $language_text['registro_trabajo']['autor_matricula'];?></th>
				  				<th></th>
				  			</tr>
				  		</thead>
				  		<tbody>
				  			<?php
				  			if(isset($trabajo['autor_imss']) && isset($trabajo['autor_matricula']) &&
	                  			isset($trabajo['autor_nombre']) && isset($trabajo['autor_app']) &&
	                  			isset($trabajo['autor_apm']) && isset($trabajo['autor_sexo']) &&
	                  			isset($trabajo['autor_pais']))
				  			{
				  				for ($i=0; $i < count($trabajo['autor_imss']); $i++) {
				  					echo '<tr>';
				  					echo '<td><input type="text" name="autor_nombre[]" maxlength="100" value="'.$trabajo['autor_nombre'][$i].'"></td>';
				  					echo '<td><input type="text" name="autor_app[]" maxlength="100" value="'.$trabajo['autor_app'][$i].'"></td>';
				  					echo '<td><input type="text" name="autor_apm[]" maxlength="100" value="'.$trabajo['autor_apm'][$i].'"></td>';
				  			?>
				  					<td>
				  					<select name="autor_sexo[]">
				  						<option value=""><?php echo $language_text['template_general']['sin_op'];?></option>
				  						<option value="<?php echo En_sexo::MASCULINO; ?>" <?php if($trabajo['autor_sexo'][$i]=='H') echo 'selected';?>><?php echo $language_text['registro_usuario']['ext_sexo_m'];?></option>
                      <option value="<?php echo En_sexo::FEMENINO; ?>" <?php if($trabajo['autor_sexo'][$i]=='M') echo 'selected';?>><?php echo $language_text['registro_usuario']['ext_sexo_f'];?></option>
				  						<option value="<?php echo En_sexo::OTRO; ?>" <?php if($trabajo['autor_sexo'][$i]=='O') echo 'selected';?>><?php echo $language_text['registro_usuario']['ext_sexo_o'];?></option>
				  					</select>
				  					</td>
				  					<td>
				  					<select name="autor_pais[]">
				  						<?php
				  						$status_paises = true;
				  						foreach ($paises as $key => $value) {
				  							if($trabajo['autor_pais'][$i]==0 && $status_paises){
				  								echo '<option value="">'.$language_text['template_general']['sin_op'].'</option>';
				  								$status_paises = false;
				  							}
				  							if($key == $trabajo['autor_pais'][$i]){
				  								echo '<option value="'.$key.'" selected>'.$value.'</option>';
				  							}else{
				  								echo '<option value="'.$key.'">'.$value.'</option>';
				  							}
				  						}
				  						?>
				  					</select>
				  					</td>
				  					<td>
				  					<select name="autor_imss[]">
				  						<option value="0" <?php if($trabajo['autor_imss'][$i]=='0') echo 'selected';?>><?php echo $language_text['template_general']['no_op'];?></option>
				  						<option value="1" <?php if($trabajo['autor_imss'][$i]=='1') echo 'selected';?>><?php echo $language_text['template_general']['si_op'];?></option>
				  					</select>
				  					</td>
				  			<?php
				  					echo '<td><input type="text" name="autor_matricula[]" maxlength="15" value="'.$trabajo['autor_matricula'][$i].'"></td>';
				  					echo '</tr>';
				  				}
				  			?>
				  			<?php
				  			}else
				  			{
				  			?>
				  			<tr>
				  				<td><input type="text" name="autor_nombre[]" maxlength="100"></td>
				  				<td><input type="text" name="autor_app[]" maxlength="100"></td>
				  				<td><input type="text" name="autor_apm[]" maxlength="100"></td>
				  				<td>
				  					<select name="autor_sexo[]">
				  						<option value=""><?php echo $language_text['template_general']['sin_op'];?></option>
				  						<option value="<?php echo En_sexo::MASCULINO; ?>"><?php echo $language_text['registro_usuario']['ext_sexo_m'];?></option>
				  						<option value="<?php echo En_sexo::FEMENINO; ?>"><?php echo $language_text['registro_usuario']['ext_sexo_f'];?></option>
				  						<option value="<?php echo En_sexo::OTRO; ?>"><?php echo $language_text['registro_usuario']['ext_sexo_o'];?></option>
				  					</select>
				  				</td>
				  				<td>
				  					<select name="autor_pais[]">
				  						<?php
				  						echo '<option value="">'.$language_text['template_general']['sin_op'].'</option>';
				  						foreach ($paises as $key => $value) {
				  							echo '<option value="'.$key.'">'.$value.'</option>';
				  						}
				  						?>
				  					</select>
				  				</td>
				  				<td>
				  					<select name="autor_imss[]">
				  						<option value="0"><?php echo $language_text['template_general']['no_op'];?></option>
				  						<option value="1"><?php echo $language_text['template_general']['si_op'];?></option>
				  					</select>
				  				</td>
				  				<td><input type="text" name="autor_matricula[]" maxlength="15"></td>
				  			</tr>
				  			<?php
				  			}
				  			?>
				  		</tbody>
				  	</table>
				  	</div>
				  </div>
				</div><!--row-->
			  <div class="row">
			  	<div class="col-sm-offset-2 col-sm-8">

			  	</div>
			  </div><!--row-->
			  <div class="row">
          <br><br>
			  	<div class="col-sm-offset-2 col-sm-8">
			  	<center>
			  		<button class="btn btn-theme animated flipInY visible" type="submit" onclick="mostrar_loader();"><?php echo $language_text['registro_trabajo']['registrar_trabajo'];?></button>
			  		<a href="<?php echo site_url('registro_investigacion');?>" class="btn btn-theme animated flipInY visible"><?php echo $language_text['template_general']['cancelar'];?></a>
			  	</center>
			  	</div>
			  </div><!--row-->
				<?php echo form_close(); ?>
    	</div>
    </div>
</div>
