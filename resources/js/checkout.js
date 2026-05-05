/**
 * VetSync - Checkout Module
 * Integracion simulada con ePayco y PSE
 *
 * EJEMPLO DE INTEGRACION REAL CON EPAYCO:
 * ========================================
 *
 * // Cargar el script de ePayco
 * <script src="https://checkout.epayco.co/checkout.js"></script>
 *
 * // Configurar handler
 * var handler = ePayco.checkout.configure({
 *     key: 'PUBLIC_KEY',
 *     test: true // false para produccion
 * });
 *
 * // Abrir checkout
 * handler.open({
 *     name: "VetSync - Plan Profesional",
 *     description: "Suscripcion mensual",
 *     invoice: "VCP-20240115-001",
 *     currency: "cop",
 *     amount: "199000",
 *     tax: "0",
 *     tax_base: "199000",
 *     country: "co",
 *     lang: "es",
 *     external: "false",
 *     response: "https://vetcarepro.com/checkout/response",
 *     confirmation: "https://vetcarepro.com/api/checkout/confirm",
 *     methodsDisable: ["TDC", "PSE", "SP", "CASH", "DP"]
 * });
 *
 * // Para PSE especificamente:
 * handler.open({
 *     // ... otros parametros
 *     method: "PSE",
 *     type_doc: "CC", // CC, CE, NIT, etc.
 *     docNumber: "1234567890",
 *     name: "Juan Perez",
 *     lastName: "Garcia",
 *     email: "juan@email.com",
 *     cellPhone: "3001234567",
 *     bank: "1007" // Codigo del banco
 * });
 */

