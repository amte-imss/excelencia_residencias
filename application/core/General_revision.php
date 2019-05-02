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
        $this->load->model('Registro_excelencia_model', 'registro');
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
                $candidatos_cartel = $this->dictamen->trabajos_candidatos($max_cartel, $max_oratoria);

                $oratoria_return = true;
                $carte_return = true;

                if (count($candidatos_oratoria) > 0) {
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

                    $oratoria_return = $this->dictamen->actualizar_registro($param_oratoria);
                }


                if (count($candidatos_cartel) > 0) {
                    $folios_cartel = [];
                    foreach ($candidatos_cartel as $key => $value) {
                        $folios_cartel[$key] = $value['folio'];
                    }
                    $param_cartel = array(
                        'where_in' => array('folio', $folios_cartel),
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

    /*     * ********************************************************** */

    /**
     * Excelencia 
     * LEAS
     */
    protected function get_niveles() {
        $idioma = $this->obtener_idioma();
        $nivel = $this->registro->getConsutasGenerales('excelencia.nivel', '*', ['activo' => true]);
        foreach ($nivel as &$value) {
            $value['descripcion'] = json_decode($value['descripcion'], true)[$idioma];
        }
        return $nivel;
    }

    protected function get_dictamen($condicion = 'all') {
        $this->load->model('Registro_excelencia_model', 'registro');
        $where = null;
        switch ($condicion) {
            case En_estado_solicitud::RECHAZADOS:
                $where = ['aceptado' => FALSE, 'premio_anterior' => TRUE];
                break;
            case En_estado_solicitud::ACEPTADOS:
                $where = ['aceptado' => TRUE, 'premio_anterior' => FALSE];
                break;
        }
        $select = ["id_dictamen", "id_solicitud", "fecha",
            "id_usuario", "id_nivel", "aceptado", "premio_anterior", "promedio"];
        $dictamen_r = $this->registro->getConsutasGenerales('excelencia.dictamen', $select, $where);
//        pr($dictamen_r);
        $dictamen = [];
        foreach ($dictamen_r as $value) {
            $dictamen[$value['id_solicitud']] = $value;
        }
        return $dictamen;
    }

    /**
     * @author LEAS 01/05/2019
     * @return types
     * Obtine el total de dictaminados por nivel
     */
    protected function get_dictamen_total_nivel() {

        $select = [
            "sum((case when id_nivel = 'n1' and aceptado then 1 else 0 end)) nivel_1",
            "sum((case when id_nivel = 'n2' and aceptado then 1 else 0 end)) nivel_2"
            , "sum((case when id_nivel = 'n3' and aceptado then 1 else 0 end)) nivel_3"
        ];
        $total_nivel = $this->registro->getConsutasGenerales('excelencia.dictamen', $select);
//        pr($dictamen_r);

        return $total_nivel[0];
    }

    protected function solicitantes() {
        $this->load->model('Registro_excelencia_model', 'registro');
        $select = [
            "'cenitluis.pumas@gmail.com' email"
            //"u.email", 
            , "h.cve_estado_solicitud",
            "concat(iu.nombre, ' ', iu.apellido_paterno, ' ', iu.apellido_materno) profesor"
            , "s.id_solicitud", "s.matricula", "s.carrera_categoria", "s.carrera_tiene",
            "s.id_convocatoria", "s.fecha"
        ];
        $join = [
            "sistema.informacion_usuario iu" => ['typejoin' => 'inner', 'condicion' => 'iu.matricula = s.matricula'],
            "sistema.usuarios u" => ['typejoin' => 'inner', 'condicion' => 'iu.id_usuario = u.id_usuario'],
            "excelencia.historico_solicitud h" => ['typejoin' => 'left', 'condicion' => 'h.id_solicitud = s.id_solicitud and h.actual'],
            "excelencia.convocatoria c" => ['typejoin' => 'inner', 'condicion' => 'c.id_convocatoria = s.id_convocatoria and c.activo'],
        ];
        $solicitantes = $this->registro->getConsutasGenerales('excelencia.solicitud s', $select, null, $join);
        $result = [];
        foreach ($solicitantes as $value) {
            $result['result'][$value['id_solicitud']] = $value;
        }
        return $result;
    }

    /**
     * 
     * @author LEAS
     * @param type $data
     * @param type $key
     * @param type $config
     */
    protected function gurda_registros_correo_dictamen($data, $config) {
//        pr($data);
//        pr($config);
        $aux = [];
        foreach ($config as $value) {
            if (isset($data[$value])) {//Valida que exista la llave 
                $aux[$value] = $data[$value];
                unset($data[$value]);
            }
        }
        $datos['config'] = json_encode($aux);
        $datos['correo_electronico'] = $data['email'];
        $datos['id_convocatoria'] = $data['id_convocatoria'];
        $datos['profesor'] = $data['profesor'];
        $datos['matricula'] = $data['matricula'];
        $datos['tipo_correo'] = $data['cve_estado_solicitud'];
        $this->registro->insert_registro_general('excelencia.envio_correos_pendientes', $datos, 'id_correo_pendiente');
    }

    protected function get_convocatoria() {
        $where = ['activo' => true, 'acceso' => ['typeWhere' => 'or_where', 'valueWhere' => true]];
        $result = $this->registro->getConsutasGenerales('excelencia.convocatoria c', '*', $where);
        return $result;
    }

    protected function get_correos_pendientes() {
        $convocatorias = $this->get_convocatoria();
        $correos = [];
//        return $correos;
        if (!empty($convocatorias)) {
            $conv = [];
            foreach ($convocatorias as $values) {
                $conv[] = $values['id_convocatoria'];
            }
//            pr($conv);
            $where = [
                'id_convocatoria' => ['typeWhere' => 'where_in', 'valueWhere' => $conv],
                'fue_enviado' => FALSE
            ];
            $correos = $this->registro->getConsutasGenerales('excelencia.envio_correos_pendientes', '*', $where, null, 'id_correo_pendiente');
        }
        return $correos;
    }

    protected function enviar_correo_control_envios_dictamen() {
        $mail_pendientes = $this->get_correos_pendientes();
//        pr($mail_pendientes);
//        exit();
        $num = 0;
        foreach ($mail_pendientes as $value) {
            ++$num;
            $value = array_merge($value, json_decode($value['config'], TRUE));
            switch ($value['tipo_correo']) {
                case En_estado_solicitud::ACEPTADOS:
//            pr($value);
                    $result = $this->enviar_correo_electronico('correo_excelencia/aceptado.php', $value['correo_electronico'], $value, $value['subject']);
                    break;
                case En_estado_solicitud::RECHAZADOS:
                    $result = $this->enviar_correo_electronico('correo_excelencia/rechazado.php', $value['correo_electronico'], $value, $value['subject']);

                    break;
            }
            if ($result) {
                $this->actualiza_bandera_correo_enviado($value['id_correo_pendiente']);
            }
        }
    }

    protected function actualiza_bandera_correo_enviado($id_correo_pendiente) {
        $where['id_correo_pendiente'] = $id_correo_pendiente;
        $set['fue_enviado'] = true;
        $set['fecha_envio'] = 'now()';
        return $this->registro->update_registro_general('excelencia.envio_correos_pendientes', $set, $where);
    }

}
