<!-- Sidebar -->
<aside class="sidebar" id="sidebar">
    <div class="sidebar-header">
        <div class="brand">
            <div class="brand-icon">
                <img src="{{ asset('build/img/logo_mini_white.png') }}" width="100%">
            </div>
            <span class="brand-text text-primary">VetSync</span>
        </div>
        <button class="sidebar-toggle d-lg-none" id="sidebarClose">
            <i class="bi bi-x-lg"></i>
        </button>
    </div>

    <nav class="sidebar-nav">
        <div class="nav-section">
            <span class="nav-section-title">Principal</span>
            <ul class="nav flex-column">
                <li class="nav-item">
                    <a class="nav-link active" href="{{ route('home') }}" data-page="dashboard">
                        <i class="bi bi-grid-1x2"></i>
                        <span>Dashboard</span>
                    </a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="{{ route('clientes.index') }}" data-page="clientes">
                        <i class="bi bi-people"></i>
                        <span>Clientes</span>
                    </a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="{{ route('mascotas.index') }}" data-page="mascotas">
                        <i class="bi bi-heart"></i>
                        <span>Mascotas</span>
                    </a>
                </li>
            </ul>
        </div>

        <div class="nav-section">
            <span class="nav-section-title">Atención</span>
            <ul class="nav flex-column">
                <li class="nav-item">
                    <a class="nav-link" href="{{ route('historiales.index') }}" data-page="historial">
                        <i class="bi bi-clipboard2-pulse"></i>
                        <span>Historial Clínico</span>
                    </a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="{{ route('prescripciones.index') }}" data-page="prescripciones">
                        <i class="bi bi-file-earmark-medical"></i>
                        <span>Prescripciones</span>
                    </a>
                </li>
            </ul>
        </div>

        <div class="nav-section">
            <span class="nav-section-title">Sistema</span>
            <ul class="nav flex-column">
                <li class="nav-item">
                    <a class="nav-link" href="#" data-page="usuarios">
                        <i class="bi bi-person-workspace"></i>
                        <span>Usuarios</span>
                    </a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="{{ route('planes.index') }}" data-page="planes">
                        <i class="bi bi-tag-fill"></i>
                        <span>Planes</span>
                    </a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="{{ route('clinicas.index') }}" data-page="clinica">
                        <i class="bi bi-hospital"></i>
                        <span>Clinica(s)</span>
                    </a>
                </li>
            </ul>
        </div>
    </nav>

    <div class="sidebar-footer">
        <div class="user-info">
            <div class="user-avatar">
                <img src="https://images.unsplash.com/photo-1472099645785-5658abf4ff4e?w=100&h=100&fit=crop"
                    alt="Admin">
            </div>
            <div class="user-details">
                <span class="user-name">{{ auth()->user()->nombre_completo }}</span>
                <span class="user-role">Administrador</span>
            </div>
        </div>
    </div>
</aside>
