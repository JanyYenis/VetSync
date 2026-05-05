/**
 * ========================================
 * VetSync - Prescription Module
 * ========================================
 * Modulo de prescripcion medica veterinaria
 * con firma electronica y exportacion a PDF
 */

$(document).ready(function() {
    // ========================================
    // Estado de la Aplicacion
    // ========================================
    const prescription = {
        vet: {
            name: '',
            license: '',
            clinic: '',
            phone: '',
            address: '',
            email: '',
            specialty: ''
        },
        pet: {
            name: '',
            species: '',
            breed: '',
            age: '',
            ageUnit: '',
            weight: '',
            sex: '',
            color: ''
        },
        owner: {
            name: '',
            phone: '',
            email: '',
            id: '',
            address: ''
        },
        diagnosis: '',
        clinicalNotes: '',
        medications: [],
        instructions: '',
        date: '',
        validity: 30,
        signature: null,
        documentId: generateDocumentId()
    };

    let currentStep = 1;
    const totalSteps = 4;
    let signatureCanvas, signatureCtx;
    let isDrawing = false;
    let hasSignature = false;

    // ========================================
    // Inicializacion
    // ========================================
    init();

    function init() {
        // Establecer fecha actual
        const today = new Date().toISOString().split('T')[0];
        $('#prescriptionDate').val(today);

        // Inicializar canvas de firma
        initSignatureCanvas();

        // Event listeners
        bindEvents();

        // Cargar datos por defecto del veterinario
        loadVetDefaults();
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

    function loadVetDefaults() {
        // Simular datos guardados del veterinario
        prescription.vet = {
            name: $('#vetName').val(),
            license: $('#vetLicense').val(),
            clinic: $('#vetClinic').val(),
            phone: $('#vetPhone').val(),
            address: $('#vetAddress').val(),
            email: $('#vetEmail').val(),
            specialty: $('#vetSpecialty').val()
        };
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
        $('.quick-instruction').on('click', function() {
            const text = $(this).data('text');
            const current = $('#generalInstructions').val();
            const newText = current ? current + '\n' + text : text;
            $('#generalInstructions').val(newText);
        });

        // Firma
        $('#btnClearSignature').on('click', clearSignature);
        $('#btnSaveSignature').on('click', saveSignature);
        $('#btnChangeSignature').on('click', changeSignature);

        // Acciones de preview
        $('#btnPrint, #modalBtnPrint').on('click', printPrescription);
        $('#btnDownloadPDF, #modalBtnPDF').on('click', downloadPDF);

        // Nueva prescripcion
        $('#btnNewPrescription').on('click', resetForm);

        // Sidebar toggle
        $('#sidebarToggle, #sidebarClose').on('click', function() {
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
        $('.step').each(function() {
            const stepNum = parseInt($(this).data('step'));
            $(this).removeClass('active completed');

            if (stepNum < currentStep) {
                $(this).addClass('completed');
            } else if (stepNum === currentStep) {
                $(this).addClass('active');
            }
        });

        // Update step lines
        $('.step-line').each(function(index) {
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
        stepElement.find('[required]').each(function() {
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
    // Recoleccion de Datos
    // ========================================
    function collectStepData(step) {
        switch(step) {
            case 1:
                prescription.vet = {
                    name: $('#vetName').val(),
                    license: $('#vetLicense').val(),
                    clinic: $('#vetClinic').val(),
                    phone: $('#vetPhone').val(),
                    address: $('#vetAddress').val(),
                    email: $('#vetEmail').val(),
                    specialty: $('#vetSpecialty').val()
                };
                break;

            case 2:
                prescription.pet = {
                    name: $('#petName').val(),
                    species: $('#petSpecies').val(),
                    breed: $('#petBreed').val(),
                    age: $('#petAge').val(),
                    ageUnit: $('#petAgeUnit').val(),
                    weight: $('#petWeight').val(),
                    sex: $('#petSex').val(),
                    color: $('#petColor').val()
                };
                prescription.owner = {
                    name: $('#ownerName').val(),
                    phone: $('#ownerPhone').val(),
                    email: $('#ownerEmail').val(),
                    id: $('#ownerId').val(),
                    address: $('#ownerAddress').val()
                };
                break;

            case 3:
                prescription.diagnosis = $('#diagnosis').val();
                prescription.clinicalNotes = $('#clinicalNotes').val();
                prescription.instructions = $('#generalInstructions').val();
                prescription.date = $('#prescriptionDate').val();
                prescription.validity = $('#prescriptionValidity').val();

                // Collect medications
                prescription.medications = [];
                $('#medicationsList .medication-item').each(function() {
                    prescription.medications.push({
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

    // ========================================
    // Medicamentos
    // ========================================
    function addMedication() {
        const index = $('#medicationsList .medication-item').length;
        const template = createMedicationTemplate(index);

        $('#emptyMedications').hide();
        $('#medicationsList').append(template);
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
                        <label class="form-label">Nombre del Medicamento <span class="required">*</span></label>
                        <input type="text" class="form-control med-name" placeholder="Ej: Amoxicilina" required>
                    </div>
                    <div class="col-md-6">
                        <label class="form-label">Presentacion</label>
                        <select class="form-select med-presentation">
                            <option value="Tabletas">Tabletas</option>
                            <option value="Capsulas">Capsulas</option>
                            <option value="Jarabe">Jarabe</option>
                            <option value="Inyectable">Inyectable</option>
                            <option value="Gotas">Gotas</option>
                            <option value="Crema">Crema</option>
                            <option value="Suspension">Suspension</option>
                            <option value="Polvo">Polvo</option>
                        </select>
                    </div>
                    <div class="col-md-4">
                        <label class="form-label">Dosis <span class="required">*</span></label>
                        <input type="text" class="form-control med-dose" placeholder="Ej: 250mg" required>
                    </div>
                    <div class="col-md-4">
                        <label class="form-label">Frecuencia <span class="required">*</span></label>
                        <select class="form-select med-frequency" required>
                            <option value="">Seleccionar...</option>
                            <option value="Cada 6 horas">Cada 6 horas</option>
                            <option value="Cada 8 horas">Cada 8 horas</option>
                            <option value="Cada 12 horas">Cada 12 horas</option>
                            <option value="Cada 24 horas">Cada 24 horas</option>
                            <option value="2 veces al dia">2 veces al dia</option>
                            <option value="3 veces al dia">3 veces al dia</option>
                            <option value="Dosis unica">Dosis unica</option>
                            <option value="Segun necesidad">Segun necesidad</option>
                        </select>
                    </div>
                    <div class="col-md-4">
                        <label class="form-label">Duracion <span class="required">*</span></label>
                        <div class="input-group">
                            <input type="number" class="form-control med-duration" min="1" placeholder="0" required>
                            <select class="form-select med-duration-unit" style="max-width: 80px;">
                                <option value="dias">dias</option>
                                <option value="semanas">sem.</option>
                                <option value="meses">mes.</option>
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
        $('#medicationsList .medication-item').each(function(index) {
            $(this).attr('data-index', index);
            $(this).find('.medication-number').text(`Medicamento #${index + 1}`);
        });
    }

    // ========================================
    // Firma Electronica
    // ========================================
    function initSignatureCanvas() {
        signatureCanvas = document.getElementById('signatureCanvas');
        signatureCtx = signatureCanvas.getContext('2d');

        // Set canvas size
        resizeCanvas();
        $(window).on('resize', resizeCanvas);

        // Mouse events
        signatureCanvas.addEventListener('mousedown', startDrawing);
        signatureCanvas.addEventListener('mousemove', draw);
        signatureCanvas.addEventListener('mouseup', stopDrawing);
        signatureCanvas.addEventListener('mouseout', stopDrawing);

        // Touch events
        signatureCanvas.addEventListener('touchstart', handleTouchStart);
        signatureCanvas.addEventListener('touchmove', handleTouchMove);
        signatureCanvas.addEventListener('touchend', stopDrawing);
    }

    function resizeCanvas() {
        const wrapper = signatureCanvas.parentElement;
        signatureCanvas.width = wrapper.offsetWidth;
        signatureCanvas.height = wrapper.offsetHeight;

        // Reset context settings after resize
        signatureCtx.strokeStyle = '#1e293b';
        signatureCtx.lineWidth = 2;
        signatureCtx.lineCap = 'round';
        signatureCtx.lineJoin = 'round';
    }

    function startDrawing(e) {
        isDrawing = true;
        $('#signaturePlaceholder').addClass('hidden');

        const rect = signatureCanvas.getBoundingClientRect();
        signatureCtx.beginPath();
        signatureCtx.moveTo(e.clientX - rect.left, e.clientY - rect.top);
    }

    function draw(e) {
        if (!isDrawing) return;

        const rect = signatureCanvas.getBoundingClientRect();
        signatureCtx.lineTo(e.clientX - rect.left, e.clientY - rect.top);
        signatureCtx.stroke();
    }

    function stopDrawing() {
        isDrawing = false;
    }

    function handleTouchStart(e) {
        e.preventDefault();
        const touch = e.touches[0];
        const mouseEvent = new MouseEvent('mousedown', {
            clientX: touch.clientX,
            clientY: touch.clientY
        });
        signatureCanvas.dispatchEvent(mouseEvent);
    }

    function handleTouchMove(e) {
        e.preventDefault();
        const touch = e.touches[0];
        const mouseEvent = new MouseEvent('mousemove', {
            clientX: touch.clientX,
            clientY: touch.clientY
        });
        signatureCanvas.dispatchEvent(mouseEvent);
    }

    function clearSignature() {
        signatureCtx.clearRect(0, 0, signatureCanvas.width, signatureCanvas.height);
        $('#signaturePlaceholder').removeClass('hidden');
        hasSignature = false;
    }

    function saveSignature() {
        // Check if canvas has any drawing
        const imageData = signatureCtx.getImageData(0, 0, signatureCanvas.width, signatureCanvas.height);
        const hasContent = imageData.data.some((channel, index) => {
            // Check alpha channel (every 4th value starting from index 3)
            return index % 4 === 3 && channel > 0;
        });

        if (!hasContent) {
            showAlert('Por favor dibuje su firma antes de guardar', 'warning');
            return;
        }

        // Save signature as base64
        prescription.signature = signatureCanvas.toDataURL('image/png');
        hasSignature = true;

        // Show saved state
        $('#signaturePreview').attr('src', prescription.signature);
        $('.signature-container').hide();
        $('#signatureSaved').show();

        showAlert('Firma guardada correctamente', 'success');
    }

    function changeSignature() {
        hasSignature = false;
        prescription.signature = null;

        clearSignature();
        $('.signature-container').show();
        $('#signatureSaved').hide();
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

        collectStepData(currentStep);
        generatePrescription();
    }

    function generatePrescription() {
        // Update preview document
        updatePreviewDocument();

        // Show prescription content, hide empty state
        $('#previewEmpty').hide();
        $('#prescriptionContent').show();

        // Enable action buttons
        $('#btnPrint, #btnDownloadPDF').prop('disabled', false);

        // Show success modal
        const successModal = new bootstrap.Modal(document.getElementById('successModal'));
        successModal.show();
    }

    function updatePreviewDocument() {
        // Update header
        $('#rxClinicName').text(prescription.vet.clinic);
        $('#rxClinicDetails').text(`${prescription.vet.address} | Tel: ${prescription.vet.phone}`);

        // Update vet info
        $('#rxVetName').text(prescription.vet.name);
        $('#rxVetLicense').text(prescription.vet.license);
        $('#rxVetSpecialty').text(prescription.vet.specialty);

        // Update pet info
        $('#rxPetName').text(prescription.pet.name);
        $('#rxPetSpecies').text(prescription.pet.species);
        $('#rxPetBreed').text(prescription.pet.breed || '-');
        $('#rxPetAge').text(prescription.pet.age ? `${prescription.pet.age} ${prescription.pet.ageUnit}` : '-');
        $('#rxPetWeight').text(prescription.pet.weight ? `${prescription.pet.weight} kg` : '-');
        $('#rxPetSex').text(prescription.pet.sex || '-');

        // Update owner info
        $('#rxOwnerName').text(prescription.owner.name);
        $('#rxOwnerPhone').text(prescription.owner.phone);
        $('#rxOwnerEmail').text(prescription.owner.email || '-');
        $('#rxOwnerId').text(prescription.owner.id || '-');

        // Update diagnosis
        $('#rxDiagnosis').text(prescription.diagnosis);
        if (prescription.clinicalNotes) {
            $('#rxClinicalNotes').text(prescription.clinicalNotes).show();
        } else {
            $('#rxClinicalNotes').hide();
        }

        // Update medications table
        updateMedicationsTable();

        // Update instructions
        if (prescription.instructions) {
            $('#rxInstructions').text(prescription.instructions);
            $('#rxInstructionsSection').show();
        } else {
            $('#rxInstructionsSection').hide();
        }

        // Update signature
        if (prescription.signature) {
            $('#rxSignature').attr('src', prescription.signature);
        }
        $('#rxSignatureName').text(prescription.vet.name);
        $('#rxSignatureLicense').text(`Lic. ${prescription.vet.license}`);

        // Update dates
        $('#rxDate').text(formatDate(prescription.date));
        const validUntil = addDays(prescription.date, prescription.validity);
        $('#rxValidUntil').text(formatDate(validUntil));

        // Update document ID
        $('#rxDocumentId').text(prescription.documentId);
    }

    function updateMedicationsTable() {
        const tbody = $('#rxMedicationsBody');
        tbody.empty();

        if (prescription.medications.length === 0) {
            tbody.html('<tr><td colspan="4" class="text-center text-muted">Sin medicamentos</td></tr>');
            return;
        }

        prescription.medications.forEach(med => {
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
            pdf.save(`prescripcion-${prescription.documentId}.pdf`);

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
        prescription.signature = null;
        prescription.medications = [];
        prescription.documentId = generateDocumentId();

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

        // Reload vet defaults
        loadVetDefaults();
    }

});
