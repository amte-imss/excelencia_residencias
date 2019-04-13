$(document).ready(function () {
// Add button Delete in row
    registros();
});
function registros() {
    var name_fields = obtener_cabeceras();
    grid = $('#jsDashboardInvestigadores').jsGrid({
        height: "1000px",
        width: "100%",
//        deleteConfirm: "¿Deseas eliminar este registro?",
        filtering: true,
        inserting: false,
        editing: false,
        sorting: false,
        selecting: false,
        paging: true,
        autoload: true,
        pageSize: 10,
        rowClick: function (args) {
            //console.log(args);
        },
        pageButtonCount: 5,
        pagerFormat: "Páginas: {pageIndex} de {pageCount}    {first} {prev} {pages} {next} {last}   Total: {itemCount}",
        pagePrevText: language_text.jsgrid_elementos.anterior_pag_js,
        pageNextText: language_text.jsgrid_elementos.siguiente_pag_js,
        pageFirstText: language_text.jsgrid_elementos.primero_pag_js,
        pageLastText: language_text.jsgrid_elementos.ultimo_pag_js,
        pageNavigatorNextText: "...",
        pageNavigatorPrevText: "...",
        noDataContent: language_text.jsgrid_elementos.datos_no_encontrados_js,
        invalidMessage: "",
        loadMessage: language_text.jsgrid_elementos.esperar_js,
        onItemUpdating: function (args) {
        },
        onItemEditing: function (args) {
        },
        cancelEdit: function () {
        },
        controller: {
            loadData: function (filter) {
                //console.log(filter);
                var d = $.Deferred();
                //var result = null;

                $.ajax({
                    type: "GET",
                    url: site_url + "/inicio/informacion",
                    dataType: "json"
                })
                        .done(function (result) {
                          console.log(result);
                            var estado_tmp;
                            var nombre_metodologia_tmp;
                            var contadores = {total_delegacion: 0, total_umae: 0, total_externos: 0, total_internos: 0};
                            var res = $.grep(result.data, function (registro) {
                              /*  try {
                                    estado_tmp = JSON.parse(registro.estado);
                                    registro.estado = estado_tmp[lang_tmp];
                                } catch (e) {
                                }
                                try {
                                    nombre_metodologia_tmp = JSON.parse(registro.nombre_metodologia);
                                    registro.nombre_metodologia = nombre_metodologia_tmp[lang_tmp];
                                } catch (e) {
                                }
                                try {//Contadores
                                    if (registro.es_imss == true) {
                                        contadores.total_internos = contadores.total_internos + 1;//Cuenta internos
                                        registro.es_imss = language_text.dashboard.es_imss_si;
                                        //console.log(registro.nivel_atencion);
                                        switch (registro.nivel_atencion.toString()) {
                                            case "1":
                                                contadores.total_delegacion = contadores.total_delegacion + 1;//Cuenta nivel 1 y 2 como delegación
                                                break;
                                            case "2":
                                                contadores.total_delegacion = contadores.total_delegacion + 1;//Cuenta nivel 1 y 2 como delegación
                                                break;
                                            case "3":
                                                contadores.total_umae = contadores.total_umae + 1;//Cuenta nivel 3 como umae
                                                break;
                                        }
                                    } else {
                                        contadores.total_externos = contadores.total_externos + 1;//Cuenta externos
                                        registro.es_imss = language_text.dashboard.es_imss_no;
                                    }
                                } catch (e) {
                                }*/

                              /*  console.log(filter);

                                return (!filter.folio || (registro.folio !== null && registro.folio.toLowerCase().indexOf(filter.folio.toString().toLowerCase()) > -1))
                                        && (!filter.titulo || (registro.titulo !== null && registro.titulo.toLowerCase().indexOf(filter.titulo.toString().toLowerCase()) > -1))
                                        && (!filter.nombre_metodologia || (registro.nombre_metodologia !== null && registro.nombre_metodologia.toLowerCase().indexOf(filter.nombre_metodologia.toString().toLowerCase()) > -1))
                                        && (!filter.fecha_registro || (registro.fecha_registro !== null && registro.fecha_registro.toLowerCase().indexOf(filter.fecha_registro.toString().toLowerCase()) > -1))
                                        && (!filter.estado || (registro.estado !== null && registro.estado.toString().indexOf(filter.estado.toString()) > -1))
                                        && (!filter.nombre_investigacor || (registro.nombre_investigacor !== null && registro.nombre_investigacor.toString().indexOf(filter.nombre_investigacor.toString()) > -1))
                                        && (!filter.es_imss || (registro.es_imss !== null && registro.es_imss.toString().indexOf(filter.es_imss.toString()) > -1))
                                        ;*/
                                        return true;
                            });
//                            d.resolve(result['data']);
                           // tablero_contador(contadores);
                            d.resolve(res);
//                            calcula_ancho_grid('jsReporteHechos', 'jsgrid-header-cell');
                        });
                return d.promise();
            },
            updateItem: function (item) {
            }
        },
        fields: [
            {name: "matricula", title: name_fields.matricula, type: "text", inserting: false, editing: false},
            {name: "nombre", title: name_fields.nombre, type: "text", inserting: false, editing: false},
            {name: "apellido_paterno", title: name_fields.apellido_paterno, type: "text", inserting: false, editing: false},
            {name: "apellido_materno", title: name_fields.apellido_materno, type: "text", inserting: false, editing: false},
            {name: "unidad", title: name_fields.unidad, type: "text", inserting: false, editing: false},
            {name: "umae", title: name_fields.umae, type: "text", inserting: false, editing: false},
            {name: "delegacion", title: name_fields.delegacion, type: "text", inserting: false, editing: false},
            {name: "fecha", title: name_fields.fecha, type: "text", inserting: false, editing: false},
            {type: "detalle", editButton: false, deleteButton: false, width: 40,
                searchModeButtonTooltip: language_text.jsgrid_elementos.cambio_busqueda, // tooltip of switching filtering/inserting button in inserting mode
                editButtonTooltip: language_text.jsgrid_elementos.editar, // tooltip of edit item button
                searchButtonTooltip: language_text.jsgrid_elementos.limpiar_filtros_busqueda, // tooltip of search button
                clearFilterButtonTooltip: language_text.jsgrid_elementos.actualizar_js, // tooltip of clear filter button
                updateButtonTooltip: language_text.jsgrid_elementoscancelar_js, // tooltip of update item button
                cancelEditButtonTooltip: language_text.jsgrid_elementos.buscar_js, // tooltip of cancel editing button
               /* itemTemplate: function (value, item) {
                    var result = get_detalle(item);
                    return result;
                }*/
            }
        ]
    });
}


