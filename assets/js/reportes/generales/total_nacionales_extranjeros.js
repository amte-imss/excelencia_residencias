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
        text: language_text.reportes_generales.t_nac_ext
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
//        exporting: {
//            buttons: {
//                contextButton: {
//                    enabled: false,
//                },
//                exportButton: {
//                    text: language_text.reportes.descarga_lbl,
//                    menuItems: Highcharts.getOptions().exporting.buttons.contextButton.menuItems.splice(5)
//                },
//            }
//        },
    series: [{
            name: language_text.reportes.porcentaje_lbl,
            colorByPoint: true,
            data: [
                [language_text.reportes_generales.lbl_nacionales, parseFloat(data_grafica.nacionales_extranjeros[0]['trabajos_nacionales'])],
                [language_text.reportes_generales.lbl_extranjeros, parseFloat(data_grafica.nacionales_extranjeros[0]['trabajos_extranjeros'])],
            ]
        }]
});

