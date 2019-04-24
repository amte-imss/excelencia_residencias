<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Revision_model extends MY_Model {

    const TAB_PERMANENCIA_DOCENTE = 'PERMANENCIA_DOCENTE';

    public function __construct() {
        // Call the CI_Model constructor
        parent::__construct();
    }

    /**
     * Devuelve la información de los registros de la tabla catalogos
     * @author
     * @date 21/05/2018
     * @return array
     */
    public function get_detalle_investigacion($param) {

        return $resutado->result_array();
    }

    /**
     * Devuelve la información de los registros de la tabla catalogos
     * @author AleSpock
     * @date 21/05/2018
     * @return array
     */
    public function get_listado_revisores($param = [], $dias_revision = 3) {
        try {
            $estado = array('success' => false, 'msg' => 'Algo salio mal', 'result' => []);
            $this->db->flush_cache();
            $this->db->reset_query();
            $this->db->select(array(
                "hr.folio folio", "ti.titulo titulo", "ma.lang metodologia",
                "CAST(r.fecha_asignacion AS DATE) + CAST('" . $dias_revision . " days' AS INTERVAL) AS fecha_limite_revision",
//                "(CASE WHEN CAST(r.fecha_asignacion AS DATE) + CAST('" . $dias_revision . " days' AS INTERVAL) < now() THEN true ELSE false END) fuera_tiempo",
            ));
            $this->db->from("foro.historico_revision hr");
            $this->db->join("foro.trabajo_investigacion ti", "hr.folio=ti.folio", 'inner');
            $this->db->join("foro.revision r", "r.folio=ti.folio", 'inner');
            $this->db->join("foro.tipo_metodologia ma", "ti.id_tipo_metodologia=ma.id_tipo_metodologia", 'left');
            $this->db->join('foro.convocatoria cc', 'cc.id_convocatoria = ti.id_convocatoria', 'inner');
            $this->db->where('cc.activo', true);
            //$this->db->where("clave_estado", "asignado");
            $this->db->where("hr.actual", TRUE);
            $this->db->where("r.id_usuario", $this->session->userdata('die_sipimss')['usuario']['id_usuario']);
            $this->db->where("r.activo", TRUE); //Agreaga filtro para saber que esta activa aún la evaluación
            $this->db->where("r.revisado", false);
            $this->db->where("(case when (now() <= CAST(r.fecha_asignacion AS timestamp) + CAST('" . $dias_revision . " days' AS INTERVAL)) then 1 else 0 end = 1)");

//            $this->db->where("hr.folio in (SELECT r.folio FROM foro.revision r WHERE hr.folio=r.folio AND r.id_usuario=" . $this->session->userdata('die_sipimss')['usuario']['id_usuario'] . " and r.revisado=false)");
//            $this->db->where("(CASE WHEN CAST(r.fecha_asignacion AS DATE) + CAST('" . $dias_revision . " days' AS INTERVAL) < now() THEN true ELSE false END)");
            $result = $this->db->get(); //pr($this->db->last_query());
            //pr($result);
            $salida = $result->result_array();
            $result->free_result();
//            pr($this->db->last_query());
//            pr($this->db->last_query());
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

    public function get_listado_solicitudes_por_revisor($id_solicitud = null) {
        try {
            $estado = array('success' => false, 'msg' => 'Algo salio mal', 'result' => []);
            $this->db->flush_cache();
            $this->db->reset_query();
            $this->db->select(array('s.id_solicitud', 's.matricula', 'i.nombre', 'i.apellido_paterno', 'i.apellido_materno', 'del.nombre as delegacion', 'to_char(s.fecha, \'DD/MM/YYYY HH:MI:SS\') as fecha', '(select count(*) from excelencia.revision rev where rev.id_solicitud=s.id_solicitud and fecha_revision is not null) as total',
                "(SELECT concat(nombre,' ',apellido_paterno,' ',apellido_materno) FROM sistema.informacion_usuario iu join excelencia.revision rev on rev.id_usuario_revision=iu.id_usuario WHERE rev.id_solicitud=s.id_solicitud and estatus=true) revisor"));
            $this->db->join('excelencia.historico_solicitud hs', 'hs.id_solicitud=s.id_solicitud and hs.actual=true', 'left', false);
            $this->db->join('sistema.informacion_usuario i', 'i.matricula=s.matricula', 'left');
            $this->db->join('excelencia.convocatoria cc', 'cc.id_convocatoria=s.id_convocatoria and cc.activo=true', 'left', false);
            $this->db->join('catalogo.delegaciones del', 'del.clave_delegacional=i.clave_delegacional', 'left');
            $this->db->where('hs.cve_estado_solicitud', 'EN_REVISION');
            if (is_null($id_solicitud)) {
                $this->db->where("s.id_solicitud in (SELECT id_solicitud FROM excelencia.revision rev WHERE rev.id_solicitud = " . $id_solicitud . " and rev.id_usuario_revision = " . $this->session->userdata('die_sipimss')['usuario']['id_usuario'] . " and estatus=true)");

            } else {
                $this->db->where("s.id_solicitud in (SELECT id_solicitud FROM excelencia.revision rev WHERE rev.id_usuario_revision = " . $this->session->userdata('die_sipimss')['usuario']['id_usuario'] . " and estatus=true)");
                
            }
            //$this->db->where("r.id_usuario", $this->session->userdata('die_sipimss')['usuario']['id_usuario']);
            $result = $this->db->get('excelencia.solicitud s'); //pr($this->db->last_query());
            //pr($result);
            $salida = $result->result_array();
            $result->free_result();
//            pr($this->db->last_query());
//            pr($this->db->last_query());
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

    /**
     * Devuelve la información de los registros de la tabla catalogos
     * @author
     * @date 21/05/2018
     * @return array
     */
    public function get_textos_evaluacion($param) {
        
    }

    public function get_estado_detalle_validacion_curso($id_solicitud) {
        $this->db->flush_cache(); //Limpia cache
        $this->db->reset_query(); //Reset result query
        $select = [
            "case when count(dc.id_documento_curso) = count(drc.id_documento_curso)  then true else false end validacion_completa",
            "count(dc.id_documento_curso) total_cursos, count(drc.id_documento_curso) total_cursos_validados"
            , "sum(case when drc.id_opcion = 1 then c.anios else 0 end) total_anios_cursos_validos"
            , "sum(case when drc.id_opcion = 1 then 1 else 0 end) total_validos"
            , "sum(case when drc.id_opcion = 2 then 1 else 0 end) total_correccion"
            , "sum(case when drc.id_opcion = 3 then 1 else 0 end) total_no_validos"
        ];
        $this->db->select($select); //Asigna el select de la consulta
        $this->db->join("excelencia_revision.excelencia.documento_curso dc", "dc.id_documento_curso = c.id_documento_curso", "inner"); //Asigna el select de la consulta
        $this->db->join("excelencia_revision.excelencia.detalle_revision_curso drc", "drc.id_documento_curso = dc.id_documento_curso", "left"); //Asigna el select de la consulta
        $this->db->where("c.id_solicitud ", $id_solicitud); //Asigna el select de la consulta 

        $result = $this->db->get("excelencia_revision.excelencia.curso c")->result_array(); //Asigna el select de la consulta 
        return $result;
    }

    public function get_estado_detalle_validacion_documentos($id_solicitud) {
        $this->db->flush_cache(); //Limpia cache
        $this->db->reset_query(); //Reset result query
        $select = [
            "case when count(d.id_documento) = count(drd.id_documento) then true else false end validacion_completa",
            "count(d.id_documento) total_documentos", "count(drd.id_documento) total_documentos_validados"
            , "sum(case when drd.id_opcion = 4 then 1 else 0 end) total_validos"
            , "sum(case when drd.id_opcion = 5 then 1 else 0 end) total_correccion"
            , "sum(case when drd.id_opcion = 6 then 1 else 0 end) total_no_validos"
        ];
        $this->db->select($select); //Asigna el select de la consulta
        $this->db->join("excelencia_revision.excelencia.detalle_revision_documento drd", "drd.id_documento = d.id_documento", "left"); //Asigna el select de la consulta
        $this->db->where("d.id_solicitud ", $id_solicitud); //Asigna el select de la consulta 
        $result = $this->db->get("excelencia_revision.excelencia.documento d")->result_array(); //Asigna el select de la consulta 
        return $result;
    }

    public function get_puntaje_tabulador($tipo_tabulador, $valor) {
        $this->db->flush_cache(); //Limpia cache
        $this->db->reset_query(); //Reset result query
        $select = [
            "t.id_tabulador", "t.tipo_tabulador", "t.rango_inicial", "t.rango_final", "t.puntaje"
        ];
        $this->db->select($select); //Asigna el select de la consulta 
        $this->db->where("t.tipo_tabulador", $tipo_tabulador); //Asigna el select de la consulta 
        $this->db->where("(" . $valor . " between rango_inicial and rango_final or (" . $valor . " >= rango_inicial and rango_final is null))", null); //Asigna el select de la consulta 
        $result = $this->db->get("excelencia.tabulador t")->result_array(); //Asigna el select de la consulta 
//        pr($this->db->last_query());
        return $result;
    }

}
