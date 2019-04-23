<?php

defined('BASEPATH') OR exit('No direct script access allowed');

/**
 * Clase que contiene el registro de participantes a premio de excelencia en residencias
 * @version 	: 1.0.0
 * @author      : JZDP
 * */
class Revision extends MY_Controller {

    const TIPO_OPCION_CURSO_PARTICIPANTE = "VALIDA_CURSO",
            TIPO_OPCION_DOCUMENTOS_PARTICIPANTE = "VALIDA_DOCUMENTOS";

    function __construct() {
        $this->grupo_language_text = ['registro_excelencia', 'mensajes', 'en_revision']; //Grupo de idiomas para el controlador actual
        parent::__construct();  
        $this->load->library('form_complete');
        $this->load->library('form_validation');
        $this->load->library('seguridad');
        $this->load->library('empleados_siap');
        $this->load->library('LNiveles_acceso');
        $this->load->library('En_carrera');
        $this->load->library('En_tipo_docente');
        $this->load->helper('secureimage');
        $this->load->model('Sesion_model', 'sesion');
        $this->load->model('Convocatoria_model', 'convocatoria');
        $this->load->model('Registro_excelencia_model', 'registro_excelencia');
    }

    public function solicitud($id_solicitud = null) {
        $output = [];
        if (is_null($id_solicitud) || !is_numeric($id_solicitud)) {
            $main_content = $this->load->view('registro_excelencia/registro_no_disponible.tpl.php', $output, true);
            $this->template->setMainContent($main_content);
            $this->template->getTemplate();
//            exit();
        }

        $datos_sesion = $this->get_datos_sesion();
        $id_informacion_usuario = $datos_sesion['username'];
        $idioma = $this->obtener_idioma();
        $output['language_text'] = $this->obtener_grupos_texto(array('registro_excelencia', 'template_general', 'registro_usuario'), $idioma);
        $this->language_text = $output['language_text'];
        $convocatoria = $this->convocatoria->get_activa(true);
        $output['convocatoria_activa'] = false;
        if (!empty($convocatoria) && $convocatoria[0]['registro'] == true) {
            $output['convocatoria_activa'] = true;
        }
        $this->load->model('Usuario_model', 'usuario');
        $output['solicitud_excelencia'] = $this->registro_excelencia->listado_solicitud($id_informacion_usuario);
        $sol = $this->registro_excelencia->get_solicitud(array('where' => array("s.id_solicitud" => $id_solicitud)));
        if (!empty($sol)) {//Valida que no sea vacio
            $output['solicitud_excelencia'] = $sol[0];
            $output['estado_solicitud'] = $this->get_estado_solicitud($output['solicitud_excelencia']['cve_estado_solicitud']);
            $output['datos_generales'] = $this->usuario->get_usuarios(array('where' => array("usuarios.username" => $output['solicitud_excelencia']['matricula'])))[0];
            $output['tipo_categoria'] = $this->registro_excelencia->tipo_categoria();
            $output['cursos_participacion'] = $this->get_view_listado_cursos($output['solicitud_excelencia']);
            $output['documentos_participacion'] = $this->get_view_listado_documentos($output['solicitud_excelencia']);
            // echo $output;
            $this->template->setTitle('Premio a la Excelencia Docente');
//        $this->get_cursos_participacion($solicitud)
            //$this->template->setNav($this->load->view('tc_template/menu.tpl.php', null, TRUE));
            $main_content = $this->load->view('registro_excelencia/revision.tpl.php', $output, true);
        } else {
            $main_content = $this->load->view('registro_excelencia/registro_no_disponible.tpl.php', $output, true);
        }
        $this->template->setMainContent($main_content);
        $this->template->getTemplate();
    }

    public function solicitud_revision() {
        $this->load->model('Revision_model', 'revision');
        $output['language_text'] = $this->language_text['en_revision'];
        $output['data_revisar'] = $this->revision->get_listado_revisores();
        $main_content = $this->load->view('revision_trabajo_investigacion/listas_revisor.php', $output, true);
        $this->template->setMainContent($main_content);
        $this->template->getTemplate();
    }

