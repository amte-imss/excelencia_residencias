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
       // $this->bd->last_query();
        $this->db->flush_cache();
        $this->db->reset_query();

        return $res->result_array();
    }

    public function get_solicitud($param = []){
        try{
            $this->db->flush_cache();
            $this->db->reset_query();
            $this->db->select(array('s.*','u.email','i.*', 'h.*', 'del.nombre as delegacion', 'dep.nombre as departamento', 'unidad.nombre as unidad','unidad.es_umae'));
            $this->db->join('sistema.usuarios u','u.username=s.matricula','left');
            $this->db->join('sistema.informacion_usuario i','i.matricula=u.username','left');
            $this->db->join('sistema.historico_informacion_usuario h','h.id_informacion_usuario=i.id_informacion_usuario','left');
            $this->db->join('catalogo.delegaciones del','i.clave_delegacional=del.clave_delegacional','left');
            $this->db->join('catalogo.departamento dep','dep.clave_departamental=h.clave_departamental','left');
            $this->db->join('catalogo.unidad unidad','unidad.clave_unidad=dep.clave_unidad','left');
           /* $this->db->where(
              array(
                's.estado'=>'1'
              )
            );*/
    
            if(isset($param['where'])) {
              $this->db->where($param['where']);
            }
    
            if(isset($param['where_in'])) {
              $this->db->where_in($param['where_in'][0],$param['where_in'][1]);
            }
    
            if(isset($param['order_by'])) {
              $this->db->order_by($param['order_by']);
            }
    
            $res = $this->db->get('excelencia.solicitud s');
            //pr($this->db->last_query());
            $this->db->flush_cache();
            $this->db->reset_query();
            $reusltado = $res->result_array();
            $resultado_mapeo = $this->map_umae($reusltado);
         
            return $resultado_mapeo;
           
    
        } catch(Exception $ex){
            return [];
        }
    }
    
    public function map_umae($data){
        foreach($data as $key => $value){
            $data[$key]['es_umae'] =  $data[$key]['es_umae'] == true? 'SI':'NO';
           
        }
        return $data;

    }

    public function insertar_solicitud($data = []){
        $this->db->flush_cache();
        $this->db->reset_query();

        $this->db->trans_begin();
        pr($data);
        $historico = array(
            'matricula' => $data['matricula'],
            'pnpc_tiene' => $data['pnpc'],
            'carrera_tiene' => $data['carrera'],
            'carrera_categoria' => $data['tipo_categoria'],
            'estado' => 1
        );
        $this->db->insert('excelencia.solicitud', $historico);

        $id_solicitud = $this->db->insert_id();

        if ($this->db->trans_status() === FALSE) {
            $this->db->trans_rollback();
            $resultado['result'] = FALSE;
            //$resultado['msg'] = $language_text['registro_usuario']['user_registro_problem'];
            $resultado['msg'] = "Ha ocurrido un error en la inserción de los datos.";
            $resultado['id_solicitud'] = null;
        } else {
            $this->db->trans_commit();
            //$resultado['msg'] = $language_text['registro_usuario']['user_registro_succes'];
            $resultado['msg'] = "Se ha cargado correctamente la información.";
            $resultado['result'] = TRUE;
            $resultado['id_solicitud'] = $id_solicitud;
        }
        return $resultado;
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


    public function listado_docente_general($condiciones = null) {
        $this->db->flush_cache();
        $this->db->reset_query();

        $this->db->select(array(
            "ti.folio", "ti.titulo", "ti.id_tipo_metodologia", "m.lang nombre_metodologia",
            "date(ti.fecha) fecha", "hr.clave_estado", "et.lang estado"
            , "a.id_informacion_usuario", "iu.es_imss"
            ,"case when uni.es_umae then 3 else 1 end as nivel_atencion"
            , "concat(iu.nombre, ' ', iu.apellido_paterno, ' ', iu.apellido_materno) nombre_investigador"
        ), false);
        $this->db->where(array(
            'a.registro' => true,
            'hr.actual' => true,
            'c.activo' => true
        ));
        $this->db->join('foro.autor a', 'a.folio_investigacion = ti.folio', 'inner');
        $this->db->join('foro.tipo_metodologia m', 'm.id_tipo_metodologia = ti.id_tipo_metodologia', 'inner');
        $this->db->join('foro.historico_revision hr', 'ti.folio = hr.folio', 'left');
        $this->db->join('foro.estado_trabajo et', 'hr.clave_estado = et.clave_estado', 'left');
        $this->db->join('sistema.informacion_usuario iu', 'iu.id_informacion_usuario = a.id_informacion_usuario', 'inner');
        $this->db->join('sistema.historico_informacion_usuario h', 'h.actual = true and h.id_informacion_usuario = iu.id_informacion_usuario', 'left', FALSE);
        $this->db->join('catalogo.departamento dep', 'dep.clave_departamental = h.clave_departamental', 'left');
        $this->db->join('foro.convocatoria c', 'ti.id_convocatoria = c.id_convocatoria');
        $this->db->join('catalogo.unidad uni', 'uni.clave_unidad = dep.clave_unidad', 'left');
//        $this->db->join('catalogo.delegaciones del', 'del.id_delegacion = uni.id_delegacion', 'left');
        $this->db->order_by('ti.folio', 'desc');
        $res = $this->db->get('foro.trabajo_investigacion ti');
        //pr($res);
//        pr($this->db->last_query());
//        pr($this->db->last_query());
        $this->db->flush_cache();
        $this->db->reset_query();

        return $res->result_array();
    }

    public function get_total_registros(){
        $this->db->flush_cache();
        $this->db->reset_query();
        $data['total_registros'] = 100;
        return $data;

    }
  


    

}
