$(document).ready(function () {
//    $(".rubro").click(function () {
//        controla_tabs_visibles(this);
//    });
    $(".evalua").change(function () {
        control_opciones(this);
    });
    $(".evaluacion_revisor").change(function () {
        valida_entrada_evaluacion(this);
    });
    $(".radios_opcion").each(function () {//Valida que este seleccionado
        if ($(this).is(':checked')) {
            opciones_secciones(this);
        }
    });
    $(".seccion_tab_data").each(function () {//Valida que este seleccionado
        select_tabs_data(this);
    });
    control_opciones();
});

function select_tabs_data(element) {
    var seccion = $(element).data("identificadorseccion");
    var tabs = document.getElementById("tabseccioncontrol_one").value;
    if (seccion == tabs) {
        $(element).addClass("active");
        $('#tab_' + seccion).addClass("in active");
    } else {
        $(element).removeClass("active");
        $('#tab_' + seccion).removeClass("in active");
    }

}

function actualiza_tabs(element) {
    var seccion = $(element).data("identificadorseccion");
    $("#tabseccioncontrol_one").val(seccion);
}

function controla_tabs_visibles(element) {
    var componente = $(element);
    var seccion = componente.data("identificadorseccion");
//    var seccion_contenido = $("#rubro" + seccion);
    var down1 = (document.getElementById("rubro" + seccion).style.display == "none") ? false : true;
    if (!down1) {
        $("#tabseccioncontrol_" + seccion).val(1);
        $("#rubro" + seccion).show(1000, function () {//muestra
            //$( this ).remove();
        });
    } else {
        $("#tabseccioncontrol_" + seccion).val(0);
        $("#rubro" + seccion).hide(1000, function () {//Oculta
            //$( this ).remove();
        });
    }

}

function valida_entrada_evaluacion(element) {
    console.log("Hola---");
    var propiedades = $(element);
    var seccion = propiedades.data('identificadorseccion');
    var eval = $("#evaluacion_opciones" + seccion);
    var val = eval.val();
    var max = eval.attr("max");
    var min = eval.attr("min");
    if (!validarSiNumero(val)) {
        val = parseInt(val);
        if (val > max || val < min) {
            eval.val("");//Limpia
        }
    } else {
        eval.val("");//Limpia
    }
}
function opciones_secciones(element) {

    var propiedades = $(element);
    var seccion = propiedades.data('identificadorseccion');
    var opcion = propiedades.val();
    var eval = $("#evaluacion_opciones" + seccion);
    $("#seleccion_opcion_evaluacion_" + seccion).val(opcion);
    var max = propiedades.data("max");
    var min = propiedades.data("min");
    eval.attr("max", max);
    eval.attr("min", min);

    $("#rango_help" + seccion).html("El rango de evaluación es: " + min + " - " + max);
}

function control_opciones(elementos) {
    console.log("Holalll,kakj");
    if ($('input[name=educativo]:checked, input[name=conflicto]:checked').length == 2) {
        $("#seccionesEva").show(1000, function () {
        });
    } else {
        $("#seccionesEva").hide(1000, function () {
        });
    }
}

