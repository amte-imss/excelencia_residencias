<?php
defined('BASEPATH') OR exit('No direct script access allowed');

/**
	*@author: Mr. Guag
	*@version: 1.0
	*@desc: Clase padre de los controladores del sistema

	 function model_load_model($model_name)
   {
      $CI =& get_instance();
      $CI->load->model($model_name);
      return $CI->$model_name;
   }
**/
class MY_Model extends CI_Model {
    function __construct(){
        parent::__construct();
        $this->load->database();   
    }

    function get_convocatoria(){
        try {
            $this->db->flush_cache();
            $this->db->reset_query();
            
            if (isset($param['where'])) {
                $this->db->where($param['where']);
            }
            
            if (isset($param['order_by'])) {
                $this->db->order_by($param['order_by']);
            }

            $res = $this->db->get('excelencia.convocatoria c');
            //pr($this->db->last_query());
            $this->db->flush_cache();
            $this->db->reset_query();
            $reusltado = $res->result_array();
            return $reusltado;
        } catch (Exception $ex) {
            return [];
        }
    }
}

//include_once APPPATH . 'core/ICron.php';