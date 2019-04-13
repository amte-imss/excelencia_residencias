<?php

defined('BASEPATH') OR exit('No direct script access allowed');

/**
 * Clase que contiene el registro de participantes a premio de excelencia en residencias
 * @version 	: 1.0.0
 * @author      : JZDP
 * */
class Registro extends MY_Controller {
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

        $output['language_text'] = $this->grupo_language_text;
        $convocatoria = $this->convocatoria->get_activa(true);
        $output['convocatoria_activa'] = false;
        if (!empty($convocatoria) && $convocatoria[0]['registro'] == true) {
            $output['convocatoria_activa'] = true;
        }
        $output['listado'] = $this->registro_excelencia->listado_solicitud($id_informacion_usuario);
       // echo $output;
        $this->template->setTitle('Premio a la Excelencia Docente');
        //$this->template->setNav($this->load->view('tc_template/menu.tpl.php', null, TRUE));
        $main_content = $this->load->view('dashboard/index.tpl.php', $output, true);
        $this->template->setMainContent($main_content);
        $this->template->getTemplate(true, 'tc_template/index_login.tpl.php');
    }

    public function solicitud($registro=null){
        $output = [];
        $datos_sesion = $this->get_datos_sesion();
        $id_informacion_usuario = $datos_sesion['username'];

        $idioma = $this->obtener_idioma();
        $lan_txt = $this->obtener_grupos_texto(array('registro_excelencia', 'template_general', 'registro_usuario'), $idioma);

        if(!is_null($registro)){
            $output['solicitud_excelencia'] = $this->registro_excelencia->get_solicitud(array('where'=>array("s.id_solicitud"=>$registro)))[0];
        }

        if($this->input->post() && !empty($output['solicitud_excelencia'])){
            //pr($this->input->post());
            $trabajo = $this->input->post(null, true);
            //pr($trabajo);
            $this->config->load('form_validation'); //Cargar archivo
            $validations = $this->config->item('form_registro_excelencia'); //Obtener validaciones de archivo general
            //$this->set_textos_campos_validacion($validations, $lan_txt['registro_trabajo']);
            $this->form_validation->set_rules($validations); //Añadir validaciones
            if(isset($trabajo['carrera']) && $trabajo['carrera']==1){
                $this->form_validation->set_rules('tipo_categoria', '¿Qué categoría tiene?', 'required');
            }
            /*if(isset($trabajo['pnpc']) && $trabajo['pnpc']==1){
                $this->form_validation->set_rules('pnpc_anio', '¿De qué año?', 'required');
            }*/

            if ($this->form_validation->run() == TRUE) {
                $trabajo['matricula'] = $id_informacion_usuario;
                $solicitud_excelencia = $this->registro_excelencia->insertar_solicitud($trabajo);
                //$registro = $solicitud_excelencia['id_solicitud'];
                redirect('/registro/solicitud/'.$solicitud_excelencia['id_solicitud'], 'refresh');
                //$archivos = $this->archivos($_FILES, array('id_informacion_usuario'=>$id_informacion_usuario));
                //pr($archivos);
            }
        }//pr($output);
        
        $output['tipo_documentos'] = $this->registro_excelencia->tipo_documentos(array('estado'=>'1'));
        $output['tipo_categoria'] = $this->registro_excelencia->tipo_categoria();
        $output['pnpc_anio'] = $this->registro_excelencia->pnpc_anio();
        $output['categoria_docente'] = $this->registro_excelencia->categoria_docente();
        $output['curso'] = dropdown_options($this->registro_excelencia->curso(), "id_especialidad", "especialidades");
        

        $this->load->model('Usuario_model', 'usuario');
        $output['solicitud'] = $this->usuario->get_usuarios(array('where'=>array("usuarios.username"=>$id_informacion_usuario)));

        $output['language_text'] = $lan_txt;

        $main_content = $this->load->view('registro_excelencia/registro.tpl.php', $output, true);
        $this->template->setMainContent($main_content);
        $this->template->getTemplate();
    }

    public function guardar_curso_participado(){
        if($this->input->post(null, true)){
            
        }
    }

    private function archivos(&$archivos, $params){
        // Armamos el folio
        /*$num_registros = $this->trabajo->numero_trabajos();
        $secuencial = $num_padded = sprintf("%04d", ($num_registros + 1));
        
        */
        // Guardamos el archivo
        $resultado = array();
        $files = $archivos;
        $ruta = './uploads/' . $params['id_informacion_usuario'] . '/';
        if (crea_directorio($ruta)) {
            $anio = date('Y');

            //Archivo
            $config['upload_path'] = $ruta;
            $config['allowed_types'] = 'pdf';
            $config['remove_spaces'] = TRUE;
            $config['max_size'] = 1024 * 15;
            $config['overwrite'] = TRUE;
            //$config['file_name'] = $folio;
            $this->load->library('upload', $config);

            for($i=0; $i< count($_FILES['archivo']['name']); $i++)
            foreach ($_FILES['archivo']['name'] as $key => $value)
            {
                $folio = $anio . "-" . $key;
                //$_FILES['archivo']['name']= $files['archivo']['name'][$key];
                $_FILES['archivo']['name']= $folio.".pdf";
                $_FILES['archivo']['type']= $files['archivo']['type'][$key];
                $_FILES['archivo']['tmp_name']= $files['archivo']['tmp_name'][$key];
                $_FILES['archivo']['error']= $files['archivo']['error'][$key];
                $_FILES['archivo']['size']= $files['archivo']['size'][$key];    

                //pr($_FILES);
                $this->upload->initialize($config);
                if ( ! $this->upload->do_upload('archivo'))
                {
                    $data = null;
                    $error = $this->upload->display_errors();
                    $res = false;
                }
                else
                {
                    $error = null;
                    $data = $this->upload->data();
                    $res = true;
                }
                $resultado['archivos'][$key]['resultado'] = $res;
                $resultado['archivos'][$key]['data'] = $data;
                $resultado['archivos'][$key]['error'] = $error;
            }
            return $resultado;
        }
    }

}