    private function get_view_listado_cursos($solicitud_excelencia) {
//        $where = ['c.id_solicitud' => $output['solicitud']['id_solicitud']];
        $where = ['c.id_solicitud' => $solicitud_excelencia['id_solicitud']];
        $output['cursos_participantes'] = $this->registro_excelencia->curso_participantes($where);
//        pr($output['cursos_participantes']);
        $output['language_text'] = $this->language_text;
        $output['categoria_docente'] = $this->registro_excelencia->categoria_docente();
        $select = ['id_opcion', 'opcion'];
        $where_opcion = ['tipo' => self::TIPO_OPCION_CURSO_PARTICIPANTE, 'activo' => true];
        $output['estado_solicitud'] = $this->get_estado_solicitud($solicitud_excelencia['cve_estado_solicitud']);
        $output['opciones_curso'] = $this->registro_excelencia->getConsutasGenerales('excelencia.opcion', $select, $where_opcion);
        $output['solicitud']['id_solicitud'] = $solicitud_excelencia['id_solicitud'];
        $output['evaluacion'] = $this->get_revision_curso($solicitud_excelencia['id_solicitud']);
//        pr($output['evaluacion']);
        $cursos_doc = $this->load->view('registro_excelencia/revision_cursos.php', $output, true);
        return $cursos_doc;
    }

    private function get_view_listado_documentos($solicitud_excelencia) {
        $output['tipo_documentos'] = $this->registro_excelencia->tipo_documentos(array('estado' => '1', 'id_tipo_documento<>' => 9));
//        $output['estado_solicitud'] = $this->get_estado_solicitud($output['solicitud_excelencia']['cve_estado_solicitud']);
        $documentos = $this->registro_excelencia->get_documento(array('where' => 'id_solicitud=' . $solicitud_excelencia['id_solicitud']));
        foreach ($documentos as $key => $value) {
            $output['documento'][$value['id_tipo_documento']] = $value;
        }
//        $output['documentos_doc'] = $this->load->view('registro_excelencia/revision_documentos.php', $output, true);
        $output['language_text'] = $this->language_text;
        $select = ['id_opcion', 'opcion'];
        $where_opcion = ['tipo' => self::TIPO_OPCION_DOCUMENTOS_PARTICIPANTE, 'activo' => true];
        $output['opciones_curso'] = $this->registro_excelencia->getConsutasGenerales('excelencia.opcion', $select, $where_opcion);
        $output['estado_solicitud'] = $this->get_estado_solicitud($solicitud_excelencia['cve_estado_solicitud']);
        $output['solicitud']['id_solicitud'] = $solicitud_excelencia['id_solicitud'];
        $output['evaluacion'] = $this->get_revision_documentos($solicitud_excelencia['id_solicitud']);
//        pr($output['evaluacion']);
        $documentos_doc = $this->load->view('registro_excelencia/revision_documentos.php', $output, true);
        return $documentos_doc;
    }

    public function terminar_revision($id_solicitud) {
        $error = 0;
        $msg = '';
        $output['solicitud_excelencia'] = $this->registro_excelencia->get_solicitud(array('where' => array("s.id_solicitud" => $id_solicitud)))[0];

        $where = ['c.id_solicitud' => $id_solicitud];
        $solicitud_excelencia = $this->registro_excelencia->curso_participantes($where);
        //pr($solicitud_excelencia);
        if (count($solicitud_excelencia) <= 0) {
            $msg .= 'Debe registrar al menos un curso.<br>';
            $error++;
        }

        $documentos = $this->registro_excelencia->get_documento(array('where' => 'id_solicitud=' . $id_solicitud));
        $tipo_documentos = $this->registro_excelencia->tipo_documentos(array('estado' => '1', 'id_tipo_documento<>' => 9));
        if (count($documentos) < count($tipo_documentos)) {
            $msg .= 'Debe de completar la documentación solicitada.<br>';
            $error++;
        }
        //pr($documentos);
        //pr($tipo_documentos);
        //$this->registro_excelencia->get_documento();

        if ($error > 0) {
            echo '<div class="alert alert-danger" role="alert">' . $msg . '</div>';
        } else {
            $resultado = $this->registro_excelencia->update_solicitud(array('id_solicitud' => $id_solicitud));
            echo '<div class="alert alert-success" role="alert">' . $resultado['mensaje'] . '</div><script>alert("' . $resultado['mensaje'] . '"); document.location.href=document.location.href;</script>';
        }
    }

