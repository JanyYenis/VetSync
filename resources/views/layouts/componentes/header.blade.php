<!-- Top Navbar -->
<nav class="top-navbar">
    <div class="d-flex align-items-center">
        <button class="sidebar-toggle me-3" id="sidebarToggle">
            <i class="bi bi-list"></i>
        </button>
        <div class="search-box d-none d-md-block">
            <i class="bi bi-search"></i>
            <input type="text" placeholder="Buscar...">
        </div>
    </div>
    <div class="navbar-actions">
        <button class="navbar-action-btn" id="themeToggle">
            <i class="bi bi-moon"></i>
        </button>
        <button class="navbar-action-btn position-relative">
            <i class="bi bi-bell"></i>
            <span class="notification-badge">3</span>
        </button>
        <div class="dropdown">
            <button class="navbar-action-btn dropdown-toggle" data-bs-toggle="dropdown">
                <img src="https://images.unsplash.com/photo-1472099645785-5658abf4ff4e?w=100&h=100&fit=crop"
                    alt="Admin" class="navbar-avatar">
            </button>
            <ul class="dropdown-menu dropdown-menu-end">
                <li>
                    <a class="dropdown-item" href="{{ route('perfil') }}">
                        <i class="bi bi-person me-2"></i>Mi Perfil
                    </a>
                </li>
                <li>
                    <a class="dropdown-item" href="#">
                        <i class="bi bi-gear me-2"></i>Configuración
                    </a>
                </li>
                <li>
                    <hr class="dropdown-divider">
                </li>
                <li>
                    <a class="dropdown-item text-danger" href="{{ route('logout') }}"
                        onclick="event.preventDefault(); document.getElementById('logout-form').submit();"
                        id="logoutBtn">
                        <i class="bi bi-box-arrow-right me-2"></i>Cerrar Sesión
                        <form id="logout-form" action="{{ route('logout') }}" method="POST" class="d-none">
                            @csrf
                        </form>
                    </a>
                </li>
            </ul>
        </div>
    </div>
</nav>
