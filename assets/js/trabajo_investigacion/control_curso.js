var monitor_formulario = false;
function reinicia_monitor() {
    monitor_formulario = false;//Reinicia el monitor
}
function activa_monitor() {
    monitor_formulario = true;//Reinicia el monitor
}
function status_monitos() {
    return monitor_formulario;//estado el monitor
}

function elemento(e) {
    var tag;
    if (e.srcElement)
        tag = e.srcElement.tagName;
    else if (e.target)
        tag = e.target.tagName;
    if (e.srcElement.type === "button") {
        return true;
    }
    switch (tag) {
        case 'SELECT':
            activa_monitor();//Activa el monitor como actualización del formulario
        case 'INPUT':
            activa_monitor();//Activa el monitor como actualización del formulario
            break;
        case 'BUTTON':
            if (e.target.name != 'cancel' && e.target.name != 'save') {
                activa_monitor();//Activa el monitor como actualización del formulario
            }
            break;
        default :
    }
}

function agregar_curso() {
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
                            setTimeout("$('#curso_msg').html('')", 6000);
                            cambio_botones_formulario("reiniciar");
                            $('#pncp_curso').val('');
                            $('#curso').val('');
                            $('#categoria_docente').val('');
                            $('#anios_docente').val('');
                            $('#archivo_curso').val('');
                            get_listado_cursos(solicitud);
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
    cambio_botones_formulario('actualizacion');
    $("#div_formulario_registro").animate({scrollTop: $('#div_formulario_registro')[0].scrollHeight}, 1000);
    $("#form_registro_solicitud_curso").append('<input type="hidden" id="editar_" name="editar_" value="1">');
    $("#form_registro_solicitud_curso").append('<input type="hidden" id="curso_row" name="curso_row" value="' + param + '">');
    reinicia_monitor();
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
                try {//Cacha el error
                    if (data.tp_msg == 'success') {
//                        $(div_respuesta).html('<div class="alert alert-success" role="alert">' + data.html + '</div>');
                        $('#curso').val(data.data.id_especialidad);
                        $('#categoria_docente').val(data.data.id_tipo_docente);
                        $('#anios_docente').val(data.data.anios);
                        var obtuvo_pnpc = (data.data.obtuvo_pnpc == true) ? '1' : '0';
                        $('#pncp_curso').val(obtuvo_pnpc);
                    } else {
                        $(div_respuesta).html(data.html);
                        setTimeout("$('#curso_msg').html('')", 5000);
                    }
                } catch (e) {
//                        $(div_respuesta).html(data);
                    cambio_botones_formulario('reiniciar');
                    $(div_respuesta).html('<div class="alert alert-danger" role="alert">' + data + '</div>');
                }

            })
            .fail(function (jqXHR, response) {
//                        $(div_respuesta).html(response);
                cambio_botones_formulario('reiniciar');
                get_mensaje_general('Ocurrió un error durante el proceso, inténtelo más tarde.', 'warning', 5000);
            })
            .always(function () {
                ocultar_loader();
            });

}
function cancelar_curso() {

    if (status_monitos()) {
        var r = confirm("Los cambios se perderan. Por favor confirme que desea cancelar");
        if (r === true) {
//            $("#div_formulario_registro").css('display', 'none');
            cambio_botones_formulario('reiniciar');
            $("#editar_").remove();
            $("#curso_row").remove();
            $('#curso').val('');
            $('#categoria_docente').val('');
            $('#anios_docente').val('');
            $('#pncp_curso').val('');
            $('#archivo_curso').val('');
        }
    } else {
//        $("#div_formulario_registro").css('display', 'none');
        cambio_botones_formulario('reiniciar');
        $("#editar_").remove();
        $("#curso_row").remove();
        $('#curso').val('');
        $('#categoria_docente').val('');
        $('#anios_docente').val('');
        $('#pncp_curso').val('');
        $('#archivo_curso').val('');
    }

}

function cambio_botones_formulario(param) {
    if (param == 'reiniciar') {
        $("#btn_agregar_curso").removeClass('hidden').removeClass('visible').addClass('visible');
        $("#btn_cancelar_curso").removeClass('visible').removeClass('visible').addClass('hidden');
        $("#btn_editar_curso").removeClass('visible').removeClass('visible').addClass('hidden');
        return 1;
    }
    if (param == 'actualizacion') {
        $("#btn_agregar_curso").removeClass('visible').removeClass('visible').addClass('hidden');
        $("#btn_cancelar_curso").removeClass('hidden').removeClass('visible').addClass('visible');
        $("#btn_editar_curso").removeClass('hidden').removeClass('visible').addClass('visible');
        return 1;
    }

}