    public function guarda_validacion_cursos() {
        if ($this->input->post(null, true)) {
            $idioma = $this->obtener_idioma();
            $output['language_text'] = $this->obtener_grupos_texto(array('registro_excelencia', 'template_general', 'registro_usuario'), $idioma);
            $this->language_text = $output['language_text'];
            $post = $this->input->post(null, true);
//            pr($post);
            $sol = $this->registro_excelencia->get_solicitud(array('where' => array("s.id_solicitud" => $post['id_solicitud'])));
            if (!empty($sol)) {
                $datos_revision = $this->get_revision($post['id_solicitud']);
                if (is_null($datos_revision)) {//No Existe la revision
                    //Se crea el registro de revision
                    $result_crea_reg = $this->crear_registro_revision($post['id_solicitud']);
                    if ($result_crea_reg['tp_msg'] === En_tpmsg::SUCCESS) {
                        $datos_revision = $result_crea_reg['data'];
                    } else {//Error, intente mas tarde
                        echo 'Ocurrió un error durante el proceso. Por favor intentelo más tarde';
                        exit();
                    }
                }
                $result = $this->guarda_validacion_cursos_detalle($datos_revision, $post);
                if ($result['tp_msg'] == En_tpmsg::SUCCESS) {
                    $result['html'] = 'La validación se guardo correctamente';
                    header('Content-Type: application/json; charset=utf-8;');
                    echo json_encode($result);
                    exit();
                } else {
                    echo $result['html'];
                    exit();
                }
            } else {
                echo 'Ocurrió un error durante el proceso. Por favor intentelo más tarde';
                exit();
            }
        } else {
            //Error al obtener solicitud 
            echo 'Ocurrió un error durante el proceso. Por favor intentelo más tarde';
            exit();
        }
    }

    private function guarda_validacion_cursos_detalle($datos_revision, $post) {
        $cursos_evaluados = [];
        foreach ($post['documento_cursos_rev'] as $id_documento_curso) {
            $opcion_seleccionada = 'opcion_curso_' . $id_documento_curso;
            if (isset($post[$opcion_seleccionada])) {
                $cursos_evaluados[$id_documento_curso] = $post[$opcion_seleccionada];
            }
        }
        $db_d_rev_curso = $this->get_revision_curso(null, $datos_revision['id_revision']);
        if (!empty($cursos_evaluados)) {//Guarga registros
            $result = ['tp_msg' => En_tpmsg::SUCCESS];
            foreach ($cursos_evaluados as $id_documento_curso => $id_opcion) {
                if (!is_null($db_d_rev_curso) && isset($db_d_rev_curso[$id_documento_curso])) {//Actualiza registro
                    $datos_detalle = [
                        'id_opcion' => $id_opcion
                    ];
                    $where = ['id_detalle_revision_curso' => $db_d_rev_curso[$id_documento_curso]['id_detalle_revision_curso']];
                    $result_aux = $this->registro_excelencia->update_registro_general('excelencia.detalle_revision_curso', $datos_detalle, $where);
                    if ($result_aux['tp_msg'] == En_tpmsg::DANGER) {
                        $result = ['tp_msg' => En_tpmsg::DANGER,
                            'html' => 'Ocurrió un error durante el proceso. Por favor intentelo más tarde'
                        ];
                    }
                } else {//Guarda nuevo registro
                    $datos_detalle = [
                        'id_revision' => $datos_revision['id_revision'],
                        'id_documento_curso' => $id_documento_curso,
                        'id_opcion' => $id_opcion
                    ];
                    $result_aux = $this->registro_excelencia->insert_registro_general('excelencia.detalle_revision_curso', $datos_detalle, 'id_detalle_revision_curso');
                    if ($result_aux['tp_msg'] == En_tpmsg::DANGER) {
                        $result = ['tp_msg' => En_tpmsg::DANGER,
                            'html' => 'Ocurrió un error durante el proceso. Por favor intentelo más tarde'
                        ];
                    }
                }
            }
            return $result;
        } else {
            return ['tp_msg' => En_tpmsg::DANGER, 'html' => 'La validación es obligatoria'];
        }
    }

