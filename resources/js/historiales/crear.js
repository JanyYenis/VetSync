"use strict";

const formHistorial = '#formHistorial';
const clienteModal = '#clienteModal';

window.historialClinico = [];
let editandoConsultaIndex = null;
let eliminandoTipo = null;
let eliminandoIndice = null;

$(function () {
    iniciarComponentes();
    generalidades.validarFormulario(formHistorial, formulario);
});

const iniciarComponentes = (form = "") => {
    $("#selectMascota").select2({
        allowClear: true,
        placeholder: 'Seleccione la mascota',
        ajax: {
            url: route('mascotas.buscar'),   // ruta de tu backend Laravel
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
                            text: item.text + ` (${item.tipo}) - ` + (item?.dueno ?? 'N/A')
                        };
                    })
                };
            },
            cache: true
        }
    });

    $(document).on('change', '#selectMascota', function() {
        const mascotaId = $(this).val();
        $('#btnCargarMascota').prop('disabled', !mascotaId);
        actualizarTablaHistorial();
    });

    $(document).on('click', '#btnCargarMascota', function() {
        cargarDatosMascota($('#selectMascota').val());
    });

    // Historial clínico (CRUD)
    $('#btnAgregarConsulta').on('click', abrirModalNuevaConsulta);
    $('#btnGuardarConsulta').on('click', guardarConsulta);
    // Confirmación de eliminación
    $('#btnConfirmarEliminar').on('click', ejecutarEliminacion);
}

/**
 * Abre el modal para agregar nueva consulta
 */
function abrirModalNuevaConsulta() {
    editandoConsultaIndex = null;
    $('#modalConsultaTitulo').html('<i class="bi bi-plus-circle me-2"></i>Agregar Consulta');
    $('#formConsulta')[0].reset();
    $('#consultaFecha').val(new Date().toISOString().split('T')[0]);
    $('#consultaVeterinario').val($('#nombreVeterinario').val());

    const modal = new bootstrap.Modal(document.getElementById('modalConsulta'));
    modal.show();
}

/**
 * Abre el modal para editar una consulta existente
 */
function editarConsulta(index) {
    editandoConsultaIndex = index;
    const consulta = historialClinico[index];

    $('#modalConsultaTitulo').html('<i class="bi bi-pencil me-2"></i>Editar Consulta');
    $('#consultaFecha').val(consulta.fecha);
    $('#consultaMotivo').val(consulta.motivo);
    $('#consultaDiagnostico').val(consulta.diagnostico);
    $('#consultaTratamiento').val(consulta.tratamiento);
    $('#consultaVeterinario').val(consulta.veterinario);

    const modal = new bootstrap.Modal(document.getElementById('modalConsulta'));
    modal.show();
}

/**
 * Guarda una consulta (nueva o editada)
 */
function guardarConsulta() {
    const fecha = $('#consultaFecha').val();
    const motivo = $('#consultaMotivo').val().trim();
    const veterinario = $('#consultaVeterinario').val().trim();

    // Validación
    if (!fecha || !motivo || !veterinario) {
        generalidades.toastrGenerico('error', 'Por favor complete los campos obligatorios (Fecha, Motivo, Veterinario).');
        return;
    }

    const consulta = {
        fecha: fecha,
        motivo: motivo,
        diagnostico: $('#consultaDiagnostico').val().trim(),
        tratamiento: $('#consultaTratamiento').val().trim(),
        veterinario: veterinario
    };

    if (editandoConsultaIndex !== null) {
        // Editar existente
        historialClinico[editandoConsultaIndex] = consulta;
        generalidades.toastrGenerico('success', 'Consulta actualizada correctamente.');
    } else {
        // Agregar nueva
        historialClinico.push(consulta);
        generalidades.toastrGenerico('success', 'Consulta agregada correctamente.');
    }

    actualizarTablaHistorial();
    bootstrap.Modal.getInstance(document.getElementById('modalConsulta')).hide();
}

/**
 * Prepara la eliminación de una consulta
 */
function prepararEliminarConsulta(index) {
    eliminandoTipo = 'consulta';
    eliminandoIndice = index;
    $('#mensajeConfirmacion').text('¿Está seguro de eliminar esta consulta del historial?');

    const modal = new bootstrap.Modal(document.getElementById('modalConfirmarEliminar'));
    modal.show();
}

/**
 * Ejecuta la eliminación confirmada
 */
function ejecutarEliminacion() {
    if (eliminandoTipo === 'consulta') {
        historialClinico.splice(eliminandoIndice, 1);
        actualizarTablaHistorial();
        generalidades.toastrGenerico('success', 'Consulta eliminada correctamente.');
    }

    bootstrap.Modal.getInstance(document.getElementById('modalConfirmarEliminar')).hide();
    eliminandoTipo = null;
    eliminandoIndice = null;
}

/**
 * Actualiza la tabla del historial clínico
 */
