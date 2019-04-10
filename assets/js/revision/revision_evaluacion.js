$(document).ready(function () {
});

function evaluacion(element) {
//    data_ajax_print(site_url + "/revision/guardar_evaluacion_revision", "#form_evaluacion", "#eval_principal", "resultado_evaluacion", "get_mensaje_general_evaluacion");
    resultado_evaluacion(site_url + "/evaluacion/guardar_evaluacion", "#form_evaluacion", "#eval_principal", "resultado_evaluacion");

}

function resultado_evaluacion(path, form_recurso, elemento_resultado) {
    //mostrar_loader();
    apprise('Confirme que realmente desea continuar', {verify: true}, function (btnClick) {
        if (btnClick) {
            var dataSend = $(form_recurso).serialize();
            $.ajax({
                url: path,
                data: dataSend,
                method: 'POST',
                beforeSend: function (xhr) {
//            $(elemento_resultado).html(create_loader());
                    mostrar_loader();
                }
            }).done(function (response) {
                var json = null;
                try {
                    json = JSON.parse(response);
                    console.log(json);
                    $(elemento_resultado).html(json.html);
                    get_mensaje_general_evaluacion(json.message, json.tp_message, 10000);
                    if (json.tp_message == 'success') {
                        $(elemento_resultado).html("");
                        alert(json.message);
                        document.location.href = site_url + "/revision/trabajos_investigacion_evaluacion";
                    } else if (json.tp_message == 'warning') {
                        document.location.href = site_url + "/revision/trabajos_investigacion_evaluacion";

                    }
                } catch (err) {//No es un json 
                    json = {html: "", msj: "Hola", tpmsj: "succes"}
                    $(elemento_resultado).html(response);
                }
            }).fail(function (jqXHR, textStatus) {
                $(elemento_resultado).html("Ocurrió un error durante el proceso, inténtelo más tarde.");
            }).always(function () {
                remove_loader();
                ocultar_loader();
            });
        } else {
            remove_loader();
            ocultar_loader();
            return false;
        }
    });
}

function get_mensaje_general_evaluacion(mensaje, tipo_mensaje, timeout) {
    $('#mensaje_notificacion').removeClass('alert-danger fade').removeClass('alert-success fade').removeClass('alert-info fade').removeClass('alert-warning fade');
    $('#mensaje_notificacion').addClass('alert-' + tipo_mensaje + " alert-dismissible");
    $('#msg_notificacion').html(mensaje);
    $('#mensaje_notificacion').show();
    setTimeout("$('#mensaje_notificacion').addClass('fade')", timeout);
}



