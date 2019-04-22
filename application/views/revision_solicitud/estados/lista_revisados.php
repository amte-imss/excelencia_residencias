<!-- contadores de lugares para oratoria y lugares para cartel -->
<div class="col-sm-12">
  <div class="col-sm-3">
    <h4 class="text-center"> <?php echo $language_text['lbl_oral'];?></h4>
    <h3 class="text-center">10 / 20</h3>
  </div>
  <div class="col-sm-3">
    <h4 class="text-center"> <?php echo $language_text['lbl_cartel'];?></h4>
    <h3 class="text-center">10 / 20</h3>
  </div>
  <div class="col-sm-3">
    <h4 class="text-center"><?php echo $language_text['lbl_cartel'];?></h4>
    <h3 class="text-center">1 / 55</h3>

  </div>
  <div class="col-sm-3">
    <h4 class="text-center"> <?php echo $language_text['lbl_tipos_de_asignacion'];?></h4>
    <br>
    <button id="show" type="button" data-animation="flipInY" data-animation-delay="100" class="btn btn-theme btn-block submit-button" data-toggle="modal" data-target="#exampleModal2"> <a  style="color:#fff;"><?php echo $language_text['btn_manual'];?></a> </button>
    <button id="hide" type="button" data-animation="flipInY" data-animation-delay="100" class="btn btn-theme btn-block submit-button" data-toggle="modal" data-target="#exampleModal2"> <a  style="color:#fff;"><?php echo $language_text['btn_automatico'];?></a> </button>
    <button type="button" data-animation="flipInY" data-animation-delay="100" class="btn btn-theme btn-block submit-button" data-toggle="modal" data-target="#exampleModal2"> <a  style="color:#fff;"><?php echo $language_text['btn_cerrar'];?></a> </button>
  </div>

</div>
<br><br>


<!-- <div id="main"> -->
<!-- <section class="page-section background-img"> -->

    <div class="col-sm-12">
    <br><br>
      <style type="text/css">
      .titulo{
        font-weight: 500;
        color:#333;
      }
      .div-borde {
        margin-top:10px;
        border: #cdcdcd medium solid;
        border-radius: 5px;
        -moz-border-radius: 5px;
        -webkit-border-radius: 5px;
        padding: 0.5em;
      }
    </style>

    <div class="sectionEvaluacion" id="secTrabajoInv" style="">
      <h3 style="color: #fff;padding-top: 15px;padding-bottom: 15px;padding-left: 15px;"><?php echo $language_text['tab_sin_asignar'];?></h3>
      <img class="arrow-black" src="<?php echo asset_url(); ?>img/arrowdownblack.png" alt="">
    </div>
    <div id="hideTrabajo" class="panel" style="display:none;">
      <h1 class="page-head-line"></h1>
      <div class="panel-body">
        <!-- Aqui va la tabla de sin asignar -->
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
            if(isset($data_revisados))
            {
              if($data_revisados['success'])
              {
                if(count($data_revisados['result']) > 0)
                {
                  $lenguaje = obtener_lenguaje_actual();
                  foreach ($data_revisados['result'] as $row)
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

                  <a href="ver_resumen" style="color:#f05a29;"><?php echo $language_text['btn_vdetalle'];?></a><br>
                  <a id="asignar" href="ver_resumen" style="color:#f05a29;"><?php echo $language_text['btn_asignar'];?></a>
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
          <h3><?php echo $data_revisados['msg'];?></h3>
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


         </div>
     </div>

     <div class="sectionEvaluacion" id="secEvaluacion">
       <h3 style="color: #fff;padding-top: 15px;padding-bottom: 15px;padding-left: 15px;">
         Asignados
       </h3>
       <img class="arrow-black" src="<?php echo asset_url(); ?>img/arrowdownblack.png" alt="">
     </div>
     <div id="hideEvaluacion" class="panel " style="display:none;">
       <div class="panel-body">
         <div id="seccionesEva">
          <!-- Aqui va la tabla de asignados -->

           <br>
         </div>


        </div>
      </div>
    </div>
  <!-- </section> -->


<script>
  $(document).ready(function(){
      $("#hide").click(function(){
          $("#asignar").hide();
      });
      $("#show").click(function(){
          $("#asignar").show();
      });
  });
</script>



<script>
$("#comite").removeClass()
$("#atencion").removeClass()
$("#revision").removeClass()
$("#revisados").addClass("active")
$("#aceptados").removeClass()
$("#rechazados").removeClass()
//$("#sin_asignar").addClass("active")
</script>

    <?php echo css("revision/evaluacion_revisor.css"); ?>

<script type="text/javascript">
$(function () {
var down1 = false;
$("#secTrabajoInv").click(function() {
down1 = !down1;
if(down1){
$( "#hideTrabajo" ).show( 1000, function() {
//$( this ).remove();
});
}else{
$( "#hideTrabajo" ).hide( 1000, function() {
//$( this ).remove();
});
}
});

var down2 = false;
$("#secEvaluacion").click(function() {
down2 = !down2;
if(down2){
$( "#hideEvaluacion" ).show( 1000, function() {
//$( this ).remove();
});
}else{
$( "#hideEvaluacion" ).hide( 1000, function() {
//$( this ).remove();
});
}
});}
);

</script>
