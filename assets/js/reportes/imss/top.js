$(document).ready(function () {
    grafica_delegacion();
    grafica_umae();
    $('.highcharts-container').each(function () {
        $(this).width('100%');
    });
    $('.highcharts-root').each(function () {
        $(this).width('100%');
    });
    $('.highcharts-credits').each(function () {
        $(this).css('display', 'none');
    });
});

function grafica_umae() {
    if (data_grafica_umae.length > 0) {
        var $container = $('#grafica_umae');
        var chart = new Highcharts.Chart({
            lang: textos_lenguaje(),
            chart: {
                type: 'column',
                renderTo: $container[0],
            },
            title: {
                text: language_text.reportes_imss.titulo_top + ' UMAE'
            },
            xAxis: {
                type: 'category',
                labels: {
                    rotation: -60,
                    style: {
                        fontSize: '13px',
                        fontFamily: 'Verdana, sans-serif'
                    }
                }
            },
            yAxis: {
                min: 0,
                title: {
                    text: language_text.reportes_imss.yaxis_top
                },
                scrollbar: {
                    enabled: true,
                    showFull: true
                }
            },
            legend: {
                enabled: false
            },
            tooltip: {
                pointFormat: language_text.reportes_imss.tooltip_top + ' <b>{point.y}</b>'
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
                    name: 'Population',
                    data: data_grafica_umae,
					dataLabels: {
					  enabled: true,
					  //rotation: -90,
					  //color: '#FFFFFF',
					  align: 'right',
					  //format: '{point.y:.1f}', // one decimal
					  y: 10, // 10 pixels down from the top
					  style: {
						fontSize: '13px',
						fontFamily: 'Verdana, sans-serif'
					  }
					}
                }]
        });
    } else {
        $('#grafica_umae').empty();
        $('#grafica_umae').append('<center><h3>' + language_text.reportes.lbl_sin_registros + '</h3></center>');
    }
}

function grafica_delegacion() {
    if(data_grafica_delegacion.length > 0){
        var $container = $('#grafica_delegacion');
        var chart = new Highcharts.Chart({
            lang: textos_lenguaje(),
            chart: {
                type: 'column',
                renderTo: $container[0],
            },
            title: {
                text: language_text.reportes_imss.titulo_top + ' delegación'
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
                scrollbar: {
                    enabled: true,
                    showFull: true
                }
            },
            yAxis: {
                min: 0,
                title: {
                    text: language_text.reportes_imss.yaxis_top
                }
            },
            legend: {
                enabled: false
            },
            tooltip: {
                pointFormat: language_text.reportes_imss.tooltip_top + ' <b>{point.y}</b>'
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
                    name: 'Population',
                    data: data_grafica_delegacion,
					dataLabels: {
					  enabled: true,
					  //rotation: -90,
					  //color: '#FFFFFF',
					  align: 'right',
					  //format: '{point.y:.1f}', // one decimal
					  y: 10, // 10 pixels down from the top
					  style: {
						fontSize: '13px',
						fontFamily: 'Verdana, sans-serif'
					  }
					}
                }]
        }
    //    , function(chart) { // on complete
    //         console.log("chart = ");
    //        console.log(chart);
    //        //chart.renderer.path(['M', 0, 0, 'L', 100, 100, 200, 50, 300, 100])
    //        chart.renderer.path(['M', 75, 223.5,'L', 259, 47])//M 75 223.5 L 593 223.5
    //            .attr({
    //                'stroke-width': 2,
    //                stroke: 'red'
    //            })
    //            .add();
    //        
    //    }
        );
    }else{
        $('#grafica_delegacion').empty();
        $('#grafica_delegacion').append('<center><h3>' + language_text.reportes.lbl_sin_registros + '</h3></center>');
    }
}