
<!-- listas de estados -->
<div class="schedule-wrapper clear" data-animation="fadeIn" data-animation-delay="200">
    <div class="schedule-tabs lv1">
        <ul id="tabs-lv1"  class="nav nav-justified">
            <li id="comite" onclick="ponerActivo(this)"> <a href="<?php echo base_url("index.php/gestion_revision/listado_control/".strtolower(En_estado_solicitud::SIN_COMITE)); ?>"><strong><?php echo $textos_idioma_nav['tab_sc']; ?></strong> <br/></a></li>
            <!--li id="atencion" onclick="ponerActivo(this)"> <a href="<?php echo base_url("index.php/gestion_revision/listado_control/2"); ?>" ><strong><?php echo $textos_idioma_nav['tab_ra']; ?></strong> <br/></a></li-->
            <li id="revision" onclick="ponerActivo(this)"> <a href="<?php echo base_url("index.php/gestion_revision/listado_control/".strtolower(En_estado_solicitud::EN_REVISION)); ?>"><strong><?php echo $textos_idioma_nav['tab_er']; ?></strong> <br/></a></li>
            <li id="revisados" onclick="ponerActivo(this)"> <a href="<?php echo base_url("index.php/gestion_revision/listado_control/".strtolower(En_estado_solicitud::REVISADOS)); ?>"><strong><?php echo $textos_idioma_nav['tab_rv']; ?></strong></a></li>
            <?php if(isset($textos_idioma_nav['tab_ca']) && $textos_idioma_nav['tab_ca']!=''){ ?>
              <li id="candidatos" onclick="ponerActivo(this)"> <a href="<?php echo base_url("index.php/gestion_revision/listado_control/".strtolower(En_estado_solicitud::CANDIDATOS)); ?>"><strong><?php echo $textos_idioma_nav['tab_ca']; ?></strong></a></li>
            <?php } ?>
            <!--li id="aceptados" onclick="ponerActivo(this)"> <a href="<?php //echo base_url("index.php/gestion_revision/listado_control/5"); ?>"><strong><?php echo $textos_idioma_nav['tab_ac']; ?></strong> <br/></a></li>
            <li id="rechazados" onclick="ponerActivo(this)"> <a href="<?php //echo base_url("index.php/gestion_revision/listado_control/6"); ?>"><strong><?php echo $textos_idioma_nav['tab_rx']; ?></strong> <br/></a></li-->
        </ul>
    </div>
    <div class="tab-content lv1">
        <!-- tab-sin-comite sin comité -->
        <div id="tab-sin-comite" class="tab-pane fade in active">
            <div class="tab-content lv2">
                <div id="tab-lv21-comite" class="tab-pane fade in active">
                    <div class="timeline">
                        <?php
                        if (isset($list_sn_comite)) {
                            echo $list_sn_comite;
                        }
                        if (isset($list_req_atencion)) {
                            echo $list_req_atencion;
                        }
                        if (isset($list_en_revision)) {
                            echo $list_en_revision;
                        }
                        if (isset($list_revisados)) {
                            echo $list_revisados;
                        }
                        if (isset($lista_aceptados)) {
                            echo $lista_aceptados;
                        }
                        if (isset($list_rechazados)) {
                            echo $list_rechazados;
                        }
                        ?>
                    </div>
                </div>
            </div>
        </div>

        <!-- END tab-sin-comite sin comité -->

      <!-- <script type="text/javascript">
          $('#myModal').on('shown.bs.modal', function () {
          $('#myInput').trigger('focus')
          })
      </script> -->


      <!-- <script>
        function ponerActivo(obj){
          console.log(obj)
          console.log(obj.id)
          switch (obj.id) {
            case 'comite':
              //$("#comite").addClass("active")
              break;
            case 'atencion':
              //$("#atencion").addClass("active")
              break;
            case 'revision':
              //$("#revision").addClass("active")
              break;
            case 'revisados':
              //$("#revisados").addClass("active")
              break;
            case 'aceptados':
              //$("#aceptados").addClass("active")
              break;
            case 'rechazados':
              //$("#rechazados").addClass("active")
              break;
            default:

          }
        }
      </script> -->
      <!-- <script>
          $("#comite").removeClass()
          $("#atencion").removeClass()
          $("#revision").removeClass()
          $("#revisados").addClass("active")
          $("#aceptados").removeClass()
          $("#rechazados").removeClass()
      </script> -->
    </div>
</div>