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
    <!-- Lightbox CSS -->
    <link href="https://cdnjs.cloudflare.com/ajax/libs/lightbox2/2.11.4/css/lightbox.min.css" rel="stylesheet">

    <link href="{{ asset('assets/plugins/global/plugins.bundle.css') }}" rel="stylesheet" type="text/css" />

    @routes
    <!-- Bootstrap 5 JS -->
    <script src="{{ asset('assets/js/scripts.bundle.js') }}"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
    <script src="{{ asset('assets/plugins/global/plugins.bundle.js') }}"></script>

    <!-- Custom CSS -->
    @vite(['resources/css/landing.css', 'resources/js/landing.js'])

    @section('imports')
    @show
</head>
<body>

    <!-- Navbar -->
    <nav class="navbar navbar-expand-lg navbar-light bg-white fixed-top shadow-sm">
        <div class="container">
            <a class="navbar-brand d-flex align-items-center" href="#">
                <div class="brand-icon me-2">
                    <img src="{{ asset('build/img/logo_mini_white.png') }}" width="100%">
                </div>
                <span class="fw-bold">VetSync</span>
            </a>
            <button class="navbar-toggler border-0" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarNav">
                <ul class="navbar-nav mx-auto">
                    <li class="nav-item">
                        <a class="nav-link active" href="{{ url('/') }}#inicio">Inicio</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="{{ url('/') }}#servicios">Servicios</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="{{ url('/') }}#galeria">Galería</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="{{ url('/') }}#testimonios">Testimonios</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="{{ route('precios') }}">Precios</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="{{ url('/') }}#contacto">Contacto</a>
                    </li>
                </ul>
                @if (Route::has('login'))
                    @auth
                        <a href="{{ route('home') }}" class="btn btn-primary px-4 rounded-pill">
                            <i class="bi bi-box-arrow-in-right me-2"></i>Dashboard
                        </a>
                    @else
                        <div class="d-flex gap-2">
                            <a href="{{ route('login') }}" class="btn btn-outline-primary px-4 rounded-pill">
                                <i class="bi bi-box-arrow-in-right me-2"></i>Iniciar Sesión
                            </a>
                            <a href="{{ route('register') }}" class="btn btn-primary px-4 rounded-pill">
                                Empezar Gratis
                            </a>
                        </div>
                    @endauth
                @endif
            </div>
        </div>
    </nav>

    @yield('content')

    <!-- Footer -->
    <footer class="footer">
        <div class="container">
            <div class="row g-4">
                <div class="col-lg-4">
                    <div class="d-flex align-items-center mb-3">
                        <div class="brand-icon me-2">
                            <img src="{{ asset('build/img/logo_mini_white.png') }}" width="100%">
                        </div>
                        <span class="fw-bold text-white fs-4">VetSync</span>
                    </div>
                    <p class="text-white-50">Cuidamos a tu mejor amigo con dedicación y profesionalismo desde hace más de 15 años.</p>
                    <div class="social-links">
                        <a href="#"><i class="bi bi-facebook"></i></a>
                        <a href="#"><i class="bi bi-instagram"></i></a>
                        <a href="#"><i class="bi bi-twitter-x"></i></a>
                        <a href="#"><i class="bi bi-youtube"></i></a>
                    </div>
                </div>
                <div class="col-lg-2 col-md-6">
                    <h6 class="fw-bold text-white mb-3">Enlaces</h6>
                    <ul class="list-unstyled footer-links">
                        <li><a href="{{ url('/') }}#inicio">Inicio</a></li>
                        <li><a href="{{ url('/') }}#servicios">Servicios</a></li>
                        <li><a href="{{ url('/') }}#galeria">Galería</a></li>
                        <li><a href="{{ url('/') }}#contacto">Contacto</a></li>
                    </ul>
                </div>
                <div class="col-lg-3 col-md-6">
                    <h6 class="fw-bold text-white mb-3">Servicios</h6>
                    <ul class="list-unstyled footer-links">
                        <li><a href="#">Consulta General</a></li>
                        <li><a href="#">Vacunación</a></li>
                        <li><a href="#">Cirugías</a></li>
                        <li><a href="#">Peluquería</a></li>
                    </ul>
                </div>
                <div class="col-lg-3">
                    <h6 class="fw-bold text-white mb-3">Contacto</h6>
                    <ul class="list-unstyled footer-links">
                        <li><i class="bi bi-geo-alt me-2"></i>Corregimiento de Navarro, Callejón el recuerdo, Casa 46</li>
                        <li><i class="bi bi-telephone me-2"></i>+57 317 178 9584</li>
                        <li><i class="bi bi-envelope me-2"></i>info@gijac.com</li>
                    </ul>
                </div>
            </div>
            <hr class="my-4 border-secondary">
            <div class="text-center text-white-50">
                <p class="mb-0">&copy; {{ date('Y') }} GIJAC WEB. Todos los derechos reservados.</p>
            </div>
        </div>
    </footer>

    <!-- WhatsApp Button -->
    <a href="https://wa.me/573171789584" class="whatsapp-btn" target="_blank">
        <i class="bi bi-whatsapp"></i>
    </a>

    <!-- jQuery -->
    <script src="https://code.jquery.com/jquery-3.7.1.min.js"></script>
    <!-- Bootstrap JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
    <!-- Lightbox JS -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/lightbox2/2.11.4/js/lightbox.min.js"></script>
</body>
</html>
