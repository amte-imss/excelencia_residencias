$(document).ready(function () {
    Highcharts.setOptions({
        lang: {
            contextButtonTitle: "Menú contextual",
            downloadJPEG: "Descargar imagen JPEG",
            downloadPDF: "Descargar documento PDF",
            downloadPNG: "Descargar imagen PNG",
            downloadSVG: "Descargar imagen en vectores SVG",
            drillUpText: "Regresar a {series.ranking}",
            loading: "Cargando...",
            months: ["Enero", "Febrero", "Marzo", "Abril", "Mayo", "Junio", "Julio", "Agosto", "Septiembre", "Octubre", "Noviembre", "Diciembre"],
            noData: "No hay datos que mostrar",
            printChart: "Imprimir gráfica",
            resetZoom: "Restablecer zoom",
            resetZoomTitle: "Restablecer zoom nivel 1:1",
            shortMonths: ["Ene", "Feb", "Mar", "Abr", "May", "Jun", "Jul", "Ago", "Sep", "Oct", "Nov", "Dic"],
            weekdays: ["Domingo", "Lunes", "Martes", "Miércoles", "Jueves", "Viernes", "Sábado"]
        },
        credits: {
            enabled: false
        },
        exporting: {
            enabled: false
        }
    });
});

function chart(id_chart, tabla, titulo, ytext, color) {
      var g = Highcharts.chart(id_chart, {
          data: {
              table: tabla
          },
          chart: {
              type: 'column',
              backgroundColor: '#3e4b5a'
          },
          //colors: color,
          plotOptions: {
            series: {
              colorByPoint: true,
              animation: false
            }
          },
          title: {
              text: titulo
          },
          legend: {
              enabled: false
          },
          yAxis: {
              allowDecimals: false,
              title: {
                  text: ytext
              },
              visible: false,
          },
          xAxis: {
            labels: {
              style: {
                  color: 'whitesmoke'
              }
            }
          }
      });
}

function progresBar(id_chart, tabla, titulo, ytext, color, promedioFinal){
      var valor = 0;
      promedioFinal = parseInt(promedioFinal);
      if(promedioFinal >= 0 && promedioFinal <= 4){
        valor = "Muy malo"
      } else if(promedioFinal >= 5 && promedioFinal <= 8){
        valor = "Malo"
      } else if(promedioFinal >= 9 && promedioFinal <= 12){
        valor = "Regular"
      } else if(promedioFinal >= 13 && promedioFinal <= 16){
        valor = "Bueno"
      } else if(promedioFinal >= 17 && promedioFinal <= 20){
        valor = "Muy Bueno"
      }
      Highcharts.setOptions({
       chart: {
         inverted: true,
         // marginLeft: 135,
         type: 'bullet',
         backgroundColor: '#3e4b5a'
       },
       title: {
         text: titulo,
         style:{
           color: 'whitesmoke'
         }
       },
       legend: {
         enabled: false
       },
       yAxis: {
         gridLineWidth: 0,
         labels: {
              style: {
                  color: 'whitesmoke'
              }
          }
       },
       plotOptions: {
         series: {
           //pointPadding: 0.25,
           //borderWidth: 0,
           color: '#ffffff',
           targetOptions: {
             //width: '200%'
           }
         }
       },
       credits: {
         enabled: false
       },
       exporting: {
         enabled: false
       }
      });

      var g = Highcharts.chart(id_chart, {
       chart: {
         //marginTop: 40
       },
       title: {
         color: '#ffffff',
         text: titulo
       },
       xAxis: {
         categories: ['<span class="hc-cat-title" style="color:whitesmoke;">'+valor+'</span><br/>']
       },
       yAxis: {
         plotBands: [{
           from: 0,
           to: 4,
           color: '#e43b5f'
         }, {
           from: 4,
           to: 8,
           color: '#ff9125'
         }, {
           from: 8,
           to: 12,
           color: '#ffc800'
         }, {
           from: 12,
           to: 16,
           color: '#6ac0b1'
         }, {
           from: 16,
           to: 20,
           color: '#21908e'
         }],
         title: null
       },
       series: [{
         data: [{
           y: promedioFinal,
           target: 20
         }]
       }]
      });
}
