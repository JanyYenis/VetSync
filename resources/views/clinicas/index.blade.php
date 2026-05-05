@extends('layouts.index', ['title' => 'Configuraciones'])

@section('imports')
    @vite(['resources/css/clinicas.css', 'resources/js/clinicas.js'])
@endsection

@section('content')
    <div class="page-content">
        <div class="page" id="page-clinicas">
            <!-- Header de página -->
            <div class="page-header">
                <div>
                    <h1 class="page-title text-primary">
                        <i class="bi bi-hospital me-2"></i>Mis Clínicas
                    </h1>
                    <p class="page-subtitle">Gestiona la información de tus clínicas veterinarias</p>
                </div>
                <div class="page-actions">
                    <button class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#clinicModal"
                        onclick="openCreateModal()">
                        <i class="bi bi-plus-lg me-2"></i>Agregar Clínica
                    </button>
                </div>
            </div>

            <!-- Estadísticas rápidas -->
            <div class="row g-3 mb-4">
                <div class="col-md-4">
                    <div class="stat-card bg-primary-subtle">
                        <div class="stat-icon bg-primary">
                            <i class="bi bi-hospital"></i>
                        </div>
                        <div class="stat-info">
                            <span class="stat-value" id="totalClinics">0</span>
                            <span class="stat-label">Total Clínicas</span>
                        </div>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="stat-card bg-success-subtle">
                        <div class="stat-icon bg-success">
                            <i class="bi bi-check-circle"></i>
                        </div>
                        <div class="stat-info">
                            <span class="stat-value" id="activeClinics">0</span>
                            <span class="stat-label">Clínicas Activas</span>
                        </div>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="stat-card bg-warning-subtle">
                        <div class="stat-icon bg-warning">
                            <i class="bi bi-pause-circle"></i>
                        </div>
                        <div class="stat-info">
                            <span class="stat-value" id="inactiveClinics">0</span>
                            <span class="stat-label">Clínicas Inactivas</span>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Grid de clínicas -->
            <div class="row g-4" id="clinicsGrid">
                <!-- Se llena dinámicamente con JavaScript -->
            </div>
        </div>
    </div>

    <!-- ========================================
         TOAST NOTIFICATIONS
    ======================================== -->
    <div class="toast-container position-fixed bottom-0 end-0 p-3">
        <div id="successToast" class="toast align-items-center text-bg-success border-0" role="alert">
            <div class="d-flex">
                <div class="toast-body">
                    <i class="bi bi-check-circle me-2"></i>
                    <span id="successMessage">Operación exitosa</span>
                </div>
                <button type="button" class="btn-close btn-close-white me-2 m-auto" data-bs-dismiss="toast"></button>
            </div>
        </div>
        <div id="errorToast" class="toast align-items-center text-bg-danger border-0" role="alert">
            <div class="d-flex">
                <div class="toast-body">
                    <i class="bi bi-x-circle me-2"></i>
                    <span id="errorMessage">Ha ocurrido un error</span>
                </div>
                <button type="button" class="btn-close btn-close-white me-2 m-auto" data-bs-dismiss="toast"></button>
            </div>
        </div>
    </div>
@endsection

@section('modals')
    @component('clinicas.modals.crear')
    @endcomponent
    @component('clinicas.modals.eliminar')
    @endcomponent
@endsection
