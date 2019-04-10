jQuery(document).ready(function () {
    $('.highcharts-credits').each(function () {
        $(this).css('display', 'none');
    });
});

function get_data_trabajos_calidad() {
    var data_r = new Array();
    var objeto = null;
    var text_sexo = '';
    var objeto_datos = data_grafica.data;
    for (var i in objeto_datos) {
        if (objeto_datos.hasOwnProperty(i)) {
              objeto = objeto_datos[i];
              text_sexo = language_text.reportes['rep_sexo_' + objeto['sexo']];
              //console.log(text_sexo)
              //data_r.push([text_sexo, parseFloat(objeto["promedio"]), parseFloat(objeto["total_trabajos"])]);
              data_r.push([text_sexo, parseFloat(objeto['promedio'])]);
        }
    }
    //console.log(objeto_datos);
    if(objeto_datos.length < 3){
      text_sexo = language_text.reportes['rep_sexo_O'];
      data_r.push([text_sexo, 0]);
    }

    return data_r;
}

Highcharts.chart('progressBar', {
    lang: textos_lenguaje(),
    chart: {
        type: 'column'
    },
    title: {
        text: language_text.reportes_calidad.calidad_genero_t
    },
    subtitle: {
        text: language_text.reportes_calidad.calidad_genero_st_fmo
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
            text: language_text.reportes.genero_lbl
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
//        text: language_text.reportes_calidad.calidad_genero_t
//    },
//    subtitle: {
//        text: language_text.reportes_calidad.calidad_genero_st_fmo
//    },
//    xAxis: {
//        type: 'category',
//        title: {
//            text: language_text.reportes_calidad.medicion_x
//        },
//        labels: {
//            rotation: -60,
//            style: {
//                fontSize: '13px',
//                fontFamily: 'Verdana, sans-serif'
//            }
//        }
//
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
////    tooltip: {
////        pointFormat: 'Trabajos registrados: <b>{point.y:.1f}%</b>'
////    },
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
//                format: '{point.y:.0f}',
//            },
//            tooltip: {
//                pointFormat: language_text.reportes.calidad + ': <b> {point.y}</b><br>' +
//                        language_text.reportes.total_trabajos + ': <b> {point.z} </b><br>'
//            },
//            colorByPoint: true
//        }],
//});
