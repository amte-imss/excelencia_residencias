var data_grafica;

function  obtener_rango_calidad(classe) {
    console.log('highcharts-container---------------->');
    console.log(classe);
    $('.' + classe).each(function () {
        console.log(this.name);
        console.log(this);
    });
    return 'bien';
}

function  obtener_rango_calidad(promedio) {
    var valor = '';
    if (promedio >= 0 && promedio <= 4) {
        valor = "Muy malo"
    } else if (promedio >= 5 && promedio <= 8) {
        valor = "Malo"
    } else if (promedio >= 9 && promedio <= 12) {
        valor = "Regular"
    } else if (promedio >= 13 && promedio <= 16) {
        valor = "Bueno"
    } else if (promedio >= 17 && promedio <= 20) {
        valor = "Muy Bueno"
    }
    return valor;
}

function textos_lenguaje() {
//    console.log("EL lenguaje actual del sistema es -> " + lang_system_);
//    console.log(lang_system_);
    if (lang_system_ != 'en') {
        lang_system = {
            contextButtonTitle: "Menú contextual",
            downloadJPEG: language_text.reportes.descarga_jpeg,
            downloadPDF: language_text.reportes.descarga_pdf,
            downloadPNG: language_text.reportes.descarga_png,
            downloadSVG: language_text.reportes.descarga_svg,
            drillUpText: "Regresar a {series.name}",
            loading: "Cargando...",
            noData: "No hay datos que mostrar",
            resetZoom: "Restablecer zoom",
            printChart: language_text.reportes.print_grafica_lbl,
            resetZoomTitle: "Restablecer zoom nivel 1:1",
            months: ["Enero", "Febrero", "Marzo", "Abril", "Mayo", "Junio", "Julio", "Agosto", "Septiembre", "Octubre", "Noviembre", "Diciembre"],
            shortMonths: ["Ene", "Feb", "Mar", "Abr", "May", "Jun", "Jul", "Ago", "Sep", "Oct", "Nov", "Dic"],
            weekdays: ["Domingo", "Lunes", "Martes", "Miércoles", "Jueves", "Viernes", "Sábado"]
        }
    } else {
        var lang_system = Highcharts.getOptions().lang;
    }
    return lang_system;
}

/* Automate testing of module somewhat Descarga local*/

//var nav = Highcharts.win.navigator,
//        isMSBrowser = /Edge\/|Trident\/|MSIE /.test(nav.userAgent),
//        isEdgeBrowser = /Edge\/\d+/.test(nav.userAgent),
//        containerEl = document.getElementById('progressBar'),
//        parentEl = containerEl.parentNode,
//        oldDownloadURL = Highcharts.downloadURL;
//
//function addText(text) {
//    var heading = document.createElement('h2');
//    heading.innerHTML = text;
//    parentEl.appendChild(heading);
//}
//
//function addURLView(title, url) {
//    var iframe = document.createElement('iframe');
//    if (isMSBrowser && Highcharts.isObject(url)) {
//        addText(title +
//                ': Microsoft browsers do not support Blob iframe.src, test manually'
//                );
//        return;
//    }
//    iframe.src = url;
//    iframe.width = 400;
//    iframe.height = 300;
//    iframe.title = title;
//    iframe.style.display = 'inline-block';
//    parentEl.appendChild(iframe);
//}
//
//function fallbackHandler(options) {
//    if (options.type !== 'image/svg+xml' && isEdgeBrowser ||
//            options.type === 'application/pdf' && isMSBrowser) {
//        addText(options.type + ' fell back on purpose');
//    } else {
//        throw 'Should not have to fall back for this combination. ' +
//                options.type;
//    }
//}
//
//Highcharts.downloadURL = function (dataURL, filename) {
//    // Emulate toBlob behavior for long URLs
//    if (dataURL.length > 2000000) {
//        dataURL = Highcharts.dataURLtoBlob(dataURL);
//        if (!dataURL) {
//            throw 'Data URL length limit reached';
//        }
//    }
//    // Show result in an iframe instead of downloading
//    addURLView(filename, dataURL);
//};
//
//Highcharts.Chart.prototype.exportTest = function (type) {
//    this.exportChartLocal({
//        type: type
//    }, {
//        title: {
//            text: type
//        },
//        subtitle: {
//            text: false
//        }
//    });
//};
//
//Highcharts.Chart.prototype.callbacks.push(function (chart) {
//    if (!chart.options.chart.forExport) {
//        var menu = chart.exportSVGElements && chart.exportSVGElements[0],
//                oldHandler;
////        chart.exportTest('image/png');
////        chart.exportTest('image/jpeg');
////        chart.exportTest('image/svg+xml');
////        chart.exportTest('application/pdf');
//
//        // Allow manual testing by resetting downloadURL handler when trying
//        // to export manually
//        if (menu) {
//            oldHandler = menu.element.onclick;
//            menu.element.onclick = function () {
//                Highcharts.downloadURL = oldDownloadURL;
//                oldHandler.call(this);
//            };
//        }
//    }
//});