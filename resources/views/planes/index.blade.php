@extends('layouts.index')

@section('imports')
    @vite(['resources/css/planes.css', 'resources/js/planes.js'])
@endsection

@section('content')
    <!-- Content Area -->
    <div class="content-area">
        <!-- Stats Cards -->
        <div class="stats-row">
            <div class="stat-card">
                <div class="stat-icon bg-primary-light">
                    <i class="bi bi-credit-card-2-front text-primary"></i>
                </div>
                <div class="stat-info">
                    <span class="stat-value" id="totalPlanes">3</span>
                    <span class="stat-label">Planes Activos</span>
                </div>
            </div>
            <div class="stat-card">
                <div class="stat-icon bg-success-light">
                    <i class="bi bi-puzzle text-success"></i>
                </div>
                <div class="stat-info">
                    <span class="stat-value" id="totalServicios">12</span>
                    <span class="stat-label">Servicios</span>
                </div>
            </div>
            <div class="stat-card">
                <div class="stat-icon bg-info-light">
                    <i class="bi bi-sliders text-info"></i>
                </div>
                <div class="stat-info">
                    <span class="stat-value" id="totalPersonalizados">2</span>
                    <span class="stat-label">Personalizados</span>
                </div>
            </div>
            <div class="stat-card">
                <div class="stat-icon bg-warning-light">
                    <i class="bi bi-people text-warning"></i>
                </div>
                <div class="stat-info">
                    <span class="stat-value" id="totalSuscriptores">156</span>
                    <span class="stat-label">Suscriptores</span>
                </div>
            </div>
        </div>

        <!-- Tabs Navigation -->
        <div class="tabs-container">
            <ul class="nav nav-tabs custom-tabs" id="plansTabs" role="tablist">
                <li class="nav-item" role="presentation">
                    <button class="nav-link active" id="planes-tab" data-bs-toggle="tab" data-bs-target="#planes"
                        type="button" role="tab">
                        <i class="bi bi-credit-card-2-front me-2"></i>Planes
                    </button>
                </li>
                <li class="nav-item" role="presentation">
                    <button class="nav-link" id="servicios-tab" data-bs-toggle="tab" data-bs-target="#servicios"
                        type="button" role="tab">
                        <i class="bi bi-puzzle me-2"></i>Servicios
                    </button>
                </li>
                <li class="nav-item" role="presentation">
                    <button class="nav-link" id="personalizados-tab" data-bs-toggle="tab" data-bs-target="#personalizados"
                        type="button" role="tab">
                        <i class="bi bi-sliders me-2"></i>Personalizados
                    </button>
                </li>
            </ul>

            <div class="tab-content" id="plansTabContent">
                <!-- Tab: Planes -->
                <div class="tab-pane fade show active" id="planes" role="tabpanel">
                    <button class="btn btn-primary" id="btnNewPlan">
                        <i class="bi bi-plus-lg me-2"></i>Nuevo Plan
                    </button>
                    <div class="plans-grid" id="planesGrid">
                        <!-- Plans will be rendered here -->
                    </div>
                </div>

                <!-- Tab: Servicios -->
                <div class="tab-pane fade" id="servicios" role="tabpanel">
                    <div class="services-header">
                        <div class="search-box">
                            <i class="bi bi-search"></i>
                            <input type="text" class="form-control" id="searchServicios"
                                placeholder="Buscar servicios...">
                        </div>
                        <button class="btn btn-primary" id="btnNewServicio">
                            <i class="bi bi-plus-lg me-2"></i>Nuevo Servicio
                        </button>
                    </div>
                    <div class="services-categories" id="serviciosContainer">
                        <!-- Services will be rendered here -->
                    </div>
                </div>

                <!-- Tab: Personalizados -->
                <div class="tab-pane fade" id="personalizados" role="tabpanel">
                    <div class="custom-plans-header">
                        <div class="search-box">
                            <i class="bi bi-search"></i>
                            <input type="text" class="form-control" id="searchPersonalizados"
                                placeholder="Buscar cliente...">
                        </div>
                        <button class="btn btn-primary" id="btnNewPersonalizado">
                            <i class="bi bi-plus-lg me-2"></i>Nuevo Plan Personalizado
                        </button>
                    </div>
                    <div class="table-responsive">
                        <table class="table custom-table" id="personalizadosTable">
                            <thead>
                                <tr>
                                    <th>Cliente</th>
                                    <th>Plan Base</th>
                                    <th>Precio</th>
                                    <th>Servicios</th>
                                    <th>Limites</th>
                                    <th>Estado</th>
                                    <th>Acciones</th>
                                </tr>
                            </thead>
                            <tbody id="personalizadosBody">
                                <!-- Custom plans will be rendered here -->
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Toast Notifications -->
    <div class="toast-container position-fixed bottom-0 end-0 p-3">
        <div id="toast" class="toast align-items-center border-0" role="alert">
            <div class="d-flex">
                <div class="toast-body">
                    <i class="bi me-2" id="toastIcon"></i>
                    <span id="toastMessage"></span>
                </div>
                <button type="button" class="btn-close btn-close-white me-2 m-auto" data-bs-dismiss="toast"></button>
            </div>
        </div>
    </div>
@endsection

@section('modals')
    @component('planes.modals.crear')
    @endcomponent
    @component('planes.modals.ver')
    @endcomponent
    @component('planes.modals.eliminar')
    @endcomponent
    @component('planes.modals.servicios.crear')
    @endcomponent
    @component('planes.modals.personalizados.crear')
    @endcomponent
@endsection
