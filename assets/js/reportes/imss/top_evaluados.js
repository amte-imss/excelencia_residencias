$(document).ready(function () {

    $('#select_umae').change(function(event) {
        $("#select_umae option[value='0']").remove();
        top_evaluados_umae($(this).val(),$('#select_umae option:selected').text());
    });

    $('#select_delegacion').change(function(event) {
        $("#select_delegacion option[value='0']").remove();
        top_evaluados_delegacion($(this).val(),$('#select_delegacion option:selected').text());
    });

    $('#select_externo').change(function(event) {
        $("#select_externo option[value='0']").remove();
        top_evaluados_externo($(this).val(),$('#select_externo option:selected').text());
    });
    
});

function top_evaluados_umae(id_tm,tipo) {
    console.log(id_tm);
    $.ajax({
        url: site_url + '/reportes_institucion/evaluados_metodologia/umae/' + id_tm,
        dataType: 'json',
    })
    .done(function(data) {
        console.log("success");
        //console.log(data);
        titulo =  language_text.reportes_imss.titulo_top_evaluados_umae;
        grafica(data,'#grafica_umae',titulo.replace('$type$',tipo));
    })
    .fail(function() {
        console.log("error");
    })
    .always(function() {
        console.log("complete");
    });
    
}

function top_evaluados_delegacion(id_tm,tipo) {
    console.log(id_tm);
    $.ajax({
        url: site_url + '/reportes_institucion/evaluados_metodologia/delegacion/' + id_tm,
        dataType: 'json',
    })
    .done(function(data) {
        console.log("success");
        //console.log(data);
        titulo =  language_text.reportes_imss.titulo_top_evaluados_del;
        grafica(data,'#grafica_delegacion',titulo.replace('$type$',tipo));
    })
    .fail(function() {
        console.log("error");
    })
    .always(function() {
        console.log("complete");
    });
    
}

function top_evaluados_externo(id_tm,tipo) {
    console.log(id_tm);
    $.ajax({
        url: site_url + '/reportes_institucion/evaluados_metodologia/externo/' + id_tm,
        dataType: 'json',
    })
    .done(function(data) {
        console.log("success");
        //console.log(data);
        titulo =  language_text.reportes_imss.titulo_top_evaluados_ext;
        grafica(data,'#grafica_externo',titulo.replace('$type$',tipo));
    })
    .fail(function() {
        console.log("error");
    })
    .always(function() {
        console.log("complete");
    });
    
}

function grafica(data_grafica,div,titulo) {
    $(div).empty();
    var $container = $(div);
    if (data_grafica.length > 0) {
        var chart = new Highcharts.Chart({
            lang: textos_lenguaje(),
            chart: {
                type: 'column',
                renderTo: $container[0],
            },
            title: {
                text: titulo
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
                    text: language_text.reportes_imss.yaxis_top_evaluados
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
                pointFormat: language_text.reportes_imss.tooltip_top_evaluados +' <b>{point.y}</b>'
            },
            series: [{
                    name: 'Population',
                    data: data_grafica,
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
        $(div).append('<center><h3>' + language_text.reportes.lbl_sin_registros + '</h3></center>');
    }
}


