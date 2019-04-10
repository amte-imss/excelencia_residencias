

<div class="content-area">
    <div class="container">
        <h1 class="section-title">
            <span data-animation="flipInY" data-animation-delay="300" class="icon-inner"><span class="fa-stack"><i class="fa rhex fa-stack-2x"></i><i class="fa fa-star fa-stack-1x"></i></span></span>
            <span data-animation="fadeInRight" data-animation-delay="500" class="title-inner"><?php echo $language_text['evaluacion']['eva_tra_investigacion'] ?></span>
            
        </h1>
        <div>
            <!-- <div id="main"> -->
            <section class="">
                <div class="container">
                    <div class="row">
                        <style type="text/css">
                            .titulo{
                                font-weight: 500;
                                color:#333;
                            }
                            .div-borde {
                                margin-top:10px;
                                border: #cdcdcd medium solid;
                                border-radius: 5px;
                                -moz-border-radius: 5px;
                                -webkit-border-radius: 5px;
                                padding: 0.5em;
                            }
                        </style>
                        <div id="mensaje_notificacion" class="alert alert-warning alert-dismissible fade show" role="alert">
                            <strong id="msg_notificacion"></strong>
                            <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                            </button>
                        </div>
                        <div class="sectionEvaluacion" id="secTrabajoInv">
                            <h3>
                                <?php echo $language_text['evaluacion']['lbl_tr_ev'] ?>
                            </h3>
                            <img src="<?php echo asset_url(); ?>img/arrowdown.png" alt="">
                        </div>
                        <div id="hideTrabajo" class="panel panel-default" style="display:none;">
                            <?php echo $trabajo_investigacion; ?>
                        </div>
                        <div class="sectionEvaluacion" id="secEvaluacion">
                            <h3>
                                <?php echo $language_text['evaluacion']['lbl_eval'] ?>
                            </h3>
                            <img src="<?php echo asset_url(); ?>img/arrowdown.png" alt="">
                        </div>
                        <div id="hideEvaluacion" class="panel panel-default" style="display:none;">
                            <div class="panel-body">
                                <?php echo form_open('' . $datos['folio'], array('id' => 'form_evaluacion')); ?>
                                <input type="hidden" value="<?php echo $datos['folio']; ?>" name="folio">
                                <input type="hidden" value="<?php echo $datos['id_tipo_metodologia']; ?>" name="tipo_metodologia">
                                <input type="hidden" value="1" name="tabseccioncontrol_one" id="tabseccioncontrol_one">
                                
                                <div id="eval_principal">
                                    <?php echo $evaluacion; ?>
                                </div>
                                <?php echo form_close(); ?>
                                <section id="sec_b">
                                    <button class="btn btn-theme btn-block submit-button animated flipInY visible" onclick="evaluacion(this);"><?php echo $language_text['evaluacion']['btn_aceptar']; ?><i class="fa fa-arrow-circle-right"></i></button>
                                </section>
                            </div>
                        </div>
                    </div>
                </div>
            </section>
        </div>
    </div>
</div>

<?php echo css("revision/evaluacion_revisor.css"); ?>
<?php echo js("revision/funcionalidad_cascada.js"); ?>
<?php echo js("revision/revision_evaluacion.js"); ?>
<script type="text/javascript">
    jQuery(document).ready(function () {
        theme.init();
        theme.initMainSlider();
        theme.initCountDown();
        theme.initPartnerSlider();
        theme.initTestimonials();
        theme.initGoogleMap();
    });
    jQuery(window).load(function () {
        theme.initAnimation();
    });

    jQuery(window).load(function () {
        jQuery('body').scrollspy({offset: 100, target: '.navigation'});
    });
    jQuery(window).load(function () {
        jQuery('body').scrollspy('refresh');
    });
    jQuery(window).resize(function () {
        jQuery('body').scrollspy('refresh');
    });

    jQuery(document).ready(function () {
        theme.onResize();
    });
    jQuery(window).load(function () {
        theme.onResize();
    });
    jQuery(window).resize(function () {
        theme.onResize();
    });

    jQuery(window).load(function () {
        if (location.hash != '') {
            var hash = '#' + window.location.hash.substr(1);
            if (hash.length) {
                jQuery('html,body').delay(0).animate({
                    scrollTop: jQuery(hash).offset().top - 44 + 'px'
                }, {
                    duration: 1200,
                    easing: "easeInOutExpo"
                });
            }
        }
    });

</script>
