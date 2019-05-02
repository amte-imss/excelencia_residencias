<?php foreach ($css_files as $file): ?>
    <link type="text/css" rel="stylesheet" href="<?php echo $file; ?>" />
<?php endforeach; ?>
<?php foreach ($js_files as $file): ?>
    <script src="<?php echo $file; ?>"></script>
<?php endforeach; ?>

<div ng-class="panelClass" class="row">
    <div class="col col-sm-12">
        <div class="panel panel-default">
            <div class="panel-heading">
                <h3 class="panel-title">Notificaciones</h3>
            </div>
            <div class="panel-body"><br>
                <div class="row">
                    <div class="col-lg-12 col-md-12 col-sm-12">
                        <div class="row" style="margin:5px;">
                            <div class="table table-container-fluid panel">
                                <div class="col-sm-12">
                                    <button 
                                        id="btn_enviar_correos_faltantes" 
                                        name="btn_enviar_correos_faltantes" 
                                        type="button"
                                        data-divmsg="msg_cerrar_proceso"
                                        onclick="javascript:envio_correos(this);"
                                        class="col-sm-6 btn btn-theme animated flipInY visible" 
                                        type="button">Enviar correos
                                    </button> 
<!--                                        style="background-color:#D4C19C; border-color:#D4C19C;" -->
                                    <br><br><br>
                                </div>
                                <div id="msg_cerrar_proceso" class="col-sm-12">
                                </div>
                                <!--<a href="javascript:history.back()" class="btn btn-success" style=" background-color:#008EAD">Regresar</a>-->  
                                <?php echo $output; ?>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
    function envio_correos(element) {
            var prop = $(element);
            var div_respuesta = '#' + prop.data('divmsg');
            $.ajax({
//                url: site_url + '/actividad_docente/datos_actividad',
                url: site_url + '/gestion_revision/envio_correos_pendientes',
//            data: null,
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
                                } else if (resp.tp_msg === 'danger') {
                                    $(div_respuesta).html('<div class="alert alert-danger" role="alert">' + resp.html + '</div>');
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
</script>        