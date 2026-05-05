@extends('layouts.index', ['title' => 'Dashboard'])

@section('imports')
    @vite(['resources/js/dashboard.js', 'resources/js/data.js'])
@endsection

@section('content')
    <!-- Page Content -->
    <div class="page-content">
        <!-- Dashboard Page -->
        <div class="page" id="page-dashboard">
            <div class="page-header">
                <div>
                    <h1 class="page-title text-primary">Dashboard</h1>
                    <p class="page-subtitle">Bienvenido al panel de administración</p>
                </div>
                <div class="page-actions">
                    {{-- <button class="btn btn-outline-secondary">
                        <i class="bi bi-download me-2"></i>Exportar
                    </button> --}}
                    <button class="btn btn-primary">
                        <i class="bi bi-plus-lg me-2"></i>Nueva Cita
                    </button>
                </div>
            </div>

            <!-- Stats Cards -->
            <div class="row g-4 mb-4">
                <div class="col-xl-3 col-md-6">
                    <div class="stat-card">
                        <div class="stat-card-body">
                            <div class="stat-icon bg-primary-subtle">
                                <i class="bi bi-people text-primary"></i>
                            </div>
                            <div class="stat-content">
                                <span class="stat-label">Total Clientes</span>
                                <h3 class="stat-value" id="totalClientes">0</h3>
                                {{-- <span class="stat-change positive">
                                    <i class="bi bi-arrow-up"></i> 12% vs mes anterior
                                </span> --}}
                            </div>
                        </div>
                        <div class="stat-card-footer">
                            <a href="{{ route('clientes.index') }}" data-page="clientes">
                                Ver todos <i class="bi bi-arrow-right"></i>
                            </a>
                        </div>
                    </div>
                </div>
                <div class="col-xl-3 col-md-6">
                    <div class="stat-card">
                        <div class="stat-card-body">
                            <div class="stat-icon bg-success-subtle">
                                <i class="bi bi-heart text-success"></i>
                            </div>
                            <div class="stat-content">
                                <span class="stat-label">Total Mascotas</span>
                                <h3 class="stat-value" id="totalMascotas">0</h3>
                                {{-- <span class="stat-change positive">
                                    <i class="bi bi-arrow-up"></i> 8% vs mes anterior
                                </span> --}}
                            </div>
                        </div>
                        <div class="stat-card-footer">
                            <a href="{{ route('mascotas.index') }}" data-page="mascotas">
                                Ver todos <i class="bi bi-arrow-right"></i>
                            </a>
                        </div>
                    </div>
                </div>
                <div class="col-xl-3 col-md-6">
                    <div class="stat-card">
                        <div class="stat-card-body">
                            <div class="stat-icon bg-warning-subtle">
                                <i class="bi bi-calendar-check text-warning"></i>
                            </div>
                            <div class="stat-content">
                                <span class="stat-label">Citas Hoy</span>
                                <h3 class="stat-value">0</h3>
                                {{-- <span class="stat-change neutral">
                                    <i class="bi bi-dash"></i> Sin cambios
                                </span> --}}
                            </div>
                        </div>
                        <div class="stat-card-footer">
                            <a href="#">
                                Ver agenda <i class="bi bi-arrow-right"></i>
                            </a>
                        </div>
                    </div>
                </div>
                <div class="col-xl-3 col-md-6">
                    <div class="stat-card">
                        <div class="stat-card-body">
                            <div class="stat-icon bg-info-subtle">
                                <i class="bi bi-file-earmark-medical text-info"></i>
                            </div>
                            <div class="stat-content">
                                <span class="stat-label">Prescripciones</span>
                                <h3 class="stat-value" id="totalPrescripciones">0</h3>
                                {{-- <span class="stat-change positive">
                                    <i class="bi bi-arrow-up"></i> 24% este mes
                                </span> --}}
                            </div>
                        </div>
                        <div class="stat-card-footer">
                            <a href="{{ route('prescripciones.index') }}" data-page="prescripciones">
                                Ver todos <i class="bi bi-arrow-right"></i>
                            </a>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Charts Row -->
            <div class="row g-4 mb-4">
                <div class="col-xl-8">
                    <div class="card">
                        <div class="card-header">
                            <h5 class="card-title mb-0">Clientes por Mes</h5>
                            <div class="card-actions">
                                <button class="btn btn-sm btn-outline-secondary">
                                    <i class="bi bi-three-dots"></i>
                                </button>
                            </div>
                        </div>
                        <div class="card-body">
                            <canvas id="clientesChart" height="300"></canvas>
                        </div>
                    </div>
                </div>
                <div class="col-xl-4">
                    <div class="card">
                        <div class="card-header">
                            <h5 class="card-title mb-0">Mascotas por Tipo</h5>
                            <div class="card-actions">
                                <button class="btn btn-sm btn-outline-secondary">
                                    <i class="bi bi-three-dots"></i>
                                </button>
                            </div>
                        </div>
                        <div class="card-body">
                            <canvas id="mascotasChart" height="300"></canvas>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Recent Activity -->
            <div class="row g-4">
                <div class="col-xl-6">
                    <div class="card">
                        <div class="card-header">
                            <h5 class="card-title mb-0">Últimas Consultas</h5>
                            <a href="{{ route('historiales.index') }}" class="btn btn-sm btn-link" data-page="historial">Ver todas</a>
                        </div>
                        <div class="card-body p-0">
                            <div class="activity-list" id="ultimasConsultas">
                                <!-- Dynamic content -->
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-xl-6">
                    <div class="card">
                        <div class="card-header">
                            <h5 class="card-title mb-0">Próximas Citas</h5>
                            <a href="#" class="btn btn-sm btn-link">Ver todas</a>
                        </div>
                        <div class="card-body p-0">
                            <div class="appointments-list">
                                <div class="appointment-item">
                                    <div class="appointment-time">
                                        <span class="time">09:00</span>
                                        <span class="period">AM</span>
                                    </div>
                                    <div class="appointment-info">
                                        <h6>Max - Consulta General</h6>
                                        <p>María González</p>
                                    </div>
                                    <span class="badge bg-primary-subtle text-primary">Confirmada</span>
                                </div>
                                <div class="appointment-item">
                                    <div class="appointment-time">
                                        <span class="time">10:30</span>
                                        <span class="period">AM</span>
                                    </div>
                                    <div class="appointment-info">
                                        <h6>Luna - Vacunación</h6>
                                        <p>Carlos Rodríguez</p>
                                    </div>
                                    <span class="badge bg-warning-subtle text-warning">Pendiente</span>
                                </div>
                                <div class="appointment-item">
                                    <div class="appointment-time">
                                        <span class="time">12:00</span>
                                        <span class="period">PM</span>
                                    </div>
                                    <div class="appointment-info">
                                        <h6>Rocky - Peluquería</h6>
                                        <p>Ana Martínez</p>
                                    </div>
                                    <span class="badge bg-success-subtle text-success">En proceso</span>
                                </div>
                                <div class="appointment-item">
                                    <div class="appointment-time">
                                        <span class="time">03:00</span>
                                        <span class="period">PM</span>
                                    </div>
                                    <div class="appointment-info">
                                        <h6>Mia - Control</h6>
                                        <p>Pedro López</p>
                                    </div>
                                    <span class="badge bg-primary-subtle text-primary">Confirmada</span>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Clientes Page -->
        <div class="page d-none" id="page-clientes">
            <div class="page-header">
                <div>
                    <h1 class="page-title">Clientes</h1>
                    <p class="page-subtitle">Gestiona la información de tus clientes</p>
                </div>
                <div class="page-actions">
                    <button class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#clienteModal">
                        <i class="bi bi-plus-lg me-2"></i>Nuevo Cliente
                    </button>
                </div>
            </div>

            <div class="card">
                <div class="card-header">
                    <div class="d-flex align-items-center gap-3">
                        <div class="search-box">
                            <i class="bi bi-search"></i>
                            <input type="text" id="searchClientes" placeholder="Buscar clientes...">
                        </div>
                    </div>
                </div>
                <div class="card-body p-0">
                    <div class="table-responsive">
                        <table class="table table-hover mb-0">
                            <thead>
                                <tr>
                                    <th>ID</th>
                                    <th>Nombre</th>
                                    <th>Teléfono</th>
                                    <th>Email</th>
                                    <th>Mascotas</th>
                                    <th>Acciones</th>
                                </tr>
                            </thead>
                            <tbody id="clientesTableBody">
                                <!-- Dynamic content -->
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>

        <!-- Mascotas Page -->
        <div class="page d-none" id="page-mascotas">
            <div class="page-header">
                <div>
                    <h1 class="page-title">Mascotas</h1>
                    <p class="page-subtitle">Gestiona la información de las mascotas</p>
                </div>
                <div class="page-actions">
                    <button class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#mascotaModal">
                        <i class="bi bi-plus-lg me-2"></i>Nueva Mascota
                    </button>
                </div>
            </div>

            <div class="card">
                <div class="card-header">
                    <div class="d-flex align-items-center gap-3">
                        <div class="search-box">
                            <i class="bi bi-search"></i>
                            <input type="text" id="searchMascotas" placeholder="Buscar mascotas...">
                        </div>
                    </div>
                </div>
                <div class="card-body p-0">
                    <div class="table-responsive">
                        <table class="table table-hover mb-0">
                            <thead>
                                <tr>
                                    <th>ID</th>
                                    <th>Nombre</th>
                                    <th>Tipo</th>
                                    <th>Raza</th>
                                    <th>Edad</th>
                                    <th>Propietario</th>
                                    <th>Acciones</th>
                                </tr>
                            </thead>
                            <tbody id="mascotasTableBody">
                                <!-- Dynamic content -->
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>

        <!-- Historial Clínico Page -->
        <div class="page d-none" id="page-historial">
            <div class="page-header">
                <div>
                    <h1 class="page-title">Historial Clínico</h1>
                    <p class="page-subtitle">Registro de consultas y tratamientos</p>
                </div>
                <div class="page-actions">
                    <button class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#historialModal">
                        <i class="bi bi-plus-lg me-2"></i>Nueva Consulta
                    </button>
                </div>
            </div>

            <div class="card">
                <div class="card-header">
                    <div class="d-flex align-items-center gap-3 flex-wrap">
                        <div class="search-box">
                            <i class="bi bi-search"></i>
                            <input type="text" id="searchHistorial" placeholder="Buscar...">
                        </div>
                        <select class="form-select" id="filterMascotaHistorial" style="width: auto;">
                            <option value="">Todas las mascotas</option>
                        </select>
                    </div>
                </div>
                <div class="card-body p-0">
                    <div class="table-responsive">
                        <table class="table table-hover mb-0">
                            <thead>
                                <tr>
                                    <th>ID</th>
                                    <th>Fecha</th>
                                    <th>Mascota</th>
                                    <th>Diagnóstico</th>
                                    <th>Tratamiento</th>
                                    <th>Acciones</th>
                                </tr>
                            </thead>
                            <tbody id="historialTableBody">
                                <!-- Dynamic content -->
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>

        <!-- Prescripciones Page -->
        <div class="page d-none" id="page-prescripciones">
            <div class="page-header">
                <div>
                    <h1 class="page-title">Prescripciones</h1>
                    <p class="page-subtitle">Recetas médicas para mascotas</p>
                </div>
                <div class="page-actions">
                    <button class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#prescripcionModal">
                        <i class="bi bi-plus-lg me-2"></i>Nueva Prescripción
                    </button>
                </div>
            </div>

            <div class="card">
                <div class="card-header">
                    <div class="d-flex align-items-center gap-3">
                        <div class="search-box">
                            <i class="bi bi-search"></i>
                            <input type="text" id="searchPrescripciones" placeholder="Buscar prescripciones...">
                        </div>
                    </div>
                </div>
                <div class="card-body p-0">
                    <div class="table-responsive">
                        <table class="table table-hover mb-0">
                            <thead>
                                <tr>
                                    <th>ID</th>
                                    <th>Fecha</th>
                                    <th>Mascota</th>
                                    <th>Medicamentos</th>
                                    <th>Indicaciones</th>
                                    <th>Acciones</th>
                                </tr>
                            </thead>
                            <tbody id="prescripcionesTableBody">
                                <!-- Dynamic content -->
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>

        <!-- Configuración Page -->
        <div class="page d-none" id="page-configuracion">
            <div class="page-header">
                <div>
                    <h1 class="page-title">Configuración</h1>
                    <p class="page-subtitle">Ajustes del sistema</p>
                </div>
            </div>

            <div class="row g-4">
                <div class="col-lg-6">
                    <div class="card">
                        <div class="card-header">
                            <h5 class="card-title mb-0">Información de la Clínica</h5>
                        </div>
                        <div class="card-body">
                            <form>
                                <div class="mb-3">
                                    <label class="form-label">Nombre de la Clínica</label>
                                    <input type="text" class="form-control" value="VetSync">
                                </div>
                                <div class="mb-3">
                                    <label class="form-label">Dirección</label>
                                    <input type="text" class="form-control" value="Av. Principal #123">
                                </div>
                                <div class="mb-3">
                                    <label class="form-label">Teléfono</label>
                                    <input type="text" class="form-control" value="+1 234 567 890">
                                </div>
                                <div class="mb-3">
                                    <label class="form-label">Email</label>
                                    <input type="email" class="form-control" value="info@vetcarepro.com">
                                </div>
                                <button type="button" class="btn btn-primary">Guardar Cambios</button>
                            </form>
                        </div>
                    </div>
                </div>
                <div class="col-lg-6">
                    <div class="card">
                        <div class="card-header">
                            <h5 class="card-title mb-0">Preferencias</h5>
                        </div>
                        <div class="card-body">
                            <div class="form-check form-switch mb-3">
                                <input class="form-check-input" type="checkbox" id="darkModeSwitch">
                                <label class="form-check-label" for="darkModeSwitch">Modo Oscuro</label>
                            </div>
                            <div class="form-check form-switch mb-3">
                                <input class="form-check-input" type="checkbox" id="notificationsSwitch" checked>
                                <label class="form-check-label" for="notificationsSwitch">Notificaciones</label>
                            </div>
                            <div class="form-check form-switch mb-3">
                                <input class="form-check-input" type="checkbox" id="emailAlertsSwitch" checked>
                                <label class="form-check-label" for="emailAlertsSwitch">Alertas por Email</label>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
