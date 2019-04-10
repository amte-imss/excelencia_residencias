<?php

defined('BASEPATH') OR exit('No direct script access allowed');

/**
 * Clase que contiene las funciones generales de las revisiones,
 * y gestión de revisiones
 * @version 	: 1.0.0
 * @author      : LEAS
 * */
class General_revision extends MY_Controller {

    const LISTA = 'lista', NUEVA = 'agregar', EDITAR = 'editar',
            CREAR = 'crear', LEER = 'leer', ACTUALIZAR = 'actualizar', ELIMINAR = 'eliminar',
            EXPORTAR = 'exportar';

    function __construct() {
        parent::__construct();
    }

    /**
     * @author
     * @Fecha 21/05/2018
     * @param type $cve_evaluacion
     * @description Obtiene el detalle de la investigación
     *
     */
    function get_detalle_evaluacion($cve_evaluacion) {
        
    }

    /**
     * @author
     * @Fecha 21/05/2018
     * @param type $folio //para el caso en que obtenga el detalle de la investigación sin folio
     * @param type $datos_trabajo Si la consulta ya se genero, trabajo contiene el folio
     * @description Obtiene el detalle de la investigación en vista html
     *
     */
    protected function get_detalle_investigacion($folio, $datos_trabajo = null) {
        $this->load->model('Trabajo_model', 'trabajo');
        $this->load->model('Catalogo_model', 'catalogo');
        $output = [];
        $lang = $this->obtener_idioma();
        if (is_null($datos_trabajo)) {
            $datos_trabajo = $this->trabajo->trabajo_investigacion_folio($folio, null)[0];
        }
        $output['lang'] = $lang;
        $output['datos'] = $datos_trabajo;
        $output['language_text'] = $this->obtener_grupos_texto(array('listado_trabajo', 'registro_trabajo', 'detalle_trabajo', 'registro_usuario'), $lang);
        $main_content = $this->load->view('trabajo/ver_revision.tpl.php', $output, true);
        return $main_content;
    }

    /**
     * Devuelve la configuracion del tipo de asignacion activo  
     * @author clapas
     * @date 27/05/2018
     * @return array
     */
    protected function tipo_asignacion() {
        $this->load->model('Dictamen_model', 'dictamen');
        return json_decode($this->dictamen->config_asignacion(), true);
    }

    /**
     * Devuelve la configuracion del cupo 
     * @author clapas
     * @date 27/05/2018
     * @return array
     */
    protected function cupo() {
        $this->load->model('Dictamen_model', 'dictamen');
        return json_decode($this->dictamen->get_cupo(), true);
    }

    /**
     * Realiza la asignacion automatica para los revisados, si la configuracion lo permite 
     * @author clapas
     * @date 28/05/2018
     */
    protected function asignacion_automatica() {
      $this->load->model('Dictamen_model', 'dictamen');
      $asig_auto = $this->tipo_asignacion()['sistema'];
      if ($asig_auto) {
        // Quitamos las sugerencias y el orden
        if ($this->dictamen->reset_orden()) {
          // Obtenemos los cupos para cada tipo de exposicion
          $max_oratoria = $this->cupo()['oratoria'];
          $max_cartel = $this->cupo()['cartel'];

          // Asignamos los trabajos para oratoria
          $candidatos_oratoria = $this->dictamen->trabajos_candidatos($max_oratoria);
          $candidatos_cartel = $this->dictamen->trabajos_candidatos($max_cartel,$max_oratoria);
          
          $oratoria_return = true;
          $carte_return = true;

          if (count($candidatos_oratoria) > 0)
          {  
            $folios_oratoria = [];
            foreach ($candidatos_oratoria as $key => $value) {
                $folios_oratoria[$key] = $value['folio'];
            }

            $param_oratoria = array(
                'where_in' => array('folio', $folios_oratoria),
                'values' => array(
                    'sugerencia' => 'O',
                    'aceptado' => true
                )
            );

            $oratoria_return =$this->dictamen->actualizar_registro($param_oratoria);
          }

          
          if(count($candidatos_cartel) > 0)
          {
            $folios_cartel = [];
            foreach ($candidatos_cartel as $key => $value) {
              $folios_cartel[$key] = $value['folio'];
            }
            $param_cartel = array(
              'where_in' => array('folio',$folios_cartel),
              'values' => array(
                  'sugerencia' => 'C',
                  'aceptado' => true
                )
            );

            $carte_return = $this->dictamen->actualizar_registro($param_cartel);
          }
          
          
          return ($carte_return && $oratoria_return);
          
        } // if reset
        return false;
      } // if asignacion automatica
    }

    /**
     * Devuelve la configuracion del cupo 
     * @author clapas
     * @date 27/05/2018
     * @return array
     */
    protected function get_dias_revision() {
        $this->load->model('Evaluacion_revision_model', 'evaluacion_m');
        $return = $this->evaluacion_m->get_configuracion_dias_revision();
        return $return;
    }

}
