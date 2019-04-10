<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Reportes_instituto_model extends MY_Model {

    public function __construct() {
        // Call the CI_Model constructor
        parent::__construct();
    }

    /**
     * Devuelve el numero total de trabajos registrados en umae o en delegaciones
     * @author clapas
     * @date 06/06/2018
     * @param boolean - true si queremos el total en umae, false para el total en delegaciones
     * @return int
     */
    public function total_registros($es_umae = false) {
        $this->db->flush_cache();
        $this->db->reset_query();

        $this->db->where('tr.es_umae', $es_umae);
        $this->db->where('tr.activo', true); //Se refiere a la convocatoria activa
        $res = $this->db->count_all_results('foro.trabajos_registrados_imss tr');
        return $res;
    }

    /**
     * Devuelve el numero de trabajos registrados (evaluados) por umae
     * @author clapas
     * @date 06/06/2018
     * @return array
     * */
    public function top_umae() {
        $this->db->flush_cache();
        $this->db->reset_query();

        $this->db->select(array('u.nombre_unidad_principal', 'count(tr.folio)::int total'));
        $this->db->join('catalogo.unidad u', 'tr.clave_unidad = u.clave_unidad', 'right');
        $this->db->where('u.es_umae', true);
        $this->db->where('tr.activo', true); //Se refiere a la convocatoria activa
        $this->db->group_by('u.nombre_unidad_principal');
        $this->db->order_by('count(tr.folio)', 'desc');
        $this->db->order_by('u.nombre_unidad_principal', 'asc');
        $res = $this->db->get('foro.trabajos_registrados_imss tr');
        return $res->result_array();
    }

    /**
     * Devuelve el numero de trabajos registrados (evaluados) por delegacion
     * @author clapas
     * @date 06/06/2018
     * @return array
     * */
    public function top_delegacion() {
        $this->db->flush_cache();
        $this->db->reset_query();

        $this->db->select(array('d.nombre', 'count(tr.folio)::int total'));
        $this->db->join('catalogo.unidad u', 'tr.clave_unidad = u.clave_unidad AND u.es_umae = false', 'inner', false);
        $this->db->join('catalogo.delegaciones d', 'tr.clave_delegacional = d.clave_delegacional', 'right');
        $this->db->where('tr.clave_delegacional !=', '00');
        $this->db->where('tr.activo', true); //Se refiere a la convocatoria activa
        $this->db->group_by('d.nombre');
        $this->db->order_by('count(tr.folio)', 'desc');
        $this->db->order_by('d.nombre', 'asc');
        $res = $this->db->get('foro.trabajos_registrados_imss tr');

        //pr($res);
        return $res->result_array();
    }

    /**
     * Devuelve el numero de trabajos registrados (evaluados) por delegacion
     * @author LEAS
     * @date 22/06/2018
     * @return array
     * */
    public function top_delegacion_umae() {
        $this->db->flush_cache();
        $this->db->reset_query();

        $this->db->select(array("sum((case when es_umae then 1 else 0 end)) umae",
            "sum((case when nivel_atencion=1 then 1 else 0 end)) Nivel1", "sum((case when nivel_atencion=2 then 1 else 0 end)) Nivel2"
            ,"sum((case when nivel_atencion isnull then 1 else 0 end)) Otros"));
        $this->db->where('tr.clave_delegacional !=', '00');
        $this->db->where('tr.activo', true); //Se refiere a la convocatoria activa
        $res = $this->db->get('foro.trabajos_registrados_imss tr');
        //pr($res);
        return $res->result_array();
    }

    /**
     * Devuelve el promedio de los trabajos evaluados por umae
     * @author clapas
     * @date 06/06/2018
     * @return array
     * */
    public function calidad_umae() {
        $this->db->flush_cache();
        $this->db->reset_query();

        $this->db->select(array('u.nombre_unidad_principal', 'avg(tr.promedio)::int promedio'));
        $this->db->join('catalogo.unidad u', 'tr.clave_unidad = u.clave_unidad', 'right');
        $this->db->where('u.es_umae', true);
        $this->db->where('tr.activo', true); //Se refiere a la convocatoria activa
        $this->db->group_by('u.nombre_unidad_principal');
        $this->db->order_by('avg(tr.promedio) is null', false);
        $this->db->order_by('avg(tr.promedio)', 'desc');
        $this->db->order_by('u.nombre_unidad_principal', 'asc');
        $res = $this->db->get('foro.trabajos_registrados_imss tr');

        return $res->result_array();
    }

    /**
     * Devuelve el promedio de los trabajos evaluados por delegacion
     * @author clapas
     * @date 06/06/2018
     * @return array
     * */
    public function calidad_delegacion() {
        $this->db->flush_cache();
        $this->db->reset_query();

        $this->db->select(array('d.nombre', 'avg(tr.promedio)::int promedio'));
        $this->db->join('catalogo.delegaciones d', 'tr.clave_delegacional = d.clave_delegacional and tr.es_umae = false', 'right', false);
        $this->db->where('d.clave_delegacional !=', '00');
        $this->db->where('tr.activo', true); //Se refiere a la convocatoria activa
        $this->db->group_by('d.nombre');
        $this->db->order_by('avg(tr.promedio) is null', false);
        $this->db->order_by('avg(tr.promedio)', 'desc');
        $this->db->order_by('d.nombre', 'asc');
        $res = $this->db->get('foro.trabajos_registrados_imss tr');

        return $res->result_array();
    }

    /**
    * Devuelve el top de trabajos evaluados por tipo de investigacion y UMAE
    * @author clapas
    * @date 12/08/2018
    * @param int id de la metodologia o null para todas
    * @return array
    */
    public function top_evaluados_umae($metodologia = null)
    {   
        $select = array('u.nombre_unidad_principal', 'count(d.folio)::int');
        $where = array('u.es_umae' => true);
        $groupby = array('u.clave_unidad_principal','u.nombre_unidad_principal');

        if(is_null($metodologia)){
            array_push($select, 'm.id_tipo_metodologia', 'm.lang::varchar');
            array_push($groupby, 'm.id_tipo_metodologia', 'm.lang::varchar');
        } else {
            $where['m.id_tipo_metodologia'] = $metodologia;
        }

       $this->db->flush_cache();
       $this->db->reset_query(); 

       $this->db->select($select,false);
       $this->db->join('foro.trabajo_investigacion ti' ,'tri.folio = ti.folio');
       $this->db->join('foro.tipo_metodologia m', 'ti.id_tipo_metodologia = m.id_tipo_metodologia');
       $this->db->join('catalogo.unidad u', 'tri.clave_unidad = u.clave_unidad');
       $this->db->join('foro.dictamen d', 'tri.folio = d.folio');
       $this->db->where($where);
       $this->db->group_by($groupby,false);
       $this->db->order_by('count(d.folio)', 'desc');

       $res = $this->db->get('foro.trabajos_registrados_imss tri');
       //pr($this->db->last_query());
       return $res->result_array();
    }


    /**
    * Devuelve el top de trabajos evaluados por tipo de investigacion y Delegacion
    * @author clapas
    * @date 12/08/2018
    * @param int id de la metodologia o null para todas
    * @return array
    */
    public function top_evaluados_delegacion($metodologia = null)
    {
        $select = array('del.nombre', 'count(d.folio)::int');
        $where = array('tri.es_umae' => false);
        $groupby = array('del.clave_delegacional','del.nombre');

        if(is_null($metodologia)){
            array_push($select, 'm.id_tipo_metodologia', 'm.lang::varchar');
            array_push($groupby, 'm.id_tipo_metodologia', 'm.lang::varchar');
        } else {
            $where['m.id_tipo_metodologia'] = $metodologia;
        }

       $this->db->flush_cache();
       $this->db->reset_query(); 

       $this->db->select($select,false);
       $this->db->join('foro.trabajo_investigacion ti' ,'tri.folio = ti.folio');
       $this->db->join('foro.tipo_metodologia m', 'ti.id_tipo_metodologia = m.id_tipo_metodologia');
       $this->db->join('catalogo.delegaciones del', 'tri.clave_delegacional = del.clave_delegacional');
       $this->db->join('foro.dictamen d', 'tri.folio = d.folio');
       $this->db->where($where);
       $this->db->group_by($groupby, false);
       $this->db->order_by('count(d.folio)', 'desc');

       $res = $this->db->get('foro.trabajos_registrados_imss tri');
       //pr($this->db->last_query());
       return $res->result_array();
    }


    /**
    * Devuelve el top de trabajos evaluados por tipo de investigacion de externos
    * @author clapas
    * @date 12/08/2018
    * @param int id de la metodologia o null para todas
    * @return array
    */
    public function top_evaluados_externos($metodologia = null)
    {
        $select = array('p.clave_pais', 'p.lang::varchar', 'count(d.folio)::int');
        $where = array('iu.es_imss' => false,'a.registro' => true);
        $groupby = array('p.clave_pais', 'p.lang::varchar');

        if(is_null($metodologia)){
            array_push($select, 'm.id_tipo_metodologia', 'm.lang::varchar');
            array_push($groupby, 'm.id_tipo_metodologia', 'm.lang::varchar');
        } else {
            $where['m.id_tipo_metodologia'] = $metodologia;
        }

       $this->db->flush_cache();
       $this->db->reset_query(); 

       $this->db->select($select,false);
       $this->db->join('foro.autor a','ti.folio = a.folio_investigacion');
       $this->db->join('sistema.informacion_usuario iu','a.id_informacion_usuario = iu.id_informacion_usuario');
       $this->db->join('catalogo.pais p', 'iu.clave_pais = p.clave_pais');
       $this->db->join('foro.tipo_metodologia m', 'ti.id_tipo_metodologia = m.id_tipo_metodologia');
       $this->db->join('foro.dictamen d', 'ti.folio = d.folio');
       $this->db->where($where);
       $this->db->group_by($groupby,false);
       $this->db->order_by('count(d.folio)', 'desc');

       $res = $this->db->get('foro.trabajo_investigacion ti');
       //pr($this->db->last_query());
       return $res->result_array();
    }

    /**
    * Devuelve el top de evaluados por seccion evaluada para la calidad del trabajo
    * y registradas en umae
    * @author clapas
    * @date 15/08/2018
    * @param int id de la seccion evaluada o null para todas
    * @return array
    */
    public function calidad_seccion_umae($id_seccion=null)
    {
        $this->db->flush_cache();
        $this->db->reset_query(); 

        $select = array('u.nombre_unidad_principal','avg(cse.promedio)::real promedio');
        $groupby = array('u.clave_unidad_principal','u.nombre_unidad_principal');

        if(is_null($id_seccion)){
            array_push($select, 'cse.id_seccion', 'cse.descripcion::varchar');
            array_push($groupby, 'cse.id_seccion', 'cse.descripcion::varchar');
        }

        $this->db->select($select,false);
        $this->db->join('foro.trabajos_registrados_imss tri','cse.folio = tri.folio AND tri.es_umae = true','inner',false);
        $this->db->join('catalogo.unidad u','tri.clave_unidad = u.clave_unidad');

        if(!is_null($id_seccion)){
            $this->db->where('cse.id_seccion',$id_seccion);
        }

        $this->db->group_by($groupby,false);
        $this->db->order_by('avg(cse.promedio)', 'desc');

        $res = $this->db->get('foro.calidad_por_seccion_evaluados cse');
       //pr($this->db->last_query());
       return $res->result_array();
    }

    /**
    * Devuelve el top de evaluados por seccion evaluada para la calidad del trabajo
    * y registradas en delegaciones
    * @author clapas
    * @date 15/08/2018
    * @param int id de la seccion evaluada o null para todas
    * @return array
    */
    public function calidad_seccion_delegacion($id_seccion=null)
    {
        $this->db->flush_cache();
        $this->db->reset_query(); 

        $select = array('d.nombre','avg(cse.promedio)::real promedio');
        $groupby = array('d.clave_delegacional','d.nombre');

        if(is_null($id_seccion)){
            array_push($select, 'cse.id_seccion', 'cse.descripcion::varchar');
            array_push($groupby, 'cse.id_seccion', 'cse.descripcion::varchar');
        }

        $this->db->select($select,false);
        $this->db->join('foro.trabajos_registrados_imss tri','cse.folio = tri.folio AND tri.es_umae = false','inner',false);
        $this->db->join('catalogo.delegaciones d','tri.clave_delegacional = d.clave_delegacional');

        if(!is_null($id_seccion)){
            $this->db->where('cse.id_seccion',$id_seccion);
        }

        $this->db->group_by($groupby,false);
        $this->db->order_by('avg(cse.promedio)', 'desc');

        $res = $this->db->get('foro.calidad_por_seccion_evaluados cse');
       //pr($this->db->last_query());
       return $res->result_array();
    }


    /**
    * Devuelve el top de evaluados por seccion evaluada para la calidad del trabajo
    * y registradas por externos
    * @author clapas
    * @date 15/08/2018
    * @param int id de la seccion evaluada o null para todas
    * @return array
    */
    public function calidad_seccion_externo($id_seccion=null)
    {
        $this->db->flush_cache();
        $this->db->reset_query(); 

        $select = array('p.lang::varchar','avg(cse.promedio)::real promedio');
        $groupby = array('p.clave_pais', 'p.lang::varchar');

        if(is_null($id_seccion)){
            array_push($select, 'cse.id_seccion', 'cse.descripcion::varchar');
            array_push($groupby, 'cse.id_seccion', 'cse.descripcion::varchar');
        }

        $this->db->select($select,false);
        $this->db->join('foro.autor a','cse.folio = a.folio_investigacion AND a.registro = true','inner',false);
        $this->db->join('sistema.informacion_usuario iu', 'a.id_informacion_usuario = iu.id_informacion_usuario AND iu.es_imss = false', 'inner', false);
        $this->db->join('catalogo.pais p','iu.clave_pais = p.clave_pais');

        if(!is_null($id_seccion)){
            $this->db->where('cse.id_seccion',$id_seccion);
        }

        $this->db->group_by($groupby,false);
        $this->db->order_by('avg(cse.promedio)', 'desc');

        $res = $this->db->get('foro.calidad_por_seccion_evaluados cse');
       //pr($this->db->last_query());
       return $res->result_array();
    }

}
