"use strict";

// rutas
const rutaEditar = "clientes.edit";

// id y clases
const formEditarCliente = "#formEditarCliente";
const seccionEditar = ".seccionEditar";
const modalEditar = "#modalEditarCliente";

$(function () {
    generalidades.validarFormulario(formEditarCliente, enviarDatos);
});

const iniciarComponentes = (form = '') => {
    $(`${form} #selectTipoIdentificacion`).select2({
        minimumResultsForSearch: -1
    });

    generalidades.initTelefonoInput(`${form} #telefonoEditar`);
}

$(document).on("click", ".btnEditar", function () {
    let id = $(this).attr("data-id");
    if (id) {
        // id = JSON.parse(id);
        cargarDatos(id);
    }
});

const cargarDatos = (id) => {
    const ruta = route(rutaEditar, { "cliente": id });
    generalidades.mostrarCargando('body');
    generalidades.refrescarSeccion(null, ruta, seccionEditar, function(){
        $(modalEditar).modal('show');
        iniciarComponentes(formEditarCliente);
    });
}

const enviarDatos = (form) => {
    let formData = new FormData(document.getElementById("formEditarCliente"));
    let inputTelefono = generalidades.darTelefonoInput(`${formEditarCliente} #telefonoEditar`);
	let tel = inputTelefono?.getNumber(intlTelInputUtils.numberFormat.NATIONAL);
    tel = tel.replace(/\((\w+)\)/g, "$1");
    tel = tel.replace(/-/g, "");
    tel = tel.replace(/\s/g, "");
	let codigo = inputTelefono?.getSelectedCountryData()?.dialCode ?? '';
    formData.set('telefono', codigo+tel);
    formData.set('codigo_telefono', codigo);
    formData.append('estado', $(`${formEditarCliente} #checkEstado`).is(':checked') ? 1 : 2);

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
            generalidades.ocultarValidaciones(formEditarCliente);
            window.listadoClientes();
        }
        generalidades.ocultarCargando(formEditarCliente);
        generalidades.toastrGenerico(response?.estado, response?.mensaje);
    }

    const error = (response) => {
        generalidades.ocultarCargando(formEditarCliente);
        generalidades.toastrGenerico(response?.estado, response?.mensaje);
        generalidades.mostrarValidaciones(formEditarCliente, response.validaciones);
    }
    const rutaActualizar = route("clientes.update", { "cliente": formData.get("id") });
    generalidades.edit(rutaActualizar, config, success, error);
    generalidades.mostrarCargando(formEditarCliente);
}
