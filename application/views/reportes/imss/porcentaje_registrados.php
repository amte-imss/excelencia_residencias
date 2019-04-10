<?php
//pr($data);
?>

<script type="text/javascript">
    data_grafica = <?php echo json_encode($data); ?>;
</script>
<?php echo js('reportes/imss/porcentaje.js'); ?>
<div class="schedule-tabs lv2">
    <ul id="tabs-lv21"  class="nav nav-justified">
        <li class="in active"><a href="#tab-lv21-first" data-toggle="tab">Nivel de atención</a></li>
        <li><a href="#tab-lv21-second" data-toggle="tab">UMAE</a></li>
        <li><a href="#tab-lv21-third" data-toggle="tab">Delegación</a></li>
    </ul>
</div>

<div class="tab-content lv2">
    <div id="tab-lv21-first" class="tab-pane fade in active">
        <div class="ajuste">
            <div id="grafica_nivel_atencion" style="height: 600px; "></div>
            <!--<div id="grafica_delegacion" style="min-width: 310px; height: 400px; max-width: 600px; margin: 0 auto"></div>-->
            <br>
            <div><p id="pie_porcentaje_nivel"> *<?php echo $language_text['reportes_imss']['nota_porcentaje_nivel']; ?> </p></div>

        </div>
    </div>
    <div id="tab-lv21-second" class="tab-pane fade in">
        <div class="ajuste">
            <div id="grafica_umae" style="height: 600px; "></div>
            <br>
            <div><p id="pie_porcentaje_umae"> *<?php echo $language_text['reportes_imss']['nota_porcentaje_umae']; ?> </p></div>
            <!--<div id="grafica_delegacion" style="min-width: 310px; height: 400px; max-width: 600px; margin: 0 auto"></div>-->
        </div>
    </div>
    <div id="tab-lv21-third" class="tab-pane fade in">
        <div class="ajuste">
            <div id="grafica_delegacion" style="width: 100%; height: 400px;"></div>
            <br>
            <div><p id="pie_porcentaje_del"> *<?php echo $language_text['reportes_imss']['nota_porcentaje_del']; ?> </p></div>
        </div>
    </div>
</div>
<script type="text/javascript">
    $("#top_registrados").removeClass();
    $("#top_evaluados").removeClass();
    $("#calidad").removeClass();
    $('#calidad_seccion').removeClass();
    $("#porcentaje_registrados").addClass("active");
</script>
