/**
 * VetSync - Profile Module
 * Modulo de perfil de usuario con validaciones y simulaciones
 */

$(document).ready(function() {
    // ========================================
    // User Data (Simulated Backend)
    // ========================================
    const user = {
        nombre: "Admin",
        apellido: "Usuario",
        genero: "masculino",
        tipoId: "cedula",
        identificacion: "1234567890",
        email: "admin@vetcarepro.com",
        codigoPais: "+57",
        telefono: "3001234567",
        pais: "colombia",
        ciudad: "bogota",
        foto: "https://images.unsplash.com/photo-1472099645785-5658abf4ff4e?w=200&h=200&fit=crop",
        twoFactorEnabled: false,
        password: "admin123"
    };

    // Cities by country
    const ciudadesPorPais = {
        colombia: ["Bogota", "Medellin", "Cali", "Barranquilla", "Cartagena"],
        usa: ["New York", "Los Angeles", "Chicago", "Houston", "Miami"],
        espana: ["Madrid", "Barcelona", "Valencia", "Sevilla", "Bilbao"],
        mexico: ["Ciudad de Mexico", "Guadalajara", "Monterrey", "Cancun", "Puebla"],
        argentina: ["Buenos Aires", "Cordoba", "Rosario", "Mendoza", "La Plata"],
        chile: ["Santiago", "Valparaiso", "Concepcion", "La Serena", "Antofagasta"],
        peru: ["Lima", "Arequipa", "Cusco", "Trujillo", "Chiclayo"],
        venezuela: ["Caracas", "Maracaibo", "Valencia", "Barquisimeto", "Maracay"]
    };

    // ========================================
    // Initialize
    // ========================================
    function init() {
        iniciarComponentes();
        initPhotoUpload();
        initCountryCity();
        initEmailValidation();
        initPasswordValidation();
        initTwoFactor();
        initFormHandlers();
    }

    function iniciarComponentes() {
        generalidades.initTelefonoInput(`#telefono`);

        // Format options
        var optionFormat = function(item) {
            if ( !item.id ) {
                return item.text;
            }

            var span = document.createElement('span');
            var imgUrl = item.element.getAttribute('data-kt-select2-country');
            var template = '';

            template += '<img src="' + imgUrl + '" class="rounded-circle h-40px w-40px me-4" alt="image"/>';
            template += item.text;

            span.innerHTML = template;

            return $(span);
        }

        // Init Select2 --- more info: https://select2.org/
        $(`#pais`).select2({
            templateSelection: optionFormat,
            templateResult: optionFormat
        });

        $(document).on('change', `#pais`, function(){
            if (this.value) {
                $.ajax({
                    type: 'GET',
                    url: route('ciudades.buscar', {'pais': this.value}),
                    success: function(response) {
                        if (response.estado == 'success') {
                            let ciudades = response?.ciudades ?? [];
                            let selectCiudad = $(`#ciudad`);
                            selectCiudad.empty();
                            let opcion = new Option('', '', false, false);
                            selectCiudad.append(opcion);
                            ciudades.forEach((ciudad) => {
                                let selected = false;
                                if (selectCiudad.attr('data-ciudad') && selectCiudad.attr('data-ciudad') == ciudad.id) {
                                    selected = true;
                                }
                                selectCiudad.append(new Option(ciudad.text, ciudad.id, selected, selected));
                            });
                            $(`#ciudad`).attr('disabled', false);
                            $(`#ciudad`).select2();
                        }
                        generalidades.toastrGenerico(response?.estado, response?.mensaje);
                        // $('.divOpciones').removeClass('d-none');
                    }
                });
            } else {
                $(`#ciudad`).attr('disabled', true);
            }
        });

        $(`#pais`).trigger('change');
    }

    // ========================================
    // Photo Upload
    // ========================================
    function initPhotoUpload() {
        const photoInput = $('#photoInput');
        const profilePhoto = $('.profile-photo');
        const photoPreviewModal = new bootstrap.Modal($('#photoPreviewModal'));

        // Click on photo or button to trigger file input
        profilePhoto.on('click', function() {
            photoInput.trigger('click');
        });

        $('#changePhotoBtn').on('click', function(e) {
            e.preventDefault();
            photoInput.trigger('click');
        });

        // Handle file selection
        photoInput.on('change', function(e) {
            const file = e.target.files[0];
            if (file) {
                // Validate file type
                if (!file.type.startsWith('image/')) {
                    showAlert('Por favor selecciona una imagen valida', 'danger');
                    return;
                }

                // Validate file size (max 5MB)
                if (file.size > 5 * 1024 * 1024) {
                    showAlert('La imagen no debe superar los 5MB', 'danger');
                    return;
                }

                // Preview image
                const reader = new FileReader();
                reader.onload = function(e) {
                    $('#photoPreviewImg').attr('src', e.target.result);
                    photoPreviewModal.show();
                };
                reader.readAsDataURL(file);
            }
        });

        // Confirm photo change
        $('#confirmPhotoBtn').on('click', function() {
            const newPhotoSrc = $('#photoPreviewImg').attr('src');
            user.foto = newPhotoSrc;

            // Update all photo elements
            $('#profilePhoto, #sidebarAvatar, #navbarAvatar').attr('src', newPhotoSrc);

            photoPreviewModal.hide();
            showAlert('Foto de perfil actualizada correctamente', 'success');

            // Reset input
            photoInput.val('');
        });
    }

    // ========================================
    // Country/City Dependency
    // ========================================
    function initCountryCity() {
        $('#pais').on('change', function() {
            const pais = $(this).val();
            updateCities(pais);
        });
    }

    function updateCities(pais, selectedCity = null) {
        const ciudadSelect = $('#ciudad');
        ciudadSelect.empty();

        if (pais && ciudadesPorPais[pais]) {
            ciudadSelect.prop('disabled', false);
            ciudadSelect.append('<option value="">Seleccionar ciudad...</option>');

            ciudadesPorPais[pais].forEach(function(ciudad) {
                const value = ciudad.toLowerCase().replace(/\s+/g, '-');
                const selected = selectedCity && value === selectedCity ? 'selected' : '';
                ciudadSelect.append(`<option value="${value}" ${selected}>${ciudad}</option>`);
            });
        } else {
            ciudadSelect.prop('disabled', true);
            ciudadSelect.append('<option value="">Selecciona pais primero</option>');
        }
    }

    // ========================================
    // Email Validation
    // ========================================
    function initEmailValidation() {
        $('#email, #emailConfirm').on('input', function() {
            validateEmails();
        });
    }

    function validateEmails() {
        const email = $('#email').val();
        const emailConfirm = $('#emailConfirm').val();

        if (emailConfirm && email !== emailConfirm) {
            $('#emailConfirm').addClass('is-invalid');
            $('#emailMatchError').show();
            return false;
        } else {
            $('#emailConfirm').removeClass('is-invalid');
            $('#emailMatchError').hide();
            return true;
        }
    }

    // ========================================
    // Password Validation
    // ========================================
    function initPasswordValidation() {
        // Toggle password visibility
        $('.toggle-password').on('click', function() {
            const input = $(this).siblings('input');
            const icon = $(this).find('i');

            if (input.attr('type') === 'password') {
                input.attr('type', 'text');
                icon.removeClass('bi-eye').addClass('bi-eye-slash');
            } else {
                input.attr('type', 'password');
                icon.removeClass('bi-eye-slash').addClass('bi-eye');
            }
        });

        // Password strength checker
        $('#newPassword').on('input', function() {
            const password = $(this).val();
            checkPasswordStrength(password);
            validatePasswordRequirements(password);
            checkPasswordMatch();
        });

        // Password match
        $('#confirmPassword').on('input', function() {
            checkPasswordMatch();
        });
    }

    function checkPasswordStrength(password) {
        const strengthFill = $('#strengthFill');
        const strengthText = $('#strengthText');

        let strength = 0;

        if (password.length >= 8) strength++;
        if (/[a-z]/.test(password)) strength++;
        if (/[A-Z]/.test(password)) strength++;
        if (/[0-9]/.test(password)) strength++;
        if (/[^a-zA-Z0-9]/.test(password)) strength++;

        strengthFill.removeClass('weak fair good strong');
        strengthText.removeClass('weak fair good strong');

        if (password.length === 0) {
            strengthText.text('Ingresa una contrasena');
        } else if (strength <= 2) {
            strengthFill.addClass('weak');
            strengthText.addClass('weak').text('Debil');
        } else if (strength === 3) {
            strengthFill.addClass('fair');
            strengthText.addClass('fair').text('Regular');
        } else if (strength === 4) {
            strengthFill.addClass('good');
            strengthText.addClass('good').text('Buena');
        } else {
            strengthFill.addClass('strong');
            strengthText.addClass('strong').text('Fuerte');
        }
    }

    function validatePasswordRequirements(password) {
        // Length
        toggleRequirement('#req-length', password.length >= 8);
        // Uppercase
        toggleRequirement('#req-upper', /[A-Z]/.test(password));
        // Lowercase
        toggleRequirement('#req-lower', /[a-z]/.test(password));
        // Number
        toggleRequirement('#req-number', /[0-9]/.test(password));
        // Special character
        toggleRequirement('#req-special', /[^a-zA-Z0-9]/.test(password));
    }

    function toggleRequirement(selector, isValid) {
        const element = $(selector);
        if (isValid) {
            element.addClass('valid');
        } else {
            element.removeClass('valid');
        }
    }

    function checkPasswordMatch() {
        const newPassword = $('#newPassword').val();
        const confirmPassword = $('#confirmPassword').val();

        if (confirmPassword && newPassword !== confirmPassword) {
            $('#confirmPassword').addClass('is-invalid');
            $('#passwordMatchError').show();
            return false;
        } else {
            $('#confirmPassword').removeClass('is-invalid');
            $('#passwordMatchError').hide();
            return true;
        }
    }

    // ========================================
    // Two-Factor Authentication
    // ========================================
    function initTwoFactor() {
        // Toggle 2FA
        $('#twoFactorSwitch').on('change', function() {
            const isEnabled = $(this).prop('checked');

            if (isEnabled) {
                $('#twoFactorLabel').text('Activando...');
                $('#twofaSetup').removeClass('d-none');
                $('#twofaActive').addClass('d-none');
            } else {
                if (user.twoFactorEnabled) {
                    // Confirm disable
                    if (confirm('¿Estas seguro de desactivar la autenticacion de dos factores?')) {
                        user.twoFactorEnabled = false;
                        updateTwoFactorStatus();
                        $('#twofaSetup').addClass('d-none');
                        $('#twofaActive').addClass('d-none');
                        showAlert('Autenticacion de dos factores desactivada', 'warning');
                    } else {
                        $(this).prop('checked', true);
                    }
                } else {
                    $('#twoFactorLabel').text('Desactivado');
                    $('#twofaSetup').addClass('d-none');
                }
            }
        });

        // Code digit inputs
        $('.code-digit').on('input', function() {
            const value = $(this).val();
            const index = parseInt($(this).data('index'));

            // Only allow numbers
            $(this).val(value.replace(/[^0-9]/g, ''));

            // Auto-focus next input
            if (value.length === 1 && index < 5) {
                $(`.code-digit[data-index="${index + 1}"]`).focus();
            }
        });

        // Handle backspace
        $('.code-digit').on('keydown', function(e) {
            const index = parseInt($(this).data('index'));

            if (e.key === 'Backspace' && $(this).val() === '' && index > 0) {
                $(`.code-digit[data-index="${index - 1}"]`).focus();
            }
        });

        // Verify code
        $('#verifyCodeBtn').on('click', function() {
            let code = '';
            $('.code-digit').each(function() {
                code += $(this).val();
            });

            if (code.length !== 6) {
                showAlert('Por favor ingresa el codigo completo de 6 digitos', 'danger');
                $('.verification-code-input').addClass('shake');
                setTimeout(() => $('.verification-code-input').removeClass('shake'), 300);
                return;
            }

            // Simulate verification
            const btn = $(this);
            btn.find('.btn-text').addClass('d-none');
            btn.find('.btn-loader').removeClass('d-none');
            btn.prop('disabled', true);

            setTimeout(function() {
                // Simulated success (any 6-digit code works)
                user.twoFactorEnabled = true;
                updateTwoFactorStatus();

                $('#twofaSetup').addClass('d-none');
                $('#twofaActive').removeClass('d-none');

                btn.find('.btn-text').removeClass('d-none');
                btn.find('.btn-loader').addClass('d-none');
                btn.prop('disabled', false);

                // Clear code inputs
                $('.code-digit').val('');

                showAlert('Autenticacion de dos factores activada correctamente', 'success');
            }, 1500);
        });

        // Copy secret code
        $('#copySecret').on('click', function() {
            const secretCode = $('#secretCode').text();
            navigator.clipboard.writeText(secretCode).then(function() {
                showAlert('Codigo secreto copiado al portapapeles', 'success');
            });
        });

        // Download backup codes
        $('#downloadCodes').on('click', function() {
            const codes = [];
            $('#backupCodes code').each(function() {
                codes.push($(this).text());
            });

            const content = "VetSync - Codigos de Respaldo 2FA\n\n" +
                           "Guarda estos codigos en un lugar seguro.\n" +
                           "Cada codigo solo puede usarse una vez.\n\n" +
                           codes.join('\n');

            const blob = new Blob([content], { type: 'text/plain' });
            const url = URL.createObjectURL(blob);
            const a = document.createElement('a');
            a.href = url;
            a.download = 'vetcarepro-backup-codes.txt';
            a.click();
            URL.revokeObjectURL(url);

            showAlert('Codigos de respaldo descargados', 'success');
        });

        // Regenerate codes
        $('#regenerateCodes').on('click', function() {
            if (confirm('¿Estas seguro? Los codigos actuales quedaran invalidos.')) {
                const newCodes = generateBackupCodes();
                const codesGrid = $('#backupCodes');
                codesGrid.empty();

                newCodes.forEach(function(code) {
                    codesGrid.append(`<code>${code}</code>`);
                });

                showAlert('Nuevos codigos de respaldo generados', 'success');
            }
        });
    }

    function updateTwoFactorStatus() {
        const statusIcon = $('#twoFactorStatusIcon');
        const statusText = $('#twoFactorStatusText');
        const toggle = $('#twoFactorSwitch');
        const label = $('#twoFactorLabel');

        if (user.twoFactorEnabled) {
            statusIcon.addClass('active').find('i').removeClass('bi-x-lg').addClass('bi-check-lg');
            statusText.text('Activado');
            toggle.prop('checked', true);
            label.text('Activado');
            $('#twofaActive').removeClass('d-none');
            $('#twofaSetup').addClass('d-none');
        } else {
            statusIcon.removeClass('active').find('i').removeClass('bi-check-lg').addClass('bi-x-lg');
            statusText.text('No activado');
            toggle.prop('checked', false);
            label.text('Desactivado');
            $('#twofaActive').addClass('d-none');
        }
    }

    function generateBackupCodes() {
        const codes = [];
        const chars = 'ABCDEFGHIJKLMNOPQRSTUVWXYZ0123456789';

        for (let i = 0; i < 6; i++) {
            let code = '';
            for (let j = 0; j < 4; j++) {
                code += chars.charAt(Math.floor(Math.random() * chars.length));
            }
            code += '-';
            for (let j = 0; j < 4; j++) {
                code += chars.charAt(Math.floor(Math.random() * chars.length));
            }
            codes.push(code);
        }

        return codes;
    }

    // ========================================
    // Form Handlers
    // ========================================
    function initFormHandlers() {
        // Personal data form
        $('#personalDataForm').on('submit', function(e) {
            e.preventDefault();

            // Validate emails match
            if (!validateEmails()) {
                showAlert('Los correos electronicos no coinciden', 'danger');
                return;
            }

            let formData = new FormData(document.getElementById("personalDataForm"));
            let inputTelefono = generalidades.darTelefonoInput(`#telefono`);
            let tel = inputTelefono?.getNumber(intlTelInputUtils.numberFormat.NATIONAL);
            tel = tel.replace(/\((\w+)\)/g, "$1");
            tel = tel.replace(/-/g, "");
            tel = tel.replace(/\s/g, "");
            let codigo = inputTelefono?.getSelectedCountryData()?.dialCode ?? '';
            let nombre_tel = inputTelefono?.getSelectedCountryData()?.iso2 ?? '';
            formData.set('telefono', tel);
            formData.set('codigo_telefono', codigo);
            formData.set('nombre_tel', nombre_tel);

            const config = {
                'method': 'PUT',
                'headers': {
                    'Accept': generalidades.CONTENT_TYPE_JSON,
                },
                'body': formData
            }

            const success = (response) => {
                if (response.estado == 'success') {
                    generalidades.ocultarValidaciones('#personalDataForm');
                }
                generalidades.ocultarCargando('#personalDataForm');
                generalidades.toastrGenerico(response?.estado, response?.mensaje);
                location.reload();
            }

            const error = (response) => {
                generalidades.ocultarCargando('3personalDataForm');
                generalidades.toastrGenerico(response?.estado, response?.mensaje);
                generalidades.mostrarValidaciones('#personalDataForm', response.validaciones);
            }
            const rutaActualizar = route("usuarios.update", { "usuario": formData.get("uuid") });
            generalidades.edit(rutaActualizar, config, success, error);
            generalidades.mostrarCargando('#personalDataForm');
        });

        // Cancel personal form
        $('#cancelPersonalBtn').on('click', function() {
            // loadUserData();
            showAlert('Cambios descartados', 'warning');
        });

        // Password form
        $('#passwordForm').on('submit', function(e) {
            e.preventDefault();

            const currentPassword = $('#currentPassword').val();
            const newPassword = $('#newPassword').val();
            const confirmPassword = $('#confirmPassword').val();

            // Validate current password
            if (currentPassword !== user.password) {
                showAlert('La contrasena actual es incorrecta', 'danger');
                $('#currentPassword').addClass('is-invalid');
                return;
            }
            $('#currentPassword').removeClass('is-invalid');

            // Validate password match
            if (!checkPasswordMatch()) {
                showAlert('Las contrasenas no coinciden', 'danger');
                return;
            }

            // Validate password strength
            if (newPassword.length < 8) {
                showAlert('La contrasena debe tener al menos 8 caracteres', 'danger');
                return;
            }

            // Show loading
            const btn = $('#savePasswordBtn');
            btn.find('.btn-text').addClass('d-none');
            btn.find('.btn-loader').removeClass('d-none');
            btn.prop('disabled', true);

            // Simulate save
            setTimeout(function() {
                user.password = newPassword;

                // Reset form
                $('#passwordForm')[0].reset();
                checkPasswordStrength('');
                $('.requirements-list li').removeClass('valid');

                btn.find('.btn-text').removeClass('d-none');
                btn.find('.btn-loader').addClass('d-none');
                btn.prop('disabled', false);

                showAlert('Contrasena actualizada correctamente', 'success');
            }, 1500);
        });

        // Close all sessions
        $('#closeAllSessions').on('click', function() {
            if (confirm('¿Estas seguro de cerrar todas las sesiones? Tendras que volver a iniciar sesion.')) {
                showAlert('Todas las sesiones han sido cerradas', 'success');
                setTimeout(function() {
                    window.location.href = 'login.html';
                }, 1500);
            }
        });
    }

    // ========================================
    // Alert Helper
    // ========================================
    function showAlert(message, type) {
        const alertContainer = $('#alertContainer');
        const iconMap = {
            success: 'bi-check-circle-fill',
            danger: 'bi-exclamation-circle-fill',
            warning: 'bi-exclamation-triangle-fill',
            info: 'bi-info-circle-fill'
        };

        const alert = $(`
            <div class="alert alert-${type} alert-dismissible fade show" role="alert">
                <i class="bi ${iconMap[type]}"></i>
                <span>${message}</span>
                <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
            </div>
        `);

        alertContainer.html(alert);

        // Auto dismiss after 5 seconds
        setTimeout(function() {
            alert.alert('close');
        }, 5000);
    }

    // ========================================
    // Initialize
    // ========================================
    init();
});
