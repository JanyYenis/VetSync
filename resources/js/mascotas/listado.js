"use strict";

const tablaMascotas = "#tablaMascotas";
const rutaCargarListadoMascotas = route("mascotas.listado");

$(function () {
    listadoMascotas();
});

/**
 * Función que permite cargar el listado.
 */
window.listadoMascotas = () => {
    var table = $("#tablaMascotas").DataTable({
        paging: true,
        responsive: true,
        serverSide: true,
        scrollX: true,
        searchDelay: 500,

        ajax: {
            "url": rutaCargarListadoMascotas,
            "type": "GET",

            "headers": {
                "X-CSRF-TOKEN": $('meta[name="csrf-token"]').attr('content')
            },
            data: function (data) {
                generalidades.mostrarCargando(tablaMascotas);
                data = Object.assign(data);
            },
            dataSrc: function (json) {
                generalidades.ocultarCargando(tablaMascotas);
                return json.data
            },
        },
        buttons: [
            {
                extend: "excel",
                text: '<i class="fa fa-download"></i> Excel',
                className: "btn btn-success",
                title: "Listado Mascotas.",
                exportOptions: {
                    columns: [0, 1, 2, 3, 4, 5, 6, 7, 8, 9],
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
                render: function (data, type, full, meta) {
                    return meta.row + 1;
                },
                searchable: false
            },
            {
                data: 'nombre',
                name: 'nombre',
                render: function(data, type, full, meta) {
                    return full?.nombre ?? 'N/A';
                },
            },
            {
                data: 'tipo',
                name: 'tipo',
            },
            {
                data: 'raza',
                name: 'raza',
            },
            {
                data: 'edad',
                name: 'edad',
            },
            {
                data: 'propietario',
                name: 'propietario',
            },
            {
                data: 'peso',
                name: 'peso',
            },
            {
                data: 'genero',
                name: 'genero',
            },
            {
                data: 'color',
                name: 'color',
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
