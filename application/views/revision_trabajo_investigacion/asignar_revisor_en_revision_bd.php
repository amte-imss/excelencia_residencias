<script type="text/javascript">
$(document).ready(function () {
    <?php if($resultado['result']==true)
    { ?>
        alert('Se ha reasignado correctamente el revisor.');
        document.location.href=site_url + '/gestion_revision/listado_control/3';
    <?php } else { 
        echo 'alert("'.$resultado['msg'].'");';
    } ?>
});
</script>