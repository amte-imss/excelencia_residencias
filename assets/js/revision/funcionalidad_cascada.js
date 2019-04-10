$(function () {
  var down1 = false;
  $("#secTrabajoInv").click(function() {
    down1 = !down1;
    if(down1){
      $( "#hideTrabajo" ).show( 1000, function() {
        //$( this ).remove();
      });
    }else{
      $( "#hideTrabajo" ).hide( 1000, function() {
        //$( this ).remove();
      });
    }
  });

  var down2 = false;
  $("#secEvaluacion").click(function() {
    down2 = !down2;
    if(down2){
      $( "#hideEvaluacion" ).show( 1000, function() {
        //$( this ).remove();
      });
    }else{
      $( "#hideEvaluacion" ).hide( 1000, function() {
        //$( this ).remove();
      });
    }
  });

  var down3 = false;
  $("#seccion1").click(function() {
    down3 = !down3;
    if(down3){
      $( "#rubro1" ).show( 500, function() {
        //$( this ).remove();
      });
    }else{
      $( "#rubro1" ).hide( 500, function() {
        //$( this ).remove();
      });
    }
  });

  var down4 = false;
  $("#seccion2").click(function() {
    down4 = !down4;
    if(down4){
      $( "#rubro2" ).show( 500, function() {
        //$( this ).remove();
      });
    }else{
      $( "#rubro2" ).hide( 500, function() {
        //$( this ).remove();
      });
    }
  });

  var down5 = false;
  $("#seccion3").click(function() {
    down5 = !down5;
    if(down5){
      $( "#rubro3" ).show( 500, function() {
        //$( this ).remove();
      });
    }else{
      $( "#rubro3" ).hide( 500, function() {
        //$( this ).remove();
      });
    }
  });

  var down6 = false;
  $("#seccion4").click(function() {
    down6 = !down6;
    if(down6){
      $( "#rubro4" ).show( 500, function() {
        //$( this ).remove();
      });
    }else{
      $( "#rubro4" ).hide( 500, function() {
        //$( this ).remove();
      });
    }
  });

  var down7 = false;
  $("#seccion5").click(function() {
    down7 = !down7;
    if(down7){
      $( "#rubro5" ).show( 500, function() {
        //$( this ).remove();
      });
    }else{
      $( "#rubro5" ).hide( 500, function() {
        //$( this ).remove();
      });
    }
  });

  var down8 = false;
  $("#seccion6").click(function() {
    down8 = !down8;
    if(down8){
      $( "#rubro6" ).show( 500, function() {
        //$( this ).remove();
      });
    }else{
      $( "#rubro6" ).hide( 500, function() {
        //$( this ).remove();
      });
    }
  });

  var down9 = false;
  $("#seccion7").click(function() {
    down9 = !down9;
    if(down9){
      $( "#rubro7" ).show( 500, function() {
        //$( this ).remove();
      });
    }else{
      $( "#rubro7" ).hide( 500, function() {
        //$( this ).remove();
      });
    }
  });

  var down10 = false;
  $("#secResTrabajoInv").click(function(){
    down10 = !down10;
    if(down10){
      $("#hideResumen").show(1000, function(){
      })
    }else{
      $("#hideResumen").hide(1000, function(){
      })
    }
  })

  if($('input[value=educativo]:checked, input[value=conflicto]:checked').length == 2){
    $( "#seccionesEva" ).show( 1000, function() {
    });
  }else{
    $( "#seccionesEva" ).hide( 1000, function() {
    });
  }
  // $('#b_finalizar').click(function() {
  //   console.log("CALIDAD DE RESUMEN: ", $('input[name=calidad]:checked').val());
  //   console.log("ORIGINALIDAD: ", $('input[name=originalidad]:checked').val());
  //   console.log("CUANTITATIVAS: ", $('input[name=cuantitativas]:checked').val());
  //   console.log("CUALITATIVAS: ", $('input[name=cualitativas]:checked').val());
  //   console.log("MIXTAS: ", $('input[name=mixtas]:checked').val());
  //   console.log("TRASCENDENCIA: ", $('input[name=trascendencia]:checked').val());
  //   console.log("ASPECTOS ETNICOS: ", $('input[name=aspectos]:checked').val());
  // });
})

