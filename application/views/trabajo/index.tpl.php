<?php //pr($language_text); ?>
<div class="panel panel-default">
    <h1 class="page-head-line text-center"><?php echo $language_text['listado_trabajo']['titulo_seccion']; ?></h1>
    <div class="panel-body">
        <div>
            <div class="row">
                <div class="col-sm-offset-1 col-sm-10">
                    <?php
                    if (isset($alerta)) {
                        echo '<div class="alert alert-' . $alerta['msg_type'] . '">';
                        echo $alerta['msg'] . ' <strong>' . $alerta['folio'] . '</strong>';
                        ?>
                        <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                        <?php
                        echo '</div>';
                    }
                    ?>
                </div>
            </div>
            <?php if ($convocatoria_activa) { ?>
                <div class="row">
                    <div class="col-sm-offset-8 col-md-4">
                        <a href="<?php echo site_url('registro_investigacion/nuevo'); ?>" class="btn btn-theme animated flipInY visible pull-right"><?php echo $language_text['listado_trabajo']['registrar_nuevo']; ?></a>
                    </div>
                </div><!--row-->
            <?php } ?>
            <br><br>
            <div class="row">
                <div class="col-sm-offset-1 col-sm-10">
                    <div class="table-responsive">
                        <table class="table table-striped table-bordered">
                            <tr>
                                <th><?php echo $language_text['listado_trabajo']['folio']; ?></th>
                                <th><?php echo $language_text['listado_trabajo']['titulo_ttabla']; ?></th>
                                <th><?php echo $language_text['listado_trabajo']['tipo_metodologia_tabla']; ?></th>
                                <th><?php echo $language_text['listado_trabajo']['fecha_registro']; ?></th>
                                <th><?php echo $language_text['listado_trabajo']['estado_trabajo']; ?></th>
                                <th></th>
                            </tr>
                            <?php
                            if (isset($listado)) {
                                foreach ($listado as $key => $value) {
                                    echo '<tr>';
                                    echo '<td>' . $value['folio'] . '</td>';
                                    echo '<td>' . $value['titulo'] . '</td>';
                                    echo '<td>' . $value['nombre_metodologia'] . '</td>';
                                    echo '<td>' . $value['fecha'] . '</td>';
                                    echo '<td>' . $value['estado_trabajo'] . '</td>';
                                    $site = site_url('registro_investigacion/ver/' . $value['folio']);
                                    echo '<td><a href="' . $site . '" class="btn btn-theme animated flipInY visible pull-right"><i class="fa fa-eye" aria-hidden="true"></i></a></td>';
                                    echo '</tr>';
                                }
                            } else {
                                echo '<tr><td colspan="6"><center>' . $language_text['listado_trabajo']['sin_datos_detalle'] . '</center></td></tr>';
                            }
                            ?>
                        </table>
                    </div>
                </div>
            </div><!--row-->
        </div>
    </div>
</div>
