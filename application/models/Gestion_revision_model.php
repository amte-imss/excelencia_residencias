<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Gestion_revision_model extends MY_Model {

    //const AUTOMATICO = 1, MANUAL = 2;

    public function __construct() {
        // Call the CI_Model constructor
        parent::__construct();
        $this->load->library('LNiveles_acceso');
    }

    /**
     * Devuelve la información de los registros de la tabla catalogos
     * @author
     * @date 21/05/2018
     * @return array
     */
    /*public function get_detalle_evaluacion($param) {
        $result = [];
        return $resut;
    }*/

    /**
     * Devuelve la información de los registros de la tabla catalogos
     * @author JZDP
     * @date 18/04/2019
     * @return array
     */
    public function get_sn_comite($param = []) {
        try {
            $estado = array('success' => false, 'msg' => 'Algo salio mal', 'result' => []);
            $this->db->flush_cache();
            $this->db->reset_query();
            /*$this->db->select(array('hr.folio folio', 'ti.titulo titulo', 'ma.lang metodologia'));
            $this->db->join('foro.trabajo_investigacion ti', 'hr.folio = ti.folio', 'left');
            $this->db->join('foro.tipo_metodologia ma', 'ti.id_tipo_metodologia = ma.id_tipo_metodologia', 'left');
            $this->db->join('foro.convocatoria cc', 'cc.id_convocatoria = ti.id_convocatoria', 'inner');
            $this->db->where('cc.activo', true);
            $this->db->where('clave_estado', 'sin_asignacion');
            $this->db->where('actual', true);*/
            
/*            select 
from 
inner join  on 
left join  on 
left join  on 
where hs.cve_estado_solicitud='SIN_COMITE';*/

            $this->db->select(array('s.matricula', 'i.nombre', 'i.apellido_paterno', 'i.apellido_paterno', 'del.nombre', 's.fecha',
'(select count(*) from excelencia.revision rev where rev.id_solicitud=s.id_solicitud) as total'));
            $this->db->join('excelencia.historico_solicitud hs', 'hs.id_solicitud=s.id_solicitud and hs.actual=true', 'left');
            $this->db->join('sistema.informacion_usuario i', 'i.matricula=s.matricula', 'left');
            $this->db->join('catalogo.delegaciones del', 'del.clave_delegacional=i.clave_delegacional', 'left');
            $this->db->where('cc.activo', true);
            
            $this->db->where('clave_estado', 'sin_asignacion');
            $this->db->where('actual', true);

            if (array_key_exists('fields', $param)) {
                $this->db->select($param['fields']);
            }
            if (array_key_exists('conditions', $param)) {
                $this->db->where($param['conditions']);
            }
            if (array_key_exists('order', $param)) {
                $this->db->order_by($param['order']);
            }
            $result = $this->db->get('excelencia.solicitud s');
            pr($this->db->last_query());
            $salida = $result->result_array();
            $result->free_result();
            $this->db->flush_cache();
            $this->db->reset_query();
            $estado['success'] = true;
            $estado['msg'] = "Se obtuvo el reporte con exito";
            $estado['result'] = $salida;
        } catch (Exception $ex) {
            $estado = array('success' => false, 'msg' => 'Algo salio mal', 'result' => []);
        }

        return $estado;
    }
}
