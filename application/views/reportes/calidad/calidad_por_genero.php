<?php // pr($data);?>
<div >
    <div  id="progressBar" style="min-width: 310px; max-width: 800px; height: 400px; margin: 0 auto"></div>
</div>

<script type="text/javascript">
        data_grafica = <?php echo json_encode($data); ?>;
        //total = data_grafica.data[0].total;
        //console.log(total);
</script>

<?php echo js("/reportes/calidad/calidad_por_genero.js"); ?>
