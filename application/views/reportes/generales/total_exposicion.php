
<div>
    <div id="container" style="min-width: 310px; max-width: 800px; height: 600px; margin: 0 auto"></div>
</div>

<script type="text/javascript">
        data_grafica = <?php echo json_encode($data); ?>;
        //console.log(data_grafica);
</script>

<?php echo js("/reportes/generales/total_exposicion.js"); ?>
