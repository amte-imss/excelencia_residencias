<?php

defined('BASEPATH') OR exit('No direct script access allowed');

/**
 * Clase que contiene la gestion de catálogos
 * @version 	: 1.0.0
 * @author      : JZDP AND LEAS
 * */
class Registro_investigacion extends MY_Controller {

    const LISTA = 'lista', NUEVA = 'agregar', EDITAR = 'editar',
            CREAR = 'crear', LEER = 'leer', ACTUALIZAR = 'actualizar', ELIMINAR = 'eliminar',
            EXPORTAR = 'exportar';

    function __construct() {
        parent::__construct();
        $this->load->model('Trabajo_model', 'trabajo');
        $this->load->model('Catalogo_model', 'catalogo');
        $this->load->model('Convocatoria_model', 'convocatoria');
    }

    public function index($alerta = null) {
        $output = [];
        $datos_sesion = $this->get_datos_sesion();
        $id_informacion_usuario = $datos_sesion['id_informacion_usuario'];

        $lang = $this->obtener_idioma();
        $output['lang'] = $lang;
        $output['language_text'] = $this->obtener_grupos_texto(array('listado_trabajo'), $lang);
        $convocatoria = $this->convocatoria->get_activa(true);
        $output['convocatoria_activa'] = false;
        if (!empty($convocatoria) && $convocatoria[0]['registro'] == true) {
            $output['convocatoria_activa'] = true;
        }
        $listado_trabajos = $this->trabajo->listado_trabajos_autor($id_informacion_usuario, $lang);

        foreach ($listado_trabajos as $key => $value) {
            $json = json_decode($value['estado'], true);
            $value['estado_trabajo'] = $json['investigador'][$lang];
            $value['nombre_metodologia'] = json_decode($value['nombre_metodologia'], true)[$lang];

            $listado_trabajos[$key] = $value;
        }

        $output['listado'] = $listado_trabajos;
        if (!is_null($alerta)) {
            $output['alerta'] = $alerta;
        }
        $main_content = $this->load->view('trabajo/index.tpl.php', $output, true);
        $this->template->setMainContent($main_content);
        $this->template->getTemplate();
    }

    private function CleanNonACIIchar($text) {
        $input = '/[^(\x20-\x7F)]*/'; //el rango de caracteres que no queremos
        $text_output = preg_replace($input, '%', $text);
        return $text_output;
    }

    private function limpia_post_input() {
//        $this->load->helper('security');
//         $this->security->sanitize_filename($this->input->post('filename'), TRUE);
        foreach ($_POST as &$value_post) {
            if (!is_array($value_post)) {
//                $value_post = transliterator_transliterate('Any-Latin; Latin-ASCII; [\u0080-\u7fff] remove', $value_post);
//                $value_post = htmlspecialchars($value_post, ENT_QUOTES);
//                $value_post = mb_convert_encoding($value_post, 'HTML-ENTITIES', 'UTF-8');
                $value_post = str_replace("%_", trim("%"), $value_post);
                $value_post = str_replace("%", trim("\$\$%\$\$"), $value_post);
//                $value_post = remove_invisible_characters($value_post);
//                $value_post = xss_clean($value_post);
//                $value_post = html_entity_decode($value_post, ENT_COMPAT, 'UTF-8');
//                $value_post = mb_convert_encoding($value_post, 'Windows-1252', 'UTF-8');
//                $value_post = utf8_decode($value_post);
//                $value_post = $this->CleanNonACIIchar($value_post);
                
                $value_post = utf8_decode($value_post);
                $value_post = utf8_encode($value_post);
//                $value_post = str_replace("\$\$porsentaje\$\$", "%", $value_post);
                $value_post = str_replace(trim("\$\$%\$\$"), "%_", $value_post);
                $value_post = rawurldecode($value_post);
                $value_post = trim($value_post);
            }
//            pr('$value_post');
//            pr($value_post);
//            pr($value_post);
        }
    }

