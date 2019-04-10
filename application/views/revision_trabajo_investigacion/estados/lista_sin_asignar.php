<?php
 // pr($data_sin_asignar);
    if(isset($data_sin_asignar))
    {
        if($data_sin_asignar['success'])
        {
            if(count($data_sin_asignar['result']) > 0)
            {
?>
<!--  lista_revisados -->
<table class="table">
  <thead>
    <tr>
      <!-- <th scope="col"></th> -->
      <th scope="col"><?php echo $language_text['col_folio'];?></th>
      <th scope="col"><?php echo $language_text['col_titulo'];?></th>
      <th scope="col"><?php echo $language_text['col_metodologia'];?></th>
      <th scope="col"><?php echo $language_text['col_r1'];?></th>
      <th scope="col"><?php echo $language_text['col_r2'];?></th>
      <th scope="col"><?php echo $language_text['col_r3'];?></th>
      <th scope="col"><?php echo $language_text['col_puntaje'];?></th>
      <th><?php echo $language_text['col_sugerencia'];?></th>
      <th scope="col"><?php echo $language_text['col_opciones'];?></th>
    </tr>
  </thead>
  <tbody>
    <?php
    $lenguaje = obtener_lenguaje_actual();

    foreach ($data_sin_asignar['result'] as $row)
    {
      ?>
      <tr>
        <td scope="row"><?php echo $row['folio'];?></td>
        <td><?php echo $row['titulo'];?></td>
        <td>
          <?php
          $metodologia = json_decode($row['metodologia'],true);
          echo $metodologia[$lenguaje];
          ?>
        </td>
        <td><?php echo $row['revisor'];?></td>
        <td><?php echo $row['revisor'];?></td>
        <td><?php echo $row['revisor'];?></td>
        <td><?php echo $row['promedio_revision'];?></td>
        <td><?php echo $row['propuesta_dictamen'];?></td>
        <td>
          <button type="button" data-animation="flipInY" data-animation-delay="100" class="btn btn-theme btn-block submit-button"> <a href="ver_resumen" style="color:#fff;">FALTA IDIOMA</a> </button>
        </td>
      </tr>
      <?php
    }
  }
  else
  {
    ?>
    <h3>No hay trabajos aceptados!</h3>
    <?php

  }
}
else
{
  ?>
  <h3><?php echo $data_sin_asignar['msg'];?></h3>
  <?php
}
?>

</tbody>
</table>
<?php
}
else
{
  ?>
  <h3>Algo salió mal, vuelve a intentarlo más tarde!</h3>
  <?php
}
?>

<script>
$("#asignados").removeClass()
$("#sin_asignar").addClass("active")
</script>
