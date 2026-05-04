@extends('layouts.index', ['title' => 'Historial Clínico'])

@section('imports')
    <script>
        window.nombre = '{{ auth()->user()->nombre_completo }}';
        window.licencia = '{{ auth()->user()->licencia }}';
    </script>
    @vite(['resources/css/historial.css', 'resources/js/historiales/principal.js'])
@endsection

@section('content')
    <div class="container-fluid py-4">
        <!-- Header con controles principales -->
        <div class="header-controls d-flex justify-content-between align-items-center mb-4 no-print">
            <h1 class="h4 text-primary mb-0">
                <i class="bi bi-clipboard2-pulse me-2"></i>Gestión de Historias Clínicas
            </h1>
            <div class="d-flex gap-2">
                {{-- <button type="button" class="btn btn-success" id="btnNuevaHistoria">
                    <i class="bi bi-plus-circle me-1"></i>Nueva Historia
                </button> --}}
                <button type="button" class="btn btn-outline-primary" id="btnListarHistorias">
                    <i class="bi bi-list-ul me-1"></i>Ver Historial
                </button>
            </div>
        </div>

        <!-- Alertas -->
        <div id="alertContainer" class="no-print"></div>

        <form id="formHistorial" data-modo="1">
            <div id="watermark">GIJAC WEB</div>
            <input type="hidden" name="id" id="idHistorial">
            <!-- Panel de selección de mascota -->
            <div class="card mb-4 no-print" id="panelSeleccion">
                <div class="card-header bg-primary text-white">
                    <i class="bi bi-search me-2"></i>Seleccionar Mascota
                </div>
                <div class="card-body">
                    <div class="row align-items-end">
                        <div class="col-md-6">
                            <label for="selectMascota" class="form-label fw-semibold">Mascota / Propietario</label>
                            <select class="form-select form-select-lg" id="selectMascota" name="cod_mascota">
                                <option value="">-- Seleccione una mascota --</option>
                            </select>
                        </div>
                        <div class="col-md-6 mt-3 mt-md-0">
                            <button type="button" class="btn btn-primary" id="btnCargarMascota" disabled>
                                <i class="bi bi-arrow-down-circle me-1"></i>Cargar Datos
                            </button>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Documento de Historia Clínica -->
            <div class="clinical-document" id="documentoHistoria">
                <!-- Encabezado del documento -->
                <div class="document-header text-center">
                    <div class="clinic-logo mb-2" style="width: 4rem;">
                        <img src="{{ asset('build/img/logo_mini.png') }}" width="100%">
                    </div>
                    <h2 class="document-title">HISTORIA CLÍNICA</h2>
                    {{-- <div class="row mt-3">
                        <div class="col-6 text-start">
                            <small class="text-muted">Fecha de creación:</small>
                            <input type="date" class="form-control form-control-sm d-inline-block w-auto ms-2"
                                id="fechaCreacion" value="{{ date('d/m/Y') }}">
                        </div>
                        <div class="col-6 text-end">
                            <small class="text-muted">N° Historia:</small>
                            <input type="text" class="form-control form-control-sm d-inline-block w-auto ms-2" id="numeroHistoria" placeholder="HC-0001" readonly>
                        </div>
                    </div> --}}
                </div>

                <hr class="document-divider">

                <!-- Sección: Información General -->
                <div class="document-section">
                    <h5 class="section-title">
                        <i class="bi bi-info-circle me-2"></i>INFORMACIÓN GENERAL
                    </h5>
                    <div class="row g-3">
                        <div class="col-md-4">
                            <label class="form-label">Nombre de Mascota</label>
                            <input type="text" class="form-control" id="nombreMascota" name="nombre_mascota"
                                required placeholder="Ingrese el nombre de la mascota" readonly>
                        </div>
                        <div class="col-md-4">
                            <label class="form-label">Tipo</label>
                            <select class="form-select" id="tipoMascota" name="tipo_mascota"
                                data-control="select2" data-placeholder="Seleccione el tipo de mascota"
                                data-allow-clear="true" data-hide-search="true" disabled>
                                <option value=""></option>
                                @foreach ($tipos as $item)
                                    <option value="{{ $item?->codigo }}">{{ $item?->nombre }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="col-md-4">
                            <label class="form-label">Raza</label>
                            <input type="text" class="form-control" id="razaMascota" name="raza_mascota"
                                required placeholder="Ingrese la raza de la mascota" readonly>
                        </div>
                        <div class="col-md-3">
                            <label class="form-label">Edad</label>
                            <input type="number" class="form-control" id="edadMascota" name="edad_mascota"
                                placeholder="Ej: 3 años" required min="0">
                        </div>
                        <div class="col-md-3">
                            <label class="form-label">Genero</label>
                            <select class="form-select" id="sexoMascota" name="genero_mascota" required
                                data-control="select2" data-placeholder="Seleccione el genero de la mascota"
                                data-allow-clear="true" data-hide-search="true" disabled>
                                <option value=""></option>
                                @foreach ($generos as $item)
                                    <option value="{{ $item?->codigo }}">{{ $item?->nombre }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="col-md-3">
                            <label class="form-label">Color</label>
                            <input type="text" class="form-control" id="colorMascota" name="color_mascota"
                                required placeholder="Ingrese el color de la mascota" readonly>
                        </div>
                        <div class="col-md-3">
                            <label class="form-label">Peso (kg)</label>
                            <input type="number" class="form-control" id="pesoMascota" step="0.1"
                                name="peso_mascota" required placeholder="Ingrese el peso de la mascota">
                        </div>
                    </div>

                    <hr class="my-4">

                    <input type="hidden" name="cod_cliente" id="codigoPropietario">
                    <div class="row g-3">
                        <div class="col-md-6">
                            <label class="form-label">Propietario</label>
                            <input type="text" class="form-control" id="nombrePropietario" readonly required
                                name="nombre_propietario" placeholder="Ingrese el nombre del propietario">
                        </div>
                        <div class="col-md-3">
                            <label class="form-label">Teléfono</label>
                            <input type="tel" class="form-control" id="telefonoPropietario" readonly required
                                name="telefono_propietario" placeholder="Ingrese el telefono del propietario">
                        </div>
                        <div class="col-md-3">
                            <label class="form-label">Email</label>
                            <input type="email" class="form-control" id="emailPropietario" readonly required
                                name="email_propietario" placeholder="Ingrese el email del propietario">
                        </div>
                        <div class="col-12">
                            <label class="form-label">Dirección</label>
                            <input type="text" class="form-control" id="direccionPropietario" readonly required
                                name="direccion_propietario" placeholder="Ingrese la dirección del propietario">
                        </div>
                    </div>
                </div>

                <hr class="document-divider">

                <!-- Sección: Antecedentes -->
                <div class="document-section">
                    <h5 class="section-title">
                        <i class="bi bi-clipboard-data me-2"></i>ANTECEDENTES
                    </h5>

                    <h6 class="subsection-title mt-3">Vacunas</h6>
                    <div class="row g-3">
                        <div class="col-md-4">
                            <label class="form-label">Rabia</label>
                            <input type="date" class="form-control" id="vacunaRabia" name="rabia">
                        </div>
                        <div class="col-md-4">
                            <label class="form-label">Parvovirus</label>
                            <input type="date" class="form-control" id="vacunaParvovirus" name="parvovirus">
                        </div>
                        <div class="col-md-4">
                            <label class="form-label">Moquillo</label>
                            <input type="date" class="form-control" id="vacunaMoquillo" name="moquillo">
                        </div>
                    </div>

                    <div class="row g-3 mt-2">
                        <div class="col-md-6">
                            <label class="form-label">Última desparasitación interna</label>
                            <input type="date" class="form-control" id="desparasitacionInterna"
                                name="desparasitacion_interna">
                        </div>
                        <div class="col-md-6">
                            <label class="form-label">Última desparasitación externa</label>
                            <input type="date" class="form-control" id="desparasitacionExterna"
                                name="desparasitacion_externa">
                        </div>
                    </div>

                    <div class="row g-3 mt-2">
                        <div class="col-md-6">
                            <label class="form-label">Alergias conocidas</label>
                            <textarea class="form-control" id="alergias" rows="2" name="alergias"
                                placeholder="Describir alergias si las hay..."></textarea>
                        </div>
                        <div class="col-md-6">
                            <label class="form-label">Enfermedades crónicas</label>
                            <textarea class="form-control" id="enfermedadesCronicas" rows="2"
                                name="enfermedades_cronicas"
                                placeholder="Describir enfermedades crónicas si las hay..."></textarea>
                        </div>
                    </div>
                </div>

                <hr class="document-divider">

                <!-- Sección: Historial Clínico (CRUD) -->
                <div class="document-section">
                    <h5 class="section-title d-flex justify-content-between align-items-center">
                        <span><i class="bi bi-journal-medical me-2"></i>HISTORIAL CLÍNICO</span>
                        <button type="button" class="btn btn-sm btn-success no-print" id="btnAgregarConsulta">
                            <i class="bi bi-plus-lg me-1"></i>Agregar Consulta
                        </button>
                    </h5>

                    <div class="table-responsive mt-3">
                        <table class="table table-bordered table-hover" id="tablaHistorial">
                            <thead class="table-primary">
                                <tr>
                                    <th style="width: 100px;">Fecha</th>
                                    <th style="width: 150px;">Motivo</th>
                                    <th>Diagnóstico</th>
                                    <th>Tratamiento</th>
                                    <th style="width: 120px;">Veterinario</th>
                                    <th style="width: 100px;" class="no-print">Acciones</th>
                                </tr>
                            </thead>
                            <tbody id="tbodyHistorial">
                                <!-- Filas dinámicas -->
                            </tbody>
                        </table>
                    </div>
                    <p class="text-muted small" id="mensajeSinConsultas">
                        <i class="bi bi-info-circle me-1"></i>No hay consultas registradas. Haga clic en "Agregar Consulta" para comenzar.
                    </p>
                </div>

                <hr class="document-divider">

                <!-- Sección: Firma Electrónica -->
                <div class="document-section">
                    <h5 class="section-title">
                        <i class="bi bi-pen me-2"></i>FIRMA DEL VETERINARIO
                    </h5>
                    <div class="row">
                        <div class="col-md-6">
                            <label class="form-label">Nombre del Veterinario</label>
                            <input type="text" class="form-control" id="nombreVeterinario"
                                placeholder="Dr./Dra." value="{{ auth()->user()->nombre_completo ?? 'N/A' }}"
                                readonly disabled>
                        </div>
                        <div class="col-md-6">
                            <label class="form-label">Matrícula Profesional</label>
                            <input type="text" class="form-control" id="matriculaVeterinario" readonly disabled
                                placeholder="N° de matrícula" value="{{ auth()->user()->licencia ?? '' }}"
                                required>
                        </div>
                    </div>

                    <div class="signature-area mt-4">
                        <label class="form-label">Firma Electrónica</label>
                        <div class="signature-container">
                            <canvas id="canvasFirma" width="400" height="150"></canvas>
                            <img id="firmaGuardada" class="d-none" alt="Firma">
                        </div>
                        <div class="signature-controls mt-2 no-print">
                            <button type="button" class="btn btn-outline-secondary btn-sm" id="btnLimpiarFirma">
                                <i class="bi bi-eraser me-1"></i>Limpiar
                            </button>
                            <button type="button" class="btn btn-primary btn-sm d-none" id="btnGuardarFirma">
                                <i class="bi bi-check-lg me-1"></i>Guardar Firma
                            </button>
                        </div>
                    </div>
                </div>

                <hr class="document-divider">

                <!-- Observaciones generales -->
                <div class="document-section">
                    <h5 class="section-title">
                        <i class="bi bi-chat-left-text me-2"></i>OBSERVACIONES GENERALES
                    </h5>
                    <textarea class="form-control" id="observacionesGenerales" rows="3" name="observacion_general"
                        placeholder="Notas adicionales sobre el paciente..."></textarea>
                </div>

                <!-- Botones de acción -->
                <div class="action-buttons mt-4 no-print">
                    <button type="submit" class="btn btn-success btn-lg" id="btnGuardarHistoria">
                        <i class="bi bi-save me-2"></i>Guardar Historia
                    </button>
                    {{-- <button type="button" class="btn btn-info btn-lg text-white" id="btnImprimir">
                        <i class="bi bi-printer me-2"></i>Imprimir
                    </button> --}}
                    <button type="button" class="btn btn-danger btn-lg d-none" id="btnExportarPDF">
                        <i class="bi bi-file-earmark-pdf me-2"></i>Exportar PDF
                    </button>
                </div>
            </div>
        </form>
    </div>
@endsection

@section('modals')
    @component('historiales.modals.consultas')
    @endcomponent
    @component('historiales.modals.listado')
    @endcomponent
    @component('historiales.modals.eliminar')
    @endcomponent
@endsection
