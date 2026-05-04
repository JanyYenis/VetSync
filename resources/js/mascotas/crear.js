"use strict";

const mascotaForm = '#mascotaForm';
const mascotaModal = '#mascotaModal';

$(function () {
    iniciarComponentes();
    generalidades.validarFormulario(mascotaForm, enviarDatos);
});

const iniciarComponentes = (form = "") => {
    //
}

$(document).on('shown.bs.modal', mascotaModal, function () {
    $("#mascotaForm #mascotaCliente").select2({
        allowClear: true,
        placeholder: 'Seleccione el propietario',
        dropdownParent: $('#mascotaForm'),
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
});

const enviarDatos = (form) => {
    let formData = new FormData(document.getElementById("mascotaForm"));

    const config = {
        'method': 'POST',
        'headers': {
            'Accept': generalidades.CONTENT_TYPE_JSON,
        },
        'body': formData
    }

    const success = (response) => {
        if (response.estado == 'success') {
            generalidades.ocultarValidaciones(mascotaForm);-
            generalidades.resetValidate(mascotaForm);
            $('.btn-close').trigger('click');
            window.listadoMascotas();
        }
        generalidades.ocultarCargando(mascotaForm);
        generalidades.toastrGenerico(response?.estado, response?.mensaje);
    }

    const error = (response) => {
        generalidades.ocultarCargando(mascotaForm);
        generalidades.toastrGenerico(response?.estado, response?.mensaje);
        generalidades.mostrarValidaciones(mascotaForm, response.validaciones);
    }
    const ruta = route("mascotas.store");
    generalidades.create(ruta, config, success, error);
    generalidades.mostrarCargando(mascotaForm);
}
