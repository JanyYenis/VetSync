<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="description" content="VetSync - Checkout seguro con PSE">
    <title>Checkout - VetSync</title>

    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <!-- Favicon -->
    <link rel="shortcut icon" href="{{ asset('build/img/logo_mini.png') }}">

    <!-- Google Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700;800&display=swap" rel="stylesheet">

    <!-- Bootstrap 5 CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">

    <!-- Bootstrap Icons -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.1/font/bootstrap-icons.css">

    <!-- Custom CSS -->
    <link href="{{ asset('assets/plugins/global/plugins.bundle.css') }}" rel="stylesheet" type="text/css" />
    {{-- <link href="{{ asset('assets/css/style.bundle.css') }}" rel="stylesheet" type="text/css" /> --}}
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/intl-tel-input@18.2.1/build/css/intlTelInput.css">
    <link href="{{ asset('assets/plugins/custom/datatables/datatables.bundle.css') }}" rel="stylesheet"
        type="text/css" />

    @routes
    <!-- Bootstrap 5 JS -->
    <script src="{{ asset('assets/js/scripts.bundle.js') }}"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
    <script src="{{ asset('assets/plugins/global/plugins.bundle.js') }}"></script>
    <script src="https://cdn.jsdelivr.net/npm/intl-tel-input@18.1.1/build/js/intlTelInput.min.js"></script>
    <script src="{{ asset('assets/plugins/custom/datatables/datatables.bundle.js') }}"></script>
    <script src="{{ asset('assets/multi-select/js/jquery.quicksearch.js') }}"></script>
    <script src="{{ asset('assets/multi-select/js/jquery.multi-select.js') }}"></script>

    <!-- Chart.js -->
    <script src="https://cdn.jsdelivr.net/npm/chart.js@4.4.1/dist/chart.umd.min.js"></script>
    <!-- jsPDF -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jspdf/2.5.1/jspdf.umd.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/html2canvas/1.4.1/html2canvas.min.js"></script>

    <!-- Custom CSS -->
    @vite(['resources/js/app.js', 'resources/css/checkout.css', 'resources/css/datatables.css',
        'resources/css/datatable-gijac.css', 'resources/js/jquery-validator.init.js', 'resources/js/checkout.js'])

    <script src="https://cdn.jsdelivr.net/npm/jquery-validation@1.19.5/dist/jquery.validate.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/jquery-validation@1.19.5/dist/jquery.validate.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/jquery-validation@1.19.5/dist/additional-methods.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/jquery-validation@1.19.5/dist/additional-methods.min.js"></script>
