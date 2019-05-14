<link rel="stylesheet" type="text/css" href="<?php echo asset_url(); ?>grocery_crud/themes/datatables/css/jquery.dataTables_1.10.19.css">
<style>
.tab-content.lv2 .tab-pane {
  padding: 20px 20px;
}
.timeline {
  overflow: scroll;
  height: 800px;
}
</style>
<div class="schedule-wrapper clear" data-animation="fadeIn" data-animation-delay="200">
    <div class="schedule-tabs lv1">
        <ul id="tabs-lv1"  class="nav nav-justified">
            <li id="comite" onclick=""> <a href="#"><strong><?php echo $opciones_secciones['titulo_ganador'];; ?></strong> <br/></a></li>
        </ul>
    </div>
    <div class="tab-content lv1">
        <!-- tab-sin-comite sin comité -->
        <div id="tab-sin-comite" class="tab-pane fade in active">
            <div class="tab-content lv2">
                <div id="tab-lv21-comite" class="tab-pane fade in active">
                    <div class="timeline">
                        <!--<script type="text/javascript" charset="utf8" src="<?php echo asset_url(); ?>grocery_crud/themes/datatables/js/jquery.dataTables.js"></script>-->
                        <?php
                        //if(isset($listado))
                        //{
                            //if($listado['success'])
                            //{
                                if(count($listado) > 0)
                                {
                        ?>
                                    <br><br>
                                    <!--div class="col-sm-12 text-right">
                                            
                                            <a href="<?php //echo site_url('/gestion_revision/listado_control/'.strtolower(En_estado_solicitud::ACEPTADOS)."_e"); ?>" class=" btn btn-theme animated flipInY visible"><?php //echo $opciones_secciones['btn_exportar_aceptados']; ?></a> 
                                            <br><br><br>
                                        </div><div style="clear:both;"></div-->

                                    <table class="table" id="table_ganadores">
                                
                                    <thead>
                                        <tr >
                                            <!--<th scope="col"><?php // echo $opciones_secciones['col_nivel'];?></th>-->
                                            <th scope="col"><?php echo $opciones_secciones['col_ganador_nivel'];?></th>
                                            <th scope="col"><?php echo $opciones_secciones['col_ganador_matricula'];?></th>
                                            <th scope="col"><?php echo $opciones_secciones['col_ganador_nombre'];?></th>
                                            <th scope="col"><?php echo $opciones_secciones['col_ganador_apellido_paterno'];?></th>
                                            <th scope="col"><?php echo $opciones_secciones['col_ganador_apellido_materno'];?></th>
                                            <th scope="col"><?php echo $opciones_secciones['col_ganador_delegacion'];?></th>
                                            <th scope="col"><?php echo $opciones_secciones['col_ganador_correo'];?></th>
                                            <th scope="col"><?php echo $opciones_secciones['col_ganador_pun_excelencia'];?></th>
                                            <th scope="col"><?php echo $opciones_secciones['col_ganador_fecha_registro'];?></th>
                                        </tr>
                                    </thead>
                                    <tbody>
                        <?php
                                    $lenguaje = obtener_lenguaje_actual();
                                    $h=1;
                                    foreach ($listado as $row)
                                    {
                                        /*if(isset($data_dictamen[$row['id_solicitud']])){
                                            
                                        $row['id_solicitud'];
                                        $nivel = 'Sin nivel';
                                        if($h<=$configuracion['nivel_1']){
                                                $nivel = 'Nivel 1';
                                        } elseif($h<=($configuracion['nivel_1']+$configuracion['nivel_2'])){
                                                $nivel = 'Nivel 2';
                                            } elseif($h<=($configuracion['nivel_1']+$configuracion['nivel_2']+$configuracion['nivel_3'])){
                                                $nivel = 'Nivel 3';
                                        }
                                        $check_gano_premio='';
                                        $value_nivel='';
                                        $dictaminado_style='style="background: #F3E9D1"';
                                        if(isset($data_dictamen[$row['id_solicitud']])){
                                            if($data_dictamen[$row['id_solicitud']]['premio_anterior']){
                                                $check_gano_premio = 'checked="checked"';
                                            }
                                            $dictaminado_style = '';
                                            $value_nivel = $data_dictamen[$row['id_solicitud']]['id_nivel'];
                                        }*/
                        ?>
                                    <tr <?php //echo $dictaminado_style; ?>>
                                            <!--<td scope="row"><?php // echo $nivel; ?></td>-->
                                            <td><?php  echo ($row['nivel']);?></td>
                                            <td><?php echo $row['matricula'];?></td>
                                            <td><?php echo $row['nombre_solicitante'];?></td>
                                            <td><?php  echo $row['apellido_paterno'];?></td>
                                            <td><?php  echo $row['apellido_materno'];?></td>
                                            <td><?php  echo $row['delegacion'];?></td>
                                            <td><?php  echo $row['email'];?></td>
                                            <td><?php  echo ($row['puntaje_excelencia_docente']);?></td>
                                            <td><?php  echo $row['fecha'];?></td>
                                            <!-- td>

                                            <a href="<?php //echo site_url().'/revision/index/'.$row['id_solicitud']; ?>/detalle" type="button"><?php //echo $opciones_secciones['btn_ver'];?> <span class="glyphicon glyphicon-new-window"/></a>
                                            </td-->
                                        </tr>
                        <?php
                                        $h++;
                                        //}
                                    }
                                }
                                else
                                {
                        ?>
                                <h3><?php echo $opciones_secciones['er_mensaje'];?></h3>
                        <?php

                                }
                            //}
                            /*else
                            {
                        ?>
                            <h3><?php echo $mensajes['ern_mensaje'];?></h3>
                        <?php
                            }*/
                        ?>

                            </tbody>
                        </table>

                        <?php
                        //}
                        /*else
                        {
                        ?>
                            <h3><?php echo $mensajes['er_no_datos'];?></h3>
                        <?php
                        }*/
                        ?>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>


<?php echo js("jquery.dataTables.min.js"); ?>
  <script>
   $(document).ready(function () {
    <?php if($super===true){ ?>
      var ruta_language_datatable = url + "assets/spanish_table.json";
      $('#table_ganadores').DataTable({
          "language": {
    //                    "url": "//cdn.datatables.net/plug-ins/1.10.15/i18n/Spanish.json"
                    "url": ruta_language_datatable
                }
      });
    <?php } ?>
  });
  </script>
<?php echo js('trabajo_investigacion/control_dictamen.js'); ?>