    public function nuevo() {
        $this->load->library('form_complete');
        $this->load->library('form_validation');
        $this->limpia_post_input();
        //pr($this->get_datos_sesion());
//        pr($_POST);
//        pr($this->input->post(null, true));
        $post = $this->input->post(null, TRUE);
        $output = [];
        $folio = null;
        $msg = null;
        $msg_type = null;
        $trabajo = null;
        $status = true;
        $autores = [];
        $status_autores;

        //Obtenemos textos con respecto al idioma
        $idioma = $this->obtener_idioma();
        $lan_txt = $this->obtener_grupos_texto(array('registro_trabajo', 'template_general', 'registro_usuario', 'correo'), $idioma);

        $output['language_text'] = $lan_txt;

        //Catalogo de paises y tipos de metodologias tomando el idioma
        $output['tipos_metodologias'] = dropdown_options($this->trabajo->tipo_metodologia(), "id_tipo_metodologia", "lang", $idioma);
        $output['paises'] = dropdown_options($this->catalogo->get_paises(), "clave_pais", "lang", $idioma);

        if ($post) {
            $tmp = mb_convert_encoding($post['pregunta_investigacion'], 'Windows-1252', 'UTF-8');
//            pr($tmp);
//            pr(utf8_encode($tmp));
//            pr(utf8_decode($tmp));
//            pr($post['pregunta_investigacion']);
//            error_log($post['pregunta_investigacion']);
//            error_log($tmp);
//            error_log(utf8_decode($tmp));
//            error_log(utf8_decode($tmp));
            $trabajo = $post;
            //pr($post);
            //Validaciones
            $this->config->load('form_validation'); //Cargar archivo
            $validations = $this->config->item('form_registro_investigacion'); //Obtener validaciones de archivo general
            $this->set_textos_campos_validacion($validations, $lan_txt['registro_trabajo']);
            $this->form_validation->set_rules($validations); //Añadir validaciones

            if ($this->form_validation->run() == TRUE) {

                $num_caracteres = strlen($post['metodologia'] . $post['antecedentes'] . $post['problema'] . $post['justificacion'] . $post['pregunta_investigacion'] . $post['objetivo'] . $post['hipotesis'] . $post['resultados'] . $post['conclusiones'] . $post['consideraciones_eticas']);

                // if ($num_caracteres <= 2500) {

                $num_autores = count($post['autor_imss']);

                $hay_autores = ($post['autor_nombre'][0] == '' || is_null($post['autor_nombre'][0])) &&
                        ($post['autor_app'][0] == '' || is_null($post['autor_app'][0])) &&
                        ($post['autor_sexo'][0] == '' || is_null($post['autor_sexo'][0])) &&
                        ($post['autor_pais'][0] == '' || is_null($post['autor_pais'][0]));

                if (!$hay_autores) {

                    for ($i = 0; $i < $num_autores; $i++) {
                        $autor_imss = ($post['autor_imss'][$i]) ? true : false;
                        $autor_matricula = $post['autor_matricula'][$i];
                        $autor_nombre = $post['autor_nombre'][$i];
                        $autor_app = $post['autor_app'][$i];
                        $autor_apm = $post['autor_apm'][$i];
                        $autor_sexo = $post['autor_sexo'][$i];
                        $autor_pais = $post['autor_pais'][$i];

                        //Validamos requeridos
                        if ((is_null($autor_nombre) || $autor_nombre == '') ||
                                (is_null($autor_app) || $autor_app == '') ||
                                (is_null($autor_sexo) || $autor_sexo == '') ||
                                (is_null($autor_pais) || $autor_pais == '')) {
                            $status = false;
                            $msg_type = 'danger';
                            $msg = $lan_txt['registro_trabajo']['rti_autores'];
                            break;
                        } else {
                            $autores[$i] = array(
                                'es_imss' => $autor_imss,
                                'matricula' => $autor_matricula,
                                'nombre' => $autor_nombre,
                                'apellido_paterno' => $autor_app,
                                'apellido_materno' => $autor_apm,
                                'sexo' => $autor_sexo,
                                'clave_pais' => $autor_pais
                            );
                        }
                    }//for autores
                } else {
                    unset($post['autor_imss']);
                    unset($post['autor_matricula']);
                    unset($post['autor_nombre']);
                    unset($post['autor_app']);
                    unset($post['autor_apm']);
                    unset($post['autor_sexo']);
                    unset($post['autor_pais']);
                }
                //Si ingresaron coautores

                if ($status) {
                    //Pasaron las validaciones de texto y opciones
                    //Obtenemos el id de la informacion de usuario
                    $datos_sesion = $this->get_datos_sesion();
                    $id_informacion_usuario = $datos_sesion['id_informacion_usuario'];

                    //Obtenemos el id de la convocatoria
                    $convocatoria = $this->convocatoria->get_activa(true)[0];
                    $id_convocatoria = $convocatoria['id_convocatoria'];

                    // Armamos el folio
                    $num_registros = $this->trabajo->numero_trabajos();
                    $secuencial = $num_padded = sprintf("%04d", ($num_registros + 1));
                    $anio = substr($convocatoria['anio'], 2, 2);
                    $folio = "IMSS-CES-FNFIES-P-" . $anio . "-" . $secuencial;

                    // Guardamos el archivo
                    $archivo_original = $_FILES;
                    $ruta = './uploads/' . $id_informacion_usuario . '/';

                    if (crea_directorio($ruta)) {
                        //Archivo
                        $config['upload_path'] = $ruta;
                        $config['allowed_types'] = 'pdf|docx|doc';
                        $config['remove_spaces'] = TRUE;
                        $config['max_size'] = 1024 * 15;
                        $config['file_name'] = $folio;
                        $this->load->library('upload', $config);

                        if ($this->upload->do_upload('trabajo_archivo')) {
                            $upload_data = array('upload_data' => $this->upload->data());

                            $archivo = array(
                                'nombre_fisico' => $upload_data['upload_data']['file_name'],
                                'ruta' => $ruta,
                                'folio_investigacion' => $folio
                            );

                            $trabajo['id_tipo_metodologia'] = $post['tipo_metodologia'];
                            unset($trabajo['tipo_metodologia']);
                            $trabajo['titulo'] = $trabajo['titulo_trabajo'];
                            unset($trabajo['titulo_trabajo']);
                            $trabajo['folio'] = $folio;
                            $trabajo['id_convocatoria'] = $id_convocatoria;

                            unset($trabajo['autor_imss']);
                            unset($trabajo['autor_matricula']);
                            unset($trabajo['autor_nombre']);
                            unset($trabajo['autor_app']);
                            unset($trabajo['autor_apm']);
                            unset($trabajo['autor_sexo']);
                            unset($trabajo['autor_pais']);

//                            foreach ($trabajo as $key => &$value) {
//                                //pr($trabajo);
//                                //$value= str_replace('%', 'porciento' , $value);
//                                $dec = utf8_decode ($value);
//                                $value = utf8_encode($dec);
////                                $value = mb_convert_encoding($value, 'UTF-8', 'Windows-1252');
//                            }

                            $datos = array(
                                'datos' => $trabajo,
                                'registrante' => $id_informacion_usuario,
                                'autores' => $autores,
                                'archivo' => $archivo
                            );

                            $status = $this->trabajo->nuevo($datos);
                            if ($status) {
                                //Enviamos un correo notificando que se registro el trabajo
                                $this->enviar_correo_registro($datos_sesion['email'], $datos = array(
                                    'folio' => $folio,
                                    'investigador' => $datos_sesion['nombre'] . ' ' . $datos_sesion['apellido_paterno'] . ' ' . $datos_sesion['apellido_materno'],
                                    'titulo' => $post['titulo_trabajo']
                                        )
                                );
                                //$this->enviar_correo_registro($datos_sesion['email'],$folio,$post['titulo_trabajo'],$lan_txt['correo']['asunto_nuevo_trabajo'],$lan_txt['correo']['cuerpo_nuevo_trabajo']);

                                $output['msg'] = $lan_txt['registro_trabajo']['rti_success'];
                                $output['msg_type'] = 'success';
                                $output['folio'] = $folio;
                                $this->session->set_flashdata('limpiar_post_update_lenguaje', true);
                                $this->index($output);
                                return;
                            } else {
                                $msg = $lan_txt['registro_trabajo']['rti_error'];
                                $msg_type = 'danger';
                                $trabajo = $post;
                            }
                        } else {
                            $msg = array('error' => $this->upload->display_errors())['error'];
                            $msg_type = 'danger';
                            $status = false;
                        }
                    } // archivo
                } // se validaron autores
                // } else {
                //     $msg = $lan_txt['registro_trabajo']['rti_caracteres'];
                //     $msg_type = 'danger';
                //     $status = false;
                // }
                //validacion de caracteres
            } else {
                $status = false;
            } //validacion de requeridos
        } //post
        //pr($post);
        $output['msg'] = $msg;
        $output['msg_type'] = $msg_type;
        $output['folio'] = '';
        if (!$status) {
            $output['trabajo'] = $post;
        }
        /* else{
          $this->session->set_flashdata('limpiar_post_update_lenguaje', true);
          } */
        $main_content = $this->load->view('trabajo/registro.tpl.php', $output, true);
        $this->template->setMainContent($main_content);
        $this->template->getTemplate();
    }

