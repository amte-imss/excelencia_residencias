<!-- <div id="main"> -->
<section class="page-section background-img">
  <div class="container">
    <div class="row">
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

    <div class="sectionEvaluacion col-sm-12" id="secTrabajoInv">
      <h3>Sin Asignar</h3>
      <img src="../public/img/arrowdown.png" alt="">
    </div>
    <div id="hideTrabajo" class="panel panel-default" style="display:none;">
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

     <div class="sectionEvaluacion col-sm-12" id="secEvaluacion">
       <h3>
         Asignados
       </h3>
       <img src="../public/img/arrowdown.png" alt="">
     </div>
     <div id="hideEvaluacion" class="panel panel-default" style="display:none;">
       <div class="panel-body">
         <div id="seccionesEva">
          <!-- Aqui va la tabla de asignados -->

           <br>
         </div>


     </div>
     </div>

     </div>
     </div>
     </section>
     <?php
     //if(isset($list_asignados)){
     //  echo $list_asignados;
     //}
     //if(isset($list_sin_asignar)){
     //  echo $list_sin_asignar;
     //}
     ?>
     <script>
     $("#comite").removeClass()
     $("#atencion").removeClass()
     $("#revision").removeClass()
     $("#revisados").addClass("active")
     $("#aceptados").removeClass()
     $("#rechazados").removeClass()
     // $("#sin_asignar").removeClass("active")
     </script>
