<?php

defined('BASEPATH') OR exit('No direct script access allowed');

/**
 * Clase que contiene la gestion de catálogos
 * @version 	: 1.0.0
 * @author      : LEAS
 * */
class Gestion_revision extends General_revision {
    /* const SN_COMITE = 1, REQ_ATENCION = 2, EN_REVISION = 3,
      REVISADOS = 4, ACEPTADOS = 5, RECHAZADOS = 6; */

    function __construct() {
        $this->grupo_language_text = ['sin_comite', 'req_atencion', 'en_revision',
            'evaluado', 'aceptado', 'rechazado', 'listado_trabajo', 'generales', 'evaluacion', 'en_revision', 'candidatos', 'mensajes', 'detalle_revision', 'detalle_trabajo']; //Grupo de idiomas para el controlador actual
        parent::__construct();
        $this->load->library('form_complete', 'security');
        $this->load->model('Gestion_revision_model', 'gestion_revision');
    }

    /**
     * @author LEAS
     * @Fecha 21/05/2018
     * @param type $folio
     * @description genera el espacio de la evaluación
     *
     */
    public function listado_control($tipo = null) {
        $datos['mensajes'] = $this->obtener_grupos_texto('mensajes', $this->obtener_idioma())['mensajes'];
        switch ($tipo) {
            case strtolower(En_estado_solicitud::SIN_COMITE):
                $datos['data_sn_comite'] = $this->sn_comite();
                $datos['opciones_secciones'] = $this->obtener_grupos_texto('sin_comite', $this->obtener_idioma())['sin_comite'];
                $output['list_sn_comite'] = $this->load->view('revision_solicitud/estados/lista_sin_comite.php', $datos, true);
                break;
            /* case En_estado_solicitud::REQ_ATENCION:
              $datos['data_req_atencion'] = $this->requiere_atencion();
              $datos['opciones_secciones'] = $this->obtener_grupos_texto('req_atencion', $this->obtener_idioma())['req_atencion'];
              $output['list_req_atencion'] = $this->load->view('revision_solicitud/estados/lista_requiere_atencion.php', $datos, true);
              break; */
            case strtolower(En_estado_solicitud::EN_REVISION):
                $datos['data_en_revision'] = $this->en_revision();
                $datos['opciones_secciones'] = $this->obtener_grupos_texto('en_revision', $this->obtener_idioma())['en_revision'];
                $output['list_en_revision'] = $this->load->view('revision_solicitud/estados/lista_en_revision.php', $datos, true);
                break;
            case strtolower(En_estado_solicitud::REVISADOS):
                $datos['data_revisados'] = $this->revisados();
                $datos['opciones_secciones'] = $this->obtener_grupos_texto('revisados', $this->obtener_idioma())['revisados'];
                $output['list_revisados'] = $this->load->view('revision_solicitud/estados/lista_revisados.php', $datos, true);
                break;
            case strtolower(En_estado_solicitud::CANDIDATOS):
                $this->load->model('Registro_excelencia_model', 'registro');
                $datos['data_revisados'] = $this->candidatos();
                $datos['data_dictamen'] = $this->get_dictamen();
                $datos['total_registrados_nivel'] = $this->get_dictamen_total_nivel();
                
//                pr($datos);
                $datos['niveles'] = dropdown_options($this->get_niveles(), 'id_nivel', 'descripcion');
                $conf = $this->gestion_revision->get_configuracion(array('where' => "llave='cupo'"));
                $datos['configuracion'] = (isset($conf['result'][0])) ? json_decode($conf['result'][0]['valor'], true) : null;
                $datos['opciones_secciones'] = $this->obtener_grupos_texto('candidatos', $this->obtener_idioma())['candidatos'];
                $output['list_revisados'] = $this->load->view('revision_solicitud/estados/lista_candidatos.php', $datos, true); //pr($datos);
                break;
            case strtolower(En_estado_solicitud::ACEPTADOS):
                $this->load->model('Registro_excelencia_model', 'registro');
                $datos['data_revisados'] = $this->candidatos();
                $datos['data_dictamen'] = $this->get_dictamen(En_estado_solicitud::ACEPTADOS);
                $datos['configuracion'] = (isset($conf['result'][0])) ? json_decode($conf['result'][0]['valor'], true) : null;
                $datos['niveles'] = dropdown_options($this->get_niveles(), 'id_nivel', 'descripcion');
                $datos['opciones_secciones'] = $this->obtener_grupos_texto('candidatos', $this->obtener_idioma())['candidatos'];
                $output['lista_aceptados'] = $this->load->view('revision_solicitud/estados/lista_aceptados.php', $datos, true);
                break;
            case strtolower(En_estado_solicitud::RECHAZADOS):
                $this->load->model('Registro_excelencia_model', 'registro');
                $datos['data_revisados'] = $this->candidatos();
                $datos['data_dictamen'] = $this->get_dictamen(En_estado_solicitud::RECHAZADOS);
                $datos['configuracion'] = (isset($conf['result'][0])) ? json_decode($conf['result'][0]['valor'], true) : null;
                $datos['niveles'] = dropdown_options($this->get_niveles(), 'id_nivel', 'descripcion');
                $datos['opciones_secciones'] = $this->obtener_grupos_texto('candidatos', $this->obtener_idioma())['candidatos'];
                $output['list_rechazados'] = $this->load->view('revision_solicitud/estados/lista_rechazados.php', $datos, true);
                break;
            default :
                $datos['data_sn_comite'] = $this->sn_comite();
                $datos['opciones_secciones'] = $this->obtener_grupos_texto('sin_comite', $this->obtener_idioma())['sin_comite'];
                $output['list_sn_comite'] = $this->load->view('revision_solicitud/estados/lista_sin_comite.php', $datos, true);
                break;
        }
        $output['textos_idioma_nav'] = $this->obtener_grupos_texto('tabs_gestor', $this->obtener_idioma())['tabs_gestor'];
        $main_content = $this->load->view('revision_solicitud/listas_gestor.php', $output, true);
        $this->template->setMainContent($main_content);
        $this->template->getTemplate();
    }