</head>
<body>
    <!-- Header -->
    <header class="checkout-header">
        <div class="container">
            <div class="d-flex justify-content-between align-items-center">
                <a href="{{ url('/') }}" class="logo">
                    <span class="logo-icon">🐾</span>
                    <span class="logo-text text-primary">VetSync</span>
                </a>
                <div class="security-badge">
                    <i class="bi bi-shield-lock-fill"></i>
                    <span>Pago Seguro SSL</span>
                </div>
            </div>
        </div>
    </header>

    <!-- Progress Steps -->
    <div class="checkout-progress">
        <div class="container">
            <div class="progress-steps">
                <div class="step active" data-step="1">
                    <div class="step-icon">
                        <i class="bi bi-person"></i>
                    </div>
                    <span class="step-label">Datos</span>
                </div>
                <div class="step-line active"></div>
                <div class="step" data-step="2">
                    <div class="step-icon">
                        <i class="bi bi-bank"></i>
                    </div>
                    <span class="step-label">Pago</span>
                </div>
                <div class="step-line"></div>
                <div class="step" data-step="3">
                    <div class="step-icon">
                        <i class="bi bi-check-lg"></i>
                    </div>
                    <span class="step-label">Confirmacion</span>
                </div>
            </div>
        </div>
    </div>

    <!-- Main Content -->
    <main class="checkout-main">
        <div class="container">
            <div class="row g-4">
                <!-- Checkout Form -->
                <div class="col-lg-7">
                    <div class="checkout-form-container">
                        <!-- Step 1: Datos del Pagador -->
                        <div class="checkout-step active" id="step1">
                            <div class="step-header">
                                <h2>Datos del Pagador</h2>
                                <p class="text-muted">Ingresa tus datos para procesar el pago</p>
                            </div>

                            <form id="payerForm" class="needs-validation" novalidate>
                                <div class="row g-3">
                                    <div class="col-12">
                                        <label class="form-label">Nombre completo <span class="text-danger">*</span></label>
                                        <div class="input-icon">
                                            <i class="bi bi-person"></i>
                                            <input type="text" class="form-control" id="fullName" placeholder="Juan Carlos Perez Garcia" required>
                                        </div>
                                        <div class="invalid-feedback">Por favor ingresa tu nombre completo</div>
                                    </div>

                                    <div class="col-md-5">
                                        <label class="form-label">Tipo de documento <span class="text-danger">*</span></label>
                                        <select class="form-select" id="docType" required>
                                            <option value="">Seleccionar...</option>
                                            <option value="CC">Cedula de Ciudadania</option>
                                            <option value="CE">Cedula de Extranjeria</option>
                                            <option value="NIT">NIT</option>
                                            <option value="PP">Pasaporte</option>
                                        </select>
                                        <div class="invalid-feedback">Selecciona un tipo de documento</div>
                                    </div>

                                    <div class="col-md-7">
                                        <label class="form-label">Numero de documento <span class="text-danger">*</span></label>
                                        <div class="input-icon">
                                            <i class="bi bi-card-text"></i>
                                            <input type="text" class="form-control" id="docNumber" placeholder="1234567890" required>
                                        </div>
                                        <div class="invalid-feedback">Ingresa tu numero de documento</div>
                                    </div>

                                    <div class="col-md-6">
                                        <label class="form-label">Correo electronico <span class="text-danger">*</span></label>
                                        <div class="input-icon">
                                            <i class="bi bi-envelope"></i>
                                            <input type="email" class="form-control" id="email" placeholder="correo@ejemplo.com" required>
                                        </div>
                                        <div class="invalid-feedback">Ingresa un correo valido</div>
                                    </div>

                                    <div class="col-md-6">
                                        <label class="form-label">Telefono <span class="text-danger">*</span></label>
                                        <div class="input-icon">
                                            <i class="bi bi-telephone"></i>
                                            <input type="tel" class="form-control" id="phone" placeholder="300 123 4567" required>
                                        </div>
                                        <div class="invalid-feedback">Ingresa tu telefono</div>
                                    </div>
                                </div>

                                <div class="step-actions">
                                    <a href="pricing.html" class="btn btn-outline-secondary">
                                        <i class="bi bi-arrow-left me-2"></i>Volver a planes
                                    </a>
                                    <button type="submit" class="btn btn-primary btn-continue">
                                        Continuar<i class="bi bi-arrow-right ms-2"></i>
                                    </button>
                                </div>
                            </form>
                        </div>

                        <!-- Step 2: Metodo de Pago -->
                        <div class="checkout-step" id="step2">
                            <div class="step-header">
                                <h2>Metodo de Pago</h2>
                                <p class="text-muted">Selecciona tu banco para pagar con PSE</p>
                            </div>

                            <form id="paymentForm" class="needs-validation" novalidate>
                                <!-- Payment Methods -->
                                <div class="payment-methods mb-4">
                                    <div class="payment-method active" data-method="pse">
                                        <div class="method-radio">
                                            <input type="radio" name="paymentMethod" id="methodPSE" value="pse" checked>
                                        </div>
                                        <div class="method-info">
                                            <img src="https://multimedia.epayco.co/dashboard/modal/pse2.png" alt="PSE" class="method-logo">
                                            <div>
                                                <strong>PSE - Debito bancario</strong>
                                                <span class="text-muted">Pago seguro desde tu cuenta bancaria</span>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="payment-method disabled" data-method="card">
                                        <div class="method-radio">
                                            <input type="radio" name="paymentMethod" id="methodCard" value="card" disabled>
                                        </div>
                                        <div class="method-info">
                                            <i class="bi bi-credit-card method-icon"></i>
                                            <div>
                                                <strong>Tarjeta de credito/debito</strong>
                                                <span class="text-muted">Proximamente</span>
                                            </div>
                                        </div>
                                        <span class="badge bg-secondary">Pronto</span>
                                    </div>
                                </div>

                                <!-- PSE Form -->
                                <div class="pse-form">
                                    <div class="row g-3">
                                        <div class="col-md-6">
                                            <label class="form-label">Tipo de persona <span class="text-danger">*</span></label>
                                            <select class="form-select" id="personType" required>
                                                <option value="">Seleccionar...</option>
                                                <option value="0">Persona Natural</option>
                                                <option value="1">Persona Juridica</option>
                                            </select>
                                            <div class="invalid-feedback">Selecciona el tipo de persona</div>
                                        </div>

                                        <div class="col-md-6">
                                            <label class="form-label">Banco <span class="text-danger">*</span></label>
                                            <select class="form-select" id="bank" required>
                                                <option value="">Seleccionar banco...</option>
                                                <optgroup label="Bancos Principales">
                                                    <option value="1007">Bancolombia</option>
                                                    <option value="1009">Davivienda</option>
                                                    <option value="1051">Banco de Bogota</option>
                                                    <option value="1023">Banco de Occidente</option>
                                                    <option value="1019">Scotiabank Colpatria</option>
                                                    <option value="1040">BBVA Colombia</option>
                                                </optgroup>
                                                <optgroup label="Otros Bancos">
                                                    <option value="1052">AV Villas</option>
                                                    <option value="1006">Banco Itau</option>
                                                    <option value="1012">Banco GNB Sudameris</option>
                                                    <option value="1058">Banco Procredit</option>
                                                    <option value="1062">Banco Falabella</option>
                                                    <option value="1063">Banco Finandina</option>
                                                    <option value="1060">Banco Pichincha</option>
                                                    <option value="1014">Banco Itau antes Corpbanca</option>
                                                    <option value="1059">Bancoomeva</option>
                                                    <option value="1065">Banco Santander de Negocios</option>
                                                    <option value="1283">CFA Cooperativa Financiera</option>
                                                    <option value="1291">Coofinep Cooperativa Financiera</option>
                                                    <option value="1066">Confiar Cooperativa Financiera</option>
                                                    <option value="1292">Cotrafa Cooperativa Financiera</option>
                                                    <option value="1289">Coofiantioquia</option>
                                                    <option value="1370">COLTEFINANCIERA</option>
                                                    <option value="1507">Nequi</option>
                                                    <option value="1151">Daviplata</option>
                                                    <option value="1801">Movii</option>
                                                    <option value="1551">DaviVienda Daviplata</option>
                                                </optgroup>
                                            </select>
                                            <div class="invalid-feedback">Selecciona tu banco</div>
                                        </div>
                                    </div>

                                    <!-- Terms -->
                                    <div class="terms-check mt-4">
                                        <div class="form-check">
                                            <input class="form-check-input" type="checkbox" id="acceptTerms" required>
                                            <label class="form-check-label" for="acceptTerms">
                                                Acepto los <a href="#" data-bs-toggle="modal" data-bs-target="#termsModal">terminos y condiciones</a> y la <a href="#" data-bs-toggle="modal" data-bs-target="#privacyModal">politica de privacidad</a>
                                            </label>
                                            <div class="invalid-feedback">Debes aceptar los terminos y condiciones</div>
                                        </div>
                                    </div>
                                </div>

                                <div class="step-actions">
                                    <button type="button" class="btn btn-outline-secondary btn-back" data-step="1">
                                        <i class="bi bi-arrow-left me-2"></i>Volver
                                    </button>
                                    <button type="submit" class="btn btn-success btn-pay" id="btnPay">
                                        <i class="bi bi-lock-fill me-2"></i>Pagar con PSE
                                    </button>
                                </div>
                            </form>
                        </div>

                        <!-- Step 3: Confirmacion -->
                        <div class="checkout-step" id="step3">
                            <div class="confirmation-content">
                                <!-- Success State -->
                                <div class="confirmation-state success" id="confirmationSuccess">
                                    <div class="confirmation-icon success">
                                        <i class="bi bi-check-lg"></i>
                                    </div>
                                    <h2>Pago Realizado con Exito</h2>
                                    <p class="text-muted">Tu suscripcion ha sido activada correctamente</p>

                                    <div class="confirmation-details">
                                        <div class="detail-row">
                                            <span class="detail-label">Referencia de pago</span>
                                            <span class="detail-value" id="paymentRef">-</span>
                                        </div>
                                        <div class="detail-row">
                                            <span class="detail-label">Fecha y hora</span>
                                            <span class="detail-value" id="paymentDate">-</span>
                                        </div>
                                        <div class="detail-row">
                                            <span class="detail-label">Metodo de pago</span>
                                            <span class="detail-value">PSE - <span id="paymentBank">-</span></span>
                                        </div>
                                        <div class="detail-row">
                                            <span class="detail-label">Plan adquirido</span>
                                            <span class="detail-value" id="paymentPlan">-</span>
                                        </div>
                                        <div class="detail-row total">
                                            <span class="detail-label">Total pagado</span>
                                            <span class="detail-value" id="paymentTotal">-</span>
                                        </div>
                                    </div>

                                    <div class="confirmation-actions">
                                        <a href="dashboard.html" class="btn btn-primary btn-lg">
                                            <i class="bi bi-grid-fill me-2"></i>Ir al Dashboard
                                        </a>
                                        <button type="button" class="btn btn-outline-secondary btn-lg" id="btnDownloadReceipt">
                                            <i class="bi bi-download me-2"></i>Descargar Comprobante
                                        </button>
                                    </div>

                                    <div class="confirmation-email">
                                        <i class="bi bi-envelope-check"></i>
                                        <span>Hemos enviado un comprobante a tu correo electronico</span>
                                    </div>
                                </div>

                                <!-- Error State -->
                                <div class="confirmation-state error" id="confirmationError" style="display: none;">
                                    <div class="confirmation-icon error">
                                        <i class="bi bi-x-lg"></i>
                                    </div>
                                    <h2>Pago Rechazado</h2>
                                    <p class="text-muted">No pudimos procesar tu pago. Por favor intenta de nuevo.</p>

                                    <div class="error-details">
                                        <div class="alert alert-danger">
                                            <i class="bi bi-exclamation-triangle-fill me-2"></i>
                                            <span id="errorMessage">Error en la transaccion bancaria</span>
                                        </div>
                                    </div>

                                    <div class="confirmation-actions">
                                        <button type="button" class="btn btn-primary btn-lg" id="btnRetry">
                                            <i class="bi bi-arrow-clockwise me-2"></i>Intentar de nuevo
                                        </button>
                                        <a href="pricing.html" class="btn btn-outline-secondary btn-lg">
                                            <i class="bi bi-arrow-left me-2"></i>Volver a planes
                                        </a>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Order Summary -->
                <div class="col-lg-5">
                    <div class="order-summary">
                        <div class="summary-header">
                            <h3>Resumen del Pedido</h3>
                        </div>

                        <div class="summary-body">
                            <!-- Plan Info -->
                            <div class="plan-card">
                                <div class="plan-badge" id="planBadge">Mas Popular</div>
                                <div class="plan-header">
                                    <div class="plan-icon">
                                        <i class="bi bi-star-fill"></i>
                                    </div>
                                    <div class="plan-info">
                                        <h4 id="planName">Plan Profesional</h4>
                                        <span class="plan-period" id="planPeriod">Suscripcion Mensual</span>
                                    </div>
                                </div>

                                <ul class="plan-features">
                                    <li><i class="bi bi-check-circle-fill"></i> Hasta 500 pacientes</li>
                                    <li><i class="bi bi-check-circle-fill"></i> 5 usuarios veterinarios</li>
                                    <li><i class="bi bi-check-circle-fill"></i> Historial clinico completo</li>
                                    <li><i class="bi bi-check-circle-fill"></i> Prescripciones ilimitadas</li>
                                    <li><i class="bi bi-check-circle-fill"></i> Soporte prioritario</li>
                                </ul>
                            </div>

                            <!-- Pricing -->
                            <div class="pricing-details">
                                <div class="price-row">
                                    <span>Subtotal</span>
                                    <span id="subtotal">$199.000</span>
                                </div>
                                <div class="price-row discount" id="discountRow" style="display: none;">
                                    <span>Descuento (20%)</span>
                                    <span class="text-success" id="discount">-$39.800</span>
                                </div>
                                <div class="price-row">
                                    <span>IVA (19%)</span>
                                    <span id="tax">$0</span>
                                </div>
                                <div class="price-row total">
                                    <span>Total a pagar</span>
                                    <span id="total">$199.000 COP</span>
                                </div>
                            </div>

                            <!-- Security Info -->
                            <div class="security-info">
                                <div class="security-item">
                                    <i class="bi bi-shield-check"></i>
                                    <span>Transaccion 100% segura</span>
                                </div>
                                <div class="security-item">
                                    <i class="bi bi-lock"></i>
                                    <span>Encriptacion SSL 256-bit</span>
                                </div>
                                <div class="security-item">
                                    <i class="bi bi-arrow-repeat"></i>
                                    <span>Garantia de devolucion 30 dias</span>
                                </div>
                            </div>

                            <!-- Payment Logos -->
                            <div class="payment-logos">
                                <span class="powered-by">Procesado por</span>
                                <div class="logos">
                                    <img src="https://multimedia.epayco.co/dashboard/modal/logo-epayco.png" alt="ePayco" class="epayco-logo">
                                    <img src="https://multimedia.epayco.co/dashboard/modal/pse2.png" alt="PSE" class="pse-logo">
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Help -->
                    <div class="checkout-help">
                        <i class="bi bi-question-circle"></i>
                        <div>
                            <strong>Necesitas ayuda?</strong>
                            <p>Contactanos: <a href="mailto:soporte@vetcarepro.com">soporte@vetcarepro.com</a></p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </main>

    <!-- ePayco Processing Modal -->
    <div class="modal fade" id="processingModal" tabindex="-1" data-bs-backdrop="static" data-bs-keyboard="false">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content processing-modal">
                <div class="modal-body text-center">
                    <!-- Processing State -->
                    <div class="processing-state" id="processingState">
                        <div class="epayco-header">
                            <img src="https://multimedia.epayco.co/dashboard/modal/logo-epayco.png" alt="ePayco" class="modal-epayco-logo">
                        </div>

                        <div class="processing-animation">
                            <div class="bank-animation">
                                <i class="bi bi-bank"></i>
                            </div>
                            <div class="processing-dots">
                                <span></span>
                                <span></span>
                                <span></span>
                            </div>
                            <div class="pse-animation">
                                <img src="https://multimedia.epayco.co/dashboard/modal/pse2.png" alt="PSE">
                            </div>
                        </div>

                        <h4 class="processing-title">Procesando tu pago</h4>
                        <p class="processing-text">Redirigiendo a PSE...</p>
                        <p class="processing-subtext text-muted">No cierres ni recargues esta ventana</p>

                        <div class="processing-progress">
                            <div class="progress">
                                <div class="progress-bar progress-bar-striped progress-bar-animated" role="progressbar"></div>
                            </div>
                        </div>
                    </div>

                    <!-- Bank Redirect State -->
                    <div class="bank-state" id="bankState" style="display: none;">
                        <div class="bank-header">
                            <div class="bank-logo" id="bankLogo">
                                <i class="bi bi-bank2"></i>
                            </div>
                            <h4 id="bankName">Bancolombia</h4>
                        </div>

                        <div class="bank-message">
                            <i class="bi bi-shield-lock"></i>
                            <p>Ingresa a tu banca virtual para autorizar el pago</p>
                        </div>

                        <div class="transaction-info">
                            <div class="info-row">
                                <span>Comercio:</span>
                                <strong>VetSync SAS</strong>
                            </div>
                            <div class="info-row">
                                <span>Referencia:</span>
                                <strong id="modalRef">VCP-20240115-001</strong>
                            </div>
                            <div class="info-row">
                                <span>Valor:</span>
                                <strong id="modalAmount">$199.000 COP</strong>
                            </div>
                        </div>

                        <div class="bank-loader">
                            <div class="spinner-border text-primary" role="status">
                                <span class="visually-hidden">Cargando...</span>
                            </div>
                            <span>Esperando autorizacion...</span>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Terms Modal -->
    <div class="modal fade" id="termsModal" tabindex="-1">
        <div class="modal-dialog modal-lg modal-dialog-scrollable">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Terminos y Condiciones</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>
                <div class="modal-body">
                    <h6>1. Aceptacion de los Terminos</h6>
                    <p>Al acceder y utilizar los servicios de VetSync, usted acepta estar sujeto a estos terminos y condiciones de uso.</p>

                    <h6>2. Descripcion del Servicio</h6>
                    <p>VetSync es una plataforma de gestion veterinaria que permite administrar pacientes, historiales clinicos, prescripciones y mas.</p>

                    <h6>3. Suscripciones y Pagos</h6>
                    <p>Las suscripciones se renuevan automaticamente al final de cada periodo de facturacion. Puede cancelar en cualquier momento desde su panel de control.</p>

                    <h6>4. Politica de Devolucion</h6>
                    <p>Ofrecemos una garantia de devolucion de 30 dias. Si no esta satisfecho con nuestro servicio, puede solicitar un reembolso completo dentro de los primeros 30 dias.</p>

                    <h6>5. Privacidad y Seguridad</h6>
                    <p>Nos comprometemos a proteger su informacion personal y la de sus pacientes siguiendo los mas altos estandares de seguridad.</p>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-primary" data-bs-dismiss="modal">Entendido</button>
                </div>
            </div>
        </div>
    </div>

    <!-- Privacy Modal -->
    <div class="modal fade" id="privacyModal" tabindex="-1">
        <div class="modal-dialog modal-lg modal-dialog-scrollable">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Politica de Privacidad</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>
                <div class="modal-body">
                    <h6>Recopilacion de Informacion</h6>
                    <p>Recopilamos informacion que usted nos proporciona directamente, como datos de registro, informacion de pago y datos de uso del servicio.</p>

                    <h6>Uso de la Informacion</h6>
                    <p>Utilizamos su informacion para proporcionar, mantener y mejorar nuestros servicios, procesar transacciones y enviar comunicaciones relacionadas.</p>

                    <h6>Compartir Informacion</h6>
                    <p>No vendemos ni compartimos su informacion personal con terceros, excepto cuando sea necesario para proporcionar nuestros servicios o cumplir con obligaciones legales.</p>

                    <h6>Seguridad</h6>
                    <p>Implementamos medidas de seguridad tecnicas y organizativas para proteger su informacion contra acceso no autorizado.</p>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-primary" data-bs-dismiss="modal">Entendido</button>
                </div>
            </div>
        </div>
    </div>
</body>
</html>
