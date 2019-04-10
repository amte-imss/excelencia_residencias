<?php ?>
<script src="<?php echo asset_url(); ?>highcharts/highcharts.js"></script>
<script src="<?php echo asset_url(); ?>highcharts/data.js"></script>
<script src="<?php echo asset_url(); ?>highcharts/modules/exporting.js"></script>

<script type="text/javascript">
    data_grafica_umae = <?php echo json_encode($top['umae']); ?>;
    data_grafica_delegacion = <?php echo json_encode($top['delegacion']); ?>;
</script>

<div class="schedule-tabs lv2">
    <ul id="tabs-lv21"  class="nav nav-justified">
        <li class="active"><a href="#tab-lv21-first" data-toggle="tab">UMAE</a></li>
        <li><a href="#tab-lv21-second"  data-toggle="tab">Delegación</a></li>
    </ul>
</div>

<div class="tab-content lv2">
    <div id="tab-lv21-first" class="tab-pane fade in active">
        <div class="ajuste">
            <div id="grafica_umae" style="width:100%; height:400px;"></div>
        </div>
    </div>
    <div id="tab-lv21-second" class="tab-pane fade in ">
        <div class="ajuste">
            <div id="grafica_delegacion" style="width:100%; height:400px;"></div>
        </div>
    </div>
</div>

<?php echo js('reportes/imss/top.js'); ?>
<script>
    $("#calidad").removeClass();
    $("#top_evaluados").removeClass();
    $("#porcentaje_registrados").removeClass();
    $('#calidad_seccion').removeClass();
    $("#top_registrados").addClass("active");
</script>