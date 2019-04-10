jQuery(document).ready(function () {
    $('.highcharts-credits').each(function () {
        $(this).css('display', 'none');
    });
});
Highcharts.chart('container', {
    lang: textos_lenguaje(),
    chart: {
        plotBackgroundColor: null,
        plotBorderWidth: null,
        plotShadow: false,
        type: 'pie'
    },
    title: {
        text: language_text.reportes_generales.t_exposiciones
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
            data: [
                [language_text.reportes_generales.lbl_cartel, parseFloat(data_grafica.exposiciones[0]['count'])],
                [language_text.reportes_generales.lbl_oratoria, parseFloat(data_grafica.exposiciones[1]['count'])],
                // [language_text.reportes_generales.lbl_rechazados, parseFloat(data_grafica.rechazados[0]['count'])],
                [language_text.reportes_generales.lbl_rechazados_nte, parseFloat(data_grafica.no_trabajo_educacion[0]['count'])],
                ["En revision", parseFloat(data_grafica.en_revision)],
                ["Sin asignar",parseFloat(data_grafica.sin_asignacion)],
                ["Sin comite", parseFloat(data_grafica.sin_comite)]
            ]
        }]
});
