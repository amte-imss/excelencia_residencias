
<!-- listado de revisores -->
<div class="schedule-wrapper clear" data-animation="fadeIn" data-animation-delay="200">
  <div class="schedule-tabs lv1">
    <ul id="tabs-lv1"  class="nav nav-justified">
      <li class="active"><a href="#tab-trabajos-a-revisar" data-toggle="tab"><strong>Trabajos por evaluar</strong> <br/></a></li>
    </ul>
  </div>

  <div class="tab-content lv1">
    <!-- tab1 -->
    <div id="tab-trabajos-a-revisar" class="tab-pane fade in active">
      <div class="tab-content lv2">
        <div id="tab-lv21-revisar" class="tab-pane fade in active">
          <div class="timeline">
            <!-- lista nuevos trabajos a revisar -->
            <table class="table">
              <thead>

                <tr>
                    <th scope="col"><?php echo $language_text['col_folio'];?></th>
                    <th scope="col"><?php echo $language_text['col_titulo'];?></th>
                    <th scope="col"><?php echo $language_text['col_metodologia'];?></th>
                    <th scope="col"><?php echo $language_text['col_opciones'];?></th>
                </tr>

              </thead>
              <tbody>
                <?php
                if(isset($data_revisar))
                {
                  if($data_revisar['success'])
                  {
                    if(count($data_revisar['result']) > 0)
                    {
                      $lenguaje = obtener_lenguaje_actual();  
                      foreach ($data_revisar['result'] as $row)
                      {
                        ?>


                        <tr>
                          <td scope="row"><?php echo $row['folio'];?></td>
                          <td><?php echo $row['titulo'];?></td>
                          <td>
                            <?php
                                $metodologia = json_decode($row['metodologia'], true);
                                echo $metodologia[$lenguaje];
                            ?>

                          </td>
                          <td><?php echo $row['fecha_limite_revision'];?> </td>
                          <td>
                            <a href="<?php echo site_url().'/evaluacion/nueva_evaluacion_revision/'.$row['folio']; ?>" type="button" data-animation="flipInY" data-animation-delay="100" class="btn btn-theme btn-block submit-button">Evaluar</a>
                          </td>
                        </tr>

                        <?php
                      }
                    }
                    else
                    {
                      ?>
                      <h3>No hay trabajos sin comite!</h3>
                      <?php
                    }
                  }
                  else
                  {
                    ?>
                    <h3><?php echo $data_revisar['msg'];?></h3>
                    <?php
                  }
                }else
                {
                  ?>
                  <h3>Algo salió mal, vuelve a intentarlo más tarde!</h3>
                  <?php
                }
                ?>

              </tbody>
            </table>
            <!-- END lista nuevos trabajos a revisar -->
          </div>
        </div>
      </div>
    </div>
  </div>
</div>
<!-- END/listado de revisores -->
