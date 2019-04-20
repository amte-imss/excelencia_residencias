<?php echo js('trabajo_investigacion/registro.js'); ?>
<?php echo js('trabajo_investigacion/control_curso.js'); ?>
<style type="text/css">
    #div_carrera_categoria{
        display: none;
    }

    .div-borde {
    margin-top: 10px;
    border: #cdcdcd medium solid;
    border-radius: 5px;
    -moz-border-radius: 5px;
    -webkit-border-radius: 5px;
    padding: 0.5em;
    }

    .delrow{
        visibility: hidden;
    }
</style>
 
<div class="panel panel-default from-trabajos">
    <h3 class="page-head-line text-center">Solicitud "Premio a la excelencia "</h3>
    <div class="panel-body">
        <div class="container">
            <div class="row">
                <div class="col-sm-offset-1 col-sm-10">
                    
                      <!--  <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>-->
                </div>
            </div>
            <!--row-->
            <div class="row">
                <div class="col-sm-offset-2 col-sm-8">
                    <strong>Los campos marcados con * son de caracter obligatorios</strong>
                </div>
            </div><!--row-->
            <br>
            <div class="row">
                <div class="col-sm-offset-1 col-sm-10 panel">
                    <div class="panel-heading"><h2>Información general</h2></div>
                    <div class="panel-body">

                        <div class="col-sm-6">
                            <div class="div-borde" >
                                <label class="control-label"> <strong>Matricula:</strong></label><br>
                                <label class="control-label">333333333</label>
                            </div>
                        </div>

                        <div class="col-sm-6">
                            <div class="div-borde" >
                                <label class="control-label"> <strong>Delegación:</strong></label><br>
                                <label class="control-label">OFICINAS CENTRALES</label>
                            </div>
                        </div>

                        <div class="col-sm-6">
                            <div class="div-borde" >
                                <label class="control-label"> <strong>Unidad:</strong></label><br>
                                <label class="control-label">DIRECCION DE PRESTACIONES MEDICAS</label>
                            </div>
                        </div>

                        <div class="col-sm-6">
                            <div class="div-borde" >
                                <label class="control-label"> <strong>Categoría:</strong></label><br>
                                <label class="control-label">SUPERV PROYECTOS E3</label>
                            </div>
                        </div>

                        <div class="col-sm-6">
                            <div class="div-borde" >
                                <label class="control-label"> <strong>Nombre:</strong></label><br>
                                <label class="control-label">MIGUEL ANGEL GONZALEZ GUAGNELLI</label>
                            </div>
                        </div>

                        <div class="col-sm-6">
                            <div class="div-borde" >
                                <label class="control-label"> <strong>¿Tiene carrera docente?*</strong></label><br>
                                <input type="radio" name="carrera" value="1" onclick="javascript:habilitar_categoria();">&nbsp SI<br>
                                <input type="radio" name="carrera" value="0" onclick="javascript:habilitar_categoria();">&nbsp NO
                            </div>
                        </div>

                        <div class="col-sm-6">
                            <div class="div-borde" >
                                <label class="control-label"> <strong>¿Qué categoría tiene?*</strong></label><br>
                                <div>
                                    <select id="tipo_categoria" name="tipo_categoria" class="form-control">
                                    <option value="volvo">Aux A  aaaaaaa</option>
                                    <option value="saab">Aux B</option>
                                    <option value="audi">Tit A</option>
                                    <option value="audi">Tit B</option>
                                    </select>
                                </div>
                               
                            </div>
                            <br><br>
                        </div>
                        <div class="col-sm-6">
                            <div class="div-borde" >
                                <label class="control-label"> <strong>¿Tiene PNCP?*</strong></label><br>
                                <select id="tipo_categoria" name="tipo_categoria" class="form-control">
                                <option value="volvo">Si</option>
                                <option value="saab">No</option>
                                </select>
                            </div>
                            <br><br>
                        </div>

                        <div class="text-center"> 
                            <button class="btn btn-theme animated flipInY visible" id="btn_envio_general" name="btn_envio_general" type="button">Guardar solicitud</button>
                        </div>
         
                    </div>
                    <hr>
                     <!--Sección 2-->
                    <div class="panel-heading"><h2>Cursos en los que ha participado como docente</h2></div>
                    <div class="panel-body">
                        <br>
                        <table class="table ">
                            <thead>
                            <tr>
                                <th>Nombre del curso</th>
                                <th>Categoría del docente</th>
                                <th>Años</th>
                                <th>Archivo</th>
                                <th>¿El curso está registrado en el PNCP?</th>
                                <th>Opciones</th>
                            </tr>
                            </thead>
                            <tbody>
                            <tr>
                                <td>Nombre del curso</td>
                                <td>Titular A</td>
                                <td>3</td>
                                <td>archivo.pdf</td>
                                <td>Si</td>
                                <td>                                   
                                    <input type="radio" name="carrera" value="1" onclick="javascript:habilitar_categoria();">&nbsp Op 1<br>
                                    <input type="radio" name="carrera" value="1" onclick="javascript:habilitar_categoria();">&nbsp Op 2<br>
                                    <input type="radio" name="carrera" value="1" onclick="javascript:habilitar_categoria();">&nbsp Op 3<br>
                                </td>
                            </tr>
                            <tr>
                                <td>Nombre del curso</td>
                                <td>Auxiliar B</td>
                                <td>3</td>
                                <td>archivo.pdf</td>
                                <td>NoDoe</td>
                                <td>                                   
                                    <input type="radio" name="carrera" value="1" onclick="javascript:habilitar_categoria();">&nbsp Op 1<br>
                                    <input type="radio" name="carrera" value="1" onclick="javascript:habilitar_categoria();">&nbsp Op 2<br>
                                    <input type="radio" name="carrera" value="1" onclick="javascript:habilitar_categoria();">&nbsp Op 3<br>
                                </td>
                            </tr>
                            <tr>
                                <td>Nombre del curso</td>
                                <td>Titular C</td>
                                <td>2</td>
                                <td>archivo.pdf</td>
                                <td>Si</td>
                                <td>                                   
                                    <input type="radio" name="carrera" value="1" onclick="javascript:habilitar_categoria();">&nbsp Op 1<br>
                                    <input type="radio" name="carrera" value="1" onclick="javascript:habilitar_categoria();">&nbsp Op 2<br>
                                    <input type="radio" name="carrera" value="1" onclick="javascript:habilitar_categoria();">&nbsp Op 3<br>
                                </td>
                            </tr>
                            </tbody>
                        </table>

                        <div class="text-center"> 
                            <button class="btn btn-theme animated flipInY visible" id="btn_envio_general" name="btn_envio_general" type="button">Guardar opciones</button>
                        </div>
                        <br>
                    </div>
                    <hr>
                    <!--Sección 3-->
                    <div class="panel-heading"><h2>Documentación</h2></div>
                    <div class="panel-body">
                    <br>
                        <table class="table ">
                           
                            <tbody>
                            <tr>
                                <td>Nombre del documento</td>
                                <td>Descripción</td>
                                <td>                                   
                                    <input type="radio" name="carrera" value="1" onclick="javascript:habilitar_categoria();">&nbsp Op 1<br>
                                    <input type="radio" name="carrera" value="1" onclick="javascript:habilitar_categoria();">&nbsp Op 2<br>
                                    <input type="radio" name="carrera" value="1" onclick="javascript:habilitar_categoria();">&nbsp Op 3<br>
                                </td>
                            </tr>
                            <tr>
                                <td>Nombre del documento</td>
                                <td>Descripción</td>
                                <td>                                   
                                    <input type="radio" name="carrera" value="1" onclick="javascript:habilitar_categoria();">&nbsp Op 1<br>
                                    <input type="radio" name="carrera" value="1" onclick="javascript:habilitar_categoria();">&nbsp Op 2<br>
                                    <input type="radio" name="carrera" value="1" onclick="javascript:habilitar_categoria();">&nbsp Op 3<br>
                                </td>
                            </tr>
                            <tr>
                                <td>Nombre del documento</td>
                                <td>Descripción</td>
                                <td>                                   
                                    <input type="radio" name="carrera" value="1" onclick="javascript:habilitar_categoria();">&nbsp Op 1<br>
                                    <input type="radio" name="carrera" value="1" onclick="javascript:habilitar_categoria();">&nbsp Op 2<br>
                                    <input type="radio" name="carrera" value="1" onclick="javascript:habilitar_categoria();">&nbsp Op 3<br>
                                </td>
                            </tr>
                            <tr>
                                <td>Nombre del documento</td>
                                <td>Descripción</td>
                                <td>                                   
                                    <input type="radio" name="carrera" value="1" onclick="javascript:habilitar_categoria();">&nbsp Op 1<br>
                                    <input type="radio" name="carrera" value="1" onclick="javascript:habilitar_categoria();">&nbsp Op 2<br>
                                    <input type="radio" name="carrera" value="1" onclick="javascript:habilitar_categoria();">&nbsp Op 3<br>
                                </td>
                            </tr>
                            <tr>
                                <td>Nombre del documento</td>
                                <td>Descripción</td>
                                <td>                                   
                                    <input type="radio" name="carrera" value="1" onclick="javascript:habilitar_categoria();">&nbsp Op 1<br>
                                    <input type="radio" name="carrera" value="1" onclick="javascript:habilitar_categoria();">&nbsp Op 2<br>
                                    <input type="radio" name="carrera" value="1" onclick="javascript:habilitar_categoria();">&nbsp Op 3<br>
                                </td>
                            </tr>
                            <tr>
                                <td>Nombre del documento</td>
                                <td>Descripción</td>
                                <td>                                   
                                    <input type="radio" name="carrera" value="1" onclick="javascript:habilitar_categoria();">&nbsp Op 1<br>
                                    <input type="radio" name="carrera" value="1" onclick="javascript:habilitar_categoria();">&nbsp Op 2<br>
                                    <input type="radio" name="carrera" value="1" onclick="javascript:habilitar_categoria();">&nbsp Op 3<br>
                                </td>
                            </tr>
                            <tr>
                                <td>Nombre del documento</td>
                                <td>Descripción</td>
                                <td>                                   
                                    <input type="radio" name="carrera" value="1" onclick="javascript:habilitar_categoria();">&nbsp Op 1<br>
                                    <input type="radio" name="carrera" value="1" onclick="javascript:habilitar_categoria();">&nbsp Op 2<br>
                                    <input type="radio" name="carrera" value="1" onclick="javascript:habilitar_categoria();">&nbsp Op 3<br>
                                </td>
                            </tr>
                            </tbody>
                        </table>

                        <div class="text-center"> 
                            <button class="btn btn-theme animated flipInY visible" id="btn_envio_general" name="btn_envio_general" type="button">Guardar opciones</button>
                        </div>
                        <br>
                    </div>




                </div>
            </div>
            
                   

                    

               
                    


                       
                </div>




