@extends('layouts.index', ['title' => 'Crear Prescripciones'])

@section('imports')
    @vite(['resources/css/prescripciones.css', 'resources/js/prescripciones/crear.js'])
@endsection

@section('content')
    <!-- Page Content -->
        <div class="page-content">
            <!-- Page Header -->
            <div class="page-header">
                <div class="page-header-content">
                    <div class="page-title-wrapper">
                        <h1 class="page-title">Prescripcion Medica Veterinaria</h1>
                        <p class="page-subtitle">Genera prescripciones profesionales con firma electronica</p>
                    </div>
                    {{-- <div class="page-actions">
                        <button class="btn btn-outline-secondary" id="btnNewPrescription">
                            <i class="bi bi-plus-lg me-2"></i>Nueva Prescripcion
                        </button>
                    </div> --}}
                </div>
            </div>

            <!-- Main Grid -->
            <div class="prescription-grid">
                <!-- Left Column - Form -->
                <div class="form-column">
                    <!-- Step Indicator -->
                    <div class="step-indicator">
                        <div class="step active" data-step="1">
                            <div class="step-number">1</div>
                            <span class="step-label">Medicamentos</span>
                        </div>
                        <div class="step-line"></div>
                        <div class="step" data-step="2">
                            <div class="step-number">2</div>
                            <span class="step-label">Firma</span>
                        </div>
                    </div>

                    <!-- Form Card -->
                    <div class="form-card">
                        <form id="prescriptionForm">
                            <!-- Step 1: Medicamentos -->
                            <div class="form-step active" data-step="1">
                                <div class="form-step-header">
                                    <div class="form-step-icon bg-warning-subtle">
                                        <i class="bi bi-capsule text-warning"></i>
                                    </div>
                                    <div>
                                        <h3 class="form-step-title">Prescripcion de Medicamentos</h3>
                                        <p class="form-step-subtitle">Agrega los medicamentos y las indicaciones</p>
                                    </div>
                                </div>

                                <!-- Diagnostico -->
                                <div class="info-section">
                                    <h5 class="info-section-title"><i class="bi bi-clipboard2-pulse-fill me-2"></i>Diagnostico</h5>
                                    <div class="row g-3">
                                        <div class="col-12">
                                            <label class="form-label">Diagnostico Principal <span class="required">*</span></label>
                                            <select name="cod_historial" class="form-select" id="selectHistoriales" required>
                                            </select>
                                        </div>
                                    </div>
                                </div>

                                <!-- Medications List -->
                                <div class="info-section">
                                    <div class="d-flex justify-content-between align-items-center mb-3">
                                        <h5 class="info-section-title mb-0"><i class="bi bi-capsule-pill me-2"></i>Medicamentos</h5>
                                        <button type="button" class="btn btn-primary btn-sm" id="btnAddMedication">
                                            <i class="bi bi-plus-lg me-1"></i>Agregar
                                        </button>
                                    </div>

                                    <div id="medicationsList">
                                        <!-- Medication Item Template -->
                                        <div class="medication-item" data-index="0">
                                            <div class="medication-header">
                                                <span class="medication-number">Medicamento #1</span>
                                                {{-- <button type="button" class="btn btn-link text-danger btn-sm btn-remove-medication" title="Eliminar">
                                                    <i class="bi bi-trash"></i>
                                                </button> --}}
                                            </div>
                                            <div class="row g-2">
                                                <div class="col-md-6">
                                                    <label class="form-label">Medicamento <span class="required">*</span></label>
                                                    <input type="text" class="form-control med-name" placeholder="Ej: Amoxicilina" required>
                                                </div>
                                                <div class="col-md-6">
                                                    <label class="form-label">Presentacion</label>
                                                    <select class="form-select med-presentation">
                                                        <option value=""></option>
                                                    </select>
                                                </div>
                                                <div class="col-md-4">
                                                    <label class="form-label">Dosis <span class="required">*</span></label>
                                                    <input type="text" class="form-control med-dose" placeholder="Ej: 250mg" required>
                                                </div>
                                                <div class="col-md-4">
                                                    <label class="form-label">Frecuencia <span class="required">*</span></label>
                                                    <select class="form-select med-frequency" required>
                                                        <option value=""></option>
                                                    </select>
                                                </div>
                                                <div class="col-md-4">
                                                    <label class="form-label">Duracion <span class="required">*</span></label>
                                                    <div class="input-group">
                                                        <input type="number" class="form-control med-duration"
                                                            min="1" placeholder="0" required style="max-width: 4rem;">
                                                        <select class="form-select med-duration-unit" id="selectDuracion" style="max-width: 80px;">
                                                            @foreach ($duracion as $item)
                                                                <option value="{{ $item?->codigo }}">{{ $item?->nombre_corto }}</option>
                                                            @endforeach
                                                        </select>
                                                    </div>
                                                </div>
                                                <div class="col-12">
                                                    <label class="form-label">Instrucciones Adicionales</label>
                                                    <input type="text" class="form-control med-instructions" placeholder="Ej: Administrar con alimento">
                                                </div>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="empty-medications" id="emptyMedications" style="display: none;">
                                        <i class="bi bi-capsule"></i>
                                        <p>No hay medicamentos agregados</p>
                                        <button type="button" class="btn btn-outline-primary btn-sm" id="btnAddMedicationEmpty">
                                            <i class="bi bi-plus-lg me-1"></i>Agregar Medicamento
                                        </button>
                                    </div>
                                </div>

                                <!-- General Instructions -->
                                <div class="info-section">
                                    <h5 class="info-section-title"><i class="bi bi-info-circle-fill me-2"></i>Indicaciones Generales</h5>
                                    <textarea class="form-control" id="generalInstructions" rows="4" placeholder="Indicaciones adicionales para el propietario..." name="indicaciones"></textarea>

                                    <div class="quick-instructions mt-3">
                                        <span class="quick-label">Indicaciones rapidas:</span>
                                        <div class="quick-buttons">
                                            <button type="button" class="btn btn-outline-secondary btn-sm quick-instruction" data-text="Mantener al paciente en reposo.">Reposo</button>
                                            <button type="button" class="btn btn-outline-secondary btn-sm quick-instruction" data-text="Asegurar hidratacion adecuada.">Hidratacion</button>
                                            <button type="button" class="btn btn-outline-secondary btn-sm quick-instruction" data-text="Dieta blanda por 3 dias.">Dieta blanda</button>
                                            <button type="button" class="btn btn-outline-secondary btn-sm quick-instruction" data-text="Control en 7 dias.">Control 7 dias</button>
                                            <button type="button" class="btn btn-outline-secondary btn-sm quick-instruction" data-text="Evitar ejercicio intenso.">Sin ejercicio</button>
                                        </div>
                                    </div>
                                </div>

                                <!-- Prescription Date -->
                                <div class="row g-3">
                                    <div class="col-md-6">
                                        <label class="form-label">Fecha de Prescripcion <span class="required">*</span></label>
                                        <input type="date" class="form-control" id="prescriptionDate" name="fecha" required>
                                    </div>
                                    <div class="col-md-6">
                                        <label class="form-label">Validez de la Receta</label>
                                        <select class="form-select" id="prescriptionValidity" name="validez">
                                            <option value="7">7 dias</option>
                                            <option value="15">15 dias</option>
                                            <option value="30" selected>30 dias</option>
                                            <option value="60">60 dias</option>
                                            <option value="90">90 dias</option>
                                        </select>
                                    </div>
                                </div>
                            </div>

                            <!-- Step 2: Firma -->
                            <div class="form-step" data-step="2">
                                <div class="form-step-header">
                                    <div class="form-step-icon bg-info-subtle">
                                        <i class="bi bi-pen text-info"></i>
                                    </div>
                                    <div>
                                        <h3 class="form-step-title">Firma Electronica</h3>
                                        <p class="form-step-subtitle">Firma digital para validar la prescripcion</p>
                                    </div>
                                </div>

                                <div class="signature-section">
                                    <div class="signature-info">
                                        <i class="bi bi-shield-check"></i>
                                        <div>
                                            <strong>Firma Digital Segura</strong>
                                            <p>La firma electronica tiene la misma validez legal que una firma manuscrita</p>
                                        </div>
                                    </div>

                                    <div class="signature-container">
                                        <label class="form-label">Dibuje su firma en el area de abajo</label>
                                        <div class="signature-area signature-canvas-wrapper mt-4">
                                            <div class="signature-container">
                                                <canvas id="canvasFirma" width="400" height="150"></canvas>
                                                <img id="firmaGuardada" class="d-none" alt="Firma">
                                            </div>
                                        </div>
                                        <div class="signature-controls signature-actions mt-2 no-print">
                                            <button type="button" class="btn btn-outline-secondary btn-sm" id="btnLimpiarFirma">
                                                <i class="bi bi-eraser me-1"></i>Limpiar
                                            </button>
                                            <button type="button" class="btn btn-primary btn-sm d-none" id="btnGuardarFirma">
                                                <i class="bi bi-check-lg me-1"></i>Guardar Firma
                                            </button>
                                        </div>
                                    </div>

                                    <div class="signature-saved" id="signatureSaved" style="display: none;">
                                        <div class="signature-saved-preview">
                                            <img id="signaturePreview" alt="Firma guardada">
                                        </div>
                                        <div class="signature-saved-info">
                                            <i class="bi bi-check-circle-fill text-success"></i>
                                            <span>Firma guardada correctamente</span>
                                            <button type="button" class="btn btn-link btn-sm" id="btnChangeSignature">Cambiar firma</button>
                                        </div>
                                    </div>
                                </div>

                                <!-- Terms -->
                                <div class="terms-section">
                                    <div class="form-check">
                                        <input type="checkbox" class="form-check-input" id="acceptTerms" required>
                                        <label class="form-check-label" for="acceptTerms">
                                            Confirmo que la informacion proporcionada es correcta y autorizo la generacion de esta prescripcion medica veterinaria.
                                        </label>
                                    </div>
                                </div>
                            </div>

                            <!-- Form Navigation -->
                            <div class="form-navigation">
                                <button type="button" class="btn btn-outline-secondary" id="btnPrevStep" style="display: none;">
                                    <i class="bi bi-arrow-left me-1"></i>Anterior
                                </button>
                                <button type="button" class="btn btn-primary" id="btnNextStep">
                                    Siguiente<i class="bi bi-arrow-right ms-1"></i>
                                </button>
                                <button type="submit" class="btn btn-success" id="btnGeneratePrescription" style="display: none;">
                                    <i class="bi bi-file-earmark-check me-1"></i>Generar Prescripcion
                                </button>
                            </div>
                        </form>
                    </div>
                </div>

                <!-- Right Column - Preview -->
                <div class="preview-column">
                    <div class="preview-header">
                        <h4 class="preview-title"><i class="bi bi-eye me-2"></i>Vista Previa</h4>
                        <div class="preview-actions">
                            <button class="btn btn-outline-primary btn-sm" id="btnPrint" disabled>
                                <i class="bi bi-printer me-1"></i>Imprimir
                            </button>
                            <button class="btn btn-primary btn-sm" id="btnDownloadPDF" disabled>
                                <i class="bi bi-file-earmark-pdf me-1"></i>PDF
                            </button>
                        </div>
                    </div>

                    <div class="preview-container">
                        <div class="prescription-document" id="prescriptionDocument">
                            <!-- Empty State -->
                            <div class="preview-empty" id="previewEmpty">
                                <div class="preview-empty-icon">
                                    <i class="bi bi-file-earmark-medical"></i>
                                </div>
                                <h5>Vista previa de la prescripcion</h5>
                                <p>Complete el formulario para ver la prescripcion generada</p>
                            </div>

                            <!-- Prescription Content (Hidden until generated) -->
                            <div class="prescription-content" id="prescriptionContent" style="display: none;">
                                <!-- Header -->
                                <div class="rx-header">
                                    <div class="rx-logo">
                                        <div class="rx-logo-icon">
                                            <img
                                                src="{{ auth()->user()->empresa?->foto
                                                    ? asset('storage/' . auth()->user()->empresa->foto)
                                                    : asset('build/img/logo_mini.png')
                                                }}"
                                                width="100%"
                                                alt="{{ auth()->user()->empresa?->razon_social ?? 'VetSync' }}"
                                            >
                                        </div>
                                        <div class="rx-clinic-info">
                                            <h2 class="rx-clinic-name" id="rxClinicName">VetSync - Clinica Veterinaria</h2>
                                            <p class="rx-clinic-details" id="rxClinicDetails">Av. Principal 123, Ciudad | Tel: +1 (555) 123-4567</p>
                                        </div>
                                    </div>
                                    <div class="rx-header-badge">
                                        <span class="badge bg-primary">PRESCRIPCION MEDICA</span>
                                    </div>
                                </div>

                                <div class="rx-divider"></div>

                                <!-- Vet Info -->
                                <div class="rx-section">
                                    <div class="rx-section-title">
                                        <i class="bi bi-person-badge"></i>
                                        <span>Medico Veterinario</span>
                                    </div>
                                    <div class="rx-vet-info">
                                        <div class="rx-info-row">
                                            <span class="rx-label">Nombre:</span>
                                            <span class="rx-value" id="rxVetName">Dr. Carlos Martinez</span>
                                        </div>
                                        <div class="rx-info-row">
                                            <span class="rx-label">Licencia:</span>
                                            <span class="rx-value" id="rxVetLicense">VET-2024-1234</span>
                                        </div>
                                        <div class="rx-info-row">
                                            <span class="rx-label">Especialidad:</span>
                                            <span class="rx-value" id="rxVetSpecialty">Medicina General</span>
                                        </div>
                                    </div>
                                </div>

                                <!-- Patient Info -->
                                <div class="rx-section rx-patient-section">
                                    <div class="rx-columns">
                                        <div class="rx-column">
                                            <div class="rx-section-title">
                                                <i class="bi bi-heart"></i>
                                                <span>Paciente</span>
                                            </div>
                                            <div class="rx-info-grid">
                                                <div class="rx-info-item">
                                                    <span class="rx-label">Nombre:</span>
                                                    <span class="rx-value" id="rxPetName">-</span>
                                                </div>
                                                <div class="rx-info-item">
                                                    <span class="rx-label">Especie:</span>
                                                    <span class="rx-value" id="rxPetSpecies">-</span>
                                                </div>
                                                <div class="rx-info-item">
                                                    <span class="rx-label">Raza:</span>
                                                    <span class="rx-value" id="rxPetBreed">-</span>
                                                </div>
                                                <div class="rx-info-item">
                                                    <span class="rx-label">Edad:</span>
                                                    <span class="rx-value" id="rxPetAge">-</span>
                                                </div>
                                                <div class="rx-info-item">
                                                    <span class="rx-label">Peso:</span>
                                                    <span class="rx-value" id="rxPetWeight">-</span>
                                                </div>
                                                <div class="rx-info-item">
                                                    <span class="rx-label">Sexo:</span>
                                                    <span class="rx-value" id="rxPetSex">-</span>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="rx-column">
                                            <div class="rx-section-title">
                                                <i class="bi bi-person"></i>
                                                <span>Propietario</span>
                                            </div>
                                            <div class="rx-info-grid">
                                                <div class="rx-info-item">
                                                    <span class="rx-label">Nombre:</span>
                                                    <span class="rx-value" id="rxOwnerName">-</span>
                                                </div>
                                                <div class="rx-info-item">
                                                    <span class="rx-label">Telefono:</span>
                                                    <span class="rx-value" id="rxOwnerPhone">-</span>
                                                </div>
                                                <div class="rx-info-item">
                                                    <span class="rx-label">Email:</span>
                                                    <span class="rx-value" id="rxOwnerEmail">-</span>
                                                </div>
                                                <div class="rx-info-item">
                                                    <span class="rx-label">Documento:</span>
                                                    <span class="rx-value" id="rxOwnerId">-</span>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <!-- Diagnosis -->
                                <div class="rx-section">
                                    <div class="rx-section-title">
                                        <i class="bi bi-clipboard2-pulse"></i>
                                        <span>Diagnostico</span>
                                    </div>
                                    <div class="rx-diagnosis">
                                        <p id="rxDiagnosis">-</p>
                                        <p class="rx-clinical-notes" id="rxClinicalNotes"></p>
                                    </div>
                                </div>

                                <!-- Medications -->
                                <div class="rx-section">
                                    <div class="rx-section-title">
                                        <i class="bi bi-capsule"></i>
                                        <span>Prescripcion</span>
                                    </div>
                                    <div class="rx-symbol">Rx</div>
                                    <table class="rx-medications-table">
                                        <thead>
                                            <tr>
                                                <th>Medicamento</th>
                                                <th>Dosis</th>
                                                <th>Frecuencia</th>
                                                <th>Duracion</th>
                                            </tr>
                                        </thead>
                                        <tbody id="rxMedicationsBody">
                                            <tr>
                                                <td colspan="4" class="text-center text-muted">Sin medicamentos</td>
                                            </tr>
                                        </tbody>
                                    </table>
                                </div>

                                <!-- Instructions -->
                                <div class="rx-section" id="rxInstructionsSection" style="display: none;">
                                    <div class="rx-section-title">
                                        <i class="bi bi-info-circle"></i>
                                        <span>Indicaciones Generales</span>
                                    </div>
                                    <div class="rx-instructions" id="rxInstructions"></div>
                                </div>

                                <!-- Footer -->
                                <div class="rx-footer">
                                    <div class="rx-signature-area">
                                        <div class="rx-signature-box">
                                            <img id="rxSignature" src="" alt="Firma del veterinario">
                                            <div class="rx-signature-line"></div>
                                            <p class="rx-signature-label">Firma del Medico Veterinario</p>
                                            <p class="rx-signature-name" id="rxSignatureName">Dr. Carlos Martinez</p>
                                            <p class="rx-signature-license" id="rxSignatureLicense">Lic. VET-2024-1234</p>
                                        </div>
                                    </div>
                                    <div class="rx-meta">
                                        <div class="rx-date">
                                            <span class="rx-label">Fecha:</span>
                                            <span class="rx-value" id="rxDate">-</span>
                                        </div>
                                        <div class="rx-validity">
                                            <span class="rx-label">Valido hasta:</span>
                                            <span class="rx-value" id="rxValidUntil">-</span>
                                        </div>
                                    </div>
                                </div>

                                <!-- Watermark -->
                                <div class="rx-watermark">PRESCRIPCION MEDICA VETERINARIA</div>

                                <!-- Document ID -->
                                <div class="rx-document-id">
                                    <small>ID: <span id="rxDocumentId">RX-000000</span></small>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
@endsection

@section('modals')
    @component('prescripciones.modals.success')
    @endcomponent
@endsection