    private function get_niveles() {
        $idioma = $this->obtener_idioma();
        $nivel = $this->registro->getConsutasGenerales('excelencia.nivel', '*', ['activo' => true]);
        foreach ($nivel as &$value) {
            $value['descripcion'] = json_decode($value['descripcion'], true)[$idioma];
        }
        return $nivel;
    }

    private function get_dictamen($condicion = 'all') {
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
    private function get_dictamen_total_nivel() {

        $select = [
            "sum((case when id_nivel = 'n1' and aceptado then 1 else 0 end)) nivel_1",
            "sum((case when id_nivel = 'n2' and aceptado then 1 else 0 end)) nivel_2"
            , "sum((case when id_nivel = 'n3' and aceptado then 1 else 0 end)) nivel_3"
        ];
        $total_nivel = $this->registro->getConsutasGenerales('excelencia.dictamen', $select);
//        pr($dictamen_r);
        
        return $total_nivel[0];
    }

    public function guarda_informacion_dictamen() {
        if ($this->input->post(null, true)) {
            $post = $this->input->post(null, true);
            if (isset($post['solicitud'])) {
                $sesion = $this->get_datos_sesion();
                $result = $this->guarda_dictamen($post, $sesion['id_usuario']);
                if ($result['tp_msg'] == En_tpmsg::DANGER) {
                    echo $result['html'];
                } else {
                    header('Content-Type: application/json; charset=utf-8;');
                    echo json_encode($result);
//                                exit();
                }
            }
        }
    }

    private function guarda_dictamen($post, $usuario_dictamen) {
        $result = ['tp_msg' => En_tpmsg::SUCCESS,
            'html' => 'La información se guardo correctamente.'
        ];
        $this->load->model('Registro_excelencia_model', 'registro');
        $data_candidatos = $this->candidatos()['result'];
        $data_dictamen = $this->get_dictamen();
//        pr($data_candidatos);
//        pr($post);
        foreach ($post['solicitud'] as $value) {
            $con_premio = FALSE;
            $nivel = null;
            if ((isset($post['nivel'][$value]) && !empty($post['nivel'][$value]) || isset($post['con_premio'][$value]) && !empty($post['con_premio'][$value])) && isset($data_candidatos[$value])) {//Valida que este la solicitud
                if (isset($post['con_premio'][$value]) && !empty($post['con_premio'][$value])) {
                    $con_premio = true;
                }
                if (isset($post['nivel'][$value]) && !empty($post['nivel'][$value])) {
                    $nivel = $post['nivel'][$value];
                }
                $detalle_revisado = $data_candidatos[$value];
                $total_promedio = $detalle_revisado['total_suma_puntos'];
//                if (!is_null($detalle_revisado['id_evaluacion']) && !empty($detalle_revisado['id_evaluacion'])) {
//                    $total_promedio = ($detalle_revisado['puntaje_pnpc'] + $detalle_revisado['puntaje_sa_et'] + $detalle_revisado['puntaje_sa_satisfaccion'] + $detalle_revisado['puntaje_carrera_docente'] + $detalle_revisado['total_puntos_anios_cursos']);
//                } else {
//                    $total_promedio = floatval($detalle_revisado['total_puntos_anios_cursos']);
//                }
                $data = ['id_solicitud' => $value, 'id_usuario' => $usuario_dictamen,
                    'id_nivel' => $nivel,
                    'aceptado' => !$con_premio,
                    'premio_anterior' => $con_premio,
                    'promedio' => $total_promedio,
                ];
                if (isset($data_dictamen[$value])) {//actualiza registro
                    $where = ['id_dictamen' => $data_dictamen[$value]['id_dictamen'], 'id_solicitud' => $value];
                    $update = $this->registro->update_registro_general('excelencia.dictamen', $data, $where);
                    if ($update['tp_msg'] == En_tpmsg::DANGER) {
                        $result = ['tp_msg' => En_tpmsg::DANGER,
                            'html' => 'Ocurrió un error durante el proceso. Por favor intentelo nuevamente '
                        ];
                    }
                } else {//inserta nuevo registro
//                $total_promedio = $detalle_revisado['total'];
                    $insertar = $this->registro->insert_registro_general('excelencia.dictamen', $data, 'id_dictamen');
                    if ($insertar['tp_msg'] == En_tpmsg::DANGER) {
                        $result = ['tp_msg' => En_tpmsg::DANGER,
                            'html' => 'Ocurrió un error durante el proceso. Por favor intentelo nuevamente '
                        ];
                    }
                }
            } else {
                if (isset($data_dictamen[$value])) {//actualiza registro
                    $where = ['id_dictamen' => $data_dictamen[$value]['id_dictamen'], 'id_solicitud' => $value];
                    $update = $this->registro->delete_registro_general('excelencia.dictamen', $where);
                    if ($update['tp_msg'] == En_tpmsg::DANGER) {
                        $result = ['tp_msg' => En_tpmsg::DANGER,
                            'html' => 'Ocurrió un error durante el proceso. Por favor intentelo nuevamente '
                        ];
                    }
                }
            }
        }
        return $result;
    }

//    private function guarda_dictamen($post, $usuario_dictamen) {
//        $result = ['tp_msg' => En_tpmsg::SUCCESS,
//            'html' => 'La información se guardo correctamente.'
//        ];
//        $this->load->model('Registro_excelencia_model', 'registro');
//        $data_candidatos = $this->candidatos()['result'];
//        $data_dictamen = $this->get_dictamen();
////        pr($data_candidatos);
////        pr($post);
//        foreach ($post['solicitud'] as $value) {
//            $con_premio = FALSE;
//            $nivel = null;
//            if (isset($post['nivel'][$value]) && !empty($post['nivel'][$value]) && isset($data_candidatos[$value])) {//Valida que este la solicitud
//                if (isset($post['con_premio'][$value]) && !empty($post['con_premio'][$value])) {
//                    $con_premio = true;
//                }
//                $detalle_revisado = $data_candidatos[$value];
//                if (!is_null($detalle_revisado['id_evaluacion']) && !empty($detalle_revisado['id_evaluacion'])) {
//                    $total_promedio = ($detalle_revisado['puntaje_pnpc'] + $detalle_revisado['puntaje_sa_et'] + $detalle_revisado['puntaje_sa_satisfaccion'] + $detalle_revisado['puntaje_carrera_docente'] + $detalle_revisado['total_puntos_anios_cursos']);
//                } else {
//                    $total_promedio = floatval($detalle_revisado['total_puntos_anios_cursos']);
//                }
//                $nivel = $post['nivel'][$value];
//                $data = ['id_solicitud' => $value, 'id_usuario' => $usuario_dictamen,
//                    'id_nivel' => $nivel,
//                    'aceptado' => !$con_premio,
//                    'premio_anterior' => $con_premio,
//                    'promedio' => $total_promedio,
//                ];
//                if (isset($data_dictamen[$value])) {//actualiza registro
//                    $where = ['id_dictamen' => $data_dictamen[$value]['id_dictamen'], 'id_solicitud' => $value];
//                    $update = $this->registro->update_registro_general('excelencia.dictamen', $data, $where);
//                    if ($update['tp_msg'] == En_tpmsg::DANGER) {
//                        $result = ['tp_msg' => En_tpmsg::DANGER,
//                            'html' => 'Ocurrió un error durante el proceso. Por favor intentelo nuevamente '
//                        ];
//                    }
//                } else {//inserta nuevo registro
////                $total_promedio = $detalle_revisado['total'];
//                    $insertar = $this->registro->insert_registro_general('excelencia.dictamen', $data, 'id_dictamen');
//                    if ($insertar['tp_msg'] == En_tpmsg::DANGER) {
//                        $result = ['tp_msg' => En_tpmsg::DANGER,
//                            'html' => 'Ocurrió un error durante el proceso. Por favor intentelo nuevamente '
//                        ];
//                    }
//                }
//            } else {//Elimina el dictamen si existe el dictamen y el no selecciona nivel
//                if (isset($data_dictamen[$value])) {//actualiza registro
//                    $where = ['id_dictamen' => $data_dictamen[$value]['id_dictamen'], 'id_solicitud' => $value];
//                    $update = $this->registro->delete_registro_general('excelencia.dictamen', $where);
//                    if ($update['tp_msg'] == En_tpmsg::DANGER) {
//                        $result = ['tp_msg' => En_tpmsg::DANGER,
//                            'html' => 'Ocurrió un error durante el proceso. Por favor intentelo nuevamente '
//                        ];
//                    }
//                }
//            }
//        }
//        return $result;
//    }

    private function sn_comite() {
        $lenguaje = obtener_lenguaje_actual();
        $respuesta_model = $this->gestion_revision->get_sn_comite();
        //pr($respuesta_model);
        $result = array('success' => $respuesta_model['success'], 'msg' => $respuesta_model['msg'], 'result' => []);
        foreach ($respuesta_model['result'] as $row) {
            $result['result'][$row['id_solicitud']] = $row;
            /* $result['result'][$row['folio']]['titulo'] = $row['titulo'];
              $metodologia = json_decode($row['metodologia'],true);
              $result['result'][$row['folio']]['metodologia'] = $metodologia[$lenguaje]; */
        } //pr($result);
        return $result;
    }

    /* private function requiere_atencion() {
      $lenguaje = obtener_lenguaje_actual();
      $respuesta_model = $this->gestion_revision->get_requiere_atencion();
      $result = array('success'=>$respuesta_model['success'],'msg'=>$respuesta_model['msg'],'result'=>[]);
      foreach ($respuesta_model['result'] as $row) {
      $result['result'][$row['folio']]['folio'] = $row['folio'];
      $result['result'][$row['folio']]['titulo'] = $row['titulo'];
      $result['result'][$row['folio']]['clave_estado'] = $row['clave_estado'];
      $result['result'][$row['folio']]['revisores'][$row['id_usuario']]['revisor'] = $row['revisor'];
      $result['result'][$row['folio']]['revisores'][$row['id_usuario']]['clave_estado'] = ($row['revisado']==true) ? 'Revisado' : 'Sin revisar';
      $result['result'][$row['folio']]['revisores'][$row['id_usuario']]['fecha_limite_revision'] = $row['fecha_limite_revision'];
      $metodologia = json_decode($row['metodologia'],true);
      $result['result'][$row['folio']]['metodologia'] = $metodologia[$lenguaje];
      $result['result'][$row['folio']]['numero_revisiones'] = $row['numero_revisiones'];
      }
      return $result;
      } */

    private function en_revision() {
        $lenguaje = obtener_lenguaje_actual();
        $respuesta_model = $this->gestion_revision->get_en_revision();
        $result = array('success' => $respuesta_model['success'], 'msg' => $respuesta_model['msg'], 'result' => []);
        foreach ($respuesta_model['result'] as $row) {
            $result['result'][$row['id_solicitud']] = $row;
            //$result['result'][$row['id_solicitud']]['revisores'] = $row['revisor'];
            /* $result['result'][$row['folio']]['folio'] = $row['folio'];
              $result['result'][$row['folio']]['titulo'] = $row['titulo'];
              $result['result'][$row['folio']]['clave_estado'] = $row['clave_estado'];
              $result['result'][$row['folio']]['revisores'][$row['id_usuario']]['revisor'] = $row['revisor'];
              $result['result'][$row['folio']]['revisores'][$row['id_usuario']]['clave_estado'] = ($row['revisado']==true) ? 'Revisado' : 'Sin revisar';
              $result['result'][$row['folio']]['revisores'][$row['id_usuario']]['fecha_limite_revision'] = $row['fecha_limite_revision'];
              $metodologia = json_decode($row['metodologia'],true);
              $result['result'][$row['folio']]['metodologia'] = $metodologia[$lenguaje]; */
        }
        return $result;
    }

    private function revisados() {
        $lenguaje = obtener_lenguaje_actual();
        $respuesta_model = $this->gestion_revision->get_revisados();
        $result = array('success' => $respuesta_model['success'], 'msg' => $respuesta_model['msg'], 'result' => []);
        foreach ($respuesta_model['result'] as $row) {
            $result['result'][$row['id_solicitud']] = $row;
            /* $result['result'][$row['folio']]['folio'] = $row['folio'];
              $result['result'][$row['folio']]['titulo'] = $row['titulo'];
              $result['result'][$row['folio']]['clave_estado'] = $row['clave_estado'];
              $result['result'][$row['folio']]['revisores'][$row['id_usuario']]['revisor'] = $row['revisor'];
              $result['result'][$row['folio']]['revisores'][$row['id_usuario']]['clave_estado'] = ($row['revisado']==true) ? 'Revisado' : 'Sin revisar';
              $result['result'][$row['folio']]['revisores'][$row['id_usuario']]['fecha_limite_revision'] = $row['fecha_limite_revision'];
              $metodologia = json_decode($row['metodologia'],true);
              $result['result'][$row['folio']]['metodologia'] = $metodologia[$lenguaje]; */
        }
        return $result;
    }

    private function candidatos() {
        $lenguaje = obtener_lenguaje_actual();
        $param = ['order'=>'17 desc, 7 desc '];//El 17 equivale a total de suma de puntos y l 7 a la fecha
        $respuesta_model = $this->gestion_revision->get_candidatos($param);
        $result = array('success' => $respuesta_model['success'], 'msg' => $respuesta_model['msg'], 'result' => []);
        foreach ($respuesta_model['result'] as $row) {
            $result['result'][$row['id_solicitud']] = $row;
            /* $result['result'][$row['folio']]['folio'] = $row['folio'];
              $result['result'][$row['folio']]['titulo'] = $row['titulo'];
              $result['result'][$row['folio']]['clave_estado'] = $row['clave_estado'];
              $result['result'][$row['folio']]['revisores'][$row['id_usuario']]['revisor'] = $row['revisor'];
              $result['result'][$row['folio']]['revisores'][$row['id_usuario']]['clave_estado'] = ($row['revisado']==true) ? 'Revisado' : 'Sin revisar';
              $result['result'][$row['folio']]['revisores'][$row['id_usuario']]['fecha_limite_revision'] = $row['fecha_limite_revision'];
              $metodologia = json_decode($row['metodologia'],true);
              $result['result'][$row['folio']]['metodologia'] = $metodologia[$lenguaje]; */
        }
        return $result;
    }

    /**
     * @author AleSpock
     * @date 24/05/2018
     * @param type
     * @description Función que muestra la vista del resumen de un trabajo de investigación
     */
    /* private function revisados_sin_asignar() {
      //$respuesta_model = $this->gestion_revision->get_revisados();
      $param = array(
      'where' => array(
      'hr.clave_estado' => 'evaluado',
      'hr.actual' => true,
      'd.aceptado' => null,
      'd.tipo_exposicion' => null
      ),
      'order_by' => 'd.promedio, ti.fecha'
      );
      $respuesta_model = $this->gestion_revision->get_trabajos_evaluados($param);
      //pr($respuesta_model);
      return $respuesta_model;
      } */

    /* private function asignados() {
      // $respuesta_model = $this->gestion_revision->get_revisados();
      // pr($respuesta_model);
      // return $respuesta_model;
      } */

    /* private function aceptados() {
      $lenguaje = obtener_lenguaje_actual();
      $respuesta_model = $this->gestion_revision->get_aceptados();
      $result = array('success'=>$respuesta_model['success'],'msg'=>$respuesta_model['msg'],'result'=>[]);
      foreach ($respuesta_model['result'] as $row) {
      $result['result'][$row['folio']]['folio'] = $row['folio'];
      $result['result'][$row['folio']]['titulo'] = $row['titulo'];
      $metodologia = json_decode($row['metodologia'],true);
      $result['result'][$row['folio']]['metodologia'] = $metodologia[$lenguaje];
      $result['result'][$row['folio']]['tipo_exposicion'] = isset($row['tipo_exposicion']) ? $row['tipo_exposicion'] : "";
      $result['result'][$row['folio']]['promedio_revision'] = isset($row['promedio_revision']) ? $row['promedio_revision']: "";
      }
      return $result;
      }

      private function rechazados() {
      $lenguaje = obtener_lenguaje_actual();
      $respuesta_model = $this->gestion_revision->get_rechazados();
      $result = array('success'=>$respuesta_model['success'],'msg'=>$respuesta_model['msg'],'result'=>[]);
      foreach ($respuesta_model['result'] as $row) {
      $result['result'][$row['folio']]['folio'] = $row['folio'];
      $result['result'][$row['folio']]['titulo'] = $row['titulo'];
      $metodologia = json_decode($row['metodologia'],true);
      $result['result'][$row['folio']]['metodologia'] = $metodologia[$lenguaje];
      }
      return $result;
      } */

    /**
     * @author Cheko
     * @date 21/05/2018
     * @param type $id - identificador del trabajo de investigación
     * @description Función que muestra la vista del resumen de un trabajo de investigación
     */
    /* public function ver_resumen($idFolio=NULL){
      $folio = decrypt_base64($idFolio);
      //$folio = $idFolio;
      $output['trabajo_investigacion'] = $this->get_detalle_investigacion($folio);
      //pr($output['trabajo_investigacion']);
      $output['idioma'] = $this->obtener_grupos_texto('detalle_revision', $this->obtener_idioma())['detalle_revision'];
      $output['promedioFinal'] = $this->gestion_revision->get_info_promedio_final_por_trabajo($folio);
      $output['revisores'] = $this->gestion_revision->get_revisores_por_trabajo($folio);
      $output['tablaSeccion'] = $this->gestion_revision->get_promedio_por_seccion_por_trabajo($folio);
      $main_content = $this->load->view('revision_trabajo_investigacion/resumen_trabajo_investigacion.php', $output, true);
      $this->template->setMainContent($main_content);
      $this->template->getTemplate();
      } */

    /**
     * @author AleSpock
     * @date 21/05/2018
     * @param
     * @description Función que muestra la vista de los estados en la administracion de gestor de revisores
     */
    public function trabajos_investigacion_evaluacion_gestor() {
        $this->listado_control('SN_COMITE');

        $this->template->setMainContent($main_content);
        $this->template->getTemplate();
    }

    /**
     * @author JZDP
     * @Fecha 23/05/2018
     * @param string $folio Identificador del trabajo de investigación
     * @description Genera el listado de revisores disponibles para la asignación de trabajo de investigación en la sección 'Sin comite'
     *
     */
    public function asignar_revisor() {
        if ($this->input->is_ajax_request()) { //Validar que se realice una petición ajax
            if ($this->input->post()) { //Se valida que se envien datos
                $folios = $this->input->post(null, true); //Obtener valores enviados por usuario y limpiarlos
                $datos['folios_enc'] = $folios; //Enviar datos a vista
                //s$datos['folios'] = array_map("decrypt_base64", $folios); //Desencriptar identificadores de trabajos
                $this->load->model('Registro_excelencia_model', 'registro_excelencia');
                $datos['solicitud'] = $this->registro_excelencia->get_solicitud(array('where' => "s.id_solicitud IN (" . implode(",", $folios) . ")"));
                //pr($datos);
                $datos['revisores'] = $this->gestion_revision->get_revisores()['result']; //Obtener listado de revisores

                $this->load->view('revision_solicitud/asignar_revisor.php', $datos);
            }
        }
    }

    /**
     * @author JZDP
     * @Fecha 23/05/2018
     * @param string $folio Identificador del trabajo de investigación
     * @description Genera el listado de revisores disponibles para la asignación de trabajo de investigación en la sección 'Requiere Atención'
     *
     */
    /* public function asignar_revisor_requiere_atencion($param){
      if($this->input->is_ajax_request()){ //Validar que se realice una petición ajax
      if(isset($param) && !empty($param)){ //Se valida que se envien datos
      $folios = $this->security->xss_clean($param); ///Limpiar parámetro
      $datos['folios_enc'] = array($folios);
      $datos['folios'] = array(decrypt_base64($folios)); //Desencriptar identificadores de trabajos
      $condiciones = array('conditions'=>"iu.id_usuario not in (select id_usuario from foro.revision r1 where r1.folio='".decrypt_base64($folios)."')"); //Generar condiciones para mostrar revisores.
      $datos['revisores'] = $this->gestion_revision->get_revisores($condiciones)['result']; ///Obtener listado de revisores
      $this->load->view('revision_trabajo_investigacion/asignar_revisor.php', $datos);
      }
      }
      } */

    /**
     * @author JZDP
     * @Fecha 25/05/2018
     * @param string $folio Identificador del trabajo de investigación
     * @description Obtiene el número de revisores a remplazar por trabajo
     *
     */
    /* private function validar_numero_revisores_remplazar(){

      } */

    /**
     * @author JZDP
     * @Fecha 23/05/2018
     * @param string $folio Identificador del trabajo de investigación
     * @description Genera el listado de revisores disponibles para la asignación de trabajo de investigación
     *
     */
    public function asignar_revisor_bd() {
        if ($this->input->is_ajax_request()) { //Validar que se realice una petición ajax
            if ($this->input->post()) { //Se valida que se envien datos
                //pr($this->input->post());
                $id = $this->input->post(null, true);
                $datos['usuarios'] = array_map("decrypt_base64", $id['usuarios']); ///Obtener identificadores de usuarios
                $datos['folios'] = explode(',', $id['folios']); //Obtener identificadores de folios
                $datos['resultado'] = $this->gestion_revision->insert_asignar_revisor($datos);
                //print_r($id);
                //pr($datos);
                $this->load->view('revision_trabajo_investigacion/asignar_revisor_bd.php', $datos);
            }
        }
    }

}