    public function guarda_validacion_documentos() {
        if ($this->input->post(null, true)) {
            $idioma = $this->obtener_idioma();
            $output['language_text'] = $this->obtener_grupos_texto(array('registro_excelencia'), $idioma);
            $this->language_text = $output['language_text'];
            $post = $this->input->post(null, true);
//            pr($post);
            $sol = $this->registro_excelencia->get_solicitud(array('where' => array("s.id_solicitud" => $post['id_solicitud'])));
//            exit();
            if (!empty($sol)) {
                $datos_revision = $this->get_revision($post['id_solicitud']);
                if (is_null($datos_revision)) {//No Existe la revision
                    //Se crea el registro de revision
                    $result_crea_reg = $this->crear_registro_revision($post['id_solicitud']);
                    if ($result_crea_reg['tp_msg'] === En_tpmsg::SUCCESS) {
                        $datos_revision = $result_crea_reg['data'];
                    } else {//Error, intente mas tarde
                        echo 'Ocurrió un error durante el proceso. Por favor intentelo más tarde';
                        exit();
                    }
                }
                $result = $this->guarda_validacion_documentos_detalle($datos_revision, $post);
                if ($result['tp_msg'] == En_tpmsg::SUCCESS) {
                    $result['html'] = 'La validación se guardo correctamente';
                    header('Content-Type: application/json; charset=utf-8;');
                    echo json_encode($result);
                    exit();
                } else {
                    echo $result['html'];
                    exit();
                }
            } else {
                echo 'Ocurrió un error durante el proceso. Por favor intentelo más tarde';
                exit();
            }
        } else {
            //Error al obtener solicitud 
            echo 'Ocurrió un error durante el proceso. Por favor intentelo más tarde';
            exit();
        }
    }

    private function guarda_validacion_documentos_detalle($datos_revision, $post) {
        $documentos_evaluados = [];
        foreach ($post['documento_rev'] as $id_documento) {
            $opcion_seleccionada = 'opcion_documento_' . $id_documento;
            if (isset($post[$opcion_seleccionada])) {
                $documentos_evaluados[$id_documento] = $post[$opcion_seleccionada];
            }
        }
        $db_d_rev_documentos = $this->get_revision_documentos(null, $datos_revision['id_revision']);
        if (!empty($documentos_evaluados)) {//Guarga registros
            $result = ['tp_msg' => En_tpmsg::SUCCESS];
            foreach ($documentos_evaluados as $id_documento => $id_opcion) {
                if (!is_null($db_d_rev_documentos) && isset($db_d_rev_documentos[$id_documento])) {//Actualiza registro
                    $datos_detalle = [
                        'id_opcion' => $id_opcion
                    ];
                    $where = ['id_detalle_revision_documento' => $db_d_rev_documentos[$id_documento]['id_detalle_revision_documento']];
                    $result_aux = $this->registro_excelencia->update_registro_general('excelencia.detalle_revision_documento', $datos_detalle, $where);
                    if ($result_aux['tp_msg'] == En_tpmsg::DANGER) {
                        $result = ['tp_msg' => En_tpmsg::DANGER,
                            'html' => 'Ocurrió un error durante el proceso. Por favor intentelo más tarde'
                        ];
                    }
                } else {//Guarda nuevo registro
                    $datos_detalle = [
                        'id_revision' => $datos_revision['id_revision'],
                        'id_documento' => $id_documento,
                        'id_opcion' => $id_opcion
                    ];
                    $result_aux = $this->registro_excelencia->insert_registro_general('excelencia.detalle_revision_documento', $datos_detalle, 'id_detalle_revision_documento');
                    if ($result_aux['tp_msg'] == En_tpmsg::DANGER) {
                        $result = ['tp_msg' => En_tpmsg::DANGER,
                            'html' => 'Ocurrió un error durante el proceso. Por favor intentelo más tarde'
                        ];
                    }
                }
            }
            return $result;
        } else {
            return ['tp_msg' => En_tpmsg::DANGER, 'html' => 'La validación es obligatoria'];
        }
    }

