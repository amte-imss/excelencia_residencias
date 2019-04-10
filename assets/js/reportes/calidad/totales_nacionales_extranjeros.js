jQuery(document).ready(function () {
    $('.highcharts-credits').each(function () {
        $(this).css('display', 'none');
    });
});


Highcharts.chart('progressBar', {
    lang: textos_lenguaje(),
    chart: {
        plotBackgroundColor: null,
        plotBorderWidth: null,
        plotShadow: false,
        type: 'pie'
    },
    title: {
        text: language_text.reportes_calidad.calidad_ext_nac_t
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
                format: '<b>{point.name}</b><br> ' +
                        language_text.reportes.total_gral + ': <b>{point.y}</b><br> ' +
                        language_text.reportes.porcentaje_lbl + ': {point.percentage:.1f} %',
                style: {
                    color: (Highcharts.theme && Highcharts.theme.contrastTextColor) || 'black'
                }
            },
            showInLegend: false
        }
    },
//    exporting: {
////        menuItemDefinitions: {
////            // Custom definition
////            label: {
////                onclick: function () {
////                    this.renderer.label(
////                            'You just clicked a custom menu item',
////                            100,
////                            100
////                            )
////                            .attr({
////                                fill: '#a4edba',
////                                r: 5,
////                                padding: 10,
////                                zIndex: 10
////                            })
////                            .css({
////                                fontSize: '1.5em'
////                            })
////                            .add();
////                },
////                text: 'Show label'
////            }
////        },
//        buttons: {
//            contextButton: {
//                enabled: false,
////                menuItems: ['downloadPNG', 'downloadSVG', 'separator', 'label']
//            },
//            exportButton: {
//                text: language_text.reportes.descarga_lbl,
//                menuItems: Highcharts.getOptions().exporting.buttons.contextButton.menuItems.splice(5),
//            },
////            printButton: {
////                text: 'Print',
////                onclick: function () {
////                    this.print();
////                }
////            }
//        }
//    },
    series: [{
            name: language_text.reportes.porcentaje_lbl,
            colorByPoint: true,
            data: [
                [language_text.reportes_calidad.nac_inst, parseFloat(data_grafica.data.trabajos_nacionales_imss)],
                [language_text.reportes_calidad.ext_inst, parseFloat(data_grafica.data.trabajos_extranjeros_imss)],
                [language_text.reportes_calidad.nac_no_inst, parseFloat(data_grafica.data.trabajos_nacionales_no_imss)],
                [language_text.reportes_calidad.ext_no_inst, parseFloat(data_grafica.data.trabajos_extranjeros_no_imss)],
            ]
        }],
//    exporting: {
//        buttons: {
//            contextButton: {
//                menuItems: [],
//                onclick: function () {
//                    console.log(this);
//
////                    this.exportChart({format: "pdf"});
////                    chart.exportTest('application/pdf');
//                }
//            }
//        }
//    }
});

/* End of automation code */
