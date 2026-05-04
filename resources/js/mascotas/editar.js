"use strict";

// rutas
const rutaEditar = "mascotas.edit";

// id y clases
const formEditarMascota = "#formEditarMascota";
const seccionEditar = ".seccionEditar";
const modalEditar = "#modalEditarMascota";

$(function () {
    generalidades.validarFormulario(formEditarMascota, enviarDatos);
});

const iniciarComponentes = (form = '') => {
    $("#formEditarMascota #selectPropietarioEditar").select2({
        allowClear: true,
        placeholder: 'Seleccione el propietario',
        dropdownParent: $('#formEditarMascota'),
        ajax: {
            url: route('clientes.buscar'),   // ruta de tu backend Laravel
            dataType: 'json',
            delay: 250,
            data: function (params) {
                return {
                    busqueda: params.term // término de búsqueda
                };
            },
            processResults: function (data) {
                // Aquí conviertes la respuesta en el formato que Select2 entiende
                return {
                    results: data.map(function (item) {
                        return {
                            id: item.id,
                            text: item.text
                        };
                    })
                };
            },
            cache: true
        }
    });

    $(`${form} #selectGeneroMascotaEditar`).select2({
        minimumResultsForSearch: -1
    });

    $(`${form} #selectTipoEdit`).select2({
        minimumResultsForSearch: -1
    });
}

$(document).on("click", ".btnEditar", function () {
    let id = $(this).attr("data-id");
    if (id) {
        // id = JSON.parse(id);
        cargarDatos(id);
    }
});

const cargarDatos = (id) => {
    const ruta = route(rutaEditar, { "mascota": id });
    generalidades.mostrarCargando('body');
    generalidades.refrescarSeccion(null, ruta, seccionEditar, function(){
        $(modalEditar).modal('show');
        iniciarComponentes(formEditarMascota);
        let select = $('#selectPropietarioEditar');

        let id = select.data('id');
        let text = select.data('text');

        let option = new Option(text, id, true, true);
        select.append(option).trigger('change');
    });
}

const enviarDatos = (form) => {
    let formData = new FormData(document.getElementById("formEditarMascota"));
    formData.append('estado', $(`${formEditarMascota} #checkEstado`).is(':checked') ? 1 : 2);

    const config = {
        'method': 'PUT',
        'headers': {
            'Accept': generalidades.CONTENT_TYPE_JSON,
        },
        'body': formData
    }

    const success = (response) => {
        if (response.estado == 'success') {
            $(modalEditar).modal('hide');
            generalidades.ocultarValidaciones(formEditarMascota);
            window.listadoMascotas();
        }
        generalidades.ocultarCargando(formEditarMascota);
        generalidades.toastrGenerico(response?.estado, response?.mensaje);
    }

    const error = (response) => {
        generalidades.ocultarCargando(formEditarMascota);
        generalidades.toastrGenerico(response?.estado, response?.mensaje);
        generalidades.mostrarValidaciones(formEditarMascota, response.validaciones);
    }
    const rutaActualizar = route("mascotas.update", { "mascota": formData.get("id") });
    generalidades.edit(rutaActualizar, config, success, error);
    generalidades.mostrarCargando(formEditarMascota);
}
