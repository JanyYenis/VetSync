"use strict";

// rutas
const rutaEditar = "historiales.edit";

// id y clases
const formHistorial = "#formHistorial";

$(function () {
    //
});

const iniciarComponentes = (form = '') => {
    //
}

$(document).on("click", ".btnEditar", function () {
    let id = $(this).attr("data-id");
    if (id) {
        // id = JSON.parse(id);
        $('#modalListaHistorias').modal('hide');
        $('#formHistorial').attr('data-modo', 2);
        cargarDatos(id);
    }
});

const cargarDatos = (id) => {
    const config = {
        'method': 'GET',
        'headers': {
            'Accept': generalidades.CONTENT_TYPE_JSON,
        },
    }

    const success = (response) => {
        if (response.estado == 'success') {
            iniciarComponentes(formHistorial);
            console.log(response.historial);
            let mascota = response.historial?.mascota ?? [];
            let propietario = response.historial?.propietario ?? [];


            let select = $('#selectMascota');

            select.empty(); // opcional pero recomendado

            let option = new Option((mascota.nombre + ` (${mascota?.info_tipo?.nombre}) - ` + propietario.nombre), mascota.id, true, true);
            select.append(option).trigger('change');
            $('#idHistorial').val(response?.historial?.id ?? '');
            $('#nombreMascota').val(mascota?.nombre ?? 'N/A');
            $('#tipoMascota').val(mascota?.tipo ?? 1).trigger('change');
            $('#razaMascota').val(mascota?.raza ?? 'N/A');
            $('#edadMascota').val(response.historial?.edad ?? 0);
            $('#sexoMascota').val(mascota?.genero ?? 'N/A').trigger('change');
            $('#colorMascota').val(mascota?.color ?? 'N/A');
            $('#pesoMascota').val(response.historial?.peso ?? 0);
            $('#codigoPropietario').val(propietario?.id ?? 'N/A');
            $('#nombrePropietario').val(propietario?.nombre ?? 'N/A');
            $('#telefonoPropietario').val(propietario?.telefono ?? '');
            $('#emailPropietario').val(propietario?.email ?? '');
            $('#direccionPropietario').val(propietario?.direccion ?? '');
            $('#vacunaRabia').val(response?.historial?.rabia ? response?.historial?.rabia.split('/').reverse().join('-') : '');
            $('#vacunaParvovirus').val(response?.historial?.parvovirus ? response?.historial?.parvovirus.split('/').reverse().join('-') : '');
            $('#vacunaMoquillo').val(response?.historial?.moquillo ? response?.historial?.moquillo.split('/').reverse().join('-') : '');
            $('#desparasitacionInterna').val(response?.historial?.desparasitacion_interna ? response?.historial?.desparasitacion_interna.split('/').reverse().join('-') : '');
            $('#desparasitacionExterna').val(response?.historial?.desparasitacion_externa ? response?.historial?.desparasitacion_externa.split('/').reverse().join('-') : '');
            $('#alergias').val(response?.historial?.alergias ?? '');
            $('#enfermedadesCronicas').val(response?.historial?.enfermedades_cronicas ?? '');
            $('#observacionesGenerales').val(response?.historial?.observacion_general ?? '');

            $('#firmaGuardada').attr('src', response?.historial?.firma).removeClass('d-none');
            $('#canvasFirma').addClass('d-none');

            let consultas = response?.historial?.consultas_activas ?? [];
            consultas.forEach((consulta, index) => {
                let datos = {
                    fecha: consulta?.fecha ? consulta?.fecha.split('/').reverse().join('-') : '',
                    motivo: consulta?.motivo ?? '',
                    diagnostico: consulta?.diagnostico ?? '',
                    tratamiento: consulta?.tratamiento ?? '',
                    veterinario: window.nombre,
                };
                window.historialClinico.push(datos);
            });
            window.actualizarTablaHistorial();
            $('#btnExportarPDF').removeClass('d-none');
        }
        generalidades.ocultarCargando('body');
        generalidades.toastrGenerico(response?.estado, response?.mensaje);
    }

    const error = (response) => {
        generalidades.ocultarCargando('body');
        generalidades.toastrGenerico(response?.estado, response?.mensaje);
    }

    generalidades.get(route(rutaEditar, { "historial": id }), config, success, error);
    generalidades.mostrarCargando('body');
}

window.enviarDatosEditar = (form) => {
    let formData = new FormData(document.getElementById("formHistorial"));
    formData.append('firma', document.getElementById('canvasFirma').toDataURL('image/png'));
    formData.append('historialClinico', JSON.stringify(window.historialClinico));

    const config = {
        'method': 'PUT',
        'headers': {
            'Accept': generalidades.CONTENT_TYPE_JSON,
        },
        'body': formData
    }

    const success = (response) => {
        if (response.estado == 'success') {
            generalidades.ocultarValidaciones(formHistorial);
            generalidades.resetValidate(formHistorial);
            $('select').val('').trigger('change');
            // Limpiar firma
            window.limpiarCanvas();
            $('#firmaGuardada').addClass('d-none');
            $('#canvasFirma').removeClass('d-none');
            $('#nombreVeterinario').val(window.nombre);
            $('#matriculaVeterinario').val(window.licencia);
            window.historialClinico = [];
            window.actualizarTablaHistorial();
            $('formHistorial').attr('data-modo', 1);
            $('#btnExportarPDF').addClass('d-none');
        }
        generalidades.ocultarCargando(formHistorial);
        generalidades.toastrGenerico(response?.estado, response?.mensaje);
    }

    const error = (response) => {
        generalidades.ocultarCargando(formHistorial);
        generalidades.toastrGenerico(response?.estado, response?.mensaje);
        generalidades.mostrarValidaciones(formHistorial, response.validaciones);
    }
    const rutaActualizar = route("historiales.update", { "historial": formData.get("id") });
    generalidades.edit(rutaActualizar, config, success, error);
    generalidades.mostrarCargando(formHistorial);
}

