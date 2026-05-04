"use strict";

const clienteForm = '#clienteForm';
const clienteModal = '#clienteModal';

$(function () {
    iniciarComponentes();
    generalidades.validarFormulario(clienteForm, enviarDatos);
});

const iniciarComponentes = (form = "") => {
    generalidades.initTelefonoInput(`${form} #clienteTelefono`);
}

const enviarDatos = (form) => {
    let formData = new FormData(document.getElementById("clienteForm"));
    let inputTelefono = generalidades.darTelefonoInput(`${clienteForm} #clienteTelefono`);
	let tel = inputTelefono?.getNumber(intlTelInputUtils.numberFormat.NATIONAL);
    tel = tel.replace(/\((\w+)\)/g, "$1");
    tel = tel.replace(/-/g, "");
    tel = tel.replace(/\s/g, "");
	let codigo = inputTelefono?.getSelectedCountryData()?.dialCode ?? '';
    formData.set('telefono', codigo+tel);
    formData.set('codigo_telefono', codigo);

    const config = {
        'method': 'POST',
        'headers': {
            'Accept': generalidades.CONTENT_TYPE_JSON,
        },
        'body': formData
    }

    const success = (response) => {
        if (response.estado == 'success') {
            generalidades.ocultarValidaciones(clienteForm);-
            generalidades.resetValidate(clienteForm);
            $('.btn-close').trigger('click');
            window.listadoClientes();
        }
        generalidades.ocultarCargando(clienteForm);
        generalidades.toastrGenerico(response?.estado, response?.mensaje);
    }

    const error = (response) => {
        generalidades.ocultarCargando(clienteForm);
        generalidades.toastrGenerico(response?.estado, response?.mensaje);
        generalidades.mostrarValidaciones(clienteForm, response.validaciones);
    }
    const ruta = route("clientes.store");
    generalidades.create(ruta, config, success, error);
    generalidades.mostrarCargando(clienteForm);
}

