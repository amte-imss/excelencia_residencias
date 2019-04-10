<!--<h4 class="textRubro">-->
    <?php echo $language_text['evaluacion']['info_conflicto_tema_edu']; ?>
<!--</h4>-->
<br>
<br>
<?php
//pr($language_text);
echo $this->form_complete->create_element(
        array(
            'id' => 'educativo',
            'name' => 'educativo',
            'type' => 'checkbox',
            'value' => '',
            'attributes' => array(
                "class" => "evalua",
            )
        )
);
echo $language_text['evaluacion']['lbl_tema'] . "&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp";
echo $this->form_complete->create_element(
        array(
            'id' => 'conflicto',
            'name' => 'conflicto',
            'type' => 'checkbox',
            'value' => '',
            'attributes' => array(
                "class" => "evalua",
            )
        )
);
echo $language_text['evaluacion']['lbl_conflicto'];
?>

<div id="seccionesEva">
    <?php ?>
    <?php
    foreach ($secciones as $value_secciones) {

        echo $this->form_complete->create_element(
                array(
                    'id' => 'tabseccioncontrol_' . $value_secciones['id_seccion'],
                    'name' => 'tabseccioncontrol_' . $value_secciones['id_seccion'],
                    'type' => 'hidden',
                    'value' => '',
                )
        );
        echo $this->form_complete->create_element(
                array(
                    'id' => 'seleccion_opcion_evaluacion_' . $value_secciones['id_seccion'],
                    'name' => 'seleccion_opcion_evaluacion_' . $value_secciones['id_seccion'],
                    'type' => 'hidden',
                    'value' => '',
                )
        );
        ?>
        <section class="rubro" id="seccions<?php echo $value_secciones['id_seccion']; ?>" data-identificadorseccion="<?php echo $value_secciones['id_seccion']; ?>">
            <p class="textRubro"><?php echo $value_secciones['descripcion']; ?></p>
            <img class="arrow-black" src="<?php echo asset_url(); ?>img/arrowdownblack.png" alt="">
        </section>
        <section class="todosRubros" id="rubro<?php echo $value_secciones['id_seccion']; ?>" style="display:none;" data-identificadorseccion="<?php echo $value_secciones['id_seccion']; ?>">

            <div class="col-md-3">

                <label class="text-left" style="font-size:16px" for="lbl_arbol_seccion" class="">
                    <?php echo $value_secciones['id_seccion'] . '.'; ?>
                    <?php echo $language_text['evaluacion']['lbl_cal']; ?> 
                </label>
            </div>

            <div class="col-md-3 text-left">
                <div class="input-group input-group-sm">
                    <?php
                    echo $this->form_complete->create_element(
                            array(
                                'id' => 'evaluacion_calificacion_' . $value_secciones['id_seccion'],
                                'name' => 'evaluacion_calificacion_' . $value_secciones['id_seccion'],
                                'type' => 'number',
                                'value' => '',
                                'attributes' => array(
                                    "max" => "0",
                                    "min" => "0",
                                    "class" => "form-control text-left evaluacion_revisor",
                                    "data-identificadorseccion" => $value_secciones['id_seccion'],
                                )
                            )
                    );
                    ?>
                </div>
            </div>
            <div class="col-md-6 text-left">
                <p id="rango_help<?php echo $value_secciones['id_seccion']; ?>" ></p>
            </div>
            <div class="col-md-12 text-left">
                <?php echo form_error_format("evaluacion_calificacion_" . $value_secciones['id_seccion']); //agrega div para mostrar error ?>
            </div>

            <br>
            <br>
            <?php foreach ($opciones_secciones[$value_secciones['id_seccion']] as $opciones) { ?>
                <?php
                echo $this->form_complete->create_element(
                        array(
                            'id' => 'calidad_' . $value_secciones['id_seccion'],
                            'name' => 'calidad_' . $value_secciones['id_seccion'],
                            'type' => 'radio',
                            'value' => $opciones['id_opcion'],
                            'attributes' => array(
                                "class" => "radios_opcion",
                                "data-min" => $opciones['minimo'],
                                "data-max" => $opciones['maximo'],
                                "data-identificadorseccion" => $value_secciones['id_seccion'],
                                "onchange" => "opciones_secciones(this);",
                            )
                        )
                );
                echo $opciones['descripcion'];
                ?>
                <br>
                <br>
            <?php } ?>
        </section>
        <?php echo form_error_format("seleccion_opcion_evaluacion_" . $value_secciones['id_seccion']); //agrega div para mostrar error ?>
    <?php } ?>
    <br>
    <label for=""><?php echo $language_text['evaluacion']['lbl_e_obs']; ?></label><br>
    <?php
    echo $this->form_complete->create_element(
            array(
                'id' => 'observaciones_eval',
                'name' => 'observaciones_eval',
                'type' => 'textarea',
                'value' => '',
                'attributes' => array(
                    'class' => 'form-control',
                ),
            )
    );
    ?>
    <?php echo form_error_format("observaciones_eval"); //agrega div para mostrar error ?>
    <br><br>
    <label for=""><?php echo $language_text['evaluacion']['lbl_dictamen']; ?></label>
    <?php
    echo $this->form_complete->create_element(
            array(
                'id' => 'tipo_exposicion_eval',
                'name' => 'tipo_exposicion_eval',
                'type' => 'dropdown',
                'first' => array('' => $language_text['template_general']['selecciona_opcion']),
                'options' => array(En_tipo_exposicion::ORAL => $language_text['evaluacion']['cbx_o'], En_tipo_exposicion::CARTEL => $language_text['evaluacion']['cbx_c']),
                'value' => '',
                'attributes' => array(
                    'class' => 'form-control',
                ),
            )
    );
    ?>
    <?php echo form_error_format("tipo_exposicion_eval"); //agrega div para mostrar error ?>
</div>

<?php echo js("revision/control_tabs.js"); ?>

