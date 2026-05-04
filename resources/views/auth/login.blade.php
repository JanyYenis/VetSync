@extends('layouts.app')

@section('imports')
    @vite(['resources/js/auth/login.js'])
@endsection

@section('content')
    <!-- Right Side - Form -->
    <div class="login-form-container">
        <div class="login-form-wrapper">
            <div class="text-center mb-5">
                <div class="brand-icon-sm d-lg-none mb-4">
                    <i class="bi bi-heart-pulse-fill"></i>
                </div>
                <h2 class="fw-bold mb-2">Bienvenido de nuevo</h2>
                <p class="text-muted">Ingresa tus credenciales para acceder al sistema</p>
            </div>

            <form method="POST" action="{{ route('login') }}">
                @csrf
                <div class="mb-4">
                    <label class="form-label fw-medium">Usuario</label>
                    <div class="input-group input-group-lg">
                        <span class="input-group-text bg-light border-end-0">
                            <i class="bi bi-person text-muted"></i>
                        </span>
                        <input type="text" class="form-control border-start-0 ps-0 @error('email') is-invalid @enderror" id="email"
                            placeholder="Ingresa tu usuario" name="email" required value="{{ old('email') }}">
                    </div>
                    @error('email')
                        <span class="invalid-feedback" role="alert">
                            <strong>{{ $message }}</strong>
                        </span>
                    @enderror
                    <div class="invalid-feedback" id="usernameError"></div>
                </div>

                <div class="mb-4">
                    <label class="form-label fw-medium">Contraseña</label>
                    <div class="input-group input-group-lg">
                        <span class="input-group-text bg-light border-end-0">
                            <i class="bi bi-lock text-muted"></i>
                        </span>
                        <input type="password" class="form-control border-start-0 border-end-0 ps-0 @error('password') is-invalid @enderror"
                            name="password" autocomplete="current-password" id="password"
                            placeholder="Ingresa tu contraseña" required>
                        <button class="btn btn-light border border-start-0" type="button" id="togglePassword">
                            <i class="bi bi-eye"></i>
                        </button>
                    </div>
                    @error('password')
                        <span class="invalid-feedback" role="alert">
                            <strong>{{ $message }}</strong>
                        </span>
                    @enderror
                    <div class="invalid-feedback" id="passwordError"></div>
                </div>

                <div class="d-flex justify-content-between align-items-center mb-4">
                    <div class="form-check">
                        <input class="form-check-input" type="checkbox" name="remember" id="remember" {{ old('remember') ? 'checked' : '' }}>
                        <label class="form-check-label text-muted" for="remember">
                            Recordarme
                        </label>
                    </div>
                    <a href="{{ route('password.request') }}" class="text-primary text-decoration-none small">¿Olvidaste tu contraseña?</a>
                </div>

                <button type="submit" class="btn btn-primary btn-lg w-100 mb-4" id="loginBtn">
                    <span class="btn-text">Iniciar Sesión</span>
                    <span class="btn-loader d-none">
                        <span class="spinner-border spinner-border-sm me-2"></span>
                        Verificando...
                    </span>
                </button>

                <div class="alert alert-danger d-none" id="loginError">
                    <i class="bi bi-exclamation-circle me-2"></i>
                    <span id="loginErrorText"></span>
                </div>

                <div class="text-center">
                    <p class="text-muted mb-0">
                        <a href="{{ url('/') }}" class="text-primary text-decoration-none">
                            <i class="bi bi-arrow-left me-1"></i>Volver al inicio
                        </a>
                    </p>
                    <p class="text-muted mt-3 mb-0">
                        No tienes cuenta? <a href="{{ route('register') }}" class="text-primary text-decoration-none fw-medium">Registrate aqui</a>
                    </p>
                </div>
            </form>
        </div>
    </div>
@endsection
