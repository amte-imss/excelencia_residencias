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

            $this->db->select(array('s.id_solicitud', 's.matricula', 'i.nombre', 'i.apellido_paterno', 'i.apellido_materno', 'del.nombre as delegacion', 's.fecha','(select count(*) from excelencia.revision rev where rev.id_solicitud=s.id_solicitud and estatus=false) as total'));
            $this->db->join('excelencia.historico_solicitud hs', 'hs.id_solicitud=s.id_solicitud and hs.actual=true', 'left', false);
            $this->db->join('sistema.informacion_usuario i', 'i.matricula=s.matricula', 'left');
            $this->db->join('excelencia.convocatoria cc', 'cc.id_convocatoria=s.id_convocatoria and cc.activo=true', 'left', false);
            $this->db->join('catalogo.delegaciones del', 'del.clave_delegacional=i.clave_delegacional', 'left');
            $this->db->where('hs.cve_estado_solicitud', 'SIN_COMITE');

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
            //pr($this->db->last_query());
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

    /**
     * Devuelve la información de los registros de la tabla catalogos
     * @author
     * @date 21/05/2018
     * @return array
     */
    public function get_en_revision($param = [], $dias_revision = 3) {
        $estado = array('success' => false, 'msg' => 'Algo salio mal', 'result' => []);
        try {
            $estado = array('success' => false, 'msg' => 'Algo salio mal', 'result' => []);
            $this->db->flush_cache();
            $this->db->reset_query();
            /*$this->db->select(array('hr.folio folio', 'ti.titulo titulo', 'ma.lang metodologia', 'rn.id_usuario', 'rn.revisado',
                "(SELECT concat(nombre,' ',apellido_paterno,' ',apellido_materno) FROM sistema.informacion_usuario WHERE id_usuario=rn.id_usuario) revisor", 'hr.clave_estado',
                "CAST(rn.fecha_asignacion AS timestamp) + CAST('" . $dias_revision . " days' AS INTERVAL) fecha_limite_revision",
                "(CASE WHEN CAST(rn.fecha_asignacion AS timestamp) + CAST('" . $dias_revision . " days' AS INTERVAL) < now() THEN true ELSE false END) fuera_tiempo",
            ));
            $this->db->join('foro.trabajo_investigacion ti', 'hr.folio = ti.folio', 'left');
            $this->db->join('foro.tipo_metodologia ma', 'ti.id_tipo_metodologia = ma.id_tipo_metodologia', 'left');
            $this->db->join('foro.revision rn', 'hr.folio = rn.folio', 'left');
            $this->db->join('foro.convocatoria cc', 'cc.id_convocatoria = ti.id_convocatoria', 'inner');
            $this->db->where('cc.activo', true);
            $this->db->where_in('hr.clave_estado', array('fuera_tiempo', 'discrepancia', 'conflicto_interes', 'asignado'));
            $this->db->where('actual', true);
            $this->db->where('rn.activo', true);*/
            $this->db->select(array('s.id_solicitud', 's.matricula', 'i.nombre', 'i.apellido_paterno', 'i.apellido_materno', 'del.nombre as delegacion', 'to_char(s.fecha, \'DD/MM/YYYY HH:MI:SS\') as fecha','(select count(*) from excelencia.revision rev where rev.id_solicitud=s.id_solicitud and fecha_revision is not null) as total',
                "(SELECT concat(nombre,' ',apellido_paterno,' ',apellido_materno) FROM sistema.informacion_usuario iu join excelencia.revision rev on rev.id_usuario_revision=iu.id_usuario WHERE rev.id_solicitud=s.id_solicitud and estatus=true) revisor"));
            $this->db->join('excelencia.historico_solicitud hs', 'hs.id_solicitud=s.id_solicitud and hs.actual=true', 'left', false);
            $this->db->join('sistema.informacion_usuario i', 'i.matricula=s.matricula', 'left');
            $this->db->join('excelencia.convocatoria cc', 'cc.id_convocatoria=s.id_convocatoria and cc.activo=true', 'left', false);
            $this->db->join('catalogo.delegaciones del', 'del.clave_delegacional=i.clave_delegacional', 'left');
            $this->db->where('hs.cve_estado_solicitud', 'EN_REVISION');
            if (array_key_exists('fields', $param)) {
                $this->db->select($param['fields']);
            }
            if (array_key_exists('conditions', $param)) {
                $this->db->where($param['conditions']);
            }
            if (array_key_exists('order', $param)) {
                $this->db->order_by($param['order']);
            }
            $result = $this->db->get('excelencia.solicitud s'); //pr($this->db->last_query());
            $salida = $result->result_array();
//            pr($this->db->last_query());
            $result->free_result();
            $this->db->flush_cache();
            $this->db->reset_query();
            $estado['success'] = true;
            $estado['msg'] = "Se obtuvo el reporte con exito";
            $estado['result'] = $salida;
        } catch (Exception $ex) {
            //pedir a cesar el grupo con las tradcciones
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
    public function get_revisados($param = [], $dias_revision = 3) {
        $estado = array('success' => false, 'msg' => 'Algo salio mal', 'result' => []);
        try {
            $estado = array('success' => false, 'msg' => 'Algo salio mal', 'result' => []);
            $this->db->flush_cache();
            $this->db->reset_query();
            /*$this->db->select(array('hr.folio folio', 'ti.titulo titulo', 'ma.lang metodologia', 'rn.id_usuario', 'rn.revisado',
                "(SELECT concat(nombre,' ',apellido_paterno,' ',apellido_materno) FROM sistema.informacion_usuario WHERE id_usuario=rn.id_usuario) revisor", 'hr.clave_estado',
                "CAST(rn.fecha_asignacion AS timestamp) + CAST('" . $dias_revision . " days' AS INTERVAL) fecha_limite_revision",
                "(CASE WHEN CAST(rn.fecha_asignacion AS timestamp) + CAST('" . $dias_revision . " days' AS INTERVAL) < now() THEN true ELSE false END) fuera_tiempo",
            ));
            $this->db->join('foro.trabajo_investigacion ti', 'hr.folio = ti.folio', 'left');
            $this->db->join('foro.tipo_metodologia ma', 'ti.id_tipo_metodologia = ma.id_tipo_metodologia', 'left');
            $this->db->join('foro.revision rn', 'hr.folio = rn.folio', 'left');
            $this->db->join('foro.convocatoria cc', 'cc.id_convocatoria = ti.id_convocatoria', 'inner');
            $this->db->where('cc.activo', true);
            $this->db->where_in('hr.clave_estado', array('fuera_tiempo', 'discrepancia', 'conflicto_interes', 'asignado'));
            $this->db->where('actual', true);
            $this->db->where('rn.activo', true);*/
            $this->db->select(array('s.id_solicitud', 's.matricula', 'i.nombre', 'i.apellido_paterno', 'i.apellido_materno', 'del.nombre as delegacion', 'to_char(s.fecha, \'DD/MM/YYYY HH:MI:SS\') as fecha','(select count(*) from excelencia.revision rev where rev.id_solicitud=s.id_solicitud and fecha_revision is not null) as total',
                "(SELECT concat(nombre,' ',apellido_paterno,' ',apellido_materno) FROM sistema.informacion_usuario iu join excelencia.revision rev on rev.id_usuario_revision=iu.id_usuario WHERE rev.id_solicitud=s.id_solicitud and estatus=true) revisor"));
            $this->db->join('excelencia.historico_solicitud hs', 'hs.id_solicitud=s.id_solicitud and hs.actual=true', 'left', false);
            $this->db->join('sistema.informacion_usuario i', 'i.matricula=s.matricula', 'left');
            $this->db->join('excelencia.convocatoria cc', 'cc.id_convocatoria=s.id_convocatoria and cc.activo=true', 'left', false);
            $this->db->join('catalogo.delegaciones del', 'del.clave_delegacional=i.clave_delegacional', 'left');
            $this->db->where('hs.cve_estado_solicitud', 'REVISADO');
            if (array_key_exists('fields', $param)) {
                $this->db->select($param['fields']);
            }
            if (array_key_exists('conditions', $param)) {
                $this->db->where($param['conditions']);
            }
            if (array_key_exists('order', $param)) {
                $this->db->order_by($param['order']);
            }
            $result = $this->db->get('excelencia.solicitud s'); //pr($this->db->last_query());
            $salida = $result->result_array();
            $result->free_result();
            $this->db->flush_cache();
            $this->db->reset_query();
            $estado['success'] = true;
            $estado['msg'] = "Se obtuvo el reporte con exito";
            $estado['result'] = $salida;
        } catch (Exception $ex) {
            //pedir a cesar el grupo con las tradcciones
            $estado = array('success' => false, 'msg' => 'Algo salio mal', 'result' => []);
        }

        return $estado;
    }

    public function get_candidatos($param = [], $dias_revision = 3) {
        $estado = array('success' => false, 'msg' => 'Algo salio mal', 'result' => []);
        try {
            $estado = array('success' => false, 'msg' => 'Algo salio mal', 'result' => []);
            $this->db->flush_cache();
            $this->db->reset_query();
        
            $this->db->select(array('s.id_solicitud', 's.matricula', 'i.nombre', 'i.apellido_paterno', 
                'i.apellido_materno', 'del.nombre as delegacion', 'to_char(s.fecha, \'DD/MM/YYYY HH:MI:SS\') as fecha',
                '(select count(*) from excelencia.revision rev where rev.id_solicitud=s.id_solicitud and fecha_revision is not null) as total',        
              /*9*/  "(SELECT concat(nombre,' ',apellido_paterno,' ',apellido_materno) FROM sistema.informacion_usuario iu join excelencia.revision rev on rev.id_usuario_revision=iu.id_usuario WHERE rev.id_solicitud=s.id_solicitud and estatus=true) revisor",
                //"(SELECT total_puntos_anios_cursos FROM excelencia.revision rev WHERE rev.id_solicitud=s.id_solicitud and estatus=true) total_puntos_anios_cursos",
                'eva.id_evaluacion',
                're.total_puntos_anios_cursos','eva.puntaje_pnpc','eva.puntaje_carrera_docente', 
                'eva.puntaje_sa_et','eva.puntaje_sa_satisfaccion','eva.puntaje_anios_docente'
                , '(coalesce(total_puntos_anios_cursos,0)+ coalesce(eva.puntaje_pnpc,0)+ coalesce(eva.puntaje_carrera_docente,0)+ coalesce(eva.puntaje_sa_et,0) + coalesce(eva.puntaje_sa_satisfaccion,0)) total_suma_puntos'
                ));
            
            $this->db->join('excelencia.revision re', 're.id_solicitud= s.id_solicitud and re.estatus', 'inner');
            $this->db->join('excelencia.historico_solicitud hs', 'hs.id_solicitud=s.id_solicitud and hs.actual=true', 'left', false);
            $this->db->join('sistema.informacion_usuario i', 'i.matricula=s.matricula', 'left');
            $this->db->join('excelencia.evaluacion eva', 'eva.matricula = i.matricula', 'left');
            $this->db->join('excelencia.convocatoria cc', 'cc.id_convocatoria=s.id_convocatoria and cc.activo=true', 'left', false);
            $this->db->join('catalogo.delegaciones del', 'del.clave_delegacional=i.clave_delegacional', 'left');
            $this->db->where('hs.cve_estado_solicitud', 'REVISADO');
            if (array_key_exists('fields', $param)) {
                $this->db->select($param['fields']);
            }
            if (array_key_exists('conditions', $param)) {
                $this->db->where($param['conditions']);
            }
            if (array_key_exists('order', $param)) {
                $this->db->order_by($param['order']);
            }
            $result = $this->db->get('excelencia.solicitud s'); //pr($this->db->last_query());
            $salida = $result->result_array();
            $result->free_result();
            $this->db->flush_cache();
            $this->db->reset_query();
//            pr($this->db->last_query());
            $estado['success'] = true;
            $estado['msg'] = "Se obtuvo el reporte con exito";
            $estado['result'] = $salida;
        } catch (Exception $ex) {
            //pedir a cesar el grupo con las tradcciones
            $estado = array('success' => false, 'msg' => 'Algo salio mal', 'result' => []);
        }

        return $estado;
    }

    /**
     * Devuelve el listado de revisores registrados en la BD
     * @author JZDP
     * @date 22/04/2019
     * @return array
     */
    public function get_revisores($param = []) {
        try {
            $estado = array('success' => false, 'msg' => '', 'result' => []);
            $this->db->flush_cache();
            $this->db->reset_query();
            $this->db->select(array("iu.id_usuario",
                "iu.nombre", "iu.apellido_paterno", "iu.apellido_materno", "iu.institucion",
                "(SELECT COUNT(rn.id_usuario_revision) FROM excelencia.revision rn WHERE rn.id_usuario_revision=iu.id_usuario AND rn.estatus = false) AS revisiones_pendientes",
                "count(distinct rn.id_solicitud) AS revisiones_realizadas"
            ));
            $this->db->from("sistema.usuario_rol ul");
            $this->db->join("sistema.informacion_usuario iu", "ul.id_usuario=iu.id_usuario", 'inner');
            $this->db->join("excelencia.revision rn", "iu.id_usuario=rn.id_usuario_revision", 'left');
            $this->db->where("clave_rol IN ('" . LNiveles_acceso::Revisor . "', '" . LNiveles_acceso::Admin . "')");
            $this->db->where("ul.activo", TRUE);
            $this->db->group_by("iu.id_usuario,iu.nombre,iu.apellido_paterno,iu.apellido_materno,iu.institucion");
            $this->db->order_by("iu.nombre,iu.apellido_paterno,iu.apellido_materno,iu.institucion");

            if (array_key_exists('fields', $param)) {
                $this->db->select($param['fields']);
            }
            if (array_key_exists('conditions', $param)) {
                $this->db->where($param['conditions']);
            }
            if (array_key_exists('order', $param)) {
                $this->db->order_by($param['order']['field'], $param['order']['type']);
            }

            $result = $this->db->get();
            //pr($this->db->last_query());
            $salida = $result->result_array();
            //pr($salida);
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

    /**
     * Insertar revisiones correspondientes a sección 'Sin comite'
     * @author JZDP
     * @date 26/05/2018
     * @return array
     */
    public function insert_asignar_revisor($datos) {
        $resultado = array('result' => null, 'msg' => '', 'data' => null);
        $this->db->trans_begin(); //Definir inicio de transacción
        $folios = implode("','", $datos['folios']);

        $validar_folios = $this->get_sn_comite(array('conditions' => "s.id_solicitud in ('" . $folios . "')")); //Validar situación y/o estado de las solicitudes

        if ($validar_folios['success'] == true) { //En caso de que se encuentren datos
            $solicitud = $revision = $historico = array(); //Arreglo que contendrá asignaciones por añadir

            $this->db->where("id_solicitud IN ('" . $folios . "')");
            $this->db->update('excelencia.revision', array('estatus' => false)); ///

            $i = 0; //pr($validar_folios);
            foreach ($datos['usuarios'] as $key_u => $usuario) { //Se recorren los usuarios por asociar
                foreach ($validar_folios['result'] as $key_f => $folio) { //Se recorren los trabajos que fueron localizados
                    $revision[$i]['id_solicitud'] =  $folio['id_solicitud'];
                    $revision[$i]['estatus'] = true;
                    $revision[$i]['id_usuario_revision'] = $usuario;
                    $revision[$i]['fecha_asignacion'] = 'now()';
                    $i++;
                }
            }
            //pr($revision);
            $this->db->insert_batch('excelencia.revision', $revision); //Inserción en tabla revision

            $this->db->where("id_solicitud IN ('" . $folios . "')");
            $this->db->update('excelencia.historico_solicitud', array('actual' => false)); ///Actualizar estado de la soicitud

            $i = 0;
            foreach ($validar_folios['result'] as $key_f => $folio) { //Se recorren los trabajos que fueron localizados
                $solicitud[$i]['id_solicitud'] = $folio['id_solicitud'];
                $solicitud[$i]['cve_estado_solicitud'] = En_estado_solicitud::EN_REVISION;
                $solicitud[$i]['actual'] = true;
            }
            $this->db->insert_batch('excelencia.historico_solicitud', $solicitud); //Inserción en tabla revision

            /*$i = 0;
            foreach ($validar_folios['result'] as $key_f => $folio) { //Se recorren los trabajos que fueron localizados
                $historico[$i]['folio'] = $folio['folio'];
                $historico[$i]['actual'] = true;
                $historico[$i]['clave_estado'] = 'asignado';
                $i++;
            }
            $this->db->insert_batch('excelencia.historico_revision', $historico); //Inserción en tabla historico_revision, se agrega nuevo estado para la revisión
            */
            if ($this->db->trans_status() === FALSE) {
                $this->db->trans_rollback();
                $resultado['result'] = FALSE;
                $resultado['msg'] = "Ocurrió un error durante el guardado, por favor intentelo de nuevo más tarde.";
            } else {
                $this->db->trans_commit();
                //$resultado['data'] = $taller_id;
                $resultado['result'] = TRUE;
            }
        } else {
            $resultado['msg'] = 'No existen solicitudes disponibles para la asignación, verifique el estado de las mismas.';
        }
        return $resultado;
    }

    public function get_configuracion($param = []) {
        try {
            $estado = array('success' => false, 'msg' => '', 'result' => []);
            $this->db->flush_cache();
            $this->db->reset_query();

            if (array_key_exists('select', $param)) {
                $this->db->select($param['select']);
            }
            if (array_key_exists('where', $param)) {
                $this->db->where($param['where']);
            }
            if (array_key_exists('order', $param)) {
                $this->db->order_by($param['order']['field'], $param['order']['type']);
            }

            $result = $this->db->get('excelencia.configuracion');
            //pr($this->db->last_query());
            $salida = $result->result_array();
            //pr($salida);
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
