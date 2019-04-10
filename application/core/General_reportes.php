<?php

defined('BASEPATH') OR exit('No direct script access allowed');

/**
 * Clase que contiene las funciones generales de las revisiones,
 * y gestión de revisiones
 * @version 	: 1.0.0
 * @author      : LEAS
 * */
class General_reportes extends MY_Controller {

    function __construct() {
        parent::__construct();
    }

    public function bibliotecas_graficas($array_bibliotecas = ['a', 'c', 'd']) {
        $coleccion = [
            'a' => 'highcharts/highcharts.js',
            'b' => 'highcharts/highcharts-3d.js',
            'c' => 'highcharts/data.js',
            'd' => 'highcharts/modules/exporting.js',
            'e' => 'highcharts/modules/variwide.js',
            'f' => 'highcharts/modules/offline-exporting.js',
            'g' => 'highcharts/highstock.js',
        ];
        $output = [];
        foreach ($array_bibliotecas as $value) {
            $output[] = $coleccion[$value];
        }
        return $output;
    }

}
