
function agregar_curso() {
    var curso = $('#curso').val();
    var cat_doc = $('#categoria_docente').val();
    var solicitud = $('#solicitud_cur').val();
    $('#curso_msg').html('');

    //if (curso != '') {
    var formulario = 'form_registro_solicitud_curso';
    var formData = new FormData($('#' + formulario)[0]);
    var div_respuesta = '#curso_msg';
    $.ajax({
//                url: site_url + '/actividad_docente/datos_actividad',
        url: site_url + '/registro/guarda_cursos',
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
                    var resp = $.parseJSON(data);
                    if (typeof resp.html !== 'undefined') {
                        if (resp.tp_msg === 'success') {
                            $(div_respuesta).html('<div class="alert alert-success" role="alert">' + resp.html + '</div>');
                            get_listado_cursos(solicitud);
                            $('#curso').val('');
                            $('#categoria_docente').val('');
                            $('#anios_docente').val('');
                            $('#archivo_curso').val('');
                            //$('#pncp_curso').val('');
                            setTimeout("$('#curso_msg').html('')", 5000);
                        } else {
                            $(div_respuesta).html(resp.html);
                        }
                        if (typeof resp.mensaje !== 'undefined') {//Muestra mensaje al usuario si este existe
//                                get_mensaje_general(resp.mensaje, resp.tp_msg, 5000);
                        }
                    }
                } catch (e) {
//                        $(div_respuesta).html(data);
                    $(div_respuesta).html('<div class="alert alert-danger" role="alert">' + data + '</div>');
                }

            })
            .fail(function (jqXHR, response) {
//                        $(div_respuesta).html(response);
                get_mensaje_general('Ocurrió un error durante el proceso, inténtelo más tarde.', 'warning', 5000);
            })
            .always(function () {
                ocultar_loader();
            });
    /*} else {
     $('#curso_msg').html('<div class="alert alert-danger" role="alert">Debe seleccionar el curso y la categoría para poder agregar registros.</div>');
     }*/
}

function get_listado_cursos(solicitud) {
    var div_result = "#curso_capa";
    var path = site_url + "/registro/get_cursos_participacion/" + solicitud;
    data_ajax(path, null, div_result);

}

function editar_curso(param) {
    $("#div_formulario_registro").css('display', 'block');
    $("#btn_agregar_curso").removeClass('visible').addClass('hidden');
    $("#btn_cancelar_curso").removeClass('hidden').addClass('visible');
    $("#btn_editar_curso").removeClass('hidden').addClass('visible');
    $("#div_formulario_registro").animate({scrollTop: $('#div_formulario_registro')[0].scrollHeight}, 1000);
    $("#form_registro_solicitud_curso").append(' <input type="hidden" id="editar_" name="editar_" value="1">');
    var div_respuesta = '#curso_msg';
    $.ajax({
        url: site_url + '/registro/get_detalle_curso/' + param,
        data: null,
        method: 'POST',
        beforeSend: function (xhr) {
//            $(elemento_resultado).html(create_loader());
            mostrar_loader();
        }
    })
            .done(function (data) {
                console.log(data);
                try {//Cacha el error
//                    $(div_respuesta).empty();
//                    var data = $.parseJSON(data);
                    console.log(data);
                    if (data.tp_msg == 'success') {
                        console.log("saludos");
//                            $(div_respuesta).html('<div class="alert alert-success" role="alert">' + resp.html + '</div>');
                        $('#curso').val(data.data.id_especialidad);
                        $('#categoria_docente').val(data.data.id_tipo_docente);
                        $('#anios_docente').val(data.data.anios);
                        $('#archivo_curso').val(data.data.ruta);
                        var obtuvo_pnpc = (data.data.obtuvo_pnpc == true) ? '1' : '0';
                        $('#pncp_curso').val(obtuvo_pnpc);
//                            setTimeout("$('#curso_msg').html('')", 5000);
                        console.log("termin");
                    } else {
                        $(div_respuesta).html(data.html);
                        setTimeout("$('#curso_msg').html('')", 5000);
                    }
                } catch (e) {
//                        $(div_respuesta).html(data);
                    $(div_respuesta).html('<div class="alert alert-danger" role="alert">' + data + '</div>');
                }

            })
            .fail(function (jqXHR, response) {
//                        $(div_respuesta).html(response);
                get_mensaje_general('Ocurrió un error durante el proceso, inténtelo más tarde.', 'warning', 5000);
            })
            .always(function () {
                ocultar_loader();
            });

}
function cancelar_curso() {
    $("#div_formulario_registro").css('display', 'none');
    $("#btn_agregar_curso").removeClass('hidden').addClass('visible');
    $("#btn_cancelar_curso").removeClass('visible').addClass('hidden');
    $("#btn_editar_curso").removeClass('visible').addClass('hidden');
    $("#editar_").remove();

}

function actualizar_curso() {
    var curso = $('#curso').val();
    var cat_doc = $('#categoria_docente').val();
    var solicitud = $('#solicitud_cur').val();
    $('#curso_msg').html('');

    //if (curso != '') {
    var formulario = 'form_registro_solicitud_curso';
    var formData = new FormData($('#' + formulario)[0]);
    var div_respuesta = '#curso_msg';
    $.ajax({
//                url: site_url + '/actividad_docente/datos_actividad',
        url: site_url + '/registro/guarda_cursos',
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
                    var resp = $.parseJSON(data);
                    if (typeof resp.html !== 'undefined') {
                        if (resp.tp_msg === 'success') {
                            $(div_respuesta).html('<div class="alert alert-success" role="alert">' + resp.html + '</div>');
                            get_listado_cursos(solicitud);
                            $('#curso').val('');
                            $('#categoria_docente').val('');
                            $('#anios_docente').val('');
                            $('#archivo_curso').val('');
                            //$('#pncp_curso').val('');
                            setTimeout("$('#curso_msg').html('')", 5000);
                        } else {
                            $(div_respuesta).html(resp.html);
                        }
                        if (typeof resp.mensaje !== 'undefined') {//Muestra mensaje al usuario si este existe
//                                get_mensaje_general(resp.mensaje, resp.tp_msg, 5000);
                        }
                    }
                } catch (e) {
//                        $(div_respuesta).html(data);
                    $(div_respuesta).html('<div class="alert alert-danger" role="alert">' + data + '</div>');
                }

            })
            .fail(function (jqXHR, response) {
//                        $(div_respuesta).html(response);
                get_mensaje_general('Ocurrió un error durante el proceso, inténtelo más tarde.', 'warning', 5000);
            })
            .always(function () {
                ocultar_loader();
            });
    /*} else {
     $('#curso_msg').html('<div class="alert alert-danger" role="alert">Debe seleccionar el curso y la categoría para poder agregar registros.</div>');
     }*/
}