"use strict";

const modalListaHistorias = "#modalListaHistorias";
const tablaHistorial1 = "#tablaHistorial1";
const rutaCargarListadoHistoriales = route("historiales.listado");

$(function () {
    $('#btnListarHistorias').on('click', function() {
        $('#modalListaHistorias').modal('show');
    });
});

$(document).on('shown.bs.modal', modalListaHistorias, function () {
    listadoHistorial();
});

/**
 * Función que permite cargar el listado.
 */
window.listadoHistorial = () => {
    var table = $("#tablaHistorial1").DataTable({
        paging: true,
        responsive: true,
        serverSide: true,
        scrollX: true,
        searchDelay: 500,

        ajax: {
            "url": rutaCargarListadoHistoriales,
            "type": "GET",

            "headers": {
                "X-CSRF-TOKEN": $('meta[name="csrf-token"]').attr('content')
            },
            data: function (data) {
                generalidades.mostrarCargando(tablaHistorial1);
                data = Object.assign(data);
            },
            dataSrc: function (json) {
                generalidades.ocultarCargando(tablaHistorial1);
                return json.data
            },
        },
        buttons: [
            {
                extend: "excel",
                text: '<i class="fa fa-download"></i> Excel',
                className: "btn btn-success",
                title: "Listado Historial Clinico.",
                exportOptions: {
                    columns: [0, 1, 2, 3, 4, 5],
                    format: {
                        body: function (data, row, column, node) {

                            // eliminar HTML
                            let text = $('<div>').html(data).text();

                            return text.trim();
                        }
                    }
                }
            },
            {
                text: '<i class="fa fa-sync-alt"></i> Actualizar',
                className: "btn btn-bg-secondary",
                action: function (e, dt, node, config) {
                    dt.ajax.reload(null, false);
                }
            }
        ],
        columnDefs: [
            {
                targets: "all",
                className: "text-center"
            },
            {
                targets: "none",
                className: "text-justify"
            }
        ],
        columns: [
            {
                data: 'codigo',
                name: 'codigo',
                render: function(data, type, full, meta) {
                    return full?.codigo ?? 'N/A';
                },
            },
            {
                data: 'nombre_mascota',
                name: 'nombre_mascota',
                render: function(data, type, full, meta) {
                    return full?.nombre_mascota ?? 'N/A';
                },
            },
            {
                data: 'nombre_propietario',
                name: 'nombre_propietario',
                render: function(data, type, full, meta) {
                    return full?.nombre_propietario ?? 'N/A';
                },
            },
            {
                data: 'created_at',
                name: 'created_at',
                render: function(data, type, full, meta) {
                    return full?.created_at ?? 'N/A';
                },
            },
            {
                data: 'consultas',
                name: 'consultas',
                searchable: false
            },
            {
                data: 'estado',
                name: 'estado',
            },
            {
                data: 'action',
                name: 'action',
                orderable: false,
                searchable: false
            },
        ],
        order: [
            [1, "asc"]
        ],
        lengthMenu: [
            [15, 20, 50, 100, -1],
            [15, 20, 50, 100, "Todos"]
        ],
        pageLength: 15,
        dom: `<'row d-flex align-items-center justify-content-end'
                <'d-flex align-items-center justify-content-end'B>><'row d-flex align-items-center justify-content-between'<'col-sm-6 col-lg-6 col-md-6'l><'col-sm-6 col-lg-6 col-md-6'f>>
            <'table-responsive'tr>
            <'row'<'col-sm-12 col-md-5 d-flex align-items-center justify-content-center justify-content-md-start'i><'col-sm-12 col-md-7 d-flex align-items-center justify-content-center justify-content-md-end'p>>`,
        drawCallback: function(settings) {
            // KTMenu.createInstances();
        }
    });
}
