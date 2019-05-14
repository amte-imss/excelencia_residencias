<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Registro_excelencia_model extends CI_Model {

    function __construct() {
        parent::__construct();
        $this->load->database();
    }

    public function listado_solicitud($id_informacion_usuario) {
        $this->db->flush_cache();
        $this->db->reset_query();

        $this->db->select(array('s.*', "u.id_usuario", "u.activo", "u.email", "h.curp", "h.rfc", "h.nombre", "h.apellido_paterno", "h.apellido_materno", "h.clave_delegacional"));
        $this->db->where(array(
            's.matricula' => $id_informacion_usuario,
            'hs.actual' => true,
                //'s.estado' => '1'
        ));
        $this->db->join('excelencia.historico_solicitud hs', 'hs.id_solicitud = s.id_solicitud');
        $this->db->join('sistema.usuarios u', 'u.username=s.matricula', 'left');
        $this->db->join('sistema.informacion_usuario h', 'h.matricula=u.username', 'left');
        $this->db->join('catalogo.delegaciones d', 'd.clave_delegacional=h.clave_delegacional', 'inner');
        //$this->db->join('excelencia.estado_solicitud es', 'hr.clave_estado = et.clave_estado');
        /* $this->db->join('foro.convocatoria c', 'ti.id_convocatoria = c.id_convocatoria');
          $this->db->order_by('ti.folio', 'desc'); */
        $res = $this->db->get('excelencia.solicitud s');
//         pr($this->db->last_query());
        $this->db->flush_cache();
        $this->db->reset_query();

        return $res->result_array();
    }

    public function get_solicitud($param = []) {
        try {
            $this->db->flush_cache();
            $this->db->reset_query();
            if (isset($param['select'])) {
                $this->db->select($param['select']);
            } else {
                $this->db->select(array('s.*', 'u.email', 'i.*', 'h.*', 'hs.cve_estado_solicitud', 'hs.fecha as fecha_hs', 'del.nombre as delegacion', 'dep.nombre as departamento', 'unidad.nombre as unidad', 'unidad.es_umae', "to_char(s.fecha, 'yyyy-dd-mm hh:MI:ss') as fecha_format", "conv.*", "i.nombre as nombre_ui"));
            }
            $this->db->join('excelencia.historico_solicitud hs', 'hs.id_solicitud=s.id_solicitud and actual=true', 'left', false);
            $this->db->join('excelencia.convocatoria conv', 'conv.id_convocatoria=s.id_convocatoria and conv.activo=true', 'left', false);
            $this->db->join('sistema.usuarios u', 'u.username=s.matricula', 'left');
            $this->db->join('sistema.informacion_usuario i', 'i.matricula=u.username', 'left');
            $this->db->join('sistema.historico_informacion_usuario h', 'h.id_informacion_usuario=i.id_informacion_usuario', 'left');
            $this->db->join('catalogo.delegaciones del', 'i.clave_delegacional=del.clave_delegacional', 'left');
            $this->db->join('catalogo.departamento dep', 'dep.clave_departamental=h.clave_departamental', 'left');
            $this->db->join('catalogo.unidad unidad', 'unidad.clave_unidad=dep.clave_unidad', 'left');

            if (isset($param['where'])) {
                $this->db->where($param['where']);
            }

            if (isset($param['where_in'])) {
                $this->db->where_in($param['where_in'][0], $param['where_in'][1]);
            }

            if (isset($param['order_by'])) {
                $this->db->order_by($param['order_by']);
            }

            if (isset($param['group_by'])) {
                $this->db->group_by($param['group_by']);
            }

            $res = $this->db->get('excelencia.solicitud s');
            //pr($this->db->last_query());
            $this->db->flush_cache();
            $this->db->reset_query();
            $resultado_mapeo = $res->result_array();
            //$resultado_mapeo = $this->mapear_formato($reusltado);

            return $resultado_mapeo;
        } catch (Exception $ex) {
            return [];
        }
    }

    /* public function mapear_formato($data){

      foreach($data as $key => $value){
      $data[$key]['es_umae'] =  $data[$key]['es_umae'] == true? 'SI':'NO';
      $date = date_create($data[$key]['fecha']);
      $data[$key]['fecha'] = date_format($date, 'Y-m-d H:i:s');

      }
      return $data;

      } */

    public function update_solicitud($data, $estado_solicitud = null) {
        if (is_null($estado_solicitud)) {
            $estado_solicitud = En_estado_solicitud::SIN_COMITE;
        }
        $this->db->trans_begin(); //Inicia la transacción

        $array_update = array(
            'actual' => false
        );
        $this->db->where('id_solicitud', $data['id_solicitud']); //Id solicitud
        $this->db->update('excelencia.historico_solicitud', $array_update); //Se actualizan anteriores estados

        $insert = array(
            'id_solicitud' => $data['id_solicitud'],
            'cve_estado_solicitud' => $estado_solicitud,
            'actual' => true
        );
        $this->db->insert('excelencia.historico_solicitud', $insert); //Se inserta el nuevo registro del historico de datos IMSS
        if ($this->db->trans_status() === FALSE) {//Valida que se actualizó el archvo success
            $this->db->trans_rollback();
            $respuesta = array('tp_msg' => En_tpmsg::DANGER, 'mensaje' => 'Ocurrió un error en el guardado de información.');
        } else {
            $this->db->trans_commit();
            $respuesta = array('tp_msg' => En_tpmsg::SUCCESS, 'mensaje' => 'Se ha enviado su solicitud.');
        }
            $this->db->trans_rollback();
        return $respuesta;
    }

    public function get_documento($param = []) {
        try {
            $this->db->flush_cache();
            $this->db->reset_query();

            $this->db->select(array('d.*', 'td.nombre'));

            $this->db->join('excelencia.tipo_documento td', 'td.id_tipo_documento=d.id_tipo_documento', 'left');

            if (isset($param['where'])) {
                $this->db->where($param['where']);
            }

            if (isset($param['where_in'])) {
                $this->db->where_in($param['where_in'][0], $param['where_in'][1]);
            }

            if (isset($param['order_by'])) {
                $this->db->order_by($param['order_by']);
            }

            $res = $this->db->get('excelencia.documento d');
//            pr($this->db->last_query());
            $this->db->flush_cache();
            $this->db->reset_query();
            $reusltado = $res->result_array();
            return $reusltado;
        } catch (Exception $ex) {
            return [];
        }
    }

    public function get_curso_solicitud($param = []) {
        try {
            $this->db->flush_cache();
            $this->db->reset_query();

            //$this->db->select(array('d.*', 'td.nombre'));

            $this->db->join('excelencia.solicitud s', 's.id_solicitud=c.id_solicitud', 'left');
            $this->db->join('excelencia.documento_curso d', 'd.id_documento_curso=c.id_documento_curso', 'left');

            if (isset($param['select'])) {
                $this->db->select($param['select']);
            }

            if (isset($param['where'])) {
                $this->db->where($param['where']);
            }

            if (isset($param['where_in'])) {
                $this->db->where_in($param['where_in'][0], $param['where_in'][1]);
            }

            if (isset($param['order_by'])) {
                $this->db->order_by($param['order_by']);
            }

            $res = $this->db->get('excelencia.curso c');
            //pr($this->db->last_query());
            $this->db->flush_cache();
            $this->db->reset_query();
            $reusltado = $res->result_array();
            return $reusltado;
        } catch (Exception $ex) {
            return [];
        }
    }

    public function insertar_solicitud($data = []) {
        $this->db->flush_cache();
        $this->db->reset_query();

        $this->db->trans_begin();
        //pr($data);
        if ($data['tipo_categoria'] == '') {
            $data['tipo_categoria'] = null;
        }

        $historico = array(
            'matricula' => $data['matricula'],
            //'pnpc_tiene' => $data['pnpc'],
            'id_convocatoria' => $data['id_convocatoria'],
            'carrera_tiene' => $data['carrera'],
            'carrera_categoria' => $data['tipo_categoria']
        );
        $this->db->insert('excelencia.solicitud', $historico);

        $id_solicitud = $this->db->insert_id();

        $insert = array(
            'id_solicitud' => $id_solicitud,
            'cve_estado_solicitud' => En_estado_solicitud::REGISTRO,
            'actual' => true
        );
        $this->db->insert('excelencia.historico_solicitud', $insert); //Se inserta el nuevo registro del historico de datos IMSS

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

    public function insertar_documento($data = []) {
        $this->db->flush_cache();
        $this->db->reset_query();

        $this->db->trans_begin();

        $this->db->insert('excelencia.documento', $data);

        $id_documento = $this->db->insert_id();

        if ($this->db->trans_status() === FALSE) {
            $this->db->trans_rollback();
            $resultado['result'] = FALSE;
            //$resultado['msg'] = $language_text['registro_usuario']['user_registro_problem'];
            $resultado['msg'] = "Ha ocurrido un error en la inserción de los datos.";
            $resultado['id_documento'] = null;
        } else {
            $this->db->trans_commit();
            //$resultado['msg'] = $language_text['registro_usuario']['user_registro_succes'];
            $resultado['msg'] = "Se ha cargado correctamente la información.";
            $resultado['result'] = TRUE;
            $resultado['id_documento'] = $id_documento;
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

    public function get_estado_solicitud($param = null) {
        $this->db->flush_cache();
        $this->db->reset_query();

        if (isset($param['where'])) {
            $this->db->where($param['where']);
        }

        $res = $this->db->get('excelencia.estado_solicitud');

        $this->db->flush_cache();
        $this->db->reset_query();

        return $res->result_array();
    }

    public function pnpc_anio() {
        $anios = array();
        for ($i = date("Y"); $i >= 2015; $i--) {
            $anios[$i] = $i;
        }
        return $anios;
    }

    public function tipo_categoria() {
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

    public function categoria_docente() {
        $categoria = array(
            En_tipo_docente::TITULAR => 'Profesor Titular',
            En_tipo_docente::ADJUNTO => 'Adjunto',
            En_tipo_docente::AYUDANTE => 'Ayudante',
            En_tipo_docente::AUXILIAR_PRACTICA_CLINICA => 'Auxiliar de práctica clínica'
        );

        return $categoria;
    }

    public function curso($filtros = null) {
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
            , "case when uni.es_umae then 3 else 1 end as nivel_atencion"
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

    public function get_total_registros() {
        $this->db->flush_cache();
        $this->db->reset_query();
        $data['total_registros'] = 100;
        return $data;
    }

    public function curso_participantes($filtros = null) {
        $this->db->flush_cache();
        $this->db->reset_query();

        if (!is_null($filtros)) {
            $this->db->where($filtros);
        }

        $this->db->join('excelencia.especialidades es', 'es.id_especialidad = c.id_especialidad');
        $this->db->join('excelencia.documento_curso dc', 'dc.id_documento_curso = c.id_documento_curso ');
        $this->db->join('excelencia.tipo_documento td', 'td.id_tipo_documento = dc.id_tipo_documento');
        $this->db->order_by('es.especialidades');

        $res = $this->db->get('excelencia.curso c');

        $this->db->flush_cache();
        $this->db->reset_query();

        return $res->result_array();
    }

    public function insert_registro_general($entidad, $datos, $identificador = null) {
        $this->db->flush_cache(); //Limpia cache
        $this->db->reset_query(); //Reset result query
        $result = ['tp_msg' => En_tpmsg::DANGER, 'msg' => ''];
        $this->db->trans_begin();
        $this->db->insert($entidad, $datos);
        if (!is_null($identificador)) {
            $datos[$identificador] = $this->db->insert_id();
        }
//        pr($identificador);
//        pr($datos);
        if ($this->db->trans_status() === FALSE) {
            $this->db->trans_rollback();
        } else {
//            $this->db->trans_rollback();
//        $result = ['tp_msg' => En_tpmsg::DANGER, 'msg' => ''];
            $this->db->trans_commit();
            $result = ['tp_msg' => En_tpmsg::SUCCESS, 'msg' => ''];
            $result['data'] = $datos;
        }
        return $result;
    }

    public function delete_curso_documento($params) {
        $this->db->flush_cache(); //Limpia cache
        $this->db->reset_query(); //Reset result query
        $this->db->trans_begin();

        $this->db->where('id_curso', $params['id_curso']);
        $this->db->delete('excelencia.curso');

        $this->db->where('id_documento_curso', $params['id_documento_curso']);
        $this->db->delete('excelencia.documento_curso');

        if ($this->db->trans_status() === FALSE) {//ocurrio un error
            $this->db->trans_rollback();
            $respuesta = array('tp_msg' => En_tpmsg::DANGER, 'mensaje' => '');
        } else {
            $this->db->trans_commit();
            $respuesta = array('tp_msg' => En_tpmsg::SUCCESS, 'mensaje' => '');
        }
        return $respuesta;
    }

    /**
     * @author LEAS 
     * @param type $entidad Nombre de la tabla principal
     * @param type $select
      , es un array con el nombre de las columnas que mostrara la consulta
     * @param type $array_where
      , array con la siguiente estructura: nameColumn => [typeWhere, valorWhere].
     * Si el where es noramal (typo "and"), entonces, "nameColumn" contentra el valor solicitado (no array ni objeto)
     * posible valor de typeWhere: "or_where_in, where_not_in, where, 
     * @param type $join
      , array con la siguiente estructura: nametabla => [typejoin , condicion].
     * Si el join es noramal (typo "inner"), entonces, "nameColumn" contentra la condici{on de join     
     * Posible type de join "right and left"
     * @param type $order_by orden[]
     * @param type $group_by agrupamiento[]
     * @param type $distinct bool, true para que muetre un distinct
     * @return type
     */
    public function getConsutasGenerales($entidad, $select = '*', $array_where = null, $join = null, $order_by = null, $group_by = null, $distinct = false) {
//        pr($entidad . ' => ' . $type_where);
        $this->db->flush_cache(); //Limpia cache
        $this->db->reset_query(); //Reset result query
        if (!is_null($array_where)) {
            foreach ($array_where as $key => $value) {
                if (is_array($value)) {
                    $typeWhere = $value['typeWhere'];
                    $this->db->{$typeWhere}($key, $value['valueWhere']);
                } else {
                    $this->db->where($key, $value);
                }
            }
        }

        if ($distinct) {
            $this->db->distint();
        }

        if (!is_null($join)) {
            foreach ($join as $key_join => $value_join) {
                $this->db->join($key_join, $value_join['condicion'], $value_join['typejoin']);
            }
        }

        $this->db->select($select); //Asigna el select de la consulta 

        if (!is_null($order_by)) {
            if (is_array($order_by)) {
                foreach ($order_by as $column => $ascdesc) {
                    $this->db->order_by($column, $ascdesc);
                }
            } else {
                $this->db->order_by($order_by);
            }
        }
        if (!is_null($group_by)) {
            $this->db->group_by($group_by);
        }
        if (!is_null($order_by)) {
            if (is_array($order_by)) {
                foreach ($order_by as $column => $ascdesc) {
                    $this->db->order_by($column, $ascdesc);
                }
            } else {
                $this->db->order_by($order_by);
            }
        }
        $query = $this->db->get($entidad);
        $resultArray = $query->result_array();
        $query->free_result();
//        pr($this->db->last_query());
        return $resultArray;
    }

    public function update_registro_general($entidad, $data, $array_where) {
        $this->db->flush_cache(); //Limpia cache
        $this->db->reset_query(); //Reset result query
        $result = ['tp_msg' => En_tpmsg::DANGER, 'mensaje' => ''];
        $this->db->trans_begin();
        foreach ($array_where as $key => $value) {
            if (is_array($value)) {
                $typeWhere = $value['typeWhere'];
                $this->db->{$typeWhere}($key, $value);
            } else {
                $this->db->where($key, $value);
            }
        }
        $this->db->update($entidad, $data);
//        pr($this->db->last_query());
        if ($this->db->trans_status() === FALSE) {
            $this->db->trans_rollback();
        } else {
            $this->db->trans_commit();
            $result = ['tp_msg' => En_tpmsg::SUCCESS, 'mensaje' => ''];
        }
        return $result;
    }

    public function delete_registro_general($entidad, $array_where) {
        $result = ['tp_msg' => En_tpmsg::DANGER, 'mensaje' => ''];
        $this->db->trans_begin();
        if (!is_null($array_where)) {
            foreach ($array_where as $key => $value) {
                if (is_array($value)) {
                    $typeWhere = $value['typeWhere'];
                    $this->db->{$typeWhere}($key, $value);
                } else {
                    $this->db->where($key, $value);
                }
            }
            $this->db->delete($entidad);
            if ($this->db->trans_status() === FALSE) {
                $this->db->trans_rollback();
            } else {
                $this->db->trans_commit();
                $result = ['tp_msg' => En_tpmsg::SUCCESS, 'mensaje' => ''];
            }
        }
        return $result;
    }

    public function get_ganador($param = []) {
        try {
            $this->db->flush_cache();
            $this->db->reset_query();
            /*if (isset($param['select'])) {
                $this->db->select($param['select']);
            } else {
                $this->db->select(array('s.*', 'u.email', 'i.*', 'h.*', 'hs.cve_estado_solicitud', 'hs.fecha as fecha_hs', 'del.nombre as delegacion', 'dep.nombre as departamento', 'unidad.nombre as unidad', 'unidad.es_umae', "to_char(s.fecha, 'yyyy-dd-mm hh:MI:ss') as fecha_format", "conv.*", "i.nombre as nombre_ui"));
            }
            $this->db->join('excelencia.historico_solicitud hs', 'hs.id_solicitud=s.id_solicitud and actual=true', 'left', false);
            $this->db->join('excelencia.convocatoria conv', 'conv.id_convocatoria=s.id_convocatoria and conv.activo=true', 'left', false);
            $this->db->join('sistema.usuarios u', 'u.username=s.matricula', 'left');
            $this->db->join('sistema.informacion_usuario i', 'i.matricula=u.username', 'left');
            $this->db->join('sistema.historico_informacion_usuario h', 'h.id_informacion_usuario=i.id_informacion_usuario', 'left');
            $this->db->join('catalogo.delegaciones del', 'i.clave_delegacional=del.clave_delegacional', 'left');
            $this->db->join('catalogo.departamento dep', 'dep.clave_departamental=h.clave_departamental', 'left');*/
            $this->db->join('excelencia.ganador g', 'g.matricula=s.matricula', 'left');

            if (isset($param['where'])) {
                $this->db->where($param['where']);
            }

            if (isset($param['where_in'])) {
                $this->db->where_in($param['where_in'][0], $param['where_in'][1]);
            }

            if (isset($param['order_by'])) {
                $this->db->order_by($param['order_by']);
            }

            if (isset($param['group_by'])) {
                $this->db->group_by($param['group_by']);
            }

            $res = $this->db->get('excelencia.solicitud s');
            //pr($this->db->last_query());
            $this->db->flush_cache();
            $this->db->reset_query();
            $resultado_mapeo = $res->result_array();
            //$resultado_mapeo = $this->mapear_formato($reusltado);

            return $resultado_mapeo;
        } catch (Exception $ex) {
            return [];
        }
    }

}
