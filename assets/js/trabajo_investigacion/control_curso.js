
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
                                $('#pncp_curso').val('');
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

function agregar_curso_() {
    var curso = $('#curso').val();
    var cat_doc = $('#categoria_docente').val();
    $('#curso_msg').html('');

    if (curso != '' && cat_doc != '') {
        html = '<div class="form-group" id="curso_' + $('#curso option:selected').val() + '" style="border: 1px solid #aaaaaa;padding: 2px;border-radius: 5px;">'
                + '<label for="curso" class="col-sm-6 control-label">' + $('#curso option:selected').text() + '<input type="hidden" name="curso[]" class="curso_class" value="' + $('#curso option:selected').val() + '" /></label>'
                + '<label for="curso" class="col-sm-5 control-label">' + $('#categoria_docente option:selected').text() + '<input type="hidden" name="categoria_docente[]" value="' + $('#categoria_docente option:selected').val() + '" /></label>'
                + '<div class="col-sm-1"><input type="button" value="X" class="btn animated flipInY visible" onclick="javascript: eliminar_curso(' + $('#curso option:selected').val() + ',\'#curso_msg\');" style="color:red;" /></div>'
                + '</div>';
        $('#curso_capa').append(html);
        $('#curso').val('');
        $('#categoria_docente').val('');
    } else {
        $('#curso_msg').html('<div class="alert alert-danger" role="alert">Debe seleccionar el curso y la categoría para poder agregar registros.</div>');
    }

}

function get_listado_cursos(solicitud) {
    var div_result = "#curso_capa";
    var path = site_url + "/registro/get_cursos_participacion/" + solicitud;
    data_ajax(path, null, div_result);
    
//    $.ajax({
//        type: "GET",
//        url: site_url + "/registro/get_cursos_participacion/" + solicitud,
//        data: null,
//        dataType: "json"
//    })
//            .done(function (result) {
//                $('#curso_capa').append(result);
//            }).fail(function () {
//    });
}

//function agregar_curso(){
//	var curso = $('#curso').val();
//	var cat_doc = $('#categoria_docente').val();
//	$('#curso_msg').html('');
//
//	if(curso != '' && cat_doc != ''){
//		html = '<div class="form-group" id="curso_'+$('#curso option:selected').val()+'" style="border: 1px solid #aaaaaa;padding: 2px;border-radius: 5px;">'
//			+'<label for="curso" class="col-sm-6 control-label">'+$('#curso option:selected').text()+'<input type="hidden" name="curso[]" class="curso_class" value="'+$('#curso option:selected').val()+'" /></label>'
//			+'<label for="curso" class="col-sm-5 control-label">'+$('#categoria_docente option:selected').text()+'<input type="hidden" name="categoria_docente[]" value="'+$('#categoria_docente option:selected').val()+'" /></label>'
//			+'<div class="col-sm-1"><input type="button" value="X" class="btn animated flipInY visible" onclick="javascript: eliminar_curso('+$('#curso option:selected').val()+');" style="color:red;" /></div>'
//		+'</div>';
//		$('#curso_capa').append(html);
//		$('#curso').val('');
//		$('#categoria_docente').val('');
//	} else {
//		$('#curso_msg').html('<div class="alert alert-danger" role="alert">Debe seleccionar el curso y la categoría para poder agregar registros.</div>');
//	}
//
//}