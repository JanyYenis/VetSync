<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'VetSync') }} {{ isset($title) && $title ? '- '.$title : '' }}</title>

    <link rel="shortcut icon" href="{{ asset('build/img/logo_mini.png') }}">
    <!-- Bootstrap 5 CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- Bootstrap Icons -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.1/font/bootstrap-icons.css" rel="stylesheet">
    <!-- Google Fonts -->
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700;800&display=swap" rel="stylesheet">
    <link href="{{ asset('assets/plugins/global/plugins.bundle.css') }}" rel="stylesheet" type="text/css" />
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/intl-tel-input@18.2.1/build/css/intlTelInput.css">

    @routes
    <!-- Bootstrap 5 JS -->
    <script src="{{ asset('assets/js/scripts.bundle.js') }}"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
    <script src="{{ asset('assets/plugins/global/plugins.bundle.js') }}"></script>
    <script src="https://cdn.jsdelivr.net/npm/intl-tel-input@18.1.1/build/js/intlTelInput.min.js"></script>
    <script src="{{ asset('assets/plugins/custom/datatables/datatables.bundle.js') }}"></script>

    <!-- Custom CSS -->
    @vite(['resources/js/app.js', 'resources/css/login.css', 'resources/css/registro.css'])

    @section('imports')
    @show
</head>
<body>
    <div class="login-container">
        <!-- Left Side - Image -->
        <div class="login-image">
            <div class="login-image-overlay"></div>
            <img src="https://images.unsplash.com/photo-1548199973-03cce0bbc87b?w=1200&h=1600&fit=crop" alt="Mascotas">
            <div class="login-image-content">
                <div class="brand-logo">
                    <img src="{{ asset('build/img/logo_mini_white.png') }}" width="100%">
                </div>
                <h1 class="display-4 fw-bold text-white mb-3">VetSync</h1>
                <p class="lead text-white-50">Comienza a gestionar tu clinica veterinaria de forma profesional</p>
                {{-- <div class="mt-5">
                    <div class="d-flex align-items-center mb-3">
                        <div class="feature-icon">
                            <i class="bi bi-check-lg"></i>
                        </div>
                        <span class="text-white-50">Gestión de clientes y mascotas</span>
                    </div>
                    <div class="d-flex align-items-center mb-3">
                        <div class="feature-icon">
                            <i class="bi bi-check-lg"></i>
                        </div>
                        <span class="text-white-50">Historial clínico completo</span>
                    </div>
                    <div class="d-flex align-items-center">
                        <div class="feature-icon">
                            <i class="bi bi-check-lg"></i>
                        </div>
                        <span class="text-white-50">Prescripciones en PDF</span>
                    </div>
                </div> --}}
                <div class="features-list">
                    <div class="feature-item">
                        <div class="feature-icon">
                            <i class="bi bi-shield-check"></i>
                        </div>
                        <div>
                            <h6 class="text-white mb-1">Seguridad Garantizada</h6>
                            <small class="text-white-50">Tus datos siempre protegidos</small>
                        </div>
                    </div>
                    <div class="feature-item">
                        <div class="feature-icon">
                            <i class="bi bi-cloud-arrow-up"></i>
                        </div>
                        <div>
                            <h6 class="text-white mb-1">Respaldo en la Nube</h6>
                            <small class="text-white-50">Accede desde cualquier lugar</small>
                        </div>
                    </div>
                    <div class="feature-item">
                        <div class="feature-icon">
                            <i class="bi bi-headset"></i>
                        </div>
                        <div>
                            <h6 class="text-white mb-1">Soporte 24/7</h6>
                            <small class="text-white-50">Siempre disponibles para ti</small>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        @yield('content')
    </div>

</body>
</html>
