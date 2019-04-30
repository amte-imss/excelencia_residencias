<style type="text/css">
    #div_carrera_categoria{
        display: none;
    }

    .div-borde {
        margin-top: 4px;
        border: #cdcdcd 1px solid;
        border-radius: 5px;
        -moz-border-radius: 5px;
        -webkit-border-radius: 5px;
        padding: 0.2em;
    }
   .control-label{
        font-size:13px;
    }

    .delrow{
        visibility: hidden;
    }

    .table{
        font-size:13px;
    }
</style>

<div class="panel panel-default from-trabajos">
    <h3 class="page-head-line text-center"><?php echo $language_text['registro_excelencia']['titulo_registro']; ?></h3>
    <div class="panel-body">
        <div class="container">
            <div class="row">
                <div class="col-sm-offset-1 col-sm-10 panel">
                    <div class="panel-heading"><h2><?php echo $language_text['registro_excelencia']['reg_titulo_general']; ?></h2></div>
                    <div class="panel-body">

                        <div class="col-sm-6">
                            <div class="div-borde" >
                                <label class="control-label"> <strong><?php echo $language_text['registro_excelencia']['reg_matricula']; ?>:</strong></label><br>
                                <label class="control-label"><?php echo $datos_generales['matricula']; ?></label>
                            </div>
                        </div>

                        <div class="col-sm-6">
                            <div class="div-borde" >
                                <label class="control-label"> <strong>Nombre:</strong></label><br>
                                <label class="control-label"><?php echo $datos_generales['nombre'] . " " . $datos_generales['apellido_paterno'] . " " . $datos_generales['apellido_materno']; ?></label>
                            </div>
                        </div>

                        <div class="col-sm-6">
                            <div class="div-borde" >
                                <label class="control-label"> <strong><?php echo $language_text['registro_excelencia']['reg_delegacion']; ?></strong></label><br>
                                <label class="control-label"><?php echo $datos_generales['delegacion']; ?></label>
                            </div>
                        </div>

                        <div class="col-sm-6">
                            <div class="div-borde" >
                                <label class="control-label"> <strong>Unidad:</strong></label><br>
                                <label class="control-label"><?php echo $datos_generales['unidad']; ?></label>
                            </div>
                        </div>

                        <div class="col-sm-6">
                            <div class="div-borde" >
                                <?php
                                $si = '';
                                $no = '';
                                $result = '';
                                if (isset($solicitud_excelencia['carrera_tiene'])) {
                                    if ($solicitud_excelencia['carrera_tiene'] == '0') {
                                        //$no = 'checked';
                                        $result = 'NO';
                                    } else {
                                        //$si = 'checked';
                                        $result = 'SI';
                                    }
                                }
                                ?>
                                <label class="control-label"> <strong><?php echo $language_text['registro_excelencia']['carrera_tiene']; ?>:</strong></label><br>
                                <?php echo $result; ?>
                                <!--input type="radio" name="carrera" value="1" <?php //echo $si; ?> disabled >&nbsp <?php //echo $language_text['template_general']['si_op']; ?><br>
                                <input type="radio" name="carrera" value="0" <?php //echo $no; ?> disabled>&nbsp <?php //echo $language_text['template_general']['no_op']; ?> -->
                            </div>
                        </div>

                        <div class="col-sm-6">
                            <div class="div-borde" >
                                <label class="control-label"> <strong><?php echo $language_text['registro_excelencia']['tipo_categoria']; ?>:</strong></label><br>
                                <div>
                                    <!--select id="tipo_categoria" name="tipo_categoria" class="form-control" <?php
                                        /*if (isset($solicitud_excelencia['id_solicitud'])) {
                                            echo 'disabled';
                                        }
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
                                        }*/
                                        ?>
                                    </select -->
                                    <?php foreach ($tipo_categoria as $key => $value) {
                                            if (isset($solicitud_excelencia)) {
                                                if ($solicitud_excelencia['carrera_categoria'] == $key) {
                                                    //echo '<option value="' . $key . '" selected>' . $value . '</option>';
                                                    echo $value;
                                                }
                                            }
                                        } ?>
                                </div>

                            </div>
                            
                        </div>

                        <div class="col-sm-6">
                            <div class="div-borde" >
                                <label class="control-label"> <strong>Categoría:</strong></label><br>
                                <label class="control-label"><?php echo $datos_generales['categoria']; ?></label>
                            </div>
                        </div><br><br>

                        </div>
                        <?php if (isset($cursos_participacion)) { ?>
                            <div id="revision_cursos" class="col-sm-12 col-lg-12 col-md-12">
                                <?php echo $cursos_participacion; ?>
                            </div>
                        <?php } ?>

                        <?php if (isset($documentos_participacion)) { ?>
                            <div id="revision_documentos" class="col-sm-12 col-lg-12 col-md-12">
                                <?php echo $documentos_participacion; ?>
                            </div>
                        <?php } ?>
                    </div>
                    <hr>
                </div>
            </div>
        </div>
    </div>
</div><!--col-->

<?php //echo js('trabajo_investigacion/control_revision.js'); ?>