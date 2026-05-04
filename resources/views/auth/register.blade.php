@extends('layouts.app')

@section('imports')
    @vite(['resources/js/auth/registro.js'])
@endsection

@section('content')
    {{-- <div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">{{ __('Register') }}</div>

                <div class="card-body">
                    <form method="POST" action="{{ route('register') }}">
                        @csrf

                        <div class="row mb-3">
                            <label for="name" class="col-md-4 col-form-label text-md-end">{{ __('Name') }}</label>

                            <div class="col-md-6">
                                <input id="name" type="text" class="form-control @error('name') is-invalid @enderror" name="name" value="{{ old('name') }}" required autocomplete="name" autofocus>

                                @error('name')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>

                        <div class="row mb-3">
                            <label for="lastName" class="col-md-4 col-form-label text-md-end">{{ __('Last Name') }}</label>

                            <div class="col-md-6">
                                <input id="lastName" type="text" class="form-control @error('last_name') is-invalid @enderror" name="last_name" value="{{ old('last_name') }}" required autocomplete="last_name" autofocus>

                                @error('last_name')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>

                        <div class="row mb-3">
                            <label for="email" class="col-md-4 col-form-label text-md-end">{{ __('Email Address') }}</label>

                            <div class="col-md-6">
                                <input id="email" type="email" class="form-control @error('email') is-invalid @enderror" name="email" value="{{ old('email') }}" required autocomplete="email">

                                @error('email')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>

                        <div class="row mb-3">
                            <label for="password" class="col-md-4 col-form-label text-md-end">{{ __('Password') }}</label>

                            <div class="col-md-6">
                                <input id="password" type="password" class="form-control @error('password') is-invalid @enderror" name="password" required autocomplete="new-password">

                                @error('password')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>

                        <div class="row mb-3">
                            <label for="password-confirm" class="col-md-4 col-form-label text-md-end">{{ __('Confirm Password') }}</label>

                            <div class="col-md-6">
                                <input id="password-confirm" type="password" class="form-control" name="password_confirmation" required autocomplete="new-password">
                            </div>
                        </div>

                        <div class="row mb-0">
                            <div class="col-md-6 offset-md-4">
                                <button type="submit" class="btn btn-primary">
                                    {{ __('Register') }}
                                </button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div> --}}

    <!-- Right Side - Form -->
    <div class="register-form-container">
        <div class="register-form-wrapper">
            <!-- Header -->
            <div class="text-center mb-4">
                <div class="brand-icon-sm d-lg-none mb-3">
                    <i class="bi bi-heart-pulse-fill"></i>
                </div>
                <h2 class="fw-bold mb-2">Crea tu cuenta</h2>
                <p class="text-muted">Completa el registro en solo 2 pasos</p>
            </div>

            <!-- Progress Steps -->
            <div class="stepper-container mb-4">
                <div class="stepper">
                    <div class="step active" data-step="1">
                        <div class="step-circle">
                            <span class="step-number">1</span>
                            <i class="bi bi-check-lg step-check"></i>
                        </div>
                        <span class="step-label">Usuario</span>
                    </div>
                    <div class="step-line"></div>
                    <div class="step" data-step="2">
                        <div class="step-circle">
                            <span class="step-number">2</span>
                            <i class="bi bi-check-lg step-check"></i>
                        </div>
                        <span class="step-label">Clinica</span>
                    </div>
                </div>
                <div class="progress-bar-container">
                    <div class="progress-bar-fill" id="progressBar"></div>
                </div>
            </div>

            <!-- Alert Messages -->
            <div class="alert alert-danger d-none" id="errorAlert">
                <i class="bi bi-exclamation-circle me-2"></i>
                <span id="errorText"></span>
            </div>
            <div class="alert alert-success d-none" id="successAlert">
                <i class="bi bi-check-circle me-2"></i>
                <span id="successText"></span>
            </div>

            <!-- Form -->
            <form method="POST" action="{{ route('register') }}" enctype="multipart/form-data">
                @csrf
                <!-- Step 1: User Data -->
                <div class="form-step active" id="step1">
                    <h5 class="section-title mb-4">
                        <i class="bi bi-person-circle me-2"></i>Datos del Usuario
                    </h5>

                    <div class="row g-3">
                        <!-- Nombre -->
                        <div class="col-md-6">
                            <label class="form-label">Nombre <span class="text-danger">*</span></label>
                            <div class="input-icon">
                                <i class="bi bi-person"></i>
                                <input type="text" class="form-control" id="nombre" name="nombre" placeholder="Tu nombre" required>
                            </div>
                            <div class="invalid-feedback">El nombre es requerido</div>
                        </div>

                        <!-- Apellido -->
                        <div class="col-md-6">
                            <label class="form-label">Apellido <span class="text-danger">*</span></label>
                            <div class="input-icon">
                                <i class="bi bi-person"></i>
                                <input type="text" class="form-control" id="apellido" name="apellido" placeholder="Tu apellido"
                                    required>
                            </div>
                            <div class="invalid-feedback">El apellido es requerido</div>
                        </div>

                        <!-- Genero -->
                        <div class="col-md-6">
                            <label class="form-label">Genero <span class="text-danger">*</span></label>
                            <div class="input-icon">
                                <i class="bi bi-gender-ambiguous"></i>
                                <select class="form-select" id="genero" data-control="select2"
                                    data-placeholder="Seleccione el genero" data-allow-clear="true"
                                    data-hide-search="true" name="genero" required>
                                    <option value=""></option>
                                    @foreach ($generos as $item)
                                        <option value="{{ $item?->codigo }}">{{ $item?->nombre ?? 'N/A' }}</option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="invalid-feedback">Selecciona tu genero</div>
                        </div>

                        <!-- Tipo de Identidad -->
                        <div class="col-md-6">
                            <label class="form-label">Tipo de Identidad <span class="text-danger">*</span></label>
                            <div class="input-icon">
                                <i class="bi bi-card-text"></i>
                                <select class="form-select" id="tipoIdentidad" data-control="select2"
                                    data-placeholder="Seleccione el tipo de identificación" data-allow-clear="true"
                                    data-hide-search="true" name="tipo_identificacion" required>
                                    <option value=""></option>
                                    @foreach ($tipo_documentos as $item)
                                        <option value="{{ $item?->codigo }}">{{ $item?->nombre ?? 'N/A' }}</option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="invalid-feedback">Selecciona el tipo de identidad</div>
                        </div>

                        <!-- Numero de Identidad -->
                        <div class="col-12">
                            <label class="form-label">Numero de Identidad <span class="text-danger">*</span></label>
                            <div class="input-icon">
                                <i class="bi bi-123"></i>
                                <input type="text" class="form-control" id="numeroIdentidad"
                                    placeholder="Numero de documento" name="identificacion" required>
                            </div>
                            <div class="invalid-feedback">El numero de identidad es requerido</div>
                        </div>

                        <!-- Email -->
                        <div class="col-12">
                            <label class="form-label">Correo Electronico <span class="text-danger">*</span></label>
                            <div class="input-icon">
                                <i class="bi bi-envelope"></i>
                                <input type="email" class="form-control" name="email" id="email"
                                    placeholder="correo@ejemplo.com" required>
                            </div>
                            <div class="invalid-feedback">Ingresa un correo valido</div>
                        </div>

                        <!-- Pais -->
                        <div class="col-md-6">
                            <label class="form-label">Pais <span class="text-danger">*</span></label>
                            <div class="input-icon">
                                <i class="bi bi-globe"></i>
                                <select class="form-select" id="pais" name="cod_pais" required>
                                    <option value="">Seleccione un país</option>
                                    @foreach ($paises as $pais)
                                        <option value="{{$pais->id}}" data-kt-select2-country="{{$pais->bandera}}">{{$pais->nombre}} - {{$pais->nombre_corto}}</option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="invalid-feedback">Selecciona tu pais</div>
                        </div>

                        <!-- Ciudad -->
                        <div class="col-md-6">
                            <label class="form-label">Ciudad <span class="text-danger">*</span></label>
                            <div class="input-icon">
                                <i class="bi bi-geo-alt"></i>
                                <select class="form-select" id="ciudad" name="cod_ciudad" required disabled
                                    data-control="select2" data-placeholder="Seleccione una ciudad"
                                    data-allow-clear="true">
                                    <option value="">Selecciona un pais primero</option>
                                </select>
                            </div>
                            <div class="invalid-feedback">Selecciona tu ciudad</div>
                        </div>

                        <!-- Telefono -->
                        <div class="col-12">
                            <label class="form-label">Telefono <span class="text-danger">*</span></label>
                            <div class="input-icon">
                                <i class="bi bi-telephone"></i>
                                <input type="tel" class="form-control" name="telefono" id="telefono"
                                    placeholder="Numero de telefono" required>
                            </div>
                            <div class="invalid-feedback">El telefono es requerido</div>
                        </div>

                        <!-- Password -->
                        <div class="col-md-6">
                            <label class="form-label">Contrasena <span class="text-danger">*</span></label>
                            <div class="input-icon">
                                <i class="bi bi-lock"></i>
                                <input type="password" class="form-control" id="password"
                                    placeholder="Min. 8 caracteres" name="password" required minlength="8">
                                <button type="button" class="btn-toggle-password" tabindex="-1">
                                    <i class="bi bi-eye"></i>
                                </button>
                            </div>
                            <div class="password-strength mt-2">
                                <div class="strength-bar">
                                    <div class="strength-fill" id="strengthFill"></div>
                                </div>
                                <small class="strength-text" id="strengthText">Fuerza de la contrasena</small>
                            </div>
                            <div class="invalid-feedback">Minimo 8 caracteres</div>
                        </div>

                        <!-- Confirm Password -->
                        <div class="col-md-6">
                            <label class="form-label">Confirmar Contrasena <span class="text-danger">*</span></label>
                            <div class="input-icon">
                                <i class="bi bi-lock-fill"></i>
                                <input type="password" class="form-control" id="confirmPassword"
                                    placeholder="Repite la contrasena" name="password_confirmation" required>
                                <button type="button" class="btn-toggle-password" tabindex="-1">
                                    <i class="bi bi-eye"></i>
                                </button>
                            </div>
                            <div class="password-match" id="passwordMatch">
                                <i class="bi bi-check-circle-fill text-success"></i>
                                <span>Las contrasenas coinciden</span>
                            </div>
                            <div class="invalid-feedback">Las contrasenas no coinciden</div>
                        </div>
                    </div>

                    <!-- Next Button -->
                    <div class="d-flex justify-content-between mt-4 pt-3">
                        <a href="{{ route('login') }}" class="btn btn-outline-secondary">
                            <i class="bi bi-arrow-left me-2"></i>Volver al Login
                        </a>
                        <button type="button" class="btn btn-primary btn-next" id="btnStep1">
                            Siguiente<i class="bi bi-arrow-right ms-2"></i>
                        </button>
                    </div>
                </div>

                <!-- Step 2: Clinic Data -->
                <div class="form-step" id="step2">
                    <h5 class="section-title mb-4">
                        <i class="bi bi-building me-2"></i>Datos de la Clinica
                    </h5>

                    <div class="row g-3">
                        <!-- Logo Upload -->
                        <div class="col-12">
                            <label class="form-label">Logo de la Clinica</label>
                            <div class="logo-upload-container">
                                <div class="logo-preview" id="logoPreview">
                                    <i class="bi bi-building"></i>
                                </div>
                                <div class="logo-upload-info">
                                    <input type="file" name="foto" class="d-none" id="logoInput" accept="image/*">
                                    <button type="button" class="btn btn-outline-primary btn-sm" id="btnUploadLogo">
                                        <i class="bi bi-upload me-2"></i>Subir Logo
                                    </button>
                                    <small class="text-muted d-block mt-2">PNG, JPG hasta 2MB</small>
                                </div>
                            </div>
                        </div>

                        <!-- Nombre Clinica -->
                        <div class="col-md-6">
                            <label class="form-label">Nombre o Razon Social <span class="text-danger">*</span></label>
                            <div class="input-icon">
                                <i class="bi bi-building"></i>
                                <input type="text" class="form-control" name="razon_social" id="nombreClinica"
                                    placeholder="Nombre de la clinica" required>
                            </div>
                            <div class="invalid-feedback">El nombre es requerido</div>
                        </div>

                        <!-- NIT Clinica -->
                        <div class="col-md-6">
                            <label class="form-label">NIT <span class="text-danger">*</span></label>
                            <div class="input-icon">
                                <i class="bi bi-upc"></i>
                                <input type="text" class="form-control" name="nit" id="nitClinica"
                                    placeholder="NIT de la clinica" required>
                            </div>
                            <div class="invalid-feedback">El NIT es requerido</div>
                        </div>

                        <!-- Direccion -->
                        <div class="col-12">
                            <label class="form-label">Direccion <span class="text-danger">*</span></label>
                            <div class="input-icon">
                                <i class="bi bi-geo-alt-fill"></i>
                                <input type="text" class="form-control" name="direccion" id="direccionClinica"
                                    placeholder="Direccion completa" required>
                            </div>
                            <div class="invalid-feedback">La direccion es requerida</div>
                        </div>

                        <!-- Email Clinica -->
                        <div class="col-md-6">
                            <label class="form-label">Correo de la Clinica <span class="text-danger">*</span></label>
                            <div class="input-icon">
                                <i class="bi bi-envelope-fill"></i>
                                <input type="email" class="form-control" name="email_clinica" id="emailClinica"
                                    placeholder="contacto@clinica.com" required>
                            </div>
                            <div class="invalid-feedback">Ingresa un correo valido</div>
                        </div>

                        <!-- Telefono Clinica -->
                        <div class="col-md-6">
                            <label class="form-label">Telefono de la Clinica <span class="text-danger">*</span></label>
                            <div class="input-icon">
                                <i class="bi bi-telephone-fill"></i>
                                <input type="tel" class="form-control" name="telefono_clinica" id="telefonoClinica"
                                    placeholder="Telefono de contacto" required>
                            </div>
                            <div class="invalid-feedback">El telefono es requerido</div>
                        </div>

                        <!-- Redes Sociales -->
                        <div class="col-12">
                            <label class="form-label">Redes Sociales <small class="text-muted">(Opcional)</small></label>
                        </div>

                        <!-- Instagram -->
                        <div class="col-md-4">
                            <div class="input-icon social-input">
                                <i class="bi bi-instagram"></i>
                                <input type="url" class="form-control" id="instagram"
                                    placeholder="Instagram URL" name="instagram">
                            </div>
                        </div>

                        <!-- Facebook -->
                        <div class="col-md-4">
                            <div class="input-icon social-input">
                                <i class="bi bi-facebook"></i>
                                <input type="url" class="form-control" id="facebook"
                                    placeholder="Facebook URL" name="facebook">
                            </div>
                        </div>

                        <!-- TikTok -->
                        <div class="col-md-4">
                            <div class="input-icon social-input">
                                <i class="bi bi-tiktok"></i>
                                <input type="url" class="form-control" id="tiktok"
                                    placeholder="TikTok URL" name="tiktok">
                            </div>
                        </div>

                        <!-- Terms -->
                        <div class="col-12 mt-3">
                            <div class="form-check">
                                <input class="form-check-input" type="checkbox" id="termsCheck" required>
                                <label class="form-check-label" for="termsCheck">
                                    Acepto los <a href="#" class="text-primary">Terminos y Condiciones</a>
                                    y la <a href="#" class="text-primary">Politica de Privacidad</a>
                                </label>
                                <div class="invalid-feedback">Debes aceptar los terminos</div>
                            </div>
                        </div>
                    </div>

                    <!-- Buttons -->
                    <div class="d-flex justify-content-between mt-4 pt-3">
                        <button type="button" class="btn btn-outline-secondary btn-prev" id="btnPrev">
                            <i class="bi bi-arrow-left me-2"></i>Anterior
                        </button>
                        <button type="submit" class="btn btn-success btn-submit" id="btnSubmit">
                            <span class="btn-text">
                                <i class="bi bi-check-circle me-2"></i>Completar Registro
                            </span>
                            <span class="btn-loader d-none">
                                <span class="spinner-border spinner-border-sm me-2"></span>
                                Registrando...
                            </span>
                        </button>
                    </div>
                </div>
            </form>

            <!-- Success State -->
            <div class="success-state d-none" id="successState">
                <div class="success-icon">
                    <i class="bi bi-check-lg"></i>
                </div>
                <h3 class="fw-bold mb-3">Registro Exitoso!</h3>
                <p class="text-muted mb-4">Tu cuenta y clinica han sido registradas correctamente. Ya puedes iniciar
                    sesion.</p>
                <a href="{{ route('login') }}" class="btn btn-primary btn-lg">
                    <i class="bi bi-box-arrow-in-right me-2"></i>Iniciar Sesion
                </a>
            </div>

            <!-- Footer -->
            <div class="text-center mt-4 pt-3 border-top">
                <small class="text-muted">
                    Ya tienes cuenta? <a href="{{ route('login') }}" class="text-primary fw-medium">Inicia sesion aqui</a>
                </small>
            </div>
        </div>
    </div>
@endsection
