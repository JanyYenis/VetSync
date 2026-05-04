"use strict";

const tablaClientes = "#tablaClientes";
const rutaCargarListadoClientes = route("clientes.listado");

$(function () {
    listadoClientes();
});

/**
 * Función que permite cargar el listado.
 */
window.listadoClientes = () => {
    var table = $("#tablaClientes").DataTable({
        paging: true,
        responsive: true,
        serverSide: true,
        scrollX: true,
        searchDelay: 500,

        ajax: {
            "url": rutaCargarListadoClientes,
            "type": "GET",

            "headers": {
                "X-CSRF-TOKEN": $('meta[name="csrf-token"]').attr('content')
            },
            data: function (data) {
                generalidades.mostrarCargando(tablaClientes);
                data = Object.assign(data);
            },
            dataSrc: function (json) {
                generalidades.ocultarCargando(tablaClientes);
                return json.data
            },
        },
        buttons: [
            {
                extend: "excel",
                text: '<i class="fa fa-download"></i> Excel',
                className: "btn btn-success",
                title: "Listado Clientes.",
                exportOptions: {
                    columns: [0, 1, 2, 3, 4, 5, 6],
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
                data: 'telefono',
                name: 'telefono',
                render: function(data, type, full, meta) {
                    return full?.telefono ?? 'N/A';
                },
            },
            {
                data: 'email',
                name: 'email',
                render: function(data, type, full, meta) {
                    return full?.email ?? 'N/A';
                },
            },
            {
                data: 'mascotas',
                name: 'mascotas',
                searchable: false
            },
            {
                data: 'estado',
                name: 'estado',
            },
            {
                data: 'direccion',
                name: 'direccion',
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
