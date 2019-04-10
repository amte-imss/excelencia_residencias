<script type="text/javascript">
$(document).ready(function () {
    <?php if($resultado['result']==true)
    { ?>
        alert('Se han asignado correctamente los revisores.');
        document.location.href=site_url + '/gestion_revision/listado_control/2';
    <?php } else { 
        echo 'alert("'.$resultado['msg'].'");';
    } ?>
});
</script>