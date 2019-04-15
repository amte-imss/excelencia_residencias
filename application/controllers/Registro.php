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
            $id_solicitud = $output['solicitud_excelencia']['id_solicitud'];
        } else {
            $output['solicitud_excelencia'] = $this->registro_excelencia->get_solicitud(array('where'=>array("u.username"=>$id_informacion_usuario)));
            //pr($output);
            if(isset($output['solicitud_excelencia'][0]) && count($output['solicitud_excelencia'][0])>0){
                redirect('/registro/solicitud/'.$output['solicitud_excelencia'][0]['id_solicitud'], 'refresh');
            } else {
                $id_solicitud = null;
            }
        }
        //pr($output);
        if($this->input->post()){ // && !empty($output['solicitud_excelencia'])
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
            } else {
                //pr($trabajo);
                $output['solicitud_excelencia'] = $trabajo;
            }
        } //pr($output);

        if(!is_null($id_solicitud)){ //Validamos que exista identificador de solicitud para realizar la búsqueda de información
            $documentos = $this->registro_excelencia->get_documento(array('where'=>'id_solicitud='.$id_solicitud));
            foreach ($documentos as $key => $value) {
                $output['documento'][$value['id_tipo_documento']] = $value;
            }
        }
        
        $output['tipo_documentos'] = $this->registro_excelencia->tipo_documentos(array('estado'=>'1', 'id_tipo_documento<>'=>9));
        $output['tipo_categoria'] = $this->registro_excelencia->tipo_categoria();
        //$output['pnpc_anio'] = $this->registro_excelencia->pnpc_anio();
        $output['categoria_docente'] = $this->registro_excelencia->categoria_docente();
        $output['curso'] = dropdown_options($this->registro_excelencia->curso(), "id_especialidad", "especialidades");
        $pncp_curso = [["id_pnc_curso" => true, "nombre" => 'Sí'], ["id_pnc_curso" => false, "nombre" => 'No']];
        $output['pncp_curso'] = dropdown_options($pncp_curso, "id_pnc_curso", "nombre");

        $this->load->model('Usuario_model', 'usuario');
        $output['solicitud'] = $this->usuario->get_usuarios(array('where'=>array("usuarios.username"=>$id_informacion_usuario)));
        $output['language_text'] = $lan_txt;
        $main_content = $this->load->view('registro_excelencia/registro.tpl.php', $output, true);
        $this->template->setMainContent($main_content);
        $this->template->getTemplate();
    }

    public function cargar_archivo(){
        if($_FILES){
            //pr($_POST);
            $id_tipo_documento = $this->input->post('id_tipo_documento', TRUE);
            $id_solicitud = $this->input->post('id_solicitud', TRUE);
            $datos_sesion = $this->get_datos_sesion();
            $id_informacion_usuario = $datos_sesion['username'];
            $archivos = $this->archivos($_FILES, array('id_informacion_usuario'=>$id_informacion_usuario, 'id_tipo_documento'=>$id_tipo_documento));
            //pr($archivos);
            if($archivos['resultado']==true){
                $datos_archivo = array(
                    'ruta' => trim($archivos['data']['ruta'], '.').$archivos['data']['file_name'],
                    'extension_archivo' => 'pdf',
                    'id_solicitud' => $id_solicitud,
                    'id_tipo_documento' => $id_tipo_documento
                );
                $insercion_archivo = $this->registro_excelencia->insertar_documento($datos_archivo);
                if($insercion_archivo['result']==true){
                    echo $this->load->view('registro_excelencia/archivo_correcto', array('id_tipo_documento'=>$id_tipo_documento, 'ruta'=>base_url().trim($archivos['data']['ruta'], '.').$archivos['data']['file_name']), true);
                } else {
                    echo $this->load->view('registro_excelencia/archivo_incorrecto', array('id_tipo_documento'=>$id_tipo_documento, 'error'=>$insercion_archivo['msg']), true);
                }
            } else {
                echo $this->load->view('registro_excelencia/archivo_incorrecto', array('id_tipo_documento'=>$id_tipo_documento, 'error'=>$archivos['error']), true);
            }
        } else {
            return "No se ha enviado archivo a procesar.";
        }
    }

    public function enviar_solicitud($id_solicitud){
        $error = 0;
        $msg = '';
        $output['solicitud_excelencia'] = $this->registro_excelencia->get_solicitud(array('where'=>array("s.id_solicitud"=>$id_solicitud)))[0];
        
        $where = ['c.id_solicitud' => $id_solicitud];
        $solicitud_excelencia = $this->registro_excelencia->curso_participantes($where);
        //pr($solicitud_excelencia);
        if(count($solicitud_excelencia)<=0){
            $msg .= 'Debe registrar al menos un curso.<br>';
            $error++;
        }

        $documentos = $this->registro_excelencia->get_documento(array('where'=>'id_solicitud='.$id_solicitud));
        $tipo_documentos = $this->registro_excelencia->tipo_documentos(array('estado'=>'1', 'id_tipo_documento<>'=>9));
        if(count($documentos)<count($tipo_documentos)){
            $msg .= 'Debe de completar la documentación solicitada.<br>';
            $error++;
        }
        //pr($documentos);
        //pr($tipo_documentos);
        //$this->registro_excelencia->get_documento();

        if($error > 0){
            echo '<div class="alert alert-danger" role="alert">'.$msg.'</div>';
        } else {
            $resultado = $this->registro_excelencia->update_solicitud(array('id_solicitud'=>$id_solicitud));
            echo '<div class="alert alert-success" role="alert">'.$resultado['mensaje'].'</div><script>alert("'.$resultado['mensaje'].'"); document.location.href=document.location.href;</script>';
        }
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
        //pr($params);
        //pr($_FILES['archivo_'.$params['id_tipo_documento']]);
        //pr($files);
        $ruta = './uploads/' . $params['id_informacion_usuario'] . '/';
        if (crea_directorio($ruta)) {
            $anio = date('Y');

            //Archivo
            $config['upload_path'] = $ruta;
            $config['allowed_types'] = 'pdf';
            $config['remove_spaces'] = TRUE;
            $config['max_size'] = 1024 * 20;
            $config['overwrite'] = TRUE;
            //$config['file_name'] = $folio;
            $this->load->library('upload', $config);

            //for($i=0; $i< count($_FILES['archivo']['name']); $i++)
            //foreach ($_FILES['archivo_'.$params['id_tipo_documento']]['name'] as $key => $value)
            //{
                $folio = $anio . "-" . $params['id_tipo_documento'];
                //$_FILES['archivo']['name']= $files['archivo']['name'][$key];
                $_FILES['archivo_'.$params['id_tipo_documento']]['name']= $folio.".pdf";
                /*$_FILES['archivo_'.$params['id_tipo_documento']]['type']= $files['archivo']['type'][$key];
                $_FILES['archivo_'.$params['id_tipo_documento']]['tmp_name']= $files['archivo']['tmp_name'][$key];
                $_FILES['archivo_'.$params['id_tipo_documento']]['error']= $files['archivo']['error'][$key];
                $_FILES['archivo_'.$params['id_tipo_documento']]['size']= $files['archivo']['size'][$key];    */

                //pr($_FILES);
                $this->upload->initialize($config);
                if ( ! $this->upload->do_upload('archivo_'.$params['id_tipo_documento']))
                {
                    $data = null;
                    $error = $this->upload->display_errors();
                    $res = false;
                }
                else
                {
                    $error = null;
                    $data = $this->upload->data();
                    $data['ruta'] = $ruta;
                    $res = true;
                }
                $resultado['resultado'] = $res;
                $resultado['data'] = $data;
                $resultado['error'] = $error;
            //}
            return $resultado;
        }
    }
    
    public function guarda_cursos() {
        if ($this->input->post()) {
            $data_sesion = $this->get_datos_sesion();
            $post = $this->input->post(null, true);
//            pr($data_sesion['matricula']);
//            pr($post);
            $this->config->load('form_validation'); //Cargar archivo
            $validations = $this->config->item('form_guarda_curso_participado'); //Obtener validaciones de archivo general
            //$this->set_textos_campos_validacion($validations, $lan_txt['registro_trabajo']);
            $post['archivo_curso'] = $_FILES['archivo_curso']['name'];
//            pr($post);
            $this->form_validation->set_data($post); //Añadir validaciones
            $this->form_validation->set_rules($validations); //Añadir validaciones
            if ($this->form_validation->run() == TRUE) {
                $carga_file = $this->save_file('cursos_participacion', $data_sesion['matricula'], 'cp', 'archivo_curso');
                if ($carga_file['tp_msg'] == En_tpmsg::SUCCESS) {
                    $file = $carga_file['upload_path'] . $carga_file['file_name']; //Ruta del archivo 
                    $extension = $carga_file['file_ext'];
                    $datos_archivo = ['ruta' => $file,
                        'id_tipo_documento' => 9,
                        'extension_archivo' => $extension
                    ];
                    $result_insert = $this->registro_excelencia->insert_registro_general('excelencia.documento_curso', $datos_archivo, 'id_documento_curso');
                    if ($result_insert['tp_msg'] == En_tpmsg::SUCCESS) {
                        $datos_curso = ['id_tipo_docente' => $post['categoria_docente'],
                            'id_especialidad' => $post['curso'],
                            'id_solicitud' => $post['solicitud_cur'],
                            'obtuvo_pnpc' => boolval($post['pncp_curso']),
                            'anios' => $post['anios_docente'],
                            'id_documento_curso' => $result_insert['data']['id_documento_curso'],
                        ];
                        $result_insert = $this->registro_excelencia->insert_registro_general('excelencia.curso', $datos_curso, 'id_curso');
                        if ($result_insert['tp_msg'] == En_tpmsg::SUCCESS) {
                            $result['tp_msg'] = En_tpmsg::SUCCESS;
                            $result['html'] = 'Se guardo el registro exitosamente';
                            header('Content-Type: application/json;charset=utf-8');
                            echo json_encode($result);
                        } else {
                            echo 'No fue posible guardar el curso. Por favor intentelo mas tarde';
                            exit();
                        }
                    } else {
                        echo 'No fue posible guardar el archivo. Por favor intentelo mas tarde';
                        exit();
                    }
                } else {
                    echo $carga_file['mensaje'];
                    exit();
                }
            } else {
//                $result['tp_msg'] = En_tpmsg::DANGER; 
                echo validation_errors();
                exit();
            }
        }
    }

    public function eliminar_curso($id_curso=null){
        $output = [];
        $output['result'] = false;
        $output['msg'] = 'Ocurrió un error durante la eliminación.';
        if(!is_null($id_curso)){            
            $datos_sesion = $this->get_datos_sesion(); //Se obtienen datos de sesión para validar que solo el usuario pueda hacer modificaciones
            $id_informacion_usuario = $datos_sesion['username'];

            $idioma = $this->obtener_idioma(); //Carga de textos a utilizar
            $lan_txt = $this->obtener_grupos_texto(array('registro_excelencia', 'template_general', 'registro_usuario'), $idioma);

            ///Validación de pertenencia con usuario con sesión
            $datos_curso = $this->registro_excelencia->get_curso_solicitud(array('where'=>array('matricula'=>$id_informacion_usuario, 'id_curso'=>$id_curso)));
            //pr($datos_curso);
            if(count($datos_curso)>0){ //Se valida que devuelve información, de ser así se elimina
                //Se elimina documento de la bd
                $this->registro_excelencia->delete_curso_documento($datos_curso[0]);
                //Se elimina documento fisicamente                
                foreach ($datos_curso as $key => $docto) {
                    if (file_exists($docto['ruta'])) {//Valida que exista el archivo
                        unlink($docto['ruta']); //elmina el fichero anterior, despues de guardar la información anterior
                    }
                }
                $output['result'] = true;
                $output['msg'] = 'Eliminación realizada.';
            }
        }
        header('Content-Type: application/json; charset=utf-8;');
        echo json_encode($output);
    }

    /**
     * Obtiene el listado de cursos 
     * @param type $solicitud
     */
    public function get_cursos_participacion($solicitud) {
        $result = '';
        if (!is_null($solicitud) && is_numeric($solicitud)) {
            $where = ['c.id_solicitud' => $solicitud];
            $solicitud_excelencia = $this->registro_excelencia->curso_participantes($where);
            $output['categoria_docente'] = $this->registro_excelencia->categoria_docente();
            if (!empty($solicitud_excelencia)) {
//                pr($solicitud_excelencia );
                /*foreach ($solicitud_excelencia as $value) {
                    $output['curso'] = $value;
                    
                }*/
                $idioma = $this->obtener_idioma();
                $lan_txt = $this->obtener_grupos_texto(array('registro_excelencia', 'template_general', 'registro_usuario'), $idioma);
                $output['language_text'] = $lan_txt;
                $output['cursos'] = $solicitud_excelencia;
                $output['solicitud'] = $this->registro_excelencia->get_solicitud(array('where'=>array("s.id_solicitud"=>$solicitud)))[0];
                //pr($output);
                $result = $this->load->view('registro_excelencia/tabla_cursos.php', $output, true);
            }
        }
        echo $result;
    }

    

 

}