    private function crear_registro_revision($id_solicitud) {
        $user = $this->get_datos_sesion();
        $datos_archivo = [
            "id_solicitud" => $id_solicitud,
            "id_usuario_revision" => $user[En_datos_sesion::ID_USUARIO],
        ];
        $result_insert = $this->registro_excelencia->insert_registro_general('excelencia.revision', $datos_archivo, 'id_revision');
        return $result_insert;
    }

    private function get_revision($id_solicitud) {
        $select = ['id_revision', 'id_solicitud', 'id_usuario_revision', 'observaciones',
            'estatus', 'fecha_revision', 'fecha_asignacion'
        ];
        $where = ["id_solicitud" => $id_solicitud];
        $archivo_curso = $this->registro_excelencia->getConsutasGenerales('excelencia.revision r', $select, $where);
        if (!empty($archivo_curso)) {
            return $archivo_curso[0];
        }
        return null;
    }

    private function get_revision_curso($id_solicitud = null, $id_revision = null) {
        if (is_null($id_solicitud) && is_null($id_revision)) {
            return null;
        }
        $select = ["r.id_revision", "r.id_solicitud", "drc.id_detalle_revision_curso",
            "drc.id_documento_curso", "drc.id_opcion"
        ];
        if (!is_null($id_solicitud)) {
            $where['r.id_solicitud'] = $id_solicitud;
        }
        if (!is_null($id_revision)) {
            $where['r.id_revision'] = $id_revision;
        }
        $join = ['excelencia.detalle_revision_curso drc' => ['typejoin' => 'inner', 'condicion' => 'drc.id_revision = r.id_revision']];
        $result_revision_curso = $this->registro_excelencia->getConsutasGenerales('excelencia.revision r', $select, $where, $join);
        if (!empty($result_revision_curso)) {
            $result = [];
            foreach ($result_revision_curso as $value) {
                $result[$value['id_documento_curso']] = $value;
            }
            return $result;
        }
        return null;
    }

    private function get_revision_documentos($id_solicitud = null, $id_revision = null) {
        if (is_null($id_solicitud) && is_null($id_revision)) {
            return null;
        }
        $select = ["r.id_revision", "r.id_solicitud", "drd.id_detalle_revision_documento",
            "drd.id_documento", "drd.id_opcion"
        ];
        if (!is_null($id_solicitud)) {
            $where['r.id_solicitud'] = $id_solicitud;
        }
        if (!is_null($id_revision)) {
            $where['r.id_revision'] = $id_revision;
        }
        $join = ['excelencia.detalle_revision_documento drd' => ['typejoin' => 'inner', 'condicion' => 'drd.id_revision = r.id_revision']];
        $result_revision_curso = $this->registro_excelencia->getConsutasGenerales('excelencia.revision r', $select, $where, $join);
        if (!empty($result_revision_curso)) {
            $result = [];
            foreach ($result_revision_curso as $value) {
                $result[$value['id_documento']] = $value;
            }
            return $result;
        }
        return null;
    }

    private function get_estado_solicitud($cve_estado_solicitud) {
        $data['estado'] = $this->registro_excelencia->get_estado_solicitud(array('where' => 'cve_estado_solicitud=\'' . $cve_estado_solicitud . '\''));
        $data['config'] = null;
        $data['transicion'] = null;
        if (count($data['estado']) > 0) {
            $data['config'] = json_decode($data['estado'][0]['config'], true);
            $data['transicion'] = json_decode($data['estado'][0]['transicion'], true);
        }

        return $data;
    }

}
