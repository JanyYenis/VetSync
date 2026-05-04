/* ========================================
   VetCare Pro - Register Page Scripts
   ======================================== */

$(document).ready(function() {
    // ========================================
    // Data Store
    // ========================================
    const registro = {
        usuario: {},
        clinica: {}
    };

    let currentStep = 1;
    const totalSteps = 2;

    // ========================================
    // Initialization
    // ========================================
    function init() {
        updateProgress();
        bindEvents();

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
    }

    // ========================================
    // Event Bindings
    // ========================================
    function bindEvents() {
        // Password strength indicator
        $('#password').on('input', function() {
            const password = $(this).val();
            updatePasswordStrength(password);
            checkPasswordMatch();
        });

        // Confirm password match
        $('#confirmPassword').on('input', function() {
            checkPasswordMatch();
        });

        // Toggle password visibility
        $('.btn-toggle-password').on('click', function() {
            const input = $(this).closest('.input-icon').find('input');
            const icon = $(this).find('i');

            if (input.attr('type') === 'password') {
                input.attr('type', 'text');
                icon.removeClass('bi-eye').addClass('bi-eye-slash');
            } else {
                input.attr('type', 'password');
                icon.removeClass('bi-eye-slash').addClass('bi-eye');
            }
        });

        // Logo upload
        $('#btnUploadLogo').on('click', function() {
            $('#logoInput').click();
        });

        $('#logoInput').on('change', function(e) {
            const file = e.target.files[0];
            if (file) {
                if (file.size > 2 * 1024 * 1024) {
                    showError('El archivo debe ser menor a 2MB');
                    return;
                }

                const reader = new FileReader();
                reader.onload = function(e) {
                    $('#logoPreview').html(`<img src="${e.target.result}" alt="Logo">`);
                    $('#logoPreview').addClass('has-image');
                };
                reader.readAsDataURL(file);
            }
        });

        // Step navigation
        $('#btnStep1').on('click', function() {
            if (validateStep1()) {
                saveStep1Data();
                goToStep(2);
            }
        });

        $('#btnPrev').on('click', function() {
            goToStep(1);
        });

        // Form submission
        $('#registerForm').on('submit', function(e) {
            e.preventDefault();
            if (validateStep2()) {
                saveStep2Data();
                submitForm();
            }
        });

        // Real-time validation
        $('#email, #emailClinica').on('blur', function() {
            validateEmail($(this));
        });

        // Clear validation on input
        $('.form-control, .form-select').on('input change', function() {
            $(this).removeClass('is-invalid is-valid');
        });
    }

    // ========================================
    // Password Strength
    // ========================================
    function updatePasswordStrength(password) {
        const strengthContainer = $('.password-strength');
        const strengthFill = $('#strengthFill');
        const strengthText = $('#strengthText');

        if (password.length === 0) {
            strengthContainer.removeClass('visible');
            return;
        }

        strengthContainer.addClass('visible');

        let strength = 0;
        let text = '';

        // Length check
        if (password.length >= 8) strength++;
        if (password.length >= 12) strength++;

        // Character checks
        if (/[a-z]/.test(password)) strength++;
        if (/[A-Z]/.test(password)) strength++;
        if (/[0-9]/.test(password)) strength++;
        if (/[^a-zA-Z0-9]/.test(password)) strength++;

        strengthFill.removeClass('weak fair good strong');

        if (strength <= 2) {
            strengthFill.addClass('weak');
            text = 'Debil';
        } else if (strength <= 3) {
            strengthFill.addClass('fair');
            text = 'Regular';
        } else if (strength <= 4) {
            strengthFill.addClass('good');
            text = 'Buena';
        } else {
            strengthFill.addClass('strong');
            text = 'Fuerte';
        }

        strengthText.text(text);
    }

    // ========================================
    // Password Match Check
    // ========================================
    function checkPasswordMatch() {
        const password = $('#password').val();
        const confirmPassword = $('#confirmPassword').val();
        const matchIndicator = $('#passwordMatch');

        if (confirmPassword.length > 0 && password === confirmPassword) {
            matchIndicator.addClass('visible');
            $('#confirmPassword').removeClass('is-invalid').addClass('is-valid');
        } else {
            matchIndicator.removeClass('visible');
            if (confirmPassword.length > 0) {
                $('#confirmPassword').addClass('is-invalid').removeClass('is-valid');
            }
        }
    }

    // ========================================
    // Email Validation
    // ========================================
    function validateEmail(input) {
        const email = input.val();
        const emailRegex = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;

        if (email && !emailRegex.test(email)) {
            input.addClass('is-invalid');
            return false;
        } else if (email) {
            input.addClass('is-valid').removeClass('is-invalid');
        }
        return true;
    }

    // ========================================
    // Step Validation
    // ========================================
    function validateStep1() {
        let isValid = true;
        hideError();

        // Required fields
        const requiredFields = [
            '#nombre', '#apellido', '#genero', '#tipoIdentidad',
            '#numeroIdentidad', '#email', '#pais', '#ciudad', '#telefono',
            '#password', '#confirmPassword'
        ];

        requiredFields.forEach(function(field) {
            const input = $(field);
            if (!input.val()) {
                input.addClass('is-invalid');
                isValid = false;
            } else {
                input.removeClass('is-invalid');
            }
        });

        // Email validation
        if (!validateEmail($('#email'))) {
            isValid = false;
        }

        // Password length
        const password = $('#password').val();
        if (password.length < 8) {
            $('#password').addClass('is-invalid');
            isValid = false;
        }

        // Password match
        const confirmPassword = $('#confirmPassword').val();
        if (password !== confirmPassword) {
            $('#confirmPassword').addClass('is-invalid');
            isValid = false;
        }

        if (!isValid) {
            showError('Por favor completa todos los campos correctamente');
        }

        return isValid;
    }

    function validateStep2() {
        let isValid = true;
        hideError();

        // Required fields
        const requiredFields = [
            '#nombreClinica', '#nitClinica', '#direccionClinica',
            '#emailClinica', '#telefonoClinica'
        ];

        requiredFields.forEach(function(field) {
            const input = $(field);
            if (!input.val()) {
                input.addClass('is-invalid');
                isValid = false;
            } else {
                input.removeClass('is-invalid');
            }
        });

        // Email validation
        if (!validateEmail($('#emailClinica'))) {
            isValid = false;
        }

        // Terms checkbox
        if (!$('#termsCheck').is(':checked')) {
            $('#termsCheck').addClass('is-invalid');
            isValid = false;
        }

        if (!isValid) {
            showError('Por favor completa todos los campos requeridos');
        }

        return isValid;
    }

    // ========================================
    // Save Data
    // ========================================
    function saveStep1Data() {
        registro.usuario = {
            nombre: $('#nombre').val(),
            apellido: $('#apellido').val(),
            genero: $('#genero').val(),
            tipoIdentidad: $('#tipoIdentidad').val(),
            numeroIdentidad: $('#numeroIdentidad').val(),
            email: $('#email').val(),
            pais: $('#pais').val(),
            ciudad: $('#ciudad').val(),
            telefono: $('#telefono').val(),
            password: $('#password').val()
        };
    }

    function saveStep2Data() {
        registro.clinica = {
            logo: $('#logoInput')[0].files[0] || null,
            nombre: $('#nombreClinica').val(),
            nit: $('#nitClinica').val(),
            direccion: $('#direccionClinica').val(),
            email: $('#emailClinica').val(),
            telefono: $('#telefonoClinica').val(),
            redes: {
                instagram: $('#instagram').val(),
                facebook: $('#facebook').val(),
                tiktok: $('#tiktok').val()
            }
        };
    }

    // ========================================
    // Step Navigation
    // ========================================
    function goToStep(step) {
        currentStep = step;

        // Update step visibility
        $('.form-step').removeClass('active');
        $(`#step${step}`).addClass('active');

        // Update stepper
        $('.step').each(function() {
            const stepNum = $(this).data('step');
            $(this).removeClass('active completed');

            if (stepNum < currentStep) {
                $(this).addClass('completed');
            } else if (stepNum === currentStep) {
                $(this).addClass('active');
            }
        });

        // Update step line
        if (currentStep > 1) {
            $('.step-line').addClass('filled');
        } else {
            $('.step-line').removeClass('filled');
        }

        updateProgress();

        // Scroll to top
        $('.register-form-container').scrollTop(0);
    }

    function updateProgress() {
        const progress = (currentStep / totalSteps) * 100;
        $('#progressBar').css('width', progress + '%');
    }

    // ========================================
    // Form Submission
    // ========================================
    function submitForm() {
        const btnSubmit = $('#btnSubmit');
        const btnText = btnSubmit.find('.btn-text');
        const btnLoader = btnSubmit.find('.btn-loader');

        // Show loader
        btnText.addClass('d-none');
        btnLoader.removeClass('d-none');
        btnSubmit.prop('disabled', true);

        // Simulate API call
        setTimeout(function() {
            // Hide form, show success
            $('#registerForm').addClass('d-none');
            $('.stepper-container').addClass('d-none');
            $('#successState').removeClass('d-none');

            // Log registration data
            console.log('Registro completado:', registro);

            // Save to localStorage for demo purposes
            const users = JSON.parse(localStorage.getItem('vetcare_users') || '[]');
            users.push({
                ...registro.usuario,
                clinica: registro.clinica,
                createdAt: new Date().toISOString()
            });
            localStorage.setItem('vetcare_users', JSON.stringify(users));

        }, 2000);
    }

    // ========================================
    // Alerts
    // ========================================
    function showError(message) {
        $('#errorText').text(message);
        $('#errorAlert').removeClass('d-none');

        // Auto hide after 5 seconds
        setTimeout(function() {
            hideError();
        }, 5000);
    }

    function hideError() {
        $('#errorAlert').addClass('d-none');
    }

    function showSuccess(message) {
        $('#successText').text(message);
        $('#successAlert').removeClass('d-none');
    }

    // ========================================
    // Initialize
    // ========================================
    init();
});
