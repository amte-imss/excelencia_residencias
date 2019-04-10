jQuery(document).ready(function () {
    $('.highcharts-credits').each(function () {
        $(this).css('display', 'none');
    });
});
function get_data_trabajos_calidad() {
    var data_r = new Array();
    var objeto = null;
    var objeto_datos = data_grafica.data;
    console.log(objeto_datos);
    for (var i in objeto_datos) {
        if (objeto_datos.hasOwnProperty(i)) {
            objeto = objeto_datos[i];
//            data_r.push([language_text.reportes_calidad[i], parseFloat(objeto["promedio"]), parseFloat(objeto["total_trabajos"])]);
            data_r.push([language_text.reportes_calidad[i], parseFloat(objeto["promedio"])]);
        }
    }
    return data_r;
}

Highcharts.chart('progressBar', {
    lang: textos_lenguaje(),
    chart: {
        type: 'column'
    },
    title: {
        text: language_text.reportes_calidad.calidad_ext_nac_t
    },
    subtitle: {
        text: language_text.reportes_calidad.calidad_ext_nac_ins_st
    },
    xAxis: {
        type: 'category',
        labels: {
            rotation: -60,
            style: {
                fontSize: '13px',
                fontFamily: 'Verdana, sans-serif'
            }
        },
        title: {
            text: language_text.reportes.registros_lbl
        },
    },
    yAxis: {
        min: 0,
        title: {
            text: language_text.reportes_calidad.medicion_y
        }
    },
    legend: {
        enabled: false
    },
    tooltip: {
        pointFormat: language_text.reportes_calidad.medicion_y + ' : <b>{point.y:.1f}</b>'
    },
//    tooltip: {
//        pointFormat: language_text.reportes.calidad + ': <b> {point.y}</b><br>' +
//                language_text.reportes.total_trabajos + ': <b> {point.z} </b><br>'
//    },
    series: [{
            name: language_text.reportes_calidad.medicion_y,
            data: get_data_trabajos_calidad(),
        }]
});

//Highcharts.chart('progressBar', {
//    lang: textos_lenguaje(),
//    chart: {
//        type: 'variwide'
//    },
//    title: {
//        text: language_text.reportes_calidad.calidad_ext_nac_t
//    },
//    subtitle: {
//        text: language_text.reportes_calidad.calidad_ext_nac_ins_st
//    },
//    xAxis: {
//        type: 'category',
//        title: {
//            text: language_text.reportes_calidad.medicion_x
//        }
//    },
//    yAxis: {
//        min: 0,
//        max: 20,
//        title: {
//            text: language_text.reportes_calidad.medicion_y
//        }
//    },
//    legend: {
//        enabled: false
//    },
////    exporting: {
////        buttons: {
////            contextButton: {
////                enabled: false,
////            },
////            exportButton: {
////                text: language_text.reportes.descarga_lbl,
////                menuItems: Highcharts.getOptions().exporting.buttons.contextButton.menuItems.splice(5)
////            },
////        }
////    },
//    series: [{
//            name: 'Calidad',
//            data: get_data_trabajos_calidad(),
//            dataLabels: {
//                enabled: true,
//                format: '{point.y:.0f}'
//            },
//            tooltip: {
//                pointFormat: language_text.reportes.calidad + ': <b> {point.y}</b><br>' +
//                        language_text.reportes.total_trabajos + ': <b> {point.z} </b><br>'
//            },
//            colorByPoint: true
//        }],
//});
