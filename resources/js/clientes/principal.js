"use strict";

$(function () {
    iniciarComponentes();
});

const iniciarComponentes = (form = "") => {
    //
}

$(document).on('click', '.btnEliminar', function(){
    let id = $(this).attr('data-id');
    Swal.fire({
        icon: "info",
        text: '¿Está seguro de que deseas eliminar el cliente?',
        showCancelButton: true,
        buttonsStyling: false,
        confirmButtonText: "Si",
        cancelButtonText: "No",
        customClass: {
            confirmButton: "btn btn-primary",
            cancelButton: "btn btn-active-light"
        }
    }).then(function (result) {
        if (result.value) {
            eliminar(id);
        }
    });
});

const eliminar = (id) => {
    let ruta = route('clientes.delete', { 'cliente': id } );
    let config = {
        "headers": {
            "Accept": generalidades.CONTENT_TYPE_JSON,
            "Content-Type": generalidades.CONTENT_TYPE_JSON
        },
        "method": "DELETE",
        "body": {
            'cliente': id
        }
    }

    const success = (response) => {
        if (response.estado == 'success') {
            window.listadoClientes();
        }
        generalidades.ocultarCargando('body');
        generalidades.toastrGenerico(response?.estado, response?.mensaje);
    }
    const error = (response) => {
        generalidades.ocultarCargando('body');
        generalidades.toastrGenerico(response?.estado, response?.mensaje);
    }
    generalidades.delete(ruta, config, success, error);
    generalidades.mostrarCargando('body');
}

import './listado';
import './crear';
import './editar';
// import './tutorial';
