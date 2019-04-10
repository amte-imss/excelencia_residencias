$(document).ready(function() {
	$('#btn_manual').click(function() {
		if(confirm(confirmacion_manual)){
			$.ajax({
				url: site_url + '/dictamen/activar_asignacion/M',
				type: 'GET',
				beforeSend: function (xhr) {
           			mostrar_loader();
       			}
			})
			.done(function() {
				console.log("success");
				location.reload();
			})
			.fail(function() {
				console.log("error");
			})
			.always(function() {
				console.log("complete");
				remove_loader();
       			ocultar_loader();
			});
			
		}
	});

	$('#btn_automatico').click(function() {
		if(confirm(confirmacion_automatica)){
			$.ajax({
				url: site_url + '/dictamen/activar_asignacion/A',
				type: 'GET',
				beforeSend: function (xhr) {
           			mostrar_loader();
       			}
			})
			.done(function() {
				console.log("success");
				location.reload();
			})
			.fail(function() {
				console.log("error");
			})
			.always(function() {
				console.log("complete");
				remove_loader();
       			ocultar_loader();
			});
			
		}
	});


	$('#btn_cerar_proceso').click(function() {
		if(confirm(confirmacion_cierre_convocatoria)){
			$.ajax({
				url: site_url + '/dictamen/cierre_convocatoria',
				type: 'GET',
				beforeSend: function (xhr) {
           			mostrar_loader();
       			}
			})
			.done(function() {
				console.log("success");
				location.reload();
			})
			.fail(function() {
				console.log("error");
			})
			.always(function() {
				console.log("complete");
				remove_loader();
       			ocultar_loader();
			});
			
		}
	});

	$(".btn_asignar").click(function() {
		var $row = $(this).closest("tr");    // Find the row
	    var $text = $row.find(".row_folio").text(); // Find the text
	    var $text_slct = $row.find(".select_asignacion").val();

	    var confirmar = 'Confirmar';
	    switch($text_slct){
	    	case 'C':
	    		confirmar = confirmacion_acartel;
	    	break;
	    	case 'R':
	    		confirmar = confirmacion_rechazado;
	    	break;
	    	case 'O':
	    		confirmar = confirmacion_aoral;
	    	break;
	    	case 'Q':
	    		confirmar = confirmacion_sa;
	    	break;
	    }

	    if(confirm(confirmar)){
            var datos = {
            	folio: $text,
            	sugerencia: $text_slct
            }

	    	$.ajax({
	    		url:  site_url + '/dictamen/asignacion_manual',
	    		type: 'POST',
	    		dataType: 'json',
	    		data: datos,
	    		beforeSend: function (xhr) {
           			mostrar_loader();
       			}
	    	})
	    	.done(function(json) {
	    		console.log("success");
	    		document.location.href= site_url + '/dictamen';
	    		alert(json['msg']);
	    	})
	    	.fail(function(json) {
	    		console.log("error");
	    		alert(json['msg']);
	    	})
	    	.always(function() {
	    		console.log("complete");
	    		remove_loader();
       			ocultar_loader();
	    	});
	    	
	    }
	    // Let's test it out
	});
});