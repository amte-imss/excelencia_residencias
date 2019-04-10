<?php
// pr($datos);
$controlador = $this->uri->rsegment(1);
//$array_sexo = ['M' => En_sexo::FEMENINO, 'H' => En_sexo::MASCULINO, 'O' => En_sexo::OTRO];
?> 
<style type="text/css">
    .titulo{
        font-weight: 500;
        color:#333;
    }
    .div-borde {
        margin-top:10px;
        border: #cdcdcd medium solid;
        border-radius: 5px;
        -moz-border-radius: 5px;
        -webkit-border-radius: 5px;
        padding: 0.5em;
    }
</style>

<div class="panel panel-default">
    <h1 class="page-head-line"></h1>
    <div class="panel-body">
        <div class="row">
            <div class="col-sm-12">
                <h2 class="titulo"><?php echo $language_text['detalle_trabajo']['titulo_detalle']; ?></h2>
            </div>
        </div><!--row-->
        <div class="row">
            <div class="col-sm-4">	
                <div class="div-borde">
                    <strong><?php echo $language_text['listado_trabajo']['folio']; ?>:</strong>
                    <br>
                    <?php echo $datos['folio']; ?>
                </div>
            </div>
            <div class="col-sm-8">	
                <div class="div-borde">
                    <strong><?php echo $language_text['listado_trabajo']['titulo_ttabla']; ?>:</strong>
                    <br>
                    <?php echo $datos['titulo']; ?>
                </div>
            </div>
        </div> <!--row-->
        <div class="row">
            <div class="col-sm-12">
                <div class="div-borde">
                    <strong><?php echo $language_text['detalle_trabajo']['ver_archivo_detalle']; ?>:</strong>
                    <?php echo '<a href="' . site_url($controlador . '/ver_archivo/' . encrypt_base64($datos['id_archivo'])) . '" target="_blank"><span class="fa fa-search"></span> ' . $datos['nombre_fisico'] . '</a><br>'; ?>
                    <?php // echo '<a href="' . site_url($controlador . '/ver_archivo/' . $datos['id_archivo']) . '" target="_blank"><span class="fa fa-search"></span> ' . $language_text['detalle_trabajo']['ver_archivo_detalle'] . '</a><br>'; ?>
                </div>
            </div>
        </div>
        <?php if (isset($autor_principal)) {//Valida que exista um autor principal, si es el caso, muestra la información ?>
            <div class="row">
                <div class="col-sm-12">
                    <h2 class="titulo"><?php echo $language_text['detalle_trabajo']['autp_detalle']; ?></h2>
                </div>
            </div><!--row-->
            <div class="row">
                <div class="col-sm-4">	
                    <div class="div-borde">
                        <strong><?php echo $language_text['registro_trabajo']['autor_nombre']; ?>:</strong>
                        <br>
                        <?php echo $autor_principal['nombre']; ?>
                    </div>
                </div>
                <div class="col-sm-4">	
                    <div class="div-borde">
                        <strong><?php echo $language_text['registro_trabajo']['autor_app']; ?>:</strong>
                        <br>
                        <?php echo $autor_principal['apellido_paterno']; ?>
                    </div>
                </div>
                <div class="col-sm-4">	
                    <div class="div-borde">
                        <strong><?php echo $language_text['registro_trabajo']['autor_apm']; ?>:</strong>
                        <br>
                        <?php echo $autor_principal['apellido_materno']; ?>
                    </div>
                </div>
            </div> <!--row-->
            <div class="row">
                <div class="col-sm-6">
                    <div class="div-borde">
                        <strong><?php echo $language_text['registro_trabajo']['autor_pais']; ?>:</strong>
                        <br>
                        <?php echo json_decode($autor_principal['pais_nombre'], true)[$lang]; ?>
                    </div>
                </div>
                <?php $sexo = 'ext_sexo_' . strtolower($autor_principal['sexo']); ?>
                <div class="col-sm-2">
                    <div class="div-borde">
                        <strong><?php echo $language_text['registro_trabajo']['autor_genero']; ?>:</strong>
                        <br>
                        <?php echo (isset($language_text['registro_usuario'][$sexo])) ? $language_text['registro_usuario'][$sexo] : ''; ?>
                    </div>
                </div>
                <div class="col-sm-4">
                    <div class="div-borde">
                        <strong><?php echo $language_text['registro_trabajo']['autor_matricula']; ?>:</strong>
                        <br>
                        <?php echo $autor_principal['matricula']; ?>
                    </div>
                </div>
            </div><!--row-->
            <br>
            <div class="row">
                <div class="col-sm-12">
                    <h2 class="titulo"><?php echo $language_text['detalle_trabajo']['autc_detalle']; ?></h2>
                </div>
            </div><!--row-->
            <?php
            //pr($autores);
            foreach ($autores as $key => $value) {
                $sexo = 'ext_sexo_' . strtolower($value['sexo']);
                ?>
                <div class="row">
                    <div class="col-sm-4">	
                        <div class="div-borde">
                            <strong><?php echo $language_text['registro_trabajo']['autor_nombre']; ?>:</strong>
                            <br>
                            <?php echo $value['nombre']; ?>
                        </div>
                    </div>
                    <div class="col-sm-4">	
                        <div class="div-borde">
                            <strong><?php echo $language_text['registro_trabajo']['autor_app']; ?>:</strong>
                            <br>
                            <?php echo $value['apellido_paterno']; ?>
                        </div>
                    </div>
                    <div class="col-sm-4">	
                        <div class="div-borde">
                            <strong><?php echo $language_text['registro_trabajo']['autor_apm']; ?>:</strong>
                            <br>
                            <?php echo $value['apellido_materno']; ?>
                        </div>
                    </div>
                </div> <!--row-->
                <div class="row">
                    <div class="col-sm-6">
                        <div class="div-borde">
                            <strong><?php echo $language_text['registro_trabajo']['autor_pais']; ?>:</strong>
                            <br>
                            <?php echo json_decode($value['pais_nombre'], true)[$lang]; ?>
                        </div>
                    </div>
                    <div class="col-sm-2">
                        <div class="div-borde">
                            <strong><?php echo $language_text['registro_trabajo']['autor_genero']; ?>:</strong>
                            <br>
                            <?php echo (isset($language_text['registro_usuario'][$sexo])) ? $language_text['registro_usuario'][$sexo] : ''; ?>
                        </div>
                    </div>
                    <div class="col-sm-4">
                        <div class="div-borde">
                            <strong><?php echo $language_text['registro_trabajo']['autor_matricula']; ?>:</strong>
                            <br>
                            <?php echo $value['matricula']; ?>
                        </div>
                    </div>
                </div>
                <br>
                <?php
            }
            ?>
        <?php }//Cierra vista de autores y coautores ?>
        <div class="row">
            <div class="col-sm-12">
                <h2 class="titulo"><?php echo $language_text['detalle_trabajo']['problema_detalle']; ?></h2>
            </div>
        </div><!--row-->
        <div class="row">
            <div class="col-sm-12">
                <div class="div-borde">
                    <strong><?php echo $language_text['registro_trabajo']['pregunta_investigacion']; ?>:</strong>
                    <br>
                    <?php echo $datos['pregunta_investigacion']; ?>
                </div>
            </div>
        </div><!--row-->
        <div class="row">
            <div class="col-sm-12">
                <div class="div-borde">
                    <strong><?php echo $language_text['registro_trabajo']['problema']; ?>:</strong>
                    <br>
                    <?php echo $datos['problema']; ?>
                </div>
            </div>
        </div><!--row-->
        <div class="row">
            <div class="col-sm-12">
                <div class="div-borde">
                    <strong><?php echo $language_text['registro_trabajo']['objetivo']; ?>:</strong>
                    <br>
                    <?php echo $datos['objetivo']; ?>
                </div>
            </div>
        </div><!--row-->
        <div class="row">
            <div class="col-sm-12">
                <div class="div-borde">
                    <strong><?php echo $language_text['registro_trabajo']['justificacion']; ?>:</strong>
                    <br>
                    <?php echo $datos['justificacion']; ?>
                </div>
            </div>
        </div><!--row-->
        <div class="row">
            <div class="col-sm-12">
                <h2 class="titulo"><?php echo $language_text['detalle_trabajo']['mt_detalle']; ?></h2>
            </div>
        </div><!--row-->
        <div class="row">
            <div class="col-sm-12">
                <div class="div-borde">
                    <strong><?php echo $language_text['registro_trabajo']['antecedentes']; ?>:</strong>
                    <br>
                    <?php echo $datos['antecedentes']; ?>
                </div>
            </div>
        </div><!--row-->
        <div class="row">
            <div class="col-sm-12">
                <div class="div-borde">
                    <strong><?php echo $language_text['registro_trabajo']['tipo_metodologia']; ?>:</strong>
                    <br>
                    <?php echo json_decode($datos['tipo_metodologia'], true)[$lang]; ?>
                </div>
            </div>
        </div><!--row-->
        <div class="row">
            <div class="col-sm-12">
                <div class="div-borde">
                    <strong><?php echo $language_text['registro_trabajo']['metodologia']; ?>:</strong>
                    <br>
                    <?php echo $datos['metodologia']; ?>
                </div>
            </div>
        </div><!--row-->
        <div class="row">
            <div class="col-sm-12">
                <div class="div-borde">
                    <strong><?php echo $language_text['registro_trabajo']['consideraciones_eticas']; ?>:</strong>
                    <br>
                    <?php echo $datos['consideraciones_eticas']; ?>
                </div>
            </div>
        </div><!--row-->
        <div class="row">
            <div class="col-sm-12">
                <div class="div-borde">
                    <strong><?php echo $language_text['registro_trabajo']['hipotesis']; ?>:</strong>
                    <br>
                    <?php echo $datos['hipotesis']; ?>
                </div>
            </div>
        </div><!--row-->
        <div class="row">
            <div class="col-sm-12">
                <div class="div-borde">
                    <strong><?php echo $language_text['registro_trabajo']['resultados']; ?>:</strong>
                    <br>
                    <?php echo $datos['resultados']; ?>
                </div>
            </div>
        </div><!--row-->
        <div class="row">
            <div class="col-sm-12">
                <div class="div-borde">
                    <strong><?php echo $language_text['registro_trabajo']['conclusiones']; ?>:</strong>
                    <br>
                    <?php echo $datos['conclusiones']; ?>
                </div>
            </div>
        </div><!--row-->
        <!--row-->
    </div>
</div>