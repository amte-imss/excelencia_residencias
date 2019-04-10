<?php // pr($data);
?>
<!--<script src="https://code.highcharts.com/modules/bullet.js"></script>-->

<div >
    <div id="progressBar" style="min-width: 310px; max-width: 800px; height: 600px; margin: 0 auto"></div>
</div>

<script type="text/javascript">
        data_grafica = <?php echo json_encode($data); ?>;
</script>

<?php echo js("/reportes/calidad/totales_nacionales_extranjeros.js"); ?>
