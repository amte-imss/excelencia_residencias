<?php
// pr($data_rechazados);
// pr($opciones_secciones);
if (!empty($data_rechazados)) {
    if ($data_rechazados['success']) {
        if (count($data_rechazados['result']) > 0) {
            ?>
            <!-- lista_rechazados -->
            <table class="table">
                <thead>
                    <tr>
                        <th scope="col"><?php echo $language_text['col_folio']; ?></th>
                        <th scope="col"><?php echo $language_text['col_titulo']; ?></th>
                        <th scope="col"><?php echo $language_text['col_metodologia']; ?></th>
                        <th scope="col"><?php echo $language_text['col_opciones']; ?></th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                    $lenguaje = obtener_lenguaje_actual();
                    foreach ($data_rechazados['result'] as $row) {
                        ?>
                        <tr>
                            <td scope="row"><?php echo $row['folio']; ?></td>
                            <td><?php echo $row['titulo']; ?></td>
                            <td><?php echo $row['metodologia']; ?></td>
                            <td>
                                <a href="<?php echo site_url() . '/registro_investigacion/ver/' . $row['folio']; ?>" type="button" data-animation="flipInY" data-animation-delay="100" >Ver trabajo <span class="glyphicon glyphicon-new-window"></span></a><br>
                                <a class="cambio_revision" type="button" data-animation="flipInY" data-tifolio="<?php echo $row['folio']; ?>" data-animation-delay="100" ><?php echo $language_text['reeval_reevaluacion']; ?> &nbsp;<span class="glyphicon glyphicon-repeat"></span></a>
                            </td>
                        </tr>
                        <?php
                    }
                } else {
                    ?>
                <h3><?php echo $opciones_secciones['rz_mensaje']; ?></h3>
                <?php
            }
        } else {
            ?>
            <h3><?php echo $mensajes['ern_mensaje']; ?></h3>
            <?php
        }
        ?>

    </tbody>
    </table>
    <?php
} else {
    ?>
    <h3><?php echo $mensajes['ern_mensaje']; ?></h3>
    <?php
}
?>
<!-- END lista_rechazados -->
<script type="text/javascript">
    $("#comite").removeClass();
    $("#atencion").removeClass();
    $("#revision").removeClass();
    $("#revisados").removeClass();
    $("#aceptados").removeClass();
    $("#rechazados").addClass("active");
    $(document).ready(function () {
        $(".cambio_revision").on('click', function (e) {
            var folio = $(this).data('tifolio');
            apprise(language_text.rechazado.reeval_confirmacion, {verify: true}, function (btnClick) {
                if (btnClick) {
                    var dataSend = {folio: folio};
                    console.log(dataSend);
                    $.ajax({
                        url: site_url + '/gestion_revision/evaluar_nuevamente',
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
//                            get_mensaje_general_evaluacion(json.message, json.tp_message, 10000);
                            alert(json.message);
                            console.log(json.tp_message);
                            if (json.tp_message == 'success') {
                            console.log(json.tp_message + 1565);
                                document.location.href = site_url + "/gestion_revision/listado_control/6";
//                            } else if (json.tp_message == 'warning') {
//                                document.location.href = site_url + "/gestion_revision/listado_control/6";
                            }
                        } catch (err) {//No es un json 
                            json = {html: "", msj: "Hola", tpmsj: "succes"}
                        }
                    }).fail(function (jqXHR, textStatus) {
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
        });
    });
</script>
