<?php foreach ($bibliotecas_graficas as $value) { ?>
    <script src = "<?php echo asset_url() . $value; ?>"></script>
<?php } ?>
<?php echo js("/reportes/general_reportes.js"); ?>

<!-- listas de reportes generales -->

<!-- Content area -->
<div class="content-area">

    <!-- <div id="main"> -->
    <section class="page-section background-img">
        <div class="container">
            <div class="row">
                <div data-vc-full-width="true" data-vc-full-width-init="true" class="vc_row wpb_row vc_row-fluid vc_custom_1465704297829 vc_row-has-fill" style="position: relative; left: -89.5px; box-sizing: border-box; width: 1349px; padding-left: 89.5px; padding-right: 89.5px;">
                    <div class="wpb_column vc_column_container vc_col-sm-8">
                        <div class="vc_column-inner ">
                            <div class="wpb_wrapper">
                                <h3 class="section-title">
                                    <span data-animation="flipInY" data-animation-delay="300" class="icon-inner animated flipInY visible"><span class="fa-stack"><i class="fa rhex fa-stack-2x"></i><i class="fa fa-question fa-stack-1x"></i></span></span>
                                    <span data-animation="fadeInRight" data-animation-delay="500" class="title-inner animated fadeInRight visible">Reportes generales</span><br><br>
                                </h3>
                            </div>
                        </div>
                    </div>
                    <div class="wpb_column vc_column_container vc_col-sm-4">
                        <div class="vc_column-inner ">
                            <div class="wpb_wrapper">
                            </div>
                        </div>
                    </div>
                    <div class="wpb_column vc_column_container vc_col-sm-12">
                        <div class="vc_column-inner vc_custom_1417508840067">
                            <div class="wpb_wrapper">
                                <div class="row faq   animated fadeInUp visible" data-animation="fadeInUp" data-animation-delay="100">
                                    <div class="col-md-4">
                                        <ul id="tabs-faq" class="style1 nav">
                                            <li class="control in active" id="tab_1"><a href="<?php echo base_url("index.php/reportes_generales/reportes/1"); ?>" ><i class="fa fa-plus"></i> <span class="faq-inner"><?php echo $language_text['reportes_generales']['tab_t_exposiciones']; ?></span></a></li>
                                            <li class="control" id="tab_2"><a href="<?php echo base_url("index.php/reportes_generales/reportes/2"); ?>"><i class="fa fa-plus"></i> <span class="faq-inner"><?php echo $language_text['reportes_generales']['tab_t_nac_ext']; ?></span></a></li>
                                            <li class="control" id="tab_3"><a href="<?php echo base_url("index.php/reportes_generales/reportes/3"); ?>" ><i class="fa fa-plus"></i> <span class="faq-inner"><?php echo $language_text['reportes_generales']['tab_t_genero']; ?></span></a></li>
                                            <li id="tab_4" class="control"> <a href="<?php echo base_url("index.php/reportes_generales/reportes/4"); ?>"><i class="fa fa-plus"></i><span class="faq-inner"><?php echo $language_text['reportes_calidad']['total_trabajos']; ?></strong> <br/></a></li>
                                            <li id="tab_5" class="control"> <a href="<?php echo base_url("index.php/reportes_generales/reportes/5"); ?>"><i class="fa fa-plus"></i><span class="faq-inner"><?php echo $language_text['reportes_calidad']['calidad_ext_nac_ins']; ?></strong></a></li>
                                            <li id="tab_6" class="control"> <a href="<?php echo base_url("index.php/reportes_generales/reportes/6"); ?>"><i class="fa fa-plus"></i><span class="faq-inner"><?php echo $language_text['reportes_calidad']['calidad_genero']; ?></strong> <br/></a></li>
                    <!-- <li class="active"><a href="#tab-981039400543" data-toggle="tab"><i class="fa fa-angle-right"></i> <span class="faq-inner">Calidad de trabajos IMSS nacionales</span></a></li> -->
                                        </ul>
                                    </div>
                                    <div class="col-sm-8 col-md-8 pull-right">
                                        <div class="tab-content">
                                            <div class="tab-pane fade active in">
                                                <!-- grafica -->
                                                <?php
                                                if (isset($view_reporte)) {
                                                    echo $view_reporte;
                                                }
                                                ?>
                                            </div>

                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
</div>


<script type="text/javascript">
    $(document).ready(function () {
        select_tabs_data();
    });

    function select_tabs_data() {
        var seccion = <?php echo $tabs; ?>;
        $('.control').each(function () {
            $(this).removeClass("in active");
        });
        $('#tab_' + seccion).addClass("in active");
    }
</script>