    private function enviar_correo_registro($email, $datos) {
        $this->load->config('email');
        $this->load->library('My_phpmailer');
        $mailStatus = $this->my_phpmailer->phpmailerclass();

        /*  $mailStatus->SMTPOptions = array(
          'ssl' => array(
          'verify_peer' => false,
          'verify_peer_name' => false,
          'allow_self_signed' => true
          )
          ); */

        $mailStatus->SMTPAuth = false;
        $emailStatus = $this->load->view('correo_foro/recepcion.php', $datos, true);
        //$emailStatus = $this->procesar_correo($texto, array('{{$folio}}' => $folio, '{{$titulo}}' => $titulo));
        $mailStatus->addAddress($email);
        $mailStatus->Subject = 'Recepcion de trabajo de Investigacion';
        $mailStatus->msgHTML($emailStatus);
        $mailStatus->send();
    }

    private function procesar_correo($texto, $palabras) {
        return str_replace(array_keys($palabras), $palabras, $texto);
    }

    public function ver($folio) {
        $this->load->model('Modulo_model', 'modulo');
        $datos_sesion = $this->get_datos_sesion();
        $this->load->library('LNiveles_acceso');
        $niveles = $this->modulo->get_niveles_acceso($datos_sesion['id_usuario']);

        $output = [];
        $lang = $this->obtener_idioma();
        $output['lang'] = $lang;
        $output['datos'] = $this->trabajo->trabajo_investigacion_folio($folio, $lang)[0];
        //  $decodificar = $this->trabajo->trabajo_investigacion_folio($folio, $lang)[0];
        //
       //  $output['datos'] = $decodificar;
        //
       // foreach ($decodificar as $key => &$value ) {
        //  //pr($trabajo);
        //  //$value= str_replace('%', 'porciento' , $value);
        //
       // $dec = utf8_decode ($value);
        // $value = utf8_encode($dec);
        //
       // }

        $autores = $this->trabajo->autores_trabajo_folio($folio, $lang);
        if (!empty($autores)) {
            $output['autor_principal'] = $autores[0];
            unset($autores[0]);
            $output['autores'] = $autores;
        }

        $output['language_text'] = $this->obtener_grupos_texto(array('listado_trabajo', 'registro_trabajo', 'detalle_trabajo', 'registro_usuario'), $lang);

        $main_content = $this->load->view('trabajo/ver.tpl.php', $output, true);
        $this->template->setMainContent($main_content);
        $this->template->getTemplate();
    }

}
