"use strict";

const prescriptionForm = '#prescriptionForm';

let currentStep = 1;
const totalSteps = 2;
let hasSignature = false;
let medications = [];

$(function () {
    iniciarComponentes();
    generalidades.validarFormulario(prescriptionForm, enviarDatos);
});

const iniciarComponentes = (form = "") => {
    // Establecer fecha actual
    const today = new Date().toISOString().split('T')[0];
    $('#prescriptionDate').val(today);

    // Event listeners
    bindEvents();

    $("#selectHistoriales").select2({
        allowClear: true,
        placeholder: 'Seleccione la historia clinica',
        ajax: {
            url: route('historiales.buscar'),   // ruta de tu backend Laravel
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

    inicializarSelects();
}

const inicializarSelects = () => {
    $(".med-presentation").select2({
        allowClear: true,
        placeholder: 'Seleccione la presentancion',
        minimumResultsForSearch: -1,
        ajax: {
            url: route('prescripciones.dar-presentacion'),   // ruta de tu backend Laravel
            dataType: 'json',
            delay: 250,
            processResults: function (data) {
                // Aquí conviertes la respuesta en el formato que Select2 entiende
                return {
                    results: data.map(function (item) {
                        return {
                            id: item.codigo,
                            text: item.nombre
                        };
                    })
                };
            },
            cache: true
        }
    });
    $(".med-frequency").select2({
        allowClear: true,
        placeholder: 'Seleccione la frecuencia',
        minimumResultsForSearch: -1,
        ajax: {
            url: route('prescripciones.dar-frecuencia'),   // ruta de tu backend Laravel
            dataType: 'json',
            delay: 250,
            processResults: function (data) {
                // Aquí conviertes la respuesta en el formato que Select2 entiende
                return {
                    results: data.map(function (item) {
                        return {
                            id: item.codigo,
                            text: item.nombre
                        };
                    })
                };
            },
            cache: true
        }
    });
}

const enviarDatos = (form) => {
    let formData = new FormData(document.getElementById("prescriptionForm"));
    formData.append('firma', document.getElementById('canvasFirma').toDataURL('image/png'));
    formData.append('medications', JSON.stringify(medications));

    const config = {
        'method': 'POST',
        'headers': {
            'Accept': generalidades.CONTENT_TYPE_JSON,
        },
        'body': formData
    }

    const success = (response) => {
        if (response.estado == 'success') {
            generalidades.ocultarValidaciones(prescriptionForm); -
            // generalidades.resetValidate(prescriptionForm);
            // $('select').val('').trigger('change');
            // // Limpiar firma
            // limpiarCanvas();
            // $('#firmaGuardada').addClass('d-none');
            // $('#canvasFirma').removeClass('d-none');
            generatePrescription(response.prescripcion, response.nuevos_medicamentos);
        }
        generalidades.ocultarCargando(prescriptionForm);
        generalidades.toastrGenerico(response?.estado, response?.mensaje);
    }

    const error = (response) => {
        generalidades.ocultarCargando(prescriptionForm);
        generalidades.toastrGenerico(response?.estado, response?.mensaje);
        generalidades.mostrarValidaciones(prescriptionForm, response.validaciones);
    }
    const ruta = route("prescripciones.store");
    generalidades.create(ruta, config, success, error);
    generalidades.mostrarCargando(prescriptionForm);
}

// ========================================
// Funciones de Utilidad
// ========================================
function generateDocumentId() {
    const timestamp = Date.now().toString(36).toUpperCase();
    const random = Math.random().toString(36).substring(2, 6).toUpperCase();
    return `RX-${timestamp}-${random}`;
}

function formatDate(dateString) {
    const date = new Date(dateString);
    const options = { day: '2-digit', month: 'long', year: 'numeric' };
    return date.toLocaleDateString('es-ES', options);
}

function addDays(dateString, days) {
    const date = new Date(dateString);
    date.setDate(date.getDate() + parseInt(days));
    return date.toISOString().split('T')[0];
}

// ========================================
// Navegacion de Pasos
// ========================================
function bindEvents() {
    // Botones de navegacion
    $('#btnNextStep').on('click', nextStep);
    $('#btnPrevStep').on('click', prevStep);

    // Formulario
    $('#prescriptionForm').on('submit', handleSubmit);

    // Medicamentos
    $('#btnAddMedication, #btnAddMedicationEmpty').on('click', addMedication);
    $(document).on('click', '.btn-remove-medication', removeMedication);

    // Quick instructions
    $('.quick-instruction').on('click', function () {
        const text = $(this).data('text');
        const current = $('#generalInstructions').val();
        const newText = current ? current + '\n' + text : text;
        $('#generalInstructions').val(newText);
    });

    // Acciones de preview
    $('#btnPrint, #modalBtnPrint').on('click', printPrescription);
    $('#btnDownloadPDF, #modalBtnPDF').on('click', downloadPDF);

    // Nueva prescripcion
    $('#btnNewPrescription').on('click', resetForm);

    // Sidebar toggle
    $('#sidebarToggle, #sidebarClose').on('click', function () {
        $('#sidebar').toggleClass('active');
    });

    // Update preview en tiempo real
    $('input, select, textarea').on('change input', updatePreviewRealtime);
}

function nextStep() {
    if (!validateStep(currentStep)) {
        return;
    }

    collectStepData(currentStep);

    if (currentStep < totalSteps) {
        currentStep++;
        showStep(currentStep);
        updateStepIndicator();
        updateNavButtons();
    }
}

function prevStep() {
    if (currentStep > 1) {
        currentStep--;
        showStep(currentStep);
        updateStepIndicator();
        updateNavButtons();
    }
}

function showStep(step) {
    $('.form-step').removeClass('active');
    $(`.form-step[data-step="${step}"]`).addClass('active');
}

function updateStepIndicator() {
    $('.step').each(function () {
        const stepNum = parseInt($(this).data('step'));
        $(this).removeClass('active completed');

        if (stepNum < currentStep) {
            $(this).addClass('completed');
        } else if (stepNum === currentStep) {
            $(this).addClass('active');
        }
    });

    // Update step lines
    $('.step-line').each(function (index) {
        if (index < currentStep - 1) {
            $(this).addClass('completed');
        } else {
            $(this).removeClass('completed');
        }
    });
}

function updateNavButtons() {
    // Show/hide prev button
    if (currentStep === 1) {
        $('#btnPrevStep').hide();
    } else {
        $('#btnPrevStep').show();
    }

    // Show/hide next/submit button
    if (currentStep === totalSteps) {
        $('#btnNextStep').hide();
        $('#btnGeneratePrescription').show();
    } else {
        $('#btnNextStep').show();
        $('#btnGeneratePrescription').hide();
    }
}

// ========================================
// Validacion
// ========================================
function validateStep(step) {
    let isValid = true;
    const stepElement = $(`.form-step[data-step="${step}"]`);

    // Remove previous validation states
    stepElement.find('.is-invalid').removeClass('is-invalid');
    stepElement.find('.invalid-feedback').remove();

    // Validate required fields
    stepElement.find('[required]').each(function () {
        if (!$(this).val()) {
            isValid = false;
            $(this).addClass('is-invalid');
            $(this).after('<div class="invalid-feedback">Este campo es obligatorio</div>');
        }
    });

    // Step-specific validation
    if (step === 3) {
        // Check if at least one medication exists
        if ($('#medicationsList .medication-item').length === 0) {
            isValid = false;
            showAlert('Debe agregar al menos un medicamento', 'warning');
        }
    }

    if (step === 4) {
        // Check signature
        if (!hasSignature) {
            showAlert('Debe firmar la prescripcion antes de generar', 'warning');
            isValid = false;
        }

        // Check terms
        if (!$('#acceptTerms').is(':checked')) {
            isValid = false;
            $('#acceptTerms').addClass('is-invalid');
        }
    }

    return isValid;
}

function showAlert(message, type = 'info') {
    const alertHtml = `
            <div class="alert alert-${type} alert-dismissible fade show" role="alert">
                ${message}
                <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
            </div>
        `;

    // Insert alert at top of current step
    const currentStepEl = $(`.form-step[data-step="${currentStep}"]`);
    currentStepEl.prepend(alertHtml);

    // Auto dismiss after 5 seconds
    setTimeout(() => {
        currentStepEl.find('.alert').alert('close');
    }, 5000);
}

// ========================================
// Medicamentos
// ========================================
function addMedication() {
    const index = $('#medicationsList .medication-item').length;
    const template = createMedicationTemplate(index);

    $('#emptyMedications').hide();
    $('#medicationsList').append(template);
    inicializarSelects();
}

function createMedicationTemplate(index) {
    return `
            <div class="medication-item" data-index="${index}">
                <div class="medication-header">
                    <span class="medication-number">Medicamento #${index + 1}</span>
                    <button type="button" class="btn btn-link text-danger btn-sm btn-remove-medication" title="Eliminar">
                        <i class="bi bi-trash"></i>
                    </button>
                </div>
                <div class="row g-2">
                    <div class="col-md-6">
                        <label class="form-label">Medicamento <span class="required">*</span></label>
                        <input type="text" class="form-control med-name" placeholder="Ej: Amoxicilina" required>
                    </div>
                    <div class="col-md-6">
                        <label class="form-label">Presentacion</label>
                        <select class="form-select med-presentation">
                        </select>
                    </div>
                    <div class="col-md-4">
                        <label class="form-label">Dosis <span class="required">*</span></label>
                        <input type="text" class="form-control med-dose" placeholder="Ej: 250mg" required>
                    </div>
                    <div class="col-md-4">
                        <label class="form-label">Frecuencia <span class="required">*</span></label>
                        <select class="form-select med-frequency" required>
                        </select>
                    </div>
                    <div class="col-md-4">
                        <label class="form-label">Duracion <span class="required">*</span></label>
                        <div class="input-group">
                            <input type="number" class="form-control med-duration" min="1" placeholder="0" required>
                            <select class="form-select med-duration-unit" style="max-width: 80px;">
                                <option value="1">días</option>
                                <option value="2">sem.</option>
                                <option value="3">mes.</option>
                            </select>
                        </div>
                    </div>
                    <div class="col-12">
                        <label class="form-label">Instrucciones Adicionales</label>
                        <input type="text" class="form-control med-instructions" placeholder="Ej: Administrar con alimento">
                    </div>
                </div>
            </div>
        `;
}

function removeMedication() {
    $(this).closest('.medication-item').remove();
    updateMedicationNumbers();

    if ($('#medicationsList .medication-item').length === 0) {
        $('#emptyMedications').show();
    }
}

function updateMedicationNumbers() {
    $('#medicationsList .medication-item').each(function (index) {
        $(this).attr('data-index', index);
        $(this).find('.medication-number').text(`Medicamento #${index + 1}`);
    });
}

// ========================================
// Preview en Tiempo Real
// ========================================
function updatePreviewRealtime() {
    // Update vet info
    $('#rxClinicName').text($('#vetClinic').val() || 'Clinica Veterinaria');
    $('#rxClinicDetails').text(`${$('#vetAddress').val()} | Tel: ${$('#vetPhone').val()}`);
    $('#rxVetName').text($('#vetName').val() || '-');
    $('#rxVetLicense').text($('#vetLicense').val() || '-');
    $('#rxVetSpecialty').text($('#vetSpecialty').val() || '-');

    // Update pet info
    $('#rxPetName').text($('#petName').val() || '-');
    $('#rxPetSpecies').text($('#petSpecies').val() || '-');
    $('#rxPetBreed').text($('#petBreed').val() || '-');
    const petAge = $('#petAge').val();
    const petAgeUnit = $('#petAgeUnit').val();
    $('#rxPetAge').text(petAge ? `${petAge} ${petAgeUnit}` : '-');
    const petWeight = $('#petWeight').val();
    $('#rxPetWeight').text(petWeight ? `${petWeight} kg` : '-');
    $('#rxPetSex').text($('#petSex').val() || '-');

    // Update owner info
    $('#rxOwnerName').text($('#ownerName').val() || '-');
    $('#rxOwnerPhone').text($('#ownerPhone').val() || '-');
    $('#rxOwnerEmail').text($('#ownerEmail').val() || '-');
    $('#rxOwnerId').text($('#ownerId').val() || '-');

    // Update diagnosis
    $('#rxDiagnosis').text($('#diagnosis').val() || '-');
    $('#rxClinicalNotes').text($('#clinicalNotes').val() || '');

    // Update signature name
    $('#rxSignatureName').text($('#vetName').val() || 'Dr. Veterinario');
    $('#rxSignatureLicense').text(`Lic. ${$('#vetLicense').val() || '-'}`);
}

// ========================================
// Generacion de Prescripcion
// ========================================
function handleSubmit(e) {
    e.preventDefault();

    if (!validateStep(currentStep)) {
        return;
    }
    enviarDatos();
}

function generatePrescription(prescripcion, medicamento) {
    // Update preview document
    updatePreviewDocument(prescripcion, medicamento);

    // Show prescription content, hide empty state
    $('#previewEmpty').hide();
    $('#prescriptionContent').show();

    // Enable action buttons
    $('#btnPrint, #btnDownloadPDF').prop('disabled', false);

    // Show success modal
    const successModal = new bootstrap.Modal(document.getElementById('successModal'));
    successModal.show();
}

function updatePreviewDocument(prescripcion, medicamento) {
    let historial = prescripcion?.historial ?? '';
    let clinica = prescripcion?.veterinario?.empresa ?? '';
    let mascota = historial?.mascota ?? '';
    let propietario = historial?.propietario ?? '';

    // Update header
    $('#rxClinicName').text(clinica?.razon_social ?? '');
    $('#rxClinicDetails').text(`${clinica?.direccion ?? ''} | Tel: ${clinica?.telefono ?? ''}`);

    // Update vet info
    $('#rxVetName').text(prescripcion?.veterinario?.nombre_completo ?? '');
    $('#rxVetLicense').text(prescripcion?.veterinario?.licencia ?? '');
    $('#rxVetSpecialty').text('');

    // Update pet info
    $('#rxPetName').text(mascota?.nombre ?? '');
    $('#rxPetSpecies').text(mascota?.info_tipo?.nombre ?? '');
    $('#rxPetBreed').text(mascota?.raza || '-');
    $('#rxPetAge').text(mascota?.edad ? `${mascota?.edad} ${'años'}` : '-');
    $('#rxPetWeight').text(mascota?.peso ? `${mascota?.peso} kg` : '-');
    $('#rxPetSex').text(mascota?.info_genero?.nombre || '-');

    // Update owner info
    $('#rxOwnerName').text(propietario?.nombre ?? '');
    $('#rxOwnerPhone').text(propietario?.telefono ?? '');
    $('#rxOwnerEmail').text(propietario?.email || '-');
    $('#rxOwnerId').text(propietario?.identificacion || '-');

    // Update diagnosis
    $('#rxDiagnosis').text(historial?.observacion_general ?? '');
    if (prescripcion?.indicaciones) {
        $('#rxClinicalNotes').text(prescripcion?.indicaciones ?? '').show();
    } else {
        $('#rxClinicalNotes').hide();
    }

    // Update medications table
    updateMedicationsTable();

    // Update instructions
    if (prescripcion.indicaciones) {
        $('#rxInstructions').text(prescripcion.indicaciones);
        $('#rxInstructionsSection').show();
    } else {
        $('#rxInstructionsSection').hide();
    }

    // Update signature
    if (prescripcion.firma) {
        $('#rxSignature').attr('src', prescripcion.firma);
    }
    $('#rxSignatureName').text(prescripcion.veterinario.nombre_completo);
    $('#rxSignatureLicense').text(`Lic. ${prescripcion.veterinario.licencia}`);

    // Update dates
    $('#rxDate').text(formatDate(prescripcion.fecha));
    const validUntil = addDays(prescripcion.fecha, prescripcion.validez);
    $('#rxValidUntil').text(formatDate(validUntil));

    // Update document ID
    $('#rxDocumentId').text(prescripcion.id);
}

function updateMedicationsTable() {
    const tbody = $('#rxMedicationsBody');
    tbody.empty();

    if (medications.length === 0) {
        tbody.html('<tr><td colspan="4" class="text-center text-muted">Sin medicamentos</td></tr>');
        return;
    }

    medications.forEach(med => {
        const row = `
                <tr>
                    <td>
                        <span class="rx-med-name">${med.name}</span>
                        <span class="rx-med-presentation">(${med.presentation})</span>
                        ${med.instructions ? `<p class="rx-med-instructions">${med.instructions}</p>` : ''}
                    </td>
                    <td>${med.dose}</td>
                    <td>${med.frequency}</td>
                    <td>${med.duration} ${med.durationUnit}</td>
                </tr>
            `;
        tbody.append(row);
    });
}

// ========================================
// Impresion y PDF
// ========================================
function printPrescription() {
    window.print();
}

function downloadPDF() {
    const { jsPDF } = window.jspdf;

    // Show loading state
    $('#btnDownloadPDF').html('<span class="spinner-border spinner-border-sm me-1"></span>Generando...');
    $('#btnDownloadPDF').prop('disabled', true);

    // Use html2canvas to capture the prescription
    html2canvas(document.getElementById('prescriptionContent'), {
        scale: 2,
        useCORS: true,
        logging: false,
        backgroundColor: '#ffffff'
    }).then(canvas => {
        const imgData = canvas.toDataURL('image/png');
        const pdf = new jsPDF('p', 'mm', 'letter');

        const pageWidth = pdf.internal.pageSize.getWidth();
        const pageHeight = pdf.internal.pageSize.getHeight();

        const imgWidth = pageWidth - 20;
        const imgHeight = (canvas.height * imgWidth) / canvas.width;

        pdf.addImage(imgData, 'PNG', 10, 10, imgWidth, imgHeight);

        // Save the PDF
        pdf.save(`prescripcion-${$('#rxDocumentId').text()}.pdf`);

        // Reset button
        $('#btnDownloadPDF').html('<i class="bi bi-file-earmark-pdf me-1"></i>PDF');
        $('#btnDownloadPDF').prop('disabled', false);
    }).catch(error => {
        console.error('Error generating PDF:', error);
        showAlert('Error al generar el PDF. Por favor intente nuevamente.', 'danger');

        // Reset button
        $('#btnDownloadPDF').html('<i class="bi bi-file-earmark-pdf me-1"></i>PDF');
        $('#btnDownloadPDF').prop('disabled', false);
    });
}

// ========================================
// Reset Form
// ========================================
function resetForm() {
    // Confirm reset
    if (!confirm('Se perdera toda la informacion de la prescripcion actual. Desea continuar?')) {
        return;
    }

    // Reset form
    $('#prescriptionForm')[0].reset();

    // Reset state
    currentStep = 1;
    hasSignature = false;
    medications = [];
    // documentId = generateDocumentId();

    // Reset UI
    showStep(1);
    updateStepIndicator();
    updateNavButtons();

    // Reset medications
    $('#medicationsList').html(createMedicationTemplate(0));
    $('#emptyMedications').hide();

    // Reset signature
    changeSignature();

    // Reset preview
    $('#previewEmpty').show();
    $('#prescriptionContent').hide();
    $('#btnPrint, #btnDownloadPDF').prop('disabled', true);

    // Reset date
    const today = new Date().toISOString().split('T')[0];
    $('#prescriptionDate').val(today);
}

// ========================================
// Recoleccion de Datos
// ========================================
function collectStepData(step) {
    switch (step) {
        case 1:
            // Collect medications
            medications = [];
            $('#medicationsList .medication-item').each(function () {
                medications.push({
                    name: $(this).find('.med-name').val(),
                    presentation: $(this).find('.med-presentation').val(),
                    dose: $(this).find('.med-dose').val(),
                    frequency: $(this).find('.med-frequency').val(),
                    duration: $(this).find('.med-duration').val(),
                    durationUnit: $(this).find('.med-duration-unit').val(),
                    instructions: $(this).find('.med-instructions').val()
                });
            });
            break;
    }
}

import '../firma';
