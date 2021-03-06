<?php echo js('trabajo_investigacion/registro.js'); ?>
<?php echo js('trabajo_investigacion/control_curso.js'); ?>
<style type="text/css">
    #div_carrera_categoria{
        display: none;
    }
</style>
<?php
/* $deshabilitar = '';
  $ocultar = '';
  if (isset($solicitud_excelencia['estado']) && $solicitud_excelencia['estado'] == 2) {
  $deshabilitar = 'disabled="disabled"';
  $ocultar = 'display:none;';
  } */
?>
<div class="panel panel-default from-trabajos">
    <h3 class="page-head-line text-center"><?php echo $language_text['registro_excelencia']['titulo_registro']; ?></h3>
    <div class="panel-body">
        <div class="container">
            <div class="row">
                <div class="col-sm-offset-1 col-sm-10">
                    <?php
                    if (isset($msg)) {
                        echo '<div class="alert alert-' . $msg_type . '">';
                        echo $msg . ' <strong>' . $folio . '</strong>';
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
                    <?php echo form_open('registro/solicitud', array('id' => 'form_registro_solicitud_general', 'class' => 'form-horizontal')); ?>
                    <div class="panel-heading"><h2><?php echo $language_text['registro_excelencia']['reg_titulo_general']; ?></h2></div>
                    <div class="panel-body">
                        <div class="form-group">
                            <label class="col-sm-3 control-label"><?php echo $language_text['registro_excelencia']['reg_matricula']; ?></label>
                            <div class="col-sm-9">
                                <label class="control-label"><?php echo $solicitud[0]['username']; ?></label>
                            </div>
                        </div>

                        <div class="form-group">
                            <label  class="col-sm-3 control-label"><?php echo $language_text['registro_excelencia']['reg_delegacion']; ?></label>
                            <div class="col-sm-9">
                                <label  class="control-label"><?php echo $solicitud[0]['delegacion']; ?></label>
                            </div>
                        </div>

                        <div class="form-group">
                            <label  class="col-sm-3 control-label"><?php echo $language_text['registro_excelencia']['reg_unidad']; ?></label>
                            <div class="col-sm-9">
                                <label  class="control-label"><?php echo $solicitud[0]['unidad']; ?></label>
                            </div>
                        </div>

                        <div class="form-group">
                            <label  class="col-sm-3 control-label"><?php echo $language_text['registro_excelencia']['reg_categoria']; ?></label>
                            <div class="col-sm-9">
                                <label  class="control-label"><?php echo $solicitud[0]['categoria']; ?></label>
                            </div>
                        </div>

                        <div class="form-group">
                            <label  class="col-sm-3 control-label"><?php echo $language_text['registro_excelencia']['reg_nombre']; ?></label>
                            <div class="col-sm-9">
                                <label  class="control-label"><?php echo $solicitud[0]['nombre'] . " " . $solicitud[0]['apellido_paterno'] . " " . $solicitud[0]['apellido_materno']; ?></label>
                            </div>
                        </div>
                    </div>

                    <div class="form-group">
                        <label for="carrera" class="col-sm-3 control-label"><?php echo $language_text['registro_excelencia']['carrera_tiene']; ?>*</label>
                        <div class="col-sm-9">
                            <input type="radio" name="carrera" value="1" onclick="javascript:habilitar_categoria();"<?php
                            if (isset($solicitud_excelencia['carrera_tiene'])) {
                                if ($solicitud_excelencia['carrera_tiene'] == '1')
                                    echo 'checked';
                            }
                            ?> <?php
//                            if (isset($solicitud_excelencia['id_solicitud'])) {
//                                echo 'disabled';
//                            }
                            ?>><?php echo $language_text['template_general']['si_op']; ?><br>
                            <input type="radio" name="carrera" value="0" onclick="javascript:habilitar_categoria();" <?php
                            if (isset($solicitud_excelencia['carrera_tiene'])) {
                                if ($solicitud_excelencia['carrera_tiene'] == '0')
                                    echo 'checked';
                            }
                            ?> 
                            <?php
//                            if (isset($solicitud_excelencia['id_solicitud'])) {
//                                echo 'disabled';
//                            }
                            ?>>
                                <?php echo $language_text['template_general']['no_op']; ?><br>
                        </div><div style="clear:both;"></div>
                        <?php echo form_error_format('carrera'); ?>
                        
                    </div>

                    <div id="div_carrera_categoria" class="form-group">
                        <label for="tipo_categoria" class="col-sm-3 control-label"><?php echo $language_text['registro_excelencia']['tipo_categoria']; ?>*:</label>
                        <div class="col-sm-9">
                            <select id="tipo_categoria" name="tipo_categoria" class="form-control" <?php
//                            if (isset($solicitud_excelencia['id_solicitud'])) {
//                                echo 'disabled';
//                            }
                            ?>>
                                        <?php
                                        echo '<option value="">' . $language_text['template_general']['sin_op'] . '</option>';
                                        foreach ($tipo_categoria as $key => $value) {
                                            if (isset($solicitud_excelencia)) {
                                                if ($solicitud_excelencia['carrera_categoria'] == $key) {
                                                    echo '<option value="' . $key . '" selected>' . $value . '</option>';
                                                } else {
                                                    echo '<option value="' . $key . '">' . $value . '</option>';
                                                }
                                            } else {
                                                echo '<option value="' . $key . '">' . $value . '</option>';
                                            }
                                        }
                                        ?>
                            </select>
                            <?php echo form_error_format('tipo_categoria'); ?>
                        </div>
                    </div>

                    <!--div class="form-group">
                            <label for="pnpc" class="col-sm-3 control-label"><?php //echo $language_text['registro_excelencia']['pnpc_tiene'];                      ?>*</label>
                            <div class="col-sm-9">
                                            <input type="radio" name="pnpc" value="1" <?php //if(isset($solicitud_excelencia['pnpc'])){ if($solicitud_excelencia['pnpc']=='1') echo 'checked';}                     ?>><?php //echo $language_text['template_general']['si_op'];                     ?><br>
                                            <input type="radio" name="pnpc" value="0" <?php //if(isset($solicitud_excelencia['pnpc'])){ if($solicitud_excelencia['pnpc']=='0') echo 'checked';}                      ?>><?php //echo $language_text['template_general']['no_op'];                      ?><br>
                            </div><div style="clear:both;"></div>
                    <?php //echo form_error_format('pnpc'); ?>
                    </div -->

                    <?php if (!isset($solicitud_excelencia['id_solicitud'])) { ?>
                        <div class="panel-footer text-right">
                            <button class="btn btn-theme animated flipInY visible" id="btn_envio_general" name="btn_envio_general" type="button"><?php echo $language_text['registro_excelencia']['guardar_solicitud']; ?></button>
                        </div>
                    <?php }else {?>
                        <?php if (isset($estado_solicitud['config']['modificar_datos_generales']) && $estado_solicitud['config']['modificar_datos_generales'] == "true") { ?>
                            <input type="hidden" id="solicitud_gen" name="solicitud_gen" value="<?php echo $solicitud_excelencia['id_solicitud']; ?>">
                            <div id="datos_gen_msg">
                                <!--<div class="alert alert-success" role="alert">Saludos</div>-->
                            </div>
                            <div class="panel-footer text-right">
                                <button class="btn btn-theme animated flipInY visible" 
                                        id="btn_actualizar_general" 
                                        name="btn_actualizar_general"
                                        data-divres="datos_gen_msg"
                                        data-formulario="form_registro_solicitud_general"
                                        type="button">
                                            <?php echo $language_text['registro_excelencia']['reg_btn_actualizar']; ?>
                                </button>
                            </div>
                        <?php }?>
                    <?php }?>
                </div>

                <?php echo form_close(); ?>

                <?php if (isset($observaciones)) { ?>
                    <br>
                    <div class="col-sm-offset-1 col-sm-10 panel">
                        <div class="panel-heading"><h2><?php echo $language_text['registro_excelencia']['lbl_obseraciones_revisor_solicitud']; ?></h2></div>
                    <!--<label for="curso" class="col-sm-12 control-label"><?php // echo 'Observaciones por parte del revisor';  ?></label>-->
                        <strong><p style="color:red; size: 9"><?php echo $language_text['registro_excelencia']['nota_revision_registro'];?></p></strong>
                        <div class="alert alert-info" role="alert">
                            <?php echo $observaciones; ?>
                        </div>
                    </div>
                <?php } ?>

                <?php if (isset($solicitud_excelencia['id_solicitud']) && !empty($solicitud_excelencia['id_solicitud'])) { ?>


                    <?php // echo form_open_multipart('registro/solicitud', array('id' => 'form_registro_solicitud_curso', 'class'=>'form-horizontal', 'data-toggle'=>"validator", 'role'=>"form", 'accept-charset'=>"utf-8"));  ?>
                    <?php echo form_open('', array('id' => 'form_registro_solicitud_curso', 'class' => 'form-horizontal', 'data-toggle' => "validator", 'role' => "form", 'accept-charset' => "utf-8")); ?>
                    <div style="clear:both;"></div>
                    <hr class="col-sm-11" style="border:1px solid;">

                    <div class="col-sm-offset-1 col-sm-10 panel">
                        <div class="panel-heading"><h2><?php echo $language_text['registro_excelencia']['cursos_participado']; ?></h2></div>
                        <?php if ((isset($estado_solicitud['config']['btn_agregar_curso']) && $estado_solicitud['config']['btn_agregar_curso'] == "true") || (isset($estado_solicitud['config']['btn_editar_curso']) && $estado_solicitud['config']['btn_editar_curso'] == "true")) { ?>
                            <div id="div_formulario_registro" class="table-responsive" onmousedown="elemento(event);">
                                <input type="hidden" id="solicitud_cur" name="solicitud_cur" value="<?php echo $solicitud_excelencia['id_solicitud']; ?>">
                                <div id="" class="form-group">
                                    <label for="curso" class="col-sm-3 control-label"><?php echo $language_text['registro_excelencia']['reg_exc_curso_nombre']; ?></label>
                                    <div class="col-sm-9">
                                        <select id="curso" name="curso" class="form-control">
                                            <?php
                                            echo '<option value="">' . $language_text['template_general']['sin_op'] . '</option>';
                                            foreach ($curso as $key => $value) {
                                                if (isset($trabajo)) {
                                                    if ($trabajo['curso'] == $key) {
                                                        echo '<option value="' . $key . '" selected>' . $value . '</option>';
                                                    } else {
                                                        echo '<option value="' . $key . '">' . $value . '</option>';
                                                    }
                                                } else {
                                                    echo '<option value="' . $key . '">' . $value . '</option>';
                                                }
                                            }
                                            ?>
                                        </select>
                                    </div>
                                </div>

                                <div id="" class="form-group">
                                    <label for="categoria_docente" class="col-sm-3 control-label"><?php echo $language_text['registro_excelencia']['reg_exc_curso_categoria']; ?></label>
                                    <div class="col-sm-9">
                                        <select id="categoria_docente" name="categoria_docente" class="form-control" style="min-width: 200px;">
                                            <?php
                                            echo '<option value="">' . $language_text['template_general']['sin_op'] . '</option>';
                                            foreach ($categoria_docente as $key => $value) {
                                                if (isset($trabajo)) {
                                                    if ($trabajo['categoria_docente'] == $key) {
                                                        echo '<option value="' . $key . '" selected>' . $value . '</option>';
                                                    } else {
                                                        echo '<option value="' . $key . '">' . $value . '</option>';
                                                    }
                                                } else {
                                                    echo '<option value="' . $key . '">' . $value . '</option>';
                                                }
                                            }
                                            ?>
                                        </select>
                                    </div>
                                </div>

                                <div id="" class="form-group">
                                    <label for="anios_docente" class="col-sm-3 control-label"><?php echo $language_text['registro_excelencia']['reg_exc_curso_anios']; ?></label>
                                    <div class="col-sm-9">
                                        <input type="text" name="anios_docente" id="anios_docente" value="" />
                                    </div>
                                </div>

                                <div id="" class="form-group">
                                    <label for="archivo_curso" class="col-sm-3 control-label"><?php echo $language_text['registro_excelencia']['reg_exc_curso_archivo']; ?></label>
                                    <div class="col-sm-9">
                                        <input type="file" name="archivo_curso" id="archivo_curso" value=""  accept="application/pdf" />
                                    </div>
                                </div>
                                <div id="" class="form-group">
                                    <label for="pncp_curso" class="col-sm-3 control-label"><?php echo $language_text['registro_excelencia']['reg_exc_curso_pnpc']; ?></label>
                                    <div class="col-sm-9">
                                        <select id="pncp_curso" name="pncp_curso" class="form-control" style="min-width: 200px;">
                                            <?php
                                            echo '<option value="">' . $language_text['template_general']['sin_op'] . '</option>';
                                            foreach ($pncp_curso as $key => $value) {
                                                if (isset($trabajo)) {
                                                    if ($trabajo['categoria_docente'] == $key) {
                                                        echo '<option value="' . $key . '" selected>' . $value . '</option>';
                                                    } else {
                                                        echo '<option value="' . $key . '">' . $value . '</option>';
                                                    }
                                                } else {
                                                    echo '<option value="' . $key . '">' . $value . '</option>';
                                                }
                                            }
                                            ?>
                                        </select>
                                    </div>
                                </div>

                                <div class="col-sm-12 text-right">
                                    <?php if (isset($estado_solicitud['config']['btn_editar_curso']) && $estado_solicitud['config']['btn_editar_curso'] == "true") { ?>
                                        <input type="button" value="<?php echo $language_text['registro_excelencia']['reg_btn_cancel']; ?>" class="btn btn-theme animated flipInY hidden" id="btn_cancelar_curso" onclick="cancelar_curso()" />
                                        <input type="button" value="<?php echo $language_text['registro_excelencia']['reg_btn_actualizar']; ?>" class="btn btn-theme animated flipInY hidden"  id="btn_editar_curso" />
                                        <?php
                                    }
                                    if (isset($estado_solicitud['config']['btn_agregar_curso']) && $estado_solicitud['config']['btn_agregar_curso'] == "true") {
                                        ?>
                                        <input type="button" value="<?php echo $language_text['registro_excelencia']['reg_btn_agregar']; ?>" class="btn btn-theme animated flipInY visible"  id="btn_agregar_curso" />
                                    <?php } ?>
                                </div>

                            </div>
                            <?php
                        }
                        echo form_close();
                        ?> <div style="clear:both;"></div>
                        <div id="curso_msg" class="form-group"></div>
                        <div id="curso_capa" class="form-group"></div>
                    </div>


                    <div style="clear:both;"></div>
                    <hr class="col-sm-11" style="border:1px solid;">

                    <div class="col-sm-offset-1 col-sm-10 panel">
                        <div class="panel-heading"><h2><?php echo $language_text['registro_excelencia']['reg_titulo_documentacion']; ?></h2></div>

                        <?php echo form_open_multipart('registro/solicitud', array('id' => 'form_registro_solicitud_documentacion', 'class' => 'form-horizontal', 'data-toggle' => "validator", 'role' => "form", 'accept-charset' => "utf-8")); ?>

                        <?php foreach ($tipo_documentos as $key => $value) { 
//                            pr($value);
//                            pr($key);
//                            pr($documento);
//                            pr($tipo_documentos);
//                            pr($documento[$value['id_tipo_documento']]);
                            ?>
                            <div class="form-group" style="background-color: #EEE;">
                                <div class="col-sm-4">
                                    <label for="trabajo_archivo" class="control-label"><?php echo ( ++$key) . ") " . $value['nombre']; ?></label>
                                </div >
                                <div id="capa_archivo_<?php echo $value['id_tipo_documento']; ?>" class="text-right col-sm-8">
                                    <?php if (isset($documento) && isset($documento[$value['id_tipo_documento']])) { ?>
                                        <?php
                                        $tam = 12;
                                        $agrega_edicion = FALSE;
                                        if (isset($estado_solicitud['config']['modificar_archivos']) && $estado_solicitud['config']['modificar_archivos'] == 'true') {
                                            $tam = 5;
                                            $agrega_edicion = true;
                                        }
                                        ?>
                                        <div class="col-sm-<?php echo $tam; ?>">
                                            <label class="control-label" id="lbl_<?php echo $value['id_tipo_documento']; ?>">
                                                <?php echo str_replace('||X||', base_url() . $documento[$value['id_tipo_documento']]['ruta'].'?'.date("YmdHis"), $language_text['registro_excelencia']['reg_liga_msg_descarga']); ?>
                                            </label>
                                        </div>

                                        <?php if ($agrega_edicion) { ?>
                                            <div class="col-sm-7 ">
                                                <input type="file" 
                                                       id="archivo_<?php echo $value['id_tipo_documento']; ?>" 
                                                       name="archivo_<?php echo $value['id_tipo_documento']; ?>" 
                                                       accept="application/pdf"
                                                       > <!-- application/pdf, application/mswor -->
                                                <button class="text-left btn btn-theme animated flipInY visible" id="btn_envio_doctos" 
                                                        name="btn_envio_doctos" type="button" 
                                                        data-idtipodocumento ="<?php echo $value['id_tipo_documento']; ?>"
                                                        data-solicitud ="<?php echo $solicitud_excelencia['id_solicitud']; ?>"
                                                        data-formulario ="form_registro_solicitud_documentacion"
                                                        data-documento ="<?php echo $documento[$value['id_tipo_documento']]['id_documento']; ?>"
                                                        onclick="javascript:editar_archivos(this);">
                                                            <?php echo "Actualizar archivo"; //$language_text['registro_excelencia']['reg_btn_cargar_archivos'];      ?>
                                                </button>
                                            </div >
                                        <?php } ?>
                                        <?php
                                    } else {
                                        if (isset($estado_solicitud['config']['btn_envio_doctos']) && $estado_solicitud['config']['btn_envio_doctos'] == "true") {
                                            ?>
                                            <div class="text-right col-sm-6">
                                                <input type="file" id="archivo_<?php echo $value['id_tipo_documento']; ?>" name="archivo_<?php echo $value['id_tipo_documento']; ?>" accept="application/pdf"> <!-- application/pdf, application/mswor -->
                                            </div>
                                            <div class="text-right col-sm-6">
                                                <button class="btn btn-theme animated flipInY visible" id="btn_envio_doctos" name="btn_envio_doctos" type="button" onclick="javascript:carga_archivos('form_registro_solicitud_documentacion', '#capa_archivo_<?php echo $value['id_tipo_documento']; ?>', '<?php echo $value['id_tipo_documento']; ?>');"><?php echo $language_text['registro_excelencia']['reg_btn_cargar_archivos']; ?></button>
                                            </div>
                                            <?php
                                        }
                                    }
                                    ?>
                                </div>
                            </div>
                            <div id="msgloadfile_<?php echo $value['id_tipo_documento']; ?>" class="alert alert-danger hidden" role="alert"></div>
                        <?php } ?>
                        <div id="div_respuesta"></div>
                        <?php echo form_close(); ?>
                    </div>
                </div><!--col-->
            </div> <!--row-->

            <div class="row">
                <div class="col-sm-offset-2 col-sm-8" id="msg"></div>
            </div><!--row-->
            <?php if (isset($estado_solicitud['config']['btn_envio']) && $estado_solicitud['config']['btn_envio'] == 'true') { ?>
                <div class="row">
                    <br><br>
                    <div class="col-sm-offset-2 col-sm-8" >
                        <center>
                            <button class="btn btn-theme animated flipInY visible" id="btn_envio" name="btn_envio" type="button"><?php echo $language_text['registro_excelencia']['registrar_solicitud']; ?></button>
                            <!--a href="<?php // echo site_url('registro_investigacion');                    ?>" class="btn btn-theme animated flipInY visible"><?php // echo $language_text['template_general']['cancelar'];                    ?></a-->
                        </center>
                    </div>
                </div><!--row-->
            <?php } ?>

        <?php } ?>

    </div>
</div>
</div>
<script>
    $(document).ready(function () {
        habilitar_categoria();

        $('#btn_envio').click(function () {
            enviar_solicitud('#msg');
        });
        $('#btn_agregar_curso').click(function () {
            agregar_curso();
        });
        $('#btn_editar_curso').click(function () {
            agregar_curso();
        });
        $('#btn_editar_curso').click(function () {
            agregar_curso();
        });
        $('#btn_actualizar_general').click(function () {
            actualiza_datos_generales(this);
        });
<?php if (isset($solicitud_excelencia['id_solicitud'])) { ?>
            get_listado_cursos(<?php echo $solicitud_excelencia['id_solicitud']; ?>);
<?php } ?>
        $("#btn_envio_general").click(function () {
            mostrar_loader();
            $("form#form_registro_solicitud_general").submit();
            $("#msg").html('');
            var msg = '';
            if ($('[name="carrera"]:checked').length <= 0) {
                msg += 'Debe contestar los campos marcados como obligatorios.<br>';
            }
            if ($('[name="carrera"]:checked').val() == "true" && $('#tipo_categoria').val() == '') {
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
            if (msg == '') {
                $("form#form_registro_solicitud_general").submit();
            } else {
                $("#msg").html('<div class="alert alert-danger" role="alert">' + msg + '</div>');
            }
            ocultar_loader();
        });
    });



    /*function eliminar_curso(elemento){
     if (($("#curso_"+elemento).length > 0)){
     $("#curso_"+elemento).remove();
     }
     }*/

    function habilitar_categoria() {
        if ($('[name="carrera"]:checked').length > 0) {
            if ($('[name="carrera"]:checked').val() == 1) {
                $('#div_carrera_categoria').show();
            } else {
                $('#div_carrera_categoria').hide();
            }
        }
    }

    function carga_archivos(formulario, div_respuesta, id_tipo_documento) {
        //alert($("#archivo_"+id_tipo_documento).val());
        if ($("#archivo_" + id_tipo_documento).val() != '') {
            var formData = new FormData($('#' + formulario)[0]);
            formData.append('id_tipo_documento', id_tipo_documento);
            formData.append('id_solicitud', '<?php
if (isset($solicitud_excelencia['id_solicitud'])) {
    echo $solicitud_excelencia['id_solicitud'];
}
?>');
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

    function enviar_solicitud(div_respuesta) {
        $(div_respuesta).html('');
        $.ajax({
            //url: site_url + '/actividad_docente/datos_actividad',
            url: site_url + '/registro/enviar_solicitud/<?php
if (isset($solicitud_excelencia['id_solicitud'])) {
    echo $solicitud_excelencia['id_solicitud'];
}
?>',
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

    function eliminar_curso(elemento, div_respuesta) {
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
                                if (resultado.result == true) {
                                    get_listado_cursos(<?php
if (isset($solicitud_excelencia['id_solicitud'])) {
    echo $solicitud_excelencia['id_solicitud'];
}
?>);
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