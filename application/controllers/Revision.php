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
        $this->grupo_language_text = ['registro_excelencia', 'mensajes']; //Grupo de idiomas para el controlador actual
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

    public function index() {
        $output = [];
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

        if (!empty($output['solicitud_excelencia'])) {//Valida que no sea vacio
            $output['solicitud_excelencia'] = $output['solicitud_excelencia'][0];
            $output['datos_generales'] = $this->usuario->get_usuarios(array('where' => array("usuarios.username" => $id_informacion_usuario)))[0];
            $output['tipo_categoria'] = $this->registro_excelencia->tipo_categoria();
            $output['cursos_participacion'] = $this->get_view_listado_cursos($output['solicitud_excelencia']['id_solicitud']);
            $output['documentos_participacion'] = $this->get_view_listado_documentos($output['solicitud_excelencia']['id_solicitud']);
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

    private function get_view_listado_cursos($id_solicitud) {
//        $where = ['c.id_solicitud' => $output['solicitud']['id_solicitud']];
        $where = ['c.id_solicitud' => $id_solicitud];
        $output['cursos_participantes'] = $this->registro_excelencia->curso_participantes($where);
//        pr($output['cursos_participantes']);
        $output['language_text'] = $this->language_text;
        $output['categoria_docente'] = $this->registro_excelencia->categoria_docente();
        $select = ['id_opcion', 'opcion'];
        $where_opcion = ['tipo' => self::TIPO_OPCION_CURSO_PARTICIPANTE, 'activo' => true];
        $output['opciones_curso'] = $this->registro_excelencia->getConsutasGenerales('excelencia.opcion', $select, $where_opcion);
        $cursos_doc = $this->load->view('registro_excelencia/revision_cursos.php', $output, true);
        return $cursos_doc;
    }

    private function get_view_listado_documentos($id_solicitud) {
        $output['tipo_documentos'] = $this->registro_excelencia->tipo_documentos(array('estado' => '1', 'id_tipo_documento<>' => 9));
//        $output['estado_solicitud'] = $this->get_estado_solicitud($output['solicitud_excelencia']['cve_estado_solicitud']);
        $documentos = $this->registro_excelencia->get_documento(array('where' => 'id_solicitud=' . $id_solicitud));
        foreach ($documentos as $key => $value) {
            $output['documento'][$value['id_tipo_documento']] = $value;
        }
//        $output['documentos_doc'] = $this->load->view('registro_excelencia/revision_documentos.php', $output, true);
        $output['language_text'] = $this->language_text;
        $select = ['id_opcion', 'opcion'];
        $where_opcion = ['tipo' => self::TIPO_OPCION_DOCUMENTOS_PARTICIPANTE, 'activo' => true];
        $output['opciones_curso'] = $this->registro_excelencia->getConsutasGenerales('excelencia.opcion', $select, $where_opcion);

        $documentos_doc = $this->load->view('registro_excelencia/revision_documentos.php', $output, true);
        return $documentos_doc;
    }

    public function revision() {
        $main_content = $this->load->view('registro_excelencia/revision.tpl.php');
        $this->template->setMainContent();
        $this->template->getTemplate();
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

    public function get_cursos_participacion($solicitud) {
        $result = '';
        if (!is_null($solicitud) && is_numeric($solicitud)) {
            $where = ['c.id_solicitud' => $solicitud];
            $solicitud_excelencia = $this->registro_excelencia->curso_participantes($where);
            $output['categoria_docente'] = $this->registro_excelencia->categoria_docente();
            if (!empty($solicitud_excelencia)) {
//                pr($solicitud_excelencia );
                /* foreach ($solicitud_excelencia as $value) {
                  $output['curso'] = $value;

                  } */
                $idioma = $this->obtener_idioma();
                $lan_txt = $this->obtener_grupos_texto(array('registro_excelencia', 'template_general', 'registro_usuario'), $idioma);
                $output['language_text'] = $lan_txt;
                $output['cursos'] = $solicitud_excelencia;
                $output['solicitud'] = $this->registro_excelencia->get_solicitud(array('where' => array("s.id_solicitud" => $solicitud)))[0];
                $output['estados'] = $this->registro_excelencia->get_solicitud(array('where' => array("s.id_solicitud" => $solicitud)))[0];
                //pr($output);
                $result = $this->load->view('registro_excelencia/tabla_cursos.php', $output, true);
            }
        }
        echo $result;
    }

}
