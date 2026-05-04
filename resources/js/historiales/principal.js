"use strict";

$(function () {
    iniciarComponentes();
});

const iniciarComponentes = (form = "") => {
    $('#btnImprimir').on('click', imprimirHistoria);
    $('#btnExportarPDF').on('click', exportarPDF);
}

$(document).on('click', '.btnEliminar', function () {
    let id = $(this).attr('data-id');
    Swal.fire({
        icon: "info",
        text: '¿Está seguro de que deseas eliminar la historia clinica?',
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
    let ruta = route('historiales.delete', { 'historial': id });
    let config = {
        "headers": {
            "Accept": generalidades.CONTENT_TYPE_JSON,
            "Content-Type": generalidades.CONTENT_TYPE_JSON
        },
        "method": "DELETE",
        "body": {
            'historial': id
        }
    }

    const success = (response) => {
        if (response.estado == 'success') {
            window.listadoHistorial();
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

/**
 * Imprime la historia clínica
 */
function imprimirHistoria() {
    // ocultar navbar
    $('nav.top-navbar').addClass('d-none');

    // cambiar inputs a solo lectura visual
    $('input, textarea, select').addClass('modo-print');

    window.print();
}

window.addEventListener('afterprint', function () {
    $('nav.top-navbar').removeClass('d-none');
    $('input, textarea, select').removeClass('modo-print');
});

// =====================
// EXPORTAR A PDF
// =====================

/**
 * Exporta la historia clínica a PDF usando jsPDF y html2canvas
 */
function exportarPDF() {
    let id_registro = $('#formHistorial input#idHistorial').val();

    generalidades.toastrGenerico('info', 'Generando PDF, por favor espere...');

    const documento = document.getElementById('documentoHistoria');

    // Ocultar elementos no imprimibles temporalmente
    const elementosOcultar = document.querySelectorAll('.no-print');
    elementosOcultar.forEach(el => el.style.display = 'none');

    const config = {
        'method': 'GET',
        'headers': {
            'Accept': generalidades.CONTENT_TYPE_JSON,
        },
    }

    const success = (response) => {
        if (response.estado == 'success') {
            let historiaActual = response.historial;
            if (historiaActual.firma) {
                $('#firmaGuardada').removeClass('d-none');
                $('#canvasFirma').addClass('d-none');
            }

            html2canvas(documento, {
                scale: 2,
                useCORS: true,
                logging: false,
                backgroundColor: '#ffffff'
            }).then(canvas => {
                const { jsPDF } = window.jspdf;
                const pdf = new jsPDF('p', 'mm', 'letter');

                const imgWidth = 216; // Letter width in mm
                const pageHeight = 279; // Letter height in mm
                const imgHeight = (canvas.height * imgWidth) / canvas.width;

                let heightLeft = imgHeight;
                let position = 0;

                const imgData = canvas.toDataURL('image/png');

                // Primera página
                pdf.addImage(imgData, 'PNG', 0, position, imgWidth, imgHeight);
                heightLeft -= pageHeight;

                // Páginas adicionales si es necesario
                while (heightLeft > 0) {
                    position = heightLeft - imgHeight;
                    pdf.addPage();
                    pdf.addImage(imgData, 'PNG', 0, position, imgWidth, imgHeight);
                    heightLeft -= pageHeight;
                }

                // Nombre del archivo
                const nombreArchivo = `Historia_Clinica_${historiaActual.codigo || 'Nueva'}.pdf`;
                pdf.save(nombreArchivo);

                // Restaurar elementos ocultos
                elementosOcultar.forEach(el => el.style.display = '');

                generalidades.toastrGenerico('success', 'PDF exportado correctamente.');
            }).catch(error => {
                console.error('Error al generar PDF:', error);
                generalidades.toastrGenerico('error', 'Error al generar el PDF. Por favor intente nuevamente.');

                // Restaurar elementos ocultos
                elementosOcultar.forEach(el => el.style.display = '');
            });
        }
        generalidades.ocultarCargando('body');
        generalidades.toastrGenerico(response?.estado, response?.mensaje);
    }

    const error = (response) => {
        generalidades.ocultarCargando('body');
        generalidades.toastrGenerico(response?.estado, response?.mensaje);
    }

    generalidades.get(route('historiales.edit', { "historial": id_registro }), config, success, error);
    generalidades.mostrarCargando('body');
}

import './listado';
import './crear';
import './editar';
// import './tutorial';