function cambio(obj){
  switch (obj.name) {
    case 'calidad':
      switch (obj.value) {
        case 'calidad1':
          $("#textCalidad").text("Valores de 1 a 4");
          break;
        case 'calidad2':
          $("#textCalidad").text("Valores de 5 a 8");
          break;
        case 'calidad3':
          $("#textCalidad").text("Valores de 9 a 12");
          break;
        case 'calidad4':
          $("#textCalidad").text("Valores de 13 a 16");
          break;
        case 'calidad5':
          $("#textCalidad").text("Valores de 17 a 20");
          break;
        default:
      }
      break;
    case 'originalidad':
      switch (obj.value) {
        case 'originalidad1':
          $("#textOriginalidad").text("Valores de 1 a 4");
          break;
        case 'originalidad2':
          $("#textOriginalidad").text("Valores de 5 a 8");
          break;
        case 'originalidad3':
          $("#textOriginalidad").text("Valores de 9 a 12");
          break;
        case 'originalidad4':
          $("#textOriginalidad").text("Valores de 13 a 16");
          break;
        case 'originalidad5':
          $("#textOriginalidad").text("Valores de 17 a 20");
          break;
        default:
      }
      break;
    case 'cuantitativas':
      switch (obj.value) {
        case 'cuantitativas1':
          $("#textCuantitativas").text("Valores de 1 a 4");
          break;
        case 'cuantitativas2':
          $("#textCuantitativas").text("Valores de 5 a 8");
          break;
        case 'cuantitativas3':
          $("#textCuantitativas").text("Valores de 9 a 12");
          break;
        case 'cuantitativas4':
          $("#textCuantitativas").text("Valores de 13 a 16");
          break;
        case 'cuantitativas5':
          $("#textCuantitativas").text("Valores de 17 a 20");
          break;
        default:
      }
      break;
    case 'cualitativas':
      switch (obj.value) {
        case 'cualitativas1':
          $("#textCualitativas").text("Valores de 1 a 4");
          break;
        case 'cualitativas2':
          $("#textCualitativas").text("Valores de 5 a 8");
          break;
        case 'cualitativas3':
          $("#textCualitativas").text("Valores de 9 a 12");
          break;
        case 'cualitativas4':
          $("#textCualitativas").text("Valores de 13 a 16");
          break;
        case 'cualitativas5':
          $("#textCualitativas").text("Valores de 17 a 20");
          break;
        default:
      }
      break;
    case 'mixtas':
      switch (obj.value) {
        case 'mixtas1':
          $("#textMixtas").text("Valores de 1 a 4");
          break;
        case 'mixtas2':
          $("#textMixtas").text("Valores de 5 a 8");
          break;
        case 'mixtas3':
          $("#textMixtas").text("Valores de 9 a 12");
          break;
        case 'mixtas4':
          $("#textMixtas").text("Valores de 13 a 16");
          break;
        case 'mixtas5':
          $("#textMixtas").text("Valores de 17 a 20");
          break;
        default:
      }
      break;
    case 'trascendencia':
      switch (obj.value) {
        case 'trascendencia1':
          $("#textTrascendencia").text("Valores de 1 a 4");
          break;
        case 'trascendencia2':
          $("#textTrascendencia").text("Valores de 5 a 8");
          break;
        case 'trascendencia3':
          $("#textTrascendencia").text("Valores de 9 a 12");
          break;
        case 'trascendencia4':
          $("#textTrascendencia").text("Valores de 13 a 16");
          break;
        case 'trascendencia5':
          $("#textTrascendencia").text("Valores de 17 a 20");
          break;
        default:
      }
      break;
    case 'aspectos':
      switch (obj.value) {
        case 'aspectos1':
          $("#textAspectos").text("Valores de 1 a 4");
          break;
        case 'aspectos2':
          $("#textAspectos").text("Valores de 5 a 8");
          break;
        case 'aspectos3':
          $("#textAspectos").text("Valores de 9 a 12");
          break;
        case 'aspectos4':
          $("#textAspectos").text("Valores de 13 a 16");
          break;
        case 'aspectos5':
          $("#textAspectos").text("Valores de 17 a 20");
          break;
        default:
      }
      break;
    default:

  }
}