<?php if (isset($solicitud_excelencia['id_solicitud']) && !empty($solicitud_excelencia['id_solicitud'])) { ?>


                                        <?php // echo form_open_multipart('registro/solicitud', array('id' => 'form_registro_solicitud_curso', 'class'=>'form-horizontal', 'data-toggle'=>"validator", 'role'=>"form", 'accept-charset'=>"utf-8")); ?>
                                        <?php echo form_open('', array('id' => 'form_registro_solicitud_curso', 'class' => 'form-horizontal', 'data-toggle' => "validator", 'role' => "form", 'accept-charset' => "utf-8")); ?>
                    <div style="clear:both;"></div>
                    <hr class="col-sm-11" style="border:1px solid;">

                    <div class="col-sm-offset-1 col-sm-10 panel">
                        <div class="panel-heading"><h2><?php echo $language_text['registro_excelencia']['cursos_participado']; ?></h2></div>
                        <div id="div_formulario_registro" class="table-responsive" style="<?php echo $ocultar; ?>">
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
                                <input type="button" value="<?php echo $language_text['registro_excelencia']['reg_btn_cancel']; ?>" class="btn btn-theme animated flipInY hidden" id="btn_cancelar_curso" onclick="cancelar_curso()" />
                                <input type="button" value="<?php echo $language_text['registro_excelencia']['reg_btn_actualizar']; ?>" class="btn btn-theme animated flipInY hidden"  id="btn_editar_curso" />
                                <input type="button" value="<?php echo $language_text['registro_excelencia']['reg_btn_agregar']; ?>" class="btn btn-theme animated flipInY visible"  id="btn_agregar_curso" />
                            </div>

                        </div>
                        <?php echo form_close(); ?> <div style="clear:both;"></div>
                        <div id="curso_msg" class="form-group"></div>
                        <div id="curso_capa" class="form-group"></div>
                    </div>


                    <div style="clear:both;"></div>
                    <hr class="col-sm-11" style="border:1px solid;">

                    <div class="col-sm-offset-1 col-sm-10 panel">
                        <div class="panel-heading"><h2><?php echo $language_text['registro_excelencia']['reg_titulo_documentacion']; ?></h2></div>

    <?php echo form_open_multipart('registro/solicitud', array('id' => 'form_registro_solicitud_documentacion', 'class' => 'form-horizontal', 'data-toggle' => "validator", 'role' => "form", 'accept-charset' => "utf-8")); ?>

                                <?php foreach ($tipo_documentos as $key => $value) { ?>
                            <div class="form-group" style="background-color: #EEE;">
                                <label for="trabajo_archivo" class="col-sm-5 control-label"><?php echo ( ++$key) . ") " . $value['nombre']; ?></label>
                                <div id="capa_archivo_<?php echo $value['id_tipo_documento']; ?>">
                            <?php if (isset($documento) && isset($documento[$value['id_tipo_documento']])) { ?>
                                        <div class="col-sm-7">
                                            <label class="control-label"><?php echo str_replace('||X||', base_url() . $documento[$value['id_tipo_documento']]['ruta'], $language_text['registro_excelencia']['reg_liga_msg_descarga']); ?></label>
                                        </div>
        <?php } else { ?>
                                        <div class="text-right col-sm-4">
                                            <input type="file" id="archivo_<?php echo $value['id_tipo_documento']; ?>" name="archivo_<?php echo $value['id_tipo_documento']; ?>" accept="application/pdf"> <!-- application/pdf, application/mswor -->
                                        </div>
                                        <div class="text-right col-sm-3">
                                            <button class="btn btn-theme animated flipInY visible" id="btn_envio_doctos" name="btn_envio_doctos" type="button" onclick="javascript:carga_archivos('form_registro_solicitud_documentacion', '#capa_archivo_<?php echo $value['id_tipo_documento']; ?>', '<?php echo $value['id_tipo_documento']; ?>');"><?php echo $language_text['registro_excelencia']['reg_btn_cargar_archivos']; ?></button>
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
                        <button class="btn btn-theme animated flipInY visible" id="btn_envio" name="btn_envio" type="button"><?php echo $language_text['registro_excelencia']['registrar_solicitud']; ?></button>
                        <!--a href="<?php echo site_url('registro_investigacion'); ?>" class="btn btn-theme animated flipInY visible"><?php echo $language_text['template_general']['cancelar']; ?></a-->
                    </center>
                </div>
            </div><!--row-->

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
            actualizar_curso();
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
            formData.append('id_solicitud', '<?php if (isset($solicitud_excelencia['id_solicitud'])) {
    echo $solicitud_excelencia['id_solicitud'];
} ?>');
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
            url: site_url + '/registro/enviar_solicitud/<?php if (isset($solicitud_excelencia['id_solicitud'])) {
    echo $solicitud_excelencia['id_solicitud'];
} ?>',
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
                                    get_listado_cursos(<?php if (isset($solicitud_excelencia['id_solicitud'])) {
    echo $solicitud_excelencia['id_solicitud'];
} ?>);
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