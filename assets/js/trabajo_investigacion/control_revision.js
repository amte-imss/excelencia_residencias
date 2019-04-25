$(document).ready(function () {
    $('#btn_finalizar_revision').click(function () {
        finalizar_validacion(this);
    });
});

function guardar_validacion_doc(element) {
    var prop = $(element);
    var formulario = prop.data('formulario');
    var div_respuesta = '#' + prop.data('divmsg');
    var formData = new FormData($('#' + formulario)[0]);
    $.ajax({
//                url: site_url + '/actividad_docente/datos_actividad',
        url: site_url + '/revision/guarda_validacion_documentos',
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
                            setTimeout("$('" + div_respuesta + "').html('')", 10000);
                        } else if (resp.tp_msg === 'warning') {
                            $(div_respuesta).html('<div class="alert alert-warning" role="alert">' + resp.html + '</div>');
                            setTimeout("$('" + div_respuesta + "').html('')", 15000);
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
            })
            .always(function () {
                ocultar_loader();
            });
}

function guardar_validacion_cursos(element) {
    var prop = $(element);
    var formulario = prop.data('formulario');
    var div_respuesta = '#' + prop.data('divmsg');
    var formData = new FormData($('#' + formulario)[0]);
    $.ajax({
//                url: site_url + '/actividad_docente/datos_actividad',
        url: site_url + '/revision/guarda_validacion_cursos',
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
                            setTimeout("$('" + div_respuesta + "').html('')", 10000);
                        } else if (resp.tp_msg === 'warning') {
                            $(div_respuesta).html('<div class="alert alert-warning" role="alert">' + resp.html + '</div>');
                            setTimeout("$('" + div_respuesta + "').html('')", 15000);
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
            })
            .always(function () {
                ocultar_loader();
            });
}

function finalizar_validacion(element) {
    console.log("Enviar ");
    var prop = $(element);
    var formulario = prop.data('formulario');
    var div_respuesta = '#' + prop.data('divmsg');
    var formData = new FormData($('#' + formulario)[0]);
    $.ajax({
//                url: site_url + '/actividad_docente/datos_actividad',
        url: site_url + '/revision/terminar_revision',
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
                            $("#btn_finalizar_revision").removeClass('visible').addClass('hidden');
                            $("#btn_guardar_validaion_documentos").removeClass('visible').addClass('hidden');
                            $("#btn_guardar_validaion_cursos").removeClass('visible').addClass('hidden');
                            $(div_respuesta).html('<div class="alert alert-success" role="alert">' + resp.html + '</div>');
                            setTimeout("$('" + div_respuesta + "').html('')", 6000);
                            var link = site_url + '/revision/solicitud_revision';
                            setTimeout("location.href ='" + link + "'", 4000);
                        } else if (resp.tp_msg === 'warning') {
                            $(div_respuesta).html('<div class="alert alert-warning" role="alert">' + resp.html + '</div>');
                            setTimeout("$('" + div_respuesta + "').html('')", 15000);
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
            })
            .always(function () {
                ocultar_loader();
            });
}

