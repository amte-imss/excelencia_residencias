jQuery(document).ready(function () {
    $('.highcharts-credits').each(function () {
        $(this).css('display', 'none');
    });
});
function get_data_trabajos_calidad() {
    var data_r = new Array();
    var objeto = null;
    var text_sexo = '';
    var objeto_datos = data_grafica.genero;
    for (var i in objeto_datos[0]) {
        if (objeto_datos[0].hasOwnProperty(i)) {
            //console.log(i);
            objeto = objeto_datos[0][i];
            //console.log(objeto);
            text_sexo = language_text.reportes['rep_sexo_' + i.toUpperCase()];
            //console.log(text_sexo);
            //data_r.push([text_sexo, parseFloat(objeto["promedio"]), parseFloat(objeto["total_trabajos"])]);
            data_r.push([text_sexo, parseFloat(objeto)]);
        }
    }
    //console.log(data_r);
    return data_r;
}

Highcharts.chart('container', {
    lang: textos_lenguaje(),
    chart: {
        plotBackgroundColor: null,
        plotBorderWidth: null,
        plotShadow: false,
        type: 'pie'
    },
    title: {
        text: language_text.reportes_generales.t_genero
    },
    tooltip: {
        pointFormat: '<br>' + language_text.reportes.total_gral + '<b>{point.y}</b><br>' +
                '{series.name}: <b>{point.percentage:.1f}%'
    },
    plotOptions: {
        pie: {
            allowPointSelect: true,
            cursor: 'pointer',
            dataLabels: {
                enabled: true,
                format: '<b>{point.name}</b><br>' +
                        language_text.reportes.total_gral + ': <b>{point.y}</b><br> ' +
                        language_text.reportes.porcentaje_lbl + ': {point.percentage:.1f} % ',
                style: {
                    color: (Highcharts.theme && Highcharts.theme.contrastTextColor) || 'black'
                }
            },
            showInLegend: false
        }
    },
//    exporting: {
//        buttons: {
//            contextButton: {
//                enabled: false,
//            },
//            exportButton: {
//                text: language_text.reportes.descarga_lbl,
//                menuItems: Highcharts.getOptions().exporting.buttons.contextButton.menuItems.splice(5)
//            },
//        }
//    },
    series: [{
            name: language_text.reportes.porcentaje_lbl,
            colorByPoint: true,
            data: get_data_trabajos_calidad()
        }]
});
