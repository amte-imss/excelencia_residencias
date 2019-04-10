<?php //pr($language_text);      ?>
<!-- listas de estados -->
<?php foreach ($bibliotecas_graficas as $value) { ?>
    <script src = "<?php echo asset_url() . $value; ?>"></script>
<?php } ?>

<div class="wpb_column vc_column_container vc_col-sm-8">
    <div class="vc_column-inner ">
        <div class="wpb_wrapper">
            <h3 class="section-title">
                <span data-animation="flipInY" data-animation-delay="300" class="icon-inner animated flipInY visible"><span class="fa-stack"><i class="fa rhex fa-stack-2x"></i><i class="fa fa-question fa-stack-1x"></i></span></span>
                <span data-animation="fadeInRight" data-animation-delay="500" class="title-inner animated fadeInRight visible">Reportes IMSS</span><br><br>
            </h3>
        </div>
    </div>
</div>

<div class="schedule-wrapper clear" data-animation="fadeIn" data-animation-delay="200">
    <div class="schedule-tabs lv1">
        <ul id="tabs-lv1"  class="nav nav-justified">
            <li class="tab_reporte_calidad" id="top_registrados" data-tab="1"> <a href="<?php echo base_url("index.php/reportes_institucion/reportes/1"); ?>"><strong><?php echo $language_text['reportes_imss']['tab_top']; ?></strong> <br/></a></li>
            <li class="tab_reporte_calidad" id="porcentaje_registrados" data-tab="2"> <a href="<?php echo base_url("index.php/reportes_institucion/reportes/2"); ?>" ><strong><?php echo $language_text['reportes_imss']['tab_porcentaje']; ?></strong> <br/></a></li>
            <li class="tab_reporte_calidad" id="calidad" data-tab="3"> <a href="<?php echo base_url("index.php/reportes_institucion/reportes/3"); ?>"><strong><?php echo $language_text['reportes_imss']['tab_calidad']; ?></strong> <br/></a></li>
            <li class="tab_reporte_calidad" id="top_evaluados" data-tab="4"> <a href="<?php echo base_url("index.php/reportes_institucion/reportes/4"); ?>"><strong><?php echo $language_text['reportes_imss']['tab_top_evaluados'];?></strong> <br/></a></li>
            <li class="tab_reporte_calidad" id="calidad_seccion" data-tab="5"> <a href="<?php echo base_url("index.php/reportes_institucion/reportes/5"); ?>"><strong><?php echo $language_text['reportes_imss']['tab_calidad_seccion'];?></strong> <br/></a></li>
        </ul>
    </div>
    <div class="tab-content lv1">
        <!--<div class="tab-pane fade in active">-->
        <!--<div class="tab-content lv2">
          <div id="tab-lv21-comite" class="tab-pane fade in active">-->
        <?php
        if (isset($view_reporte)) {
            echo $view_reporte;
        }
        ?>
        <!--</div>-->
        <!--</div>-->
        <!--</div>-->
    </div>
</div>

<?php echo js("/reportes/general_reportes.js"); ?>
