<?php // pr($data);?>
<div >
    <div  id="progressBar" style="min-width: 310px; max-width: 800px; height: 400px; margin: 0 auto"></div>
</div>

<script type="text/javascript">
        data_grafica = <?php echo json_encode($data); ?>;
</script>

<?php echo js("/reportes/calidad/calidad_extranjeros_externos_institucionales_nacionales.js"); ?>
