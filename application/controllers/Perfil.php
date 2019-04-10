<?php

defined('BASEPATH') OR exit('No direct script access allowed');

/**
 * Description of Modulo
 *
 * @author chrigarc
 */
class Perfil extends MY_Controller {

  const INTERNOS = 'internos', EXTERNOS = 'externos', REGISTRO_USUARIO = "registro_usuario";

  function __construct() {
      $this->grupo_language_text = ['registro_usuario', 'sesion']; //Grupo de idiomas para el controlador actual
      parent::__construct();
//        $this->load->model('Modulo_model', 'modulo');
        $this->load->library('form_complete');
        $this->load->library('seguridad');
        $this->load->library('empleados_siap');
        $this->load->library('form_validation');
        $this->load->model('Usuario_model', 'usuario');
        $this->load->model('Catalogo_model', 'catalogo');
  }

  /**
  * Controlador que muestra la informacion general de un usuario
  * @author ale, clapas
  * @date 19/08/2018
  */
  public function ver() {
    $user_sesion = $this->get_datos_sesion();
    $es_imss = $this->get_datos_sesion(En_datos_sesion::ES_IMSS);
    $datos_usuario = $this->usuario->obtener_informacion_usuario(array('where'=>array('id_informacion_usuario'=> $user_sesion['id_informacion_usuario'])))[0];
    $output['language_text'] = $this->language_text;
    //pr($datos_usuario);
    switch ($datos_usuario['sexo']) {
      case 'M':
        $datos_usuario['sexo'] = $this->language_text['registro_usuario']['ext_sexo_m'];
        break;

      case 'F':
        $datos_usuario['sexo'] = $this->language_text['registro_usuario']['ext_sexo_f'];
        break;

      case 'O':
        $datos_usuario['sexo'] = $this->language_text['registro_usuario']['ext_sexo_o'];
        break;

      default:
        break;
    }
    $output ['datos_usuario'] = $datos_usuario;

    if ($es_imss) {//Edición imsss
      $config['ruta_registro'] = "sesion/registro_internos_ver.php";
    } else {//Es un externo
        $config['ruta_registro'] = "sesion/registro_externos_ver.php";
    }

    $output['paises'] = dropdown_options($this->catalogo->get_paises(), "clave_pais", "lang", $this->obtener_idioma());

    $main_content = $this->load->view($config['ruta_registro'], $output, TRUE);
    $this->template->setMainContent($main_content);
    $this->template->getTemplate();

  }


  /**
  * Controlador para editar el perfil por parte de un usuario
  * @author clapas
  * @date 15/06/2018
  */
  public function editar(){
    $user_sesion = $this->get_datos_sesion();
    $datos_usuario = $user_sesion;
    $es_imss = $this->get_datos_sesion(En_datos_sesion::ES_IMSS);
    //pr($user_sesion);
    $id_info_u = $user_sesion['id_informacion_usuario'];
    $post = $this->input->post(null,TRUE);
    //pr($post);

    if ($es_imss) {//Edición imsss
      $ruta_registro = "sesion/registro_internos_edicion.php";
      //$config['tipo_edicion'] = Usuario_model::SIAP;
      $config['tipo_edicion'] = Perfil::INTERNOS;
      $config['validaciones'] = 'form_editar_usuario_internos';
    } else {//Es un externo
      $ruta_registro = "sesion/registro_externos_edicion.php";
      //$config['tipo_edicion'] = Usuario_model::NO_IMSS;
      $config['tipo_edicion'] = Perfil::EXTERNOS;
      $config['validaciones'] = 'form_editar_usuario_externos';
    }

    if($post){
      $msg = '';
      $msg_type = 'danger';
      $success = false;

      $datos_usuario = array(
          'nombre' => $post['ext_nombre'],
          'apellido_paterno' => $post['ext_ap'],
          'apellido_materno' => $post['ext_am'],
          'sexo' => $post['sexo'],
          'email' => $post['ext_mail'],
          'telefono_personal' => $post['telefono_personal'],
          'telefono_oficina' => $post['telefono_oficina'],
          'clave_pais' => $post['pais_origen']
      );
      if(!$es_imss) {
        $datos_usuario['pais_institucion'] = $post['pais_institucion'];
        $datos_usuario['institucion'] = $post['institucion'];
      }
      //pr($datos_usuario);
      $this->config->load('form_validation'); //Cargar archivo con validaciones
      $validations = $this->config->item($config['validaciones']); //Obtener validaciones de archivo general
      $this->set_textos_campos_validacion($validations, $this->language_text['registro_usuario']); //Modifica los textos del nombre de campo
      $this->form_validation->set_rules($validations);

      if ($this->form_validation->run() == TRUE) {
        $param = array(
          'where' => array('id_informacion_usuario'=>$id_info_u),
          'datos' => $datos_usuario
        );

        if($this->usuario->actualizar_informacion($param)){
          $success = true;
          $msg_type = 'success';
          $msg = 'Su información se actualizó correctamente';
        }else{

          $msg = 'Ocurrio un problema, intentelo de nuevo';
        }
        $output['salida'] = array( 'msg' => $msg, 'success' => $success, 'msg_type' => $msg_type );
      }
    } else {
      $datos_usuario = $this->usuario->obtener_informacion_usuario(array('where'=>array('id_informacion_usuario'=>$id_info_u)))[0];
    }

    $output ['datos_usuario']= $datos_usuario;
    $output['paises'] = dropdown_options($this->catalogo->get_paises(), "clave_pais", "lang", $this->obtener_idioma());
    $output['language_text'] = $this->language_text;

    $main_content = $this->load->view($ruta_registro, $output, TRUE);
    $this->template->setMainContent($main_content);
    $this->template->getTemplate();

  }

  /**
  * Controlador para el cambio de contraseña
  * @author clapas
  * @date 19/06/2018
  */
  public function password()
  {
    $post = $this->input->post(null,TRUE);

    if($post){
      $msg = '';
      $msg_type = 'danger';
      $success = false;

      //pr($post);
      $this->config->load('form_validation'); //Cargar archivo con validaciones
      $validations = $this->config->item('form_editar_password'); //Obtener validaciones de archivo general
      $this->set_textos_campos_validacion($validations, $this->language_text['registro_usuario']); //Modifica los textos del nombre de campo
      $this->form_validation->set_rules($validations);

      if ($this->form_validation->run() == TRUE) {
        $user_sesion = $this->get_datos_sesion();

        $param = array(
          'pass' => $post['reg_password'],
          'id_usuario' => $user_sesion['id_usuario'],
        );

        if($this->usuario->update('password',$param)){
          $success = true;
          $msg_type = 'success';
          $msg = 'Su contraseña se actualizó correctamente';
        }else{
          $msg = 'Ocurrio un problema, intentelo de nuevo';
        }
        $output['salida'] = array( 'msg' => $msg, 'success' => $success, 'msg_type' => $msg_type );
      }
    }

    $output['language_text'] = $this->language_text;
    $main_content = $this->load->view('sesion/cambiar_password.tpl.php', $output, TRUE);
    $this->template->setMainContent($main_content);
    $this->template->getTemplate();
  }
}
