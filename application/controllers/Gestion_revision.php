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
        $this->grupo_language_text = ['sin_comite', 'req_atencion', 'en_revision', "jsgrid_elementos",
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
        $datos['sesion'] = $this->get_datos_sesion();
        $datos['super'] = false;
        $this->load->library('LNiveles_acceso');
        foreach ($datos['sesion']['niveles_acceso'] as $key_s => $sesion) {
            if ($sesion['clave_rol'] == LNiveles_acceso::Super) {
                $datos['super'] = true;
            }
        }
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
                $datos['data_revisados'] = $this->candidatos();
                $datos['data_dictamen'] = $this->get_dictamen();
                $datos['total_registrados_nivel'] = $this->get_dictamen_total_nivel();
                $datos['niveles'] = dropdown_options($this->get_niveles(), 'id_nivel', 'descripcion');
                $conf = $this->gestion_revision->get_configuracion(array('where' => "llave='cupo'"));
                $datos['configuracion'] = (isset($conf['result'][0])) ? json_decode($conf['result'][0]['valor'], true) : null;
                $datos['opciones_secciones'] = $this->obtener_grupos_texto('candidatos', $this->obtener_idioma())['candidatos'];

                $output['list_revisados'] = $this->load->view('revision_solicitud/estados/lista_candidatos.php', $datos, true); //pr($datos);
                break;
            case strtolower(En_estado_solicitud::ACEPTADOS): case strtolower(En_estado_solicitud::ACEPTADOS) . "_e":
                $convocatoria = $this->get_convocatoria();
                $lang = $this->obtener_idioma();
                $datos['language_text'] = $this->language_text; //obtiene textos del lenguaje
                //        $output['listado'] = $this->trabajo->listado_trabajos_autor($id_informacion_usuario, $lang);
                $datos['lang'] = $this->obtener_idioma();
                $datos['opciones_secciones'] = $this->obtener_grupos_texto('candidatos', $this->obtener_idioma())['candidatos'];
                $datos['configuracion'] = (isset($conf['result'][0])) ? json_decode($conf['result'][0]['valor'], true) : null;
                if (!empty($convocatoria) && $convocatoria[0]['activo']) {
                    $datos['data_revisados'] = $this->candidatos();
                    $datos['data_dictamen'] = $this->get_dictamen(En_estado_solicitud::ACEPTADOS);
                    $datos['niveles'] = dropdown_options($this->get_niveles(), 'id_nivel', 'descripcion');
                    if ($tipo == strtolower(En_estado_solicitud::ACEPTADOS) . "_e") {
                        $output['lista_aceptados'] = $this->load->view('revision_solicitud/estados/lista_aceptados_exportar.php', $datos, true);
                    } else {
                        $output['lista_aceptados'] = $this->load->view('revision_solicitud/estados/lista_aceptados.php', $datos, true);
                    }
                } else if (!empty($convocatoria) && $convocatoria[0]['acceso']) {//muestra rechazados de la convocatoria
                    $datos['data_revisados'] = $this->aceptados();
                    $datos['configuracion'] = (isset($conf['result'][0])) ? json_decode($conf['result'][0]['valor'], true) : null;
//                    pr($datos['data_revisados']);
                    $output['list_rechazados'] = $this->load->view('revision_solicitud/estados/lista_aceptados_fin_dictamen.php', $datos, true);
                }

                if ($tipo == strtolower(En_estado_solicitud::ACEPTADOS) . "_e") {
                    if (isset($output['lista_aceptados'])) {
                        // Convert to UTF-16LE and Prepend BOM
                        $string_to_export = "\xFF\xFE" . mb_convert_encoding($output['lista_aceptados'], 'UTF-16LE', 'UTF-8');

                        header("Content-Encoding: UTF-8");
                        header("Content-type: application/x-msexcel;charset=UTF-8");
                        header('Content-Disposition: attachment; filename="listado_aceptados_' . date('YmdHis') . '.xls";');

                        echo $string_to_export;

                        exit();
                    }
                }
                break;
            case strtolower(En_estado_solicitud::RECHAZADOS):
                $convocatoria = $this->get_convocatoria();
                $datos['configuracion'] = (isset($conf['result'][0])) ? json_decode($conf['result'][0]['valor'], true) : null;
//                pr($convocatoria);
                $datos['opciones_secciones'] = $this->obtener_grupos_texto('candidatos', $this->obtener_idioma())['candidatos'];
                if (!empty($convocatoria) && $convocatoria[0]['activo']) {
                    $datos['data_revisados'] = $this->candidatos();
                    $datos['data_dictamen'] = $this->get_dictamen(En_estado_solicitud::RECHAZADOS);
                    $datos['niveles'] = dropdown_options($this->get_niveles(), 'id_nivel', 'descripcion');
                    $output['list_rechazados'] = $this->load->view('revision_solicitud/estados/lista_rechazados.php', $datos, true);
                } else if (!empty($convocatoria) && $convocatoria[0]['acceso']) {//muestra rechazados de la convocatoria
                    $datos['data_dictamen'] = $this->get_dictamen();
                    $datos['data_revisados'] = $this->rechazados();
                    $datos['configuracion'] = (isset($conf['result'][0])) ? json_decode($conf['result'][0]['valor'], true) : null;
//                    pr($datos['data_revisados']);
                    $output['list_rechazados'] = $this->load->view('revision_solicitud/estados/lista_rechazados_fin_dictamen.php', $datos, true);
                }
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

    private function rechazados() {
        $lenguaje = obtener_lenguaje_actual();
        $respuesta_model = $this->gestion_revision->get_rechazados();
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

    private function aceptados() {
        $lenguaje = obtener_lenguaje_actual();
        $respuesta_model = $this->gestion_revision->get_aceptados();
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
        $param = ['order' => 'tipo_contratacion desc, premio_anterior asc, id_nivel asc, 17 desc, 7 asc ']; //El 17 equivale a total de suma de puntos y l 7 a la fecha
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

    private function actualiza_dictamen($id_dictamen, $data) {
        $where = ['id_dictamen' => $id_dictamen];
        $update = $this->registro->update_registro_general('excelencia.dictamen', $data, $where);
        return $update;
    }

    public function cierre_convocatoria() {
//        $subjet_mail = 'Dictamen de evaluaci&oacute;n';
//        exit();
        $subjet_mail = 'Dictamen de evaluación';
//        $result = ['tp_msg'=> En_tpmsg::DANGER, 'html'=>'La información se guardo correctamente'];
        $result = ['tp_msg' => En_tpmsg::SUCCESS, 'html' => 'La información se guardo correctamente'];
        $output['solicitantes'] = $this->solicitantes();
        $info_extra['total_solicitudes'] = $this->gestion_revision->total_solicitudes();
        $info_extra['total_aceptados'] = $this->gestion_revision->total_aceptados()['total_aceptados'];
        $info_extra['subject'] = $subjet_mail;
//        pr($output['solicitantes']);
//        pr($$info_extra);
//        exit();
//        $output['revisados'] = $this->revisados();
        $output['dictamen'] = $this->get_dictamen();
        $output['candidatos'] = $this->candidatos();
//        pr($output['dictamen']);
        $indicador_error = FALSE;
        if (!empty($output['solicitantes']['result'])) {//Valida que existan candidatos
            $solicitantes = $output['solicitantes']['result'];
            if (!empty($output['candidatos']['result'])) {//Valida que existan candidatos
                $numero = 0;
                foreach ($output['candidatos']['result'] as $key => $val_candidatos) {
//                pr($val_candidatos);
                    $solicitante_data = array_merge($solicitantes[$val_candidatos['id_solicitud']], $info_extra);
                    if (isset($output['dictamen'][$key])) {//Valida que este dictaminado
                        $dictamen_reg = $output['dictamen'][$key];
                        if ($dictamen_reg['aceptado'] == 1) {//aceptados
                            ++$numero;
                            $secuencial = sprintf("%04d", $numero);
                            $folio_dictamen = $val_candidatos['id_solicitud'] . strtoupper($dictamen_reg['id_nivel']) . $secuencial;
                            $result = $this->actualiza_dictamen($dictamen_reg['id_dictamen'], ['folio_dictamen' => $folio_dictamen]);
                            if ($result['tp_msg'] == En_tpmsg::SUCCESS) {
                                $solicitante_data['folio'] = $folio_dictamen;
                                $solicitante_data['promedio'] = $dictamen_reg['promedio'];
                                $solicitante_data['cve_estado_solicitud'] = En_estado_solicitud::ACEPTADOS;
                                $config = ['folio', 'total_solicitudes', 'total_aceptados', 'subject', 'promedio'];
                                $this->gestion_revision->guardar_historico_estado($val_candidatos['id_solicitud'], En_estado_solicitud::ACEPTADOS);
                                $this->gurda_registros_correo_dictamen($solicitante_data, $config);
//                                $this->enviar_correo_electronico('correo_excelencia/aceptado.php', $solicitante_data['email'], $solicitante_data, $subjet_mail);
                                unset($solicitantes[$val_candidatos['id_solicitud']]); //Retira informacion del solicitante ya trabajado
                            } else {
                                if (!$indicador_error) {
                                    $indicador_error = true;
                                }
                            }
                        } else {//Rechazados
                            $config = ['total_solicitudes', 'total_aceptados', 'subject'];
                            $solicitante_data['cve_estado_solicitud'] = En_estado_solicitud::RECHAZADOS;
                            $this->gestion_revision->guardar_historico_estado($val_candidatos['id_solicitud'], En_estado_solicitud::RECHAZADOS);
                            $this->gurda_registros_correo_dictamen($solicitante_data, $config);
//                            $this->enviar_correo_electronico('correo_excelencia/rechazado.php', $solicitante_data['email'], $solicitante_data, $subjet_mail);
                            unset($solicitantes[$val_candidatos['id_solicitud']]); //Retira informacion del solicitante ya trabajado
                        }
                    } else {
                        $config = ['total_solicitudes', 'total_aceptados', 'subject'];
                        $solicitante_data['cve_estado_solicitud'] = En_estado_solicitud::RECHAZADOS;
                        $this->gestion_revision->guardar_historico_estado($val_candidatos['id_solicitud'], En_estado_solicitud::RECHAZADOS);
                        $this->gurda_registros_correo_dictamen($solicitante_data, $config);
//                        $this->enviar_correo_electronico('correo_excelencia/rechazado.php', $solicitante_data['email'], $solicitante_data, $subjet_mail);
                        unset($solicitantes[$val_candidatos['id_solicitud']]); //Retira informacion del solicitante ya trabajado
                    }
                }
                $this->notifica_cierre_rechazados($solicitantes, $output['candidatos']['result'], $info_extra, $subjet_mail);
                $this->cerrar_convocatoria(); //Cierra la convocatoria
                $this->enviar_correo_control_envios_dictamen(); //Envio de correoes
                //Envia correos a todos los solicitantes que no partisipan
                if ($result['tp_msg'] == En_tpmsg::SUCCESS) {
//                    $result = ['tp_msg' => En_tpmsg::DANGER, 'html' => 'Ocurrio un error. Por favor intentelo nuevamente'];
                    $result['html'] = 'La información se guardo correctamente';
                }
                header('Content-Type: application/json;charset=utf-8');
                echo json_encode($result);
            } else {
                $result = ['tp_msg' => En_tpmsg::DANGER, 'html' => 'Ocurrio un error. Por favor intentelo nuevamente'];
                header('Content-Type: application/json;charset=utf-8');
                echo json_encode($result);
            }
        } else {

            $result = ['tp_msg' => En_tpmsg::DANGER, 'html' => 'Ocurrio un error. Por favor intentelo nuevamente'];
            header('Content-Type: application/json;charset=utf-8');
            echo json_encode($result);
        }
    }

    private function notifica_cierre_rechazados($solicitantes, $participantes, $extra, $subjet_mail) {
//        pr($solicitantes);
        $config = ['total_solicitudes', 'total_aceptados', 'subject'];
        foreach ($solicitantes as $value) {
            $value = array_merge($value, $extra);
            $this->gestion_revision->guardar_historico_estado($value['id_solicitud'], En_estado_solicitud::RECHAZADOS);
            $value['cve_estado_solicitud'] = En_estado_solicitud::RECHAZADOS;
            $this->gurda_registros_correo_dictamen($value, $config);
//            $this->enviar_correo_electronico('correo_excelencia/rechazado.php', $value['email'], $value, $subjet_mail);
        }
    }

    private function cerrar_convocatoria() {
        $where = ['activo' => true];
        $set = [
            'activo' => FALSE, 'registro' => FALSE, 'revision' => FALSE//, 'acceso' => FALSE
        ];
        $update = $this->registro->update_registro_general('excelencia.convocatoria', $set, $where);
//        pr($update);
        if ($update['tp_msg'] == En_tpmsg::DANGER) {
            $result = ['tp_msg' => En_tpmsg::DANGER,
                'html' => 'Ocurrió un error durante el proceso. Por favor intentelo nuevamente '
            ];
            return $result;
        }
        return $update;
    }

    public function envio_correos_cierre_proceso() {
//        sss
//        pr($this->db->schema);
//        pr($this->db);
        try {
            $this->db->schema = 'excelencia';
            $crud = $this->new_crud();
            $crud->set_table('envio_correos_pendientes');
            $crud->set_subject('Correo');
            $crud->set_primary_key('id_correo_pendiente');
            $crud->columns("id_correo_pendiente", "id_convocatoria", "tipo_correo", "profesor", "matricula", "correo_electronico", "config", "fue_enviado", "fecha", "fecha_envio");
            $crud->fields("id_convocatoria", "tipo_correo", "profesor", "matricula", "correo_electronico", "config", "fue_enviado", "fecha", "fecha_envio");
            $crud->required_fields("id_convocatoria", "tipo_correo", "profesor", "matricula", "correo_electronico", "config", "fue_enviado");
//            $crud->field_type('fue_enviado', 'dropdown', array('true' => 'NO', 'FALSE' => 'SI'));
            $crud->unset_texteditor('config', 'full_text');
            $crud->unset_read();
//            $crud->unset_export();
            $output = $crud->render();
            $main_content = $this->load->view('registro_excelencia/gc_gestion_correo.tpl.php', $output, true);
            $this->template->setMainContent($main_content);
            $this->template->getTemplate();
        } catch (Exception $e) {
            show_error($e->getMessage() . ' --- ' . $e->getTraceAsString());
        }
    }

    public function envio_correos_pendientes() {
        $this->enviar_correo_control_envios_dictamen();
    }

}
