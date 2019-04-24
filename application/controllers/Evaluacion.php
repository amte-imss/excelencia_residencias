<?php
defined('BASEPATH') OR exit('No direct script access allowed');
/**
 * Clase que contiene evaluacion de los docentes
 * @version 	: 0.0.1
 * @author      : Roa
 * */
class Evaluacion extends MY_Controller {

    const TAB_EVALUACION = 'EVALUACION';

    function __construct() {
        parent::__construct();
        
        $this->load->model('Evaluacion_model', 'em');
        $this->load->library('cart');
    }

    /**
     * Función que obtiene la evaluacion de docentes
     * con grocery crud
     * @author Roa
     * @date 24/04/2019
     *
     */
    function evaluacion(){
        try{
            $Evaluacion_model = $this->em->get_evaluaciones();
            $crud = $this->new_crud();
            $crud->set_table('evaluacion');
            $crud->set_subject('evaluacion');
            //$crud->unset_add(); //quito el botón addRecord
            $crud->set_primary_key('id_evaluacion');

            $crud->fields("matricula", "id_solicitud", "puntaje_pnpc", "puntaje_carrera_docente", "puntaje_sa_et", "puntaje_sa_satisfaccion", "puntaje_anios_docente");
            $crud->columns("matricula",  "id_solicitud", "puntaje_pnpc", "puntaje_carrera_docente", "puntaje_sa_et", "puntaje_sa_satisfaccion", "puntaje_anios_docente");
            
            //$crud->required_fields("matricula");
            
            //tomo las columnas de las tablas y las regreso como en el 2do campo en view
            $crud->display_as("matricula", "Matrícula");
            $crud->display_as("puntaje_pnpc", "Puntaje PNPC");
            $crud->display_as("puntaje_carrera_docente", "Puntaje Carrera Docente");
            $crud->display_as("puntaje_sa_et", "Puntaje de Sede Académica por Eficiencia Terminal");
            $crud->display_as("puntaje_sa_satisfaccion", "Puntaje de Satisfacción por Sede Académica");
            $crud->display_as("puntaje_anios_docente", "Puntaje de Años de Docente");

            $data_view['output'] = $crud->render();
            $data_view['title'] = "Evaluacion";

            $vista = $this->load->view('admin/admin.evaluacion.php', $data_view, true);
            $this->template->setMainContent($vista);
            $this->template->getTemplate();
        }
        catch(Exception $e){
            show_error($e->getMessage() . 'No se pudo mostrar la página' . $e->getTraceAsString());
        }
    }


}
