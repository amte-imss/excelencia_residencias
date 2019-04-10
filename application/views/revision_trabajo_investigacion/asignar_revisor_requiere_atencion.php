<div class="modal-header">
    <h3 class="modal-title" id="exampleModalLabel">Asignar revisor(es) a los folio(s): <button type="button" class="close" data-dismiss="modal" aria-label="Close">
    <span aria-hidden="true">&times;</span>
  </button></h3>
</div>
<div class="modal-body"><div id="resultado_asignacion"></div>
    <ul>
        <?php foreach ($folios as $key => $value) {
            echo "<li class='bullet-folio'>".$value."</li>";
        } ?>
    </ul>
    <?php if(isset($numero_revisores_remplazar)){ 
        echo "<h4>Se requiere asignar ".$numero_revisores_remplazar." revisor(es).</h4>
            <input type='hidden' id='numero_revisores_remplazar' name='numero_revisores_remplazar' value='".$numero_revisores_remplazar."'>";
    } ?>
    <?php echo form_open('#', array('id' => 'asignar_revisor_form', 'name' => 'asignar_revisor_form', 'autocomplete' => 'off')); ?>
    <table class="table">
      <thead>
        <tr>
          <th scope="col">Nombre</th>
          <th scope="col">Adscripción</th>
          <th scope="col">Trabajos asignados</th>
          <th scope="col">Trabajos pendientes</th>
          <th scope="col">Seleccionar</th>
        </tr>
      </thead>
      <tbody>
        <?php foreach ($revisores as $key_r => $revisor) {
            $id_usuario = encrypt_base64($revisor['id_usuario']);
            echo '<tr>
                <th scope="row">'.$revisor['nombre'].' '.$revisor['apellido_paterno'].' '.$revisor['apellido_materno'].'</th>
                <td>'.$revisor['institucion'].'</td>
                <td>'.$revisor['revisiones_realizadas'].'</td>
                <td>'.$revisor['revisiones_pendientes'].'</td>
                <td>'.$this->form_complete->create_element(array('id'=>'check_'.$id_usuario, 'type'=>'checkbox', 'value'=>$id_usuario, 'attributes'=>array('class'=>'check_asignar_usuario', 'name'=>'usuarios[]'))).'</td>
            </tr>';
        }
        ?>
      </tbody>
    </table>
    <?php 
    echo $this->form_complete->create_element(array('id'=>'folios', 'type'=>'hidden', 'value'=>implode(',', $folios_enc)));
    echo form_close(); ?>
</div>
<div class="modal-footer">
    <button type="button" id="btn_asignar" data-animation="flipInY" data-animation-delay="100" class="btn btn-theme btn-block" class="btn btn-primary">Guardar</button>
</div>
<script type="text/javascript">
$(document).ready(function () {
    $("#btn_asignar").on('click', function (e) {
        //$("#btn_asignar").attr('disabled', 'disabled');
        var numberOfChecked = $('.check_asignar_usuario:checked').length; ///Validar número de usuarios seleccionadas
        var numero_revisores_remplazar = $('#numero_revisores_remplazar').val();
        if(numberOfChecked==numero_revisores_remplazar){
            data_ajax(site_url + '/gestion_revision/asignar_revisor_requiere_atencion_bd', "#asignar_revisor_form", "#resultado_asignacion", function () {
                //alert('Yea!');
                //$('#resultado_asignacion').html('2');
            });
        } else {
            alert('Debe seleccionar '+numero_revisores_remplazar+' revisor(es).');
        }
    });
});
</script>