window.actualizarTablaHistorial = () => {
    const tbody = $('#tbodyHistorial');
    tbody.empty();

    if (historialClinico.length === 0) {
        $('#mensajeSinConsultas').show();
        return;
    }

    $('#mensajeSinConsultas').hide();

    historialClinico.forEach((consulta, index) => {
        const fechaFormateada = formatearFecha(consulta.fecha);
        const fila = `
            <tr>
                <td>${fechaFormateada}</td>
                <td>${consulta.motivo}</td>
                <td>${consulta.diagnostico || '-'}</td>
                <td>${consulta.tratamiento || '-'}</td>
                <td>${consulta.veterinario}</td>
                <td class="no-print">
                    <button type="button" class="btn btn-sm btn-outline-primary me-1 editarConsulta" data-id="${index}" title="Editar">
                        <i class="bi bi-pencil"></i>
                    </button>
                    <button type="button" class="btn btn-sm btn-outline-danger prepararEliminarConsulta" data-id="${index}" title="Eliminar">
                        <i class="bi bi-trash"></i>
                    </button>
                </td>
            </tr>
        `;
        tbody.append(fila);
    });
}

$(document).on('click', '.editarConsulta', function() {
    editarConsulta($(this).attr('data-id'));
});

$(document).on('click', '.prepararEliminarConsulta', function() {
    prepararEliminarConsulta($(this).attr('data-id'));
});

const cargarDatosMascota = (id) => {
    const config = {
        'method': 'GET',
        'headers': {
            'Accept': generalidades.CONTENT_TYPE_JSON,
        },
    }

    const success = (response) => {
        if (response.estado == 'success') {
            let mascota = response?.mascota ?? null;
            $('#nombreMascota').val(mascota?.nombre ?? 'N/A');
            $('#tipoMascota').val(mascota?.tipo ?? 1).trigger('change');
            $('#razaMascota').val(mascota?.raza ?? 'N/A');
            $('#edadMascota').val(mascota?.edad ?? 0);
            $('#sexoMascota').val(mascota?.genero ?? 'N/A').trigger('change');
            $('#colorMascota').val(mascota?.color ?? 'N/A');
            $('#pesoMascota').val(mascota?.peso ?? 0);
            $('#codigoPropietario').val(mascota?.propietario?.id ?? 'N/A');
            $('#nombrePropietario').val(mascota?.propietario?.nombre ?? 'N/A');
            $('#telefonoPropietario').val(mascota?.propietario?.telefono ?? '');
            $('#emailPropietario').val(mascota?.propietario?.email ?? '');
            $('#direccionPropietario').val(mascota?.propietario?.direccion ?? '');
        }
        generalidades.ocultarCargando('body');
        generalidades.toastrGenerico(response?.estado, response?.mensaje);
    }

    const error = (response) => {
        generalidades.ocultarCargando('body');
        generalidades.toastrGenerico(response?.estado, response?.mensaje);
    }

    generalidades.get(route('historiales.cargar.mascota', {mascota: id}), config, success, error);
    generalidades.mostrarCargando('body');
}

const formulario = () => {
    if (parseInt($(formHistorial).attr('data-modo')) === 1) {
        enviarDatos();
    } else {
        window.enviarDatosEditar();
    }
}

const enviarDatos = (form) => {
    let formData = new FormData(document.getElementById("formHistorial"));
    formData.append('firma', document.getElementById('canvasFirma').toDataURL('image/png'));
    formData.append('historialClinico', JSON.stringify(historialClinico));

    const config = {
        'method': 'POST',
        'headers': {
            'Accept': generalidades.CONTENT_TYPE_JSON,
        },
        'body': formData
    }

    const success = (response) => {
        if (response.estado == 'success') {
            generalidades.ocultarValidaciones(formHistorial);-
            generalidades.resetValidate(formHistorial);
            $('select').val('').trigger('change');
            // Limpiar firma
            limpiarCanvas();
            $('#firmaGuardada').addClass('d-none');
            $('#canvasFirma').removeClass('d-none');
            $('#nombreVeterinario').val(window.nombre);
            $('#matriculaVeterinario').val(window.licencia);
            historialClinico = [];
            actualizarTablaHistorial();
        }
        generalidades.ocultarCargando(formHistorial);
        generalidades.toastrGenerico(response?.estado, response?.mensaje);
    }

    const error = (response) => {
        generalidades.ocultarCargando(formHistorial);
        generalidades.toastrGenerico(response?.estado, response?.mensaje);
        generalidades.mostrarValidaciones(formHistorial, response.validaciones);
    }
    const ruta = route("historiales.store");
    generalidades.create(ruta, config, success, error);
    generalidades.mostrarCargando(formHistorial);
}

/**
 * Formatea una fecha ISO a formato legible
 */
function formatearFecha(fechaISO) {
    if (!fechaISO) return '-';

    const fecha = new Date(fechaISO + 'T00:00:00');
    const opciones = { day: '2-digit', month: '2-digit', year: 'numeric' };
    return fecha.toLocaleDateString('es-ES', opciones);
}

import '../firma';