$(document).ready(function() {
    'use strict';

    // ========================================
    // CONFIGURACION Y ESTADO
    // ========================================

    const CheckoutApp = {
        currentStep: 1,
        totalSteps: 3,
        payerData: {},
        paymentData: {},
        selectedPlan: null,

        // Planes disponibles
        plans: {
            basico: {
                name: 'Plan Basico',
                price: 89000,
                period: 'mensual',
                badge: '',
                icon: 'bi-building',
                features: [
                    'Hasta 100 pacientes',
                    '1 usuario veterinario',
                    'Historial clinico basico',
                    'Soporte por email'
                ]
            },
            profesional: {
                name: 'Plan Profesional',
                price: 199000,
                period: 'mensual',
                badge: 'Mas Popular',
                icon: 'bi-star-fill',
                features: [
                    'Hasta 500 pacientes',
                    '5 usuarios veterinarios',
                    'Historial clinico completo',
                    'Prescripciones ilimitadas',
                    'Soporte prioritario'
                ]
            },
            empresarial: {
                name: 'Plan Empresarial',
                price: 349000,
                period: 'mensual',
                badge: 'Premium',
                icon: 'bi-gem',
                features: [
                    'Pacientes ilimitados',
                    'Usuarios ilimitados',
                    'Todas las funcionalidades',
                    'API access',
                    'Soporte 24/7',
                    'Capacitacion incluida'
                ]
            }
        },

        // Bancos PSE (codigos reales)
        banks: {
            '1007': 'Bancolombia',
            '1009': 'Davivienda',
            '1051': 'Banco de Bogota',
            '1023': 'Banco de Occidente',
            '1019': 'Scotiabank Colpatria',
            '1040': 'BBVA Colombia',
            '1052': 'AV Villas',
            '1507': 'Nequi',
            '1151': 'Daviplata'
        }
    };

    // ========================================
    // INICIALIZACION
    // ========================================

    function init() {
        loadPlanFromURL();
        bindEvents();
        updateOrderSummary();
    }

    // Cargar plan desde URL parameters
    function loadPlanFromURL() {
        const urlParams = new URLSearchParams(window.location.search);
        const plan = urlParams.get('plan') || 'profesional';
        const billing = urlParams.get('billing') || 'monthly';

        CheckoutApp.selectedPlan = plan;
        CheckoutApp.billingCycle = billing;

        updateOrderSummary();
    }

    // ========================================
    // EVENTOS
    // ========================================

    function bindEvents() {
        // Form Step 1 - Datos del pagador
        $('#payerForm').on('submit', function(e) {
            e.preventDefault();
            if (validatePayerForm()) {
                savePayerData();
                goToStep(2);
            }
        });

        // Form Step 2 - Metodo de pago
        $('#paymentForm').on('submit', function(e) {
            e.preventDefault();
            if (validatePaymentForm()) {
                savePaymentData();
                processPayment();
            }
        });

        // Boton volver
        $('.btn-back').on('click', function() {
            const step = $(this).data('step');
            goToStep(step);
        });

        // Seleccion de metodo de pago
        $('.payment-method').on('click', function() {
            if ($(this).hasClass('disabled')) return;

            $('.payment-method').removeClass('active');
            $(this).addClass('active');
            $(this).find('input[type="radio"]').prop('checked', true);
        });

        // Reintentar pago
        $('#btnRetry').on('click', function() {
            goToStep(2);
            $('#confirmationError').hide();
            $('#confirmationSuccess').show();
        });

        // Descargar comprobante
        $('#btnDownloadReceipt').on('click', function() {
            downloadReceipt();
        });

        // Validacion en tiempo real
        $('input, select').on('change blur', function() {
            validateField($(this));
        });
    }

    // ========================================
    // NAVEGACION DE PASOS
    // ========================================

    function goToStep(step) {
        // Ocultar paso actual
        $(`.checkout-step`).removeClass('active');

        // Mostrar nuevo paso
        $(`#step${step}`).addClass('active');

        // Actualizar indicadores de progreso
        updateProgressSteps(step);

        // Actualizar estado
        CheckoutApp.currentStep = step;

        // Scroll al inicio
        window.scrollTo({ top: 0, behavior: 'smooth' });
    }

    function updateProgressSteps(currentStep) {
        $('.step').each(function(index) {
            const stepNum = index + 1;
            const $step = $(this);
            const $prevLine = $step.prev('.step-line');

            $step.removeClass('active completed');
            $prevLine.removeClass('active completed');

            if (stepNum < currentStep) {
                $step.addClass('completed');
                $prevLine.addClass('completed');
            } else if (stepNum === currentStep) {
                $step.addClass('active');
                $prevLine.addClass('active');
            }
        });
    }

    // ========================================
    // VALIDACIONES
    // ========================================

    function validatePayerForm() {
        let isValid = true;
        const form = document.getElementById('payerForm');

        // Validar campos requeridos
        $('#payerForm input[required], #payerForm select[required]').each(function() {
            if (!validateField($(this))) {
                isValid = false;
            }
        });

        // Validar email
        const email = $('#email').val();
        if (email && !isValidEmail(email)) {
            $('#email').addClass('is-invalid');
            isValid = false;
        }

        // Validar telefono
        const phone = $('#phone').val();
        if (phone && !isValidPhone(phone)) {
            $('#phone').addClass('is-invalid');
            isValid = false;
        }

        return isValid;
    }

    function validatePaymentForm() {
        let isValid = true;

        // Validar selects
        if (!$('#personType').val()) {
            $('#personType').addClass('is-invalid');
            isValid = false;
        }

        if (!$('#bank').val()) {
            $('#bank').addClass('is-invalid');
            isValid = false;
        }

        // Validar terminos
        if (!$('#acceptTerms').is(':checked')) {
            $('#acceptTerms').addClass('is-invalid');
            isValid = false;
        }

        return isValid;
    }

    function validateField($field) {
        const value = $field.val();
        const isRequired = $field.prop('required');

        $field.removeClass('is-invalid is-valid');

        if (isRequired && !value) {
            $field.addClass('is-invalid');
            return false;
        }

        if (value) {
            $field.addClass('is-valid');
        }

        return true;
    }

    function isValidEmail(email) {
        const re = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;
        return re.test(email);
    }

    function isValidPhone(phone) {
        const cleaned = phone.replace(/\D/g, '');
        return cleaned.length >= 10;
    }

    // ========================================
    // GUARDAR DATOS
    // ========================================

    function savePayerData() {
        CheckoutApp.payerData = {
            fullName: $('#fullName').val(),
            docType: $('#docType').val(),
            docNumber: $('#docNumber').val(),
            email: $('#email').val(),
            phone: $('#phone').val()
        };
    }

    function savePaymentData() {
        CheckoutApp.paymentData = {
            method: 'PSE',
            personType: $('#personType').val(),
            bank: $('#bank').val(),
            bankName: $('#bank option:selected').text()
        };
    }

    // ========================================
    // ACTUALIZAR RESUMEN
    // ========================================

    function updateOrderSummary() {
        const plan = CheckoutApp.plans[CheckoutApp.selectedPlan] || CheckoutApp.plans.profesional;
        const isAnnual = CheckoutApp.billingCycle === 'annual';

        // Calcular precios
        let subtotal = plan.price;
        let discount = 0;
        let total = subtotal;

        if (isAnnual) {
            discount = Math.round(subtotal * 0.2);
            total = subtotal - discount;
        }

        // Actualizar UI
        $('#planName').text(plan.name);
        $('#planPeriod').text(isAnnual ? 'Suscripcion Anual' : 'Suscripcion Mensual');

        if (plan.badge) {
            $('#planBadge').text(plan.badge).show();
        } else {
            $('#planBadge').hide();
        }

        // Actualizar features
        const $features = $('.plan-features');
        $features.empty();
        plan.features.forEach(feature => {
            $features.append(`<li><i class="bi bi-check-circle-fill"></i> ${feature}</li>`);
        });

        // Actualizar precios
        $('#subtotal').text(formatCurrency(subtotal));

        if (isAnnual) {
            $('#discountRow').show();
            $('#discount').text(`-${formatCurrency(discount)}`);
        } else {
            $('#discountRow').hide();
        }

        $('#tax').text('$0');
        $('#total').text(`${formatCurrency(total)} COP`);

        // Guardar total
        CheckoutApp.totalAmount = total;
    }

    function formatCurrency(amount) {
        return '$' + amount.toLocaleString('es-CO');
    }

    // ========================================
    // PROCESAR PAGO (SIMULACION)
    // ========================================

    function processPayment() {
        // Deshabilitar boton
        const $btnPay = $('#btnPay');
        $btnPay.prop('disabled', true).addClass('btn-loading');
        $btnPay.html('<span class="btn-text"><i class="bi bi-lock-fill me-2"></i>Pagar con PSE</span>');

        // Generar referencia
        const reference = generateReference();

        // Actualizar modal
        $('#modalRef').text(reference);
        $('#modalAmount').text(`${formatCurrency(CheckoutApp.totalAmount)} COP`);

        // Mostrar modal de procesamiento
        const processingModal = new bootstrap.Modal(document.getElementById('processingModal'));
        processingModal.show();

        // Simular proceso de pago
        simulatePaymentProcess(processingModal, reference);
    }

    function simulatePaymentProcess(modal, reference) {
        const $progressBar = $('.processing-progress .progress-bar');
        let progress = 0;

        // Paso 1: Conectando con ePayco (0-30%)
        const step1 = setInterval(() => {
            progress += 2;
            $progressBar.css('width', `${progress}%`);

            if (progress >= 30) {
                clearInterval(step1);

                // Paso 2: Redirigiendo a PSE (30-60%)
                $('.processing-text').text('Conectando con PSE...');

                setTimeout(() => {
                    // Mostrar estado del banco
                    $('#processingState').hide();
                    $('#bankState').show();
                    $('#bankName').text(CheckoutApp.paymentData.bankName);

                    // Paso 3: Esperando autorizacion (60-90%)
                    simulateBankAuth(modal, reference);
                }, 1500);
            }
        }, 100);
    }

    function simulateBankAuth(modal, reference) {
        // Simular espera de autorizacion bancaria
        setTimeout(() => {
            // Decidir aleatoriamente exito o error (90% exito, 10% error)
            const isSuccess = Math.random() > 0.1;

            modal.hide();

            if (isSuccess) {
                showPaymentSuccess(reference);
            } else {
                showPaymentError();
            }
        }, 3000);
    }

    function showPaymentSuccess(reference) {
        const plan = CheckoutApp.plans[CheckoutApp.selectedPlan] || CheckoutApp.plans.profesional;
        const now = new Date();

        // Actualizar datos de confirmacion
        $('#paymentRef').text(reference);
        $('#paymentDate').text(formatDate(now));
        $('#paymentBank').text(CheckoutApp.paymentData.bankName);
        $('#paymentPlan').text(plan.name);
        $('#paymentTotal').text(`${formatCurrency(CheckoutApp.totalAmount)} COP`);

        // Mostrar estado de exito
        $('#confirmationSuccess').show();
        $('#confirmationError').hide();

        // Ir al paso 3
        goToStep(3);

        // Guardar datos del pago en localStorage (para demo)
        localStorage.setItem('lastPayment', JSON.stringify({
            reference: reference,
            date: now.toISOString(),
            amount: CheckoutApp.totalAmount,
            plan: CheckoutApp.selectedPlan,
            payer: CheckoutApp.payerData
        }));
    }

    function showPaymentError() {
        // Mensajes de error aleatorios
        const errors = [
            'Fondos insuficientes en la cuenta',
            'Transaccion rechazada por el banco',
            'Tiempo de espera agotado',
            'Error de comunicacion con el banco'
        ];

        const randomError = errors[Math.floor(Math.random() * errors.length)];
        $('#errorMessage').text(randomError);

        // Mostrar estado de error
        $('#confirmationSuccess').hide();
        $('#confirmationError').show();

        // Ir al paso 3
        goToStep(3);

        // Rehabilitar boton de pago
        const $btnPay = $('#btnPay');
        $btnPay.prop('disabled', false).removeClass('btn-loading');
        $btnPay.html('<i class="bi bi-lock-fill me-2"></i>Pagar con PSE');
    }

    // ========================================
    // UTILIDADES
    // ========================================

    function generateReference() {
        const date = new Date();
        const dateStr = date.toISOString().slice(0, 10).replace(/-/g, '');
        const random = Math.floor(Math.random() * 1000).toString().padStart(3, '0');
        return `VCP-${dateStr}-${random}`;
    }

    function formatDate(date) {
        const options = {
            year: 'numeric',
            month: 'long',
            day: 'numeric',
            hour: '2-digit',
            minute: '2-digit'
        };
        return date.toLocaleDateString('es-CO', options);
    }

    // ========================================
    // DESCARGAR COMPROBANTE
    // ========================================

    function downloadReceipt() {
        const { jsPDF } = window.jspdf;
        const doc = new jsPDF();

        const plan = CheckoutApp.plans[CheckoutApp.selectedPlan] || CheckoutApp.plans.profesional;
        const reference = $('#paymentRef').text();
        const date = $('#paymentDate').text();

        // Configurar fuente
        doc.setFont('helvetica');

        // Header
        doc.setFillColor(37, 99, 235);
        doc.rect(0, 0, 220, 40, 'F');

        doc.setTextColor(255, 255, 255);
        doc.setFontSize(24);
        doc.text('VetSync', 20, 25);

        doc.setFontSize(12);
        doc.text('Comprobante de Pago', 120, 25);

        // Reset color
        doc.setTextColor(0, 0, 0);

        // Icono de exito
        doc.setFillColor(16, 185, 129);
        doc.circle(105, 60, 15, 'F');
        doc.setTextColor(255, 255, 255);
        doc.setFontSize(20);
        doc.text('✓', 101, 66);

        // Titulo
        doc.setTextColor(0, 0, 0);
        doc.setFontSize(18);
        doc.text('Pago Exitoso', 105, 90, { align: 'center' });

        // Linea separadora
        doc.setDrawColor(200, 200, 200);
        doc.line(20, 100, 190, 100);

        // Detalles
        doc.setFontSize(11);
        const startY = 115;
        const lineHeight = 12;

        const details = [
            ['Referencia:', reference],
            ['Fecha:', date],
            ['Metodo de pago:', `PSE - ${CheckoutApp.paymentData.bankName}`],
            ['Plan:', plan.name],
            ['Titular:', CheckoutApp.payerData.fullName],
            ['Documento:', `${CheckoutApp.payerData.docType} ${CheckoutApp.payerData.docNumber}`],
            ['Email:', CheckoutApp.payerData.email]
        ];

        details.forEach((detail, index) => {
            const y = startY + (index * lineHeight);
            doc.setTextColor(100, 100, 100);
            doc.text(detail[0], 20, y);
            doc.setTextColor(0, 0, 0);
            doc.text(detail[1], 80, y);
        });

        // Total
        doc.setDrawColor(200, 200, 200);
        doc.line(20, startY + (details.length * lineHeight) + 5, 190, startY + (details.length * lineHeight) + 5);

        doc.setFontSize(14);
        doc.setFont('helvetica', 'bold');
        const totalY = startY + (details.length * lineHeight) + 20;
        doc.text('Total Pagado:', 20, totalY);
        doc.setTextColor(16, 185, 129);
        doc.text(`${formatCurrency(CheckoutApp.totalAmount)} COP`, 80, totalY);

        // Footer
        doc.setTextColor(150, 150, 150);
        doc.setFontSize(9);
        doc.setFont('helvetica', 'normal');
        doc.text('Este comprobante es generado automaticamente por VetSync', 105, 270, { align: 'center' });
        doc.text('www.vetcarepro.com | soporte@vetcarepro.com', 105, 277, { align: 'center' });

        // Descargar
        doc.save(`Comprobante_${reference}.pdf`);
    }

    // ========================================
    // RESET MODAL AL CERRAR
    // ========================================

    $('#processingModal').on('hidden.bs.modal', function() {
        // Resetear estados del modal
        $('#processingState').show();
        $('#bankState').hide();
        $('.processing-progress .progress-bar').css('width', '0%');
        $('.processing-text').text('Redirigiendo a PSE...');
    });

    // Inicializar
    init();
});
