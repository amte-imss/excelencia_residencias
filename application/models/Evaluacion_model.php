<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Evaluacion_model extends MY_Model {

    public function __construct() {
        // Call the CI_Model constructor
        parent::__construct();
    }

    /**
     * Devuelve la información de los registros de la tabla evaluacion
     * @author Roa
     * @date 24/04/2019
     * @return array
     */
    public function get_evaluaciones(){
        //try {
            $this->db->flush_cache();
            $this->db->reset_query();
            $this->db->schema = 'excelencia';

            $this->db->select('*');
            $query = $this->db->get("excelencia.evaluacion eval");

            return $query->result_array();
    }    
}