function obtener_cabeceras() {
    var arr_header = {
        matricula:language_text.dashboard.matricula,
        nombre: language_text.dashboard.nombre,
        apellido_paterno: language_text.dashboard.apellido_paterno,
        apellido_materno: language_text.listado_trabajo.apellido_materno,
        unidad: language_text.listado_trabajo.unidad,
        delegacion: language_text.listado_trabajo.delegacion,
        fecha: language_text.listado_trabajo.fecha
    }

    return arr_header;
}

function cabeceras_no_exportar() {
    var arr_header = {
        acciones: 'Acciones',
    }
    return arr_header;
}


function exportar_investigacion(element) {
    var namegrid = $(element).data('namegrid');
    var headers = remove_headers(obtener_cabeceras(), cabeceras_no_exportar());
//    var headers = obtener_cabeceras_implementaciones();
    export_xlsx_grid(namegrid, headers, 'investigacion', 'investigacion');
}

function tablero_contador(contadores) {
    //console.log(contadores);
    $("#externos").html(contadores.total_externos);
    $("#internos").html(contadores.total_internos);
    $("#delegacion").html(contadores.total_delegacion);
    $("#umae").html(contadores.total_umae);
}

function get_detalle(item) {
    //console.log(item);
    var ruta = site_url + "/registro/solicitud/" + item.id_solicitud;
    var liga = '<a href="' + ruta + '" class="btn btn-theme animated flipInY visible pull-right" title="'+ language_text.listado_trabajo.accion_ver_detalle_inv +'">' +
            '<i class="fa fa-eye" aria-hidden="true"></i>' +
            '</a>';
    return liga;
}
