@extends('layouts.index', ['title' => 'Perfil'])

@section('imports')
    @vite(['resources/css/perfil.css', 'resources/js/perfil.js'])
@endsection

@section('content')
    <!-- Page Content -->
    <div class="page-content">
        <!-- Page Header -->
        <div class="page-header">
            <div>
                <h1 class="page-title">Mi Perfil</h1>
                <p class="page-subtitle">Gestiona tu informacion personal y configuracion de seguridad</p>
            </div>
        </div>

        <!-- Alert Container -->
        <div id="alertContainer"></div>

        <!-- Profile Layout -->
        <div class="row g-4">
            <!-- Left Column - Profile Card -->
            <div class="col-xl-4">
                <div class="card profile-card">
                    <div class="card-body text-center">
                        <!-- Profile Photo -->
                        <div class="profile-photo-container">
                            <div class="profile-photo">
                                <img src="{{ $usuario?->foto ? asset('storage/'.$usuario?->foto ?? '#') : 'https://images.unsplash.com/photo-1472099645785-5658abf4ff4e?w=200&h=200&fit=crop' }}"
                                    alt="Foto de perfil" id="profilePhoto">
                                <div class="photo-overlay">
                                    <i class="bi bi-camera"></i>
                                </div>
                            </div>
                            <input type="file" id="photoInput" accept="image/*" class="d-none">
                            <button class="btn btn-sm btn-outline-primary mt-3" id="changePhotoBtn">
                                <i class="bi bi-camera me-2"></i>Cambiar Foto
                            </button>
                        </div>

                        <!-- User Info Summary -->
                        <div class="profile-info mt-4">
                            <h4 class="profile-name" id="displayName">Dr. {{ $usuario?->nombre_completo ?? 'N/A' }}</h4>
                            <p class="profile-role">
                                <span class="badge bg-primary-subtle text-primary">Administrador</span>
                            </p>
                            <p class="profile-email" id="displayEmail">{{ $usuario?->email ?? 'N/A' }}</p>
                        </div>

                        <!-- Quick Stats -->
                        <div class="profile-stats">
                            <div class="stat-item">
                                <span class="stat-number">0</span>
                                <span class="stat-label">Consultas</span>
                            </div>
                            <div class="stat-item">
                                <span class="stat-number">0</span>
                                <span class="stat-label">Pacientes</span>
                            </div>
                            <div class="stat-item">
                                <span class="stat-number">0</span>
                                <span class="stat-label">Rating</span>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Account Status -->
                <div class="card mt-4">
                    <div class="card-header">
                        <h5 class="card-title mb-0">
                            <i class="bi bi-shield-check me-2"></i>Estado de la Cuenta
                        </h5>
                    </div>
                    <div class="card-body">
                        <div class="status-item">
                            <div class="status-icon {{ $usuario?->email_verified_at ? 'active' : '' }}">
                                <i class="bi {{ $usuario?->email_verified_at ? 'bi-check-lg' : 'bi-x-lg' }}"></i>
                            </div>
                            <div class="status-info">
                                <span class="status-label">Email Verificado</span>
                                <span class="status-detail">{{ $usuario?->email_verified_at ? 'Verificado el '.$usuario?->email_verified_at : 'Sin verificación' }}</span>
                            </div>
                        </div>
                        <div class="status-item">
                            <div class="status-icon {{ $usuario?->google2fa_secret ? 'active' : '' }}" id="twoFactorStatusIcon">
                                <i class="bi {{ $usuario?->google2fa_secret ? 'bi-check-lg' : 'bi-x-lg' }}"></i>
                            </div>
                            <div class="status-info">
                                <span class="status-label">Doble Verificacion (2FA)</span>
                                <span class="status-detail" id="twoFactorStatusText">{{ $usuario?->google2fa_secret ? 'Activo' : 'No activado' }}</span>
                            </div>
                        </div>
                        <div class="status-item">
                            <div class="status-icon {{ $usuario?->estado == 1 ? 'active' : '' }}">
                                <i class="bi {{ $usuario?->estado == 1 ? 'bi-check-lg' : 'bi-x-lg' }}"></i>
                            </div>
                            <div class="status-info">
                                <span class="status-label">Cuenta {{ $usuario?->estado == 1 ? 'Activa' : 'Inactiva' }}</span>
                                <span class="status-detail">{{ $usuario?->estado == 1 ? 'Desde '.$usuario?->created_at : 'N/A' }}</span>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Right Column - Tabs -->
            <div class="col-xl-8">
                <div class="card">
                    <!-- Tab Navigation -->
                    <div class="card-header border-bottom-0">
                        <ul class="nav nav-tabs card-header-tabs" id="profileTabs" role="tablist">
                            <li class="nav-item" role="presentation">
                                <button class="nav-link active" id="personal-tab" data-bs-toggle="tab"
                                        data-bs-target="#personal" type="button" role="tab">
                                    <i class="bi bi-person me-2"></i>Datos Personales
                                </button>
                            </li>
                            <li class="nav-item" role="presentation">
                                <button class="nav-link" id="security-tab" data-bs-toggle="tab"
                                        data-bs-target="#security" type="button" role="tab">
                                    <i class="bi bi-shield-lock me-2"></i>Seguridad
                                </button>
                            </li>
                            <li class="nav-item" role="presentation">
                                <button class="nav-link" id="verification-tab" data-bs-toggle="tab"
                                        data-bs-target="#verification" type="button" role="tab">
                                    <i class="bi bi-phone me-2"></i>Verificacion
                                </button>
                            </li>
                        </ul>
                    </div>

                    <!-- Tab Content -->
                    <div class="tab-content" id="profileTabsContent">
                        <!-- Personal Data Tab -->
                        <div class="tab-pane fade show active" id="personal" role="tabpanel">
                            <div class="card-body">
                                <form id="personalDataForm">
                                    <input type="hidden" name="uuid" value="{{ $usuario?->uuid }}">
                                    <div class="row g-4">
                                        <!-- Nombre -->
                                        <div class="col-md-6">
                                            <label for="nombre" class="form-label">
                                                <i class="bi bi-person text-muted me-1"></i>Nombre
                                            </label>
                                            <input type="text" class="form-control" value="{{ $usuario?->nombre ?? '' }}" id="nombre"
                                                placeholder="Ingresa tu nombre" required name="nombre">
                                        </div>

                                        <!-- Apellido -->
                                        <div class="col-md-6">
                                            <label for="apellido" class="form-label">
                                                <i class="bi bi-person text-muted me-1"></i>Apellido
                                            </label>
                                            <input type="text" class="form-control" value="{{ $usuario?->apellido ?? '' }}" id="apellido"
                                                placeholder="Ingresa tu apellido" required name="apellido">
                                        </div>

                                        <!-- Genero -->
                                        <div class="col-md-6">
                                            <label for="genero" class="form-label">
                                                <i class="bi bi-gender-ambiguous text-muted me-1"></i>Genero
                                            </label>
                                            <select class="form-select" id="genero" data-control="select2"
                                                data-placeholder="Seleccione el genero" data-allow-clear="true"
                                                data-hide-search="true" name="genero" required>
                                                <option value=""></option>
                                                @foreach ($generos as $item)
                                                    <option value="{{ $item?->codigo }}" {{ $item?->codigo == $usuario?->genero ? 'selected' : '' }}>{{ $item?->nombre ?? 'N/A' }}</option>
                                                @endforeach
                                            </select>
                                        </div>

                                        <!-- Tipo de Identificacion -->
                                        <div class="col-md-6">
                                            <label for="tipoId" class="form-label">
                                                <i class="bi bi-card-text text-muted me-1"></i>Tipo de Identificacion
                                            </label>
                                            <select class="form-select" id="tipoId" data-control="select2"
                                                data-placeholder="Seleccione el tipo de identificación" data-allow-clear="true"
                                                data-hide-search="true" name="tipo_identificacion" required>
                                                <option value=""></option>
                                                @foreach ($tipo_documentos as $item)
                                                    <option value="{{ $item?->codigo }}" {{ $item?->codigo == $usuario?->tipo_identificacion ? 'selected' : '' }}>{{ $item?->nombre ?? 'N/A' }}</option>
                                                @endforeach
                                            </select>
                                        </div>

                                        <!-- Numero de Identificacion -->
                                        <div class="col-md-6">
                                            <label for="identificacion" class="form-label">
                                                <i class="bi bi-hash text-muted me-1"></i>Numero de Identificacion
                                            </label>
                                            <input type="text" class="form-control" id="identificacion" name="identificacion" required
                                                placeholder="Ingresa tu identificacion" value="{{ $usuario?->identificacion ?? '' }}">
                                        </div>

                                        <!-- Numero de Licencia -->
                                        <div class="col-md-6">
                                            <label for="licencia" class="form-label">
                                                <i class="bi bi-hash text-muted me-1"></i>Numero de Licencia
                                            </label>
                                            <input type="text" class="form-control" id="licencia" name="licencia" required
                                                placeholder="Ingresa tu licencia" value="{{ $usuario?->licencia ?? '' }}">
                                        </div>

                                        <!-- Separator -->
                                        <div class="col-12">
                                            <hr class="my-2">
                                            <h6 class="text-muted mb-0">
                                                <i class="bi bi-envelope me-2"></i>Informacion de Contacto
                                            </h6>
                                        </div>

                                        <!-- Email -->
                                        <div class="col-md-6">
                                            <label for="email" class="form-label">Email</label>
                                            <div class="input-group">
                                                <span class="input-group-text"><i class="bi bi-envelope"></i></span>
                                                <input type="email" class="form-control" id="email" name="email" value="{{ $usuario?->email ?? '' }}"
                                                    placeholder="correo@ejemplo.com" required>
                                            </div>
                                        </div>

                                        <!-- Confirmar Email -->
                                        <div class="col-md-6">
                                            <label for="emailConfirm" class="form-label">Confirmar Email</label>
                                            <div class="input-group">
                                                <span class="input-group-text"><i class="bi bi-envelope-check"></i></span>
                                                <input type="email" class="form-control" id="emailConfirm" name="email_confirmacion" value="{{ $usuario?->email ?? '' }}"
                                                    placeholder="Confirma tu correo" required>
                                            </div>
                                            <div class="invalid-feedback" id="emailMatchError">
                                                Los correos no coinciden
                                            </div>
                                        </div>

                                        <!-- Telefono -->
                                        <div class="col-md-4">
                                            <label for="telefono" class="form-label">Telefono</label>
                                            <input type="tel" class="form-control" required name="telefono"
                                                id="telefono" value="+{{ $usuario?->numero_completo }}"
                                                placeholder="300 123 4567">
                                        </div>

                                        <!-- Pais -->
                                        <div class="col-md-4">
                                            <label for="pais" class="form-label">Pais</label>
                                            <select class="form-select" id="pais" name="pais_id" placeholder="..." required>
                                                <option value="">Seleccione un país</option>
                                                @foreach ($paises as $pais)
                                                    <option value="{{$pais->id}}" {{$pais?->id == $usuario?->ciudad?->id_pais ? 'selected' : ''}} data-kt-select2-country="{{$pais->bandera}}">{{$pais->nombre}} - {{$pais->nombre_corto}}</option>
                                                @endforeach
                                            </select>
                                        </div>

                                        <!-- Ciudad -->
                                        <div class="col-md-4">
                                            <label for="ciudad" class="form-label">Ciudad</label>
                                            <select class="form-select" id="ciudad" name="cod_ciudad"
                                                data-ciudad={{$usuario->cod_ciudad}} disabled
                                                data-control="select2" data-placeholder="Seleccione una ciudad"
                                                data-allow-clear="true" required>
                                            </select>
                                        </div>
                                    </div>

                                    <!-- Save Button -->
                                    <div class="form-actions mt-4">
                                        <button type="submit" class="btn btn-primary" id="savePersonalBtn">
                                            <span class="btn-text">
                                                <i class="bi bi-check-lg me-2"></i>Guardar Cambios
                                            </span>
                                            <span class="btn-loader d-none">
                                                <span class="spinner-border spinner-border-sm me-2"></span>
                                                Guardando...
                                            </span>
                                        </button>
                                        <button type="button" class="btn btn-outline-secondary" id="cancelPersonalBtn">
                                            Cancelar
                                        </button>
                                    </div>
                                </form>
                            </div>
                        </div>

                        <!-- Security Tab -->
                        <div class="tab-pane fade" id="security" role="tabpanel">
                            <div class="card-body">
                                <div class="security-section">
                                    <div class="section-header">
                                        <div class="section-icon">
                                            <i class="bi bi-key"></i>
                                        </div>
                                        <div class="section-info">
                                            <h5>Cambiar Contrasena</h5>
                                            <p>Actualiza tu contrasena regularmente para mantener tu cuenta segura</p>
                                        </div>
                                    </div>

                                    <form id="passwordForm">
                                        <div class="row g-4">
                                            <!-- Contrasena Actual -->
                                            <div class="col-md-12">
                                                <label for="currentPassword" class="form-label">Contrasena Actual</label>
                                                <div class="input-group">
                                                    <span class="input-group-text"><i class="bi bi-lock"></i></span>
                                                    <input type="password" class="form-control" id="currentPassword"
                                                        placeholder="Ingresa tu contrasena actual" required>
                                                    <button class="btn btn-outline-secondary toggle-password" type="button">
                                                        <i class="bi bi-eye"></i>
                                                    </button>
                                                </div>
                                            </div>

                                            <!-- Nueva Contrasena -->
                                            <div class="col-md-6">
                                                <label for="newPassword" class="form-label">Nueva Contrasena</label>
                                                <div class="input-group">
                                                    <span class="input-group-text"><i class="bi bi-lock-fill"></i></span>
                                                    <input type="password" class="form-control" id="newPassword"
                                                        placeholder="Ingresa nueva contrasena" required>
                                                    <button class="btn btn-outline-secondary toggle-password" type="button">
                                                        <i class="bi bi-eye"></i>
                                                    </button>
                                                </div>
                                                <!-- Password Strength -->
                                                <div class="password-strength mt-2">
                                                    <div class="strength-bar">
                                                        <div class="strength-fill" id="strengthFill"></div>
                                                    </div>
                                                    <span class="strength-text" id="strengthText">Ingresa una contrasena</span>
                                                </div>
                                            </div>

                                            <!-- Confirmar Contrasena -->
                                            <div class="col-md-6">
                                                <label for="confirmPassword" class="form-label">Confirmar Contrasena</label>
                                                <div class="input-group">
                                                    <span class="input-group-text"><i class="bi bi-lock-fill"></i></span>
                                                    <input type="password" class="form-control" id="confirmPassword"
                                                        placeholder="Confirma nueva contrasena" required>
                                                    <button class="btn btn-outline-secondary toggle-password" type="button">
                                                        <i class="bi bi-eye"></i>
                                                    </button>
                                                </div>
                                                <div class="invalid-feedback" id="passwordMatchError">
                                                    Las contrasenas no coinciden
                                                </div>
                                            </div>

                                            <!-- Password Requirements -->
                                            <div class="col-12">
                                                <div class="password-requirements">
                                                    <p class="mb-2"><strong>Requisitos de la contrasena:</strong></p>
                                                    <ul class="requirements-list">
                                                        <li id="req-length"><i class="bi bi-circle"></i> Minimo 8 caracteres</li>
                                                        <li id="req-upper"><i class="bi bi-circle"></i> Al menos una mayuscula</li>
                                                        <li id="req-lower"><i class="bi bi-circle"></i> Al menos una minuscula</li>
                                                        <li id="req-number"><i class="bi bi-circle"></i> Al menos un numero</li>
                                                        <li id="req-special"><i class="bi bi-circle"></i> Al menos un caracter especial</li>
                                                    </ul>
                                                </div>
                                            </div>
                                        </div>

                                        <!-- Save Button -->
                                        <div class="form-actions mt-4">
                                            <button type="submit" class="btn btn-primary" id="savePasswordBtn">
                                                <span class="btn-text">
                                                    <i class="bi bi-shield-check me-2"></i>Actualizar Contrasena
                                                </span>
                                                <span class="btn-loader d-none">
                                                    <span class="spinner-border spinner-border-sm me-2"></span>
                                                    Actualizando...
                                                </span>
                                            </button>
                                        </div>
                                    </form>
                                </div>

                                <!-- Session Section -->
                                <div class="security-section mt-5">
                                    <div class="section-header">
                                        <div class="section-icon">
                                            <i class="bi bi-laptop"></i>
                                        </div>
                                        <div class="section-info">
                                            <h5>Sesiones Activas</h5>
                                            <p>Administra los dispositivos donde has iniciado sesion</p>
                                        </div>
                                    </div>

                                    <div class="session-list">
                                        <div class="session-item current">
                                            <div class="session-icon">
                                                <i class="bi bi-laptop"></i>
                                            </div>
                                            <div class="session-info">
                                                <h6>Chrome en Windows <span class="badge bg-success-subtle text-success">Actual</span></h6>
                                                <p>Bogota, Colombia - Activo ahora</p>
                                            </div>
                                        </div>
                                        <div class="session-item">
                                            <div class="session-icon">
                                                <i class="bi bi-phone"></i>
                                            </div>
                                            <div class="session-info">
                                                <h6>Safari en iPhone</h6>
                                                <p>Medellin, Colombia - Hace 2 horas</p>
                                            </div>
                                            <button class="btn btn-sm btn-outline-danger">Cerrar</button>
                                        </div>
                                    </div>

                                    <button class="btn btn-outline-danger mt-3" id="closeAllSessions">
                                        <i class="bi bi-box-arrow-right me-2"></i>Cerrar todas las sesiones
                                    </button>
                                </div>
                            </div>
                        </div>

                        <!-- 2FA Verification Tab -->
                        <div class="tab-pane fade" id="verification" role="tabpanel">
                            <div class="card-body">
                                <div class="verification-section">
                                    <!-- 2FA Toggle -->
                                    <div class="twofa-toggle-container">
                                        <div class="twofa-info">
                                            <div class="twofa-icon">
                                                <i class="bi bi-shield-lock-fill"></i>
                                            </div>
                                            <div class="twofa-details">
                                                <h5>Autenticacion de Dos Factores (2FA)</h5>
                                                <p>Agrega una capa adicional de seguridad a tu cuenta requiriendo un codigo de verificacion al iniciar sesion</p>
                                            </div>
                                        </div>
                                        <div class="form-check form-switch">
                                            <input class="form-check-input" type="checkbox" id="twoFactorSwitch">
                                            <label class="form-check-label" for="twoFactorSwitch">
                                                <span id="twoFactorLabel">Desactivado</span>
                                            </label>
                                        </div>
                                    </div>

                                    <!-- 2FA Setup Section (Hidden by default) -->
                                    <div class="twofa-setup d-none" id="twofaSetup">
                                        <div class="setup-steps">
                                            <!-- Step 1: QR Code -->
                                            <div class="setup-step">
                                                <div class="step-number">1</div>
                                                <div class="step-content">
                                                    <h6>Escanea el codigo QR</h6>
                                                    <p>Usa Google Authenticator, Authy u otra aplicacion de autenticacion para escanear el codigo</p>

                                                    <div class="qr-container">
                                                        <div class="qr-code" id="qrCode">
                                                            <!-- Simulated QR Code -->
                                                            <svg viewBox="0 0 200 200" width="200" height="200">
                                                                <rect fill="#ffffff" x="0" y="0" width="200" height="200"/>
                                                                <g fill="#000000">
                                                                    <!-- QR Pattern (simplified) -->
                                                                    <rect x="20" y="20" width="60" height="60"/>
                                                                    <rect x="120" y="20" width="60" height="60"/>
                                                                    <rect x="20" y="120" width="60" height="60"/>
                                                                    <rect fill="#ffffff" x="30" y="30" width="40" height="40"/>
                                                                    <rect fill="#ffffff" x="130" y="30" width="40" height="40"/>
                                                                    <rect fill="#ffffff" x="30" y="130" width="40" height="40"/>
                                                                    <rect x="40" y="40" width="20" height="20"/>
                                                                    <rect x="140" y="40" width="20" height="20"/>
                                                                    <rect x="40" y="140" width="20" height="20"/>
                                                                    <!-- Data modules -->
                                                                    <rect x="90" y="20" width="10" height="10"/>
                                                                    <rect x="90" y="40" width="10" height="10"/>
                                                                    <rect x="90" y="60" width="10" height="10"/>
                                                                    <rect x="20" y="90" width="10" height="10"/>
                                                                    <rect x="40" y="90" width="10" height="10"/>
                                                                    <rect x="60" y="90" width="10" height="10"/>
                                                                    <rect x="90" y="90" width="20" height="20"/>
                                                                    <rect x="120" y="90" width="10" height="10"/>
                                                                    <rect x="140" y="90" width="10" height="10"/>
                                                                    <rect x="160" y="90" width="10" height="10"/>
                                                                    <rect x="90" y="120" width="10" height="10"/>
                                                                    <rect x="90" y="140" width="10" height="10"/>
                                                                    <rect x="90" y="160" width="10" height="10"/>
                                                                    <rect x="120" y="120" width="20" height="20"/>
                                                                    <rect x="150" y="120" width="10" height="10"/>
                                                                    <rect x="120" y="150" width="10" height="10"/>
                                                                    <rect x="140" y="160" width="20" height="20"/>
                                                                </g>
                                                            </svg>
                                                        </div>
                                                        <div class="secret-code">
                                                            <span class="label">Codigo secreto:</span>
                                                            <code id="secretCode">JBSWY3DPEHPK3PXP</code>
                                                            <button class="btn btn-sm btn-outline-secondary" id="copySecret">
                                                                <i class="bi bi-clipboard"></i>
                                                            </button>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>

                                            <!-- Step 2: Verify -->
                                            <div class="setup-step">
                                                <div class="step-number">2</div>
                                                <div class="step-content">
                                                    <h6>Ingresa el codigo de verificacion</h6>
                                                    <p>Ingresa el codigo de 6 digitos que aparece en tu aplicacion de autenticacion</p>

                                                    <div class="verification-code-input">
                                                        <input type="text" maxlength="1" class="code-digit" data-index="0">
                                                        <input type="text" maxlength="1" class="code-digit" data-index="1">
                                                        <input type="text" maxlength="1" class="code-digit" data-index="2">
                                                        <span class="code-separator">-</span>
                                                        <input type="text" maxlength="1" class="code-digit" data-index="3">
                                                        <input type="text" maxlength="1" class="code-digit" data-index="4">
                                                        <input type="text" maxlength="1" class="code-digit" data-index="5">
                                                    </div>

                                                    <button class="btn btn-primary mt-4" id="verifyCodeBtn">
                                                        <span class="btn-text">
                                                            <i class="bi bi-shield-check me-2"></i>Verificar y Activar
                                                        </span>
                                                        <span class="btn-loader d-none">
                                                            <span class="spinner-border spinner-border-sm me-2"></span>
                                                            Verificando...
                                                        </span>
                                                    </button>
                                                </div>
                                            </div>
                                        </div>
                                    </div>

                                    <!-- 2FA Active Section (Hidden by default) -->
                                    <div class="twofa-active d-none" id="twofaActive">
                                        <div class="active-status">
                                            <div class="status-badge">
                                                <i class="bi bi-shield-fill-check"></i>
                                                <span>2FA Activo</span>
                                            </div>
                                            <p>Tu cuenta esta protegida con autenticacion de dos factores</p>
                                        </div>

                                        <div class="backup-codes">
                                            <h6><i class="bi bi-key me-2"></i>Codigos de Respaldo</h6>
                                            <p>Guarda estos codigos en un lugar seguro. Puedes usarlos para acceder a tu cuenta si pierdes acceso a tu dispositivo de autenticacion.</p>

                                            <div class="codes-grid" id="backupCodes">
                                                <code>A1B2-C3D4</code>
                                                <code>E5F6-G7H8</code>
                                                <code>I9J0-K1L2</code>
                                                <code>M3N4-O5P6</code>
                                                <code>Q7R8-S9T0</code>
                                                <code>U1V2-W3X4</code>
                                            </div>

                                            <div class="backup-actions">
                                                <button class="btn btn-outline-primary btn-sm" id="downloadCodes">
                                                    <i class="bi bi-download me-2"></i>Descargar Codigos
                                                </button>
                                                <button class="btn btn-outline-secondary btn-sm" id="regenerateCodes">
                                                    <i class="bi bi-arrow-repeat me-2"></i>Regenerar Codigos
                                                </button>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

@section('modals')
    <!-- Photo Preview Modal -->
    <div class="modal fade" id="photoPreviewModal" tabindex="-1">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Vista Previa de Foto</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>
                <div class="modal-body text-center">
                    <img src="" alt="Vista previa" id="photoPreviewImg" class="img-fluid rounded-circle" style="max-width: 250px;">
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-outline-secondary" data-bs-dismiss="modal">Cancelar</button>
                    <button type="button" class="btn btn-primary" id="confirmPhotoBtn">
                        <i class="bi bi-check-lg me-2"></i>Confirmar Foto
                    </button>
                </div>
            </div>
        </div>
    </div>
@endsection
