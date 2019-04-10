<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Registro_excelencia_model extends CI_Model {

    function __construct() {
        parent::__construct();
        $this->load->database();
    }

    public function listado_solicitud($id_informacion_usuario){
        $this->db->flush_cache();
        $this->db->reset_query();

        $this->db->select(array('s.*', "u.id_usuario", "u.activo", "u.email", "h.curp", "h.rfc", "h.nombre", "h.apellido_paterno", "h.apellido_materno", "h.clave_delegacional"));
        $this->db->where(array(
            's.matricula' => $id_informacion_usuario,
            's.estado' => '1'
        ));
        $this->db->join('sistema.usuarios u', 'u.username=s.matricula', 'left');
        $this->db->join('sistema.informacion_usuario h', 'h.matricula=u.username', 'left');
        $this->db->join('catalogo.delegaciones d', 'd.clave_delegacional=h.clave_delegacional', 'inner');
        /*$this->db->join('foro.estado_trabajo et', 'hr.clave_estado = et.clave_estado');
        $this->db->join('foro.convocatoria c', 'ti.id_convocatoria = c.id_convocatoria');
        $this->db->order_by('ti.folio', 'desc');*/
        $res = $this->db->get('excelencia.solicitud s');

        $this->db->flush_cache();
        $this->db->reset_query();

        return $res->result_array();
    }

    public function tipo_documentos($filtros = null) {
        $this->db->flush_cache();
        $this->db->reset_query();

        if (!is_null($filtros))
            $this->db->where($filtros);

        $res = $this->db->get('excelencia.tipo_documento');

        $this->db->flush_cache();
        $this->db->reset_query();

        return $res->result_array();
    }

    public function pnpc_anio(){
        $anios = array();
        for ($i=date("Y"); $i >= 2015; $i--) { 
            $anios[$i] = $i;
        }
        return $anios;
    }

    public function tipo_categoria(){
        $categoria = array(
            En_carrera::ASOCIADO_A => 'Asociado A',
            En_carrera::ASOCIADO_B => 'Asociado B',
            En_carrera::ASOCIADO_C => 'Asociado C',
            En_carrera::TITULAR_A => 'Titular A',
            En_carrera::TITULAR_B => 'Titular B',
            En_carrera::TITULAR_C => 'Titular C',
        );
        
        return $categoria;
    }

    public function categoria_docente(){
        $categoria = array(
            En_tipo_docente::TITULAR => 'Profesor Titular',
            En_tipo_docente::ADJUNTO => 'Adjunto',
            En_tipo_docente::AYUDANTE => 'Ayudante',
            En_tipo_docente::AUXILIAR_PRACTICA_CLINICA => 'Auxiliar de práctica clínica'
        );
        
        return $categoria;
    }

    public function curso($filtros = null){
        $this->db->flush_cache();
        $this->db->reset_query();

        if (!is_null($filtros))
            $this->db->where($filtros);
        
        $this->db->order_by('especialidades', 'asc');

        $res = $this->db->get('excelencia.especialidades');

        $this->db->flush_cache();
        $this->db->reset_query();

        return $res->result_array();
    }

}
