/* ========================================
   VetCare Pro - Login Scripts
   ======================================== */

$(document).ready(function() {
    'use strict';

    // ==========================================
    // Toggle Password Visibility
    // ==========================================
    $('#togglePassword').on('click', function() {
        const $password = $('#password');
        const $icon = $(this).find('i');
        
        if ($password.attr('type') === 'password') {
            $password.attr('type', 'text');
            $icon.removeClass('bi-eye').addClass('bi-eye-slash');
        } else {
            $password.attr('type', 'password');
            $icon.removeClass('bi-eye-slash').addClass('bi-eye');
        }
    });

    // ==========================================
    // Login Form Validation and Submission
    // ==========================================
    $('#loginForm').on('submit', function(e) {
        e.preventDefault();
        
        const username = $('#username').val().trim();
        const password = $('#password').val().trim();
        
        // Reset previous errors
        resetErrors();
        
        // Validate fields
        let hasErrors = false;
        
        if (!username) {
            showError('username', 'Por favor ingresa tu usuario');
            hasErrors = true;
        }
        
        if (!password) {
            showError('password', 'Por favor ingresa tu contraseña');
            hasErrors = true;
        }
        
        if (hasErrors) return;
        
        // Show loading state
        const $btn = $('#loginBtn');
        $btn.find('.btn-text').addClass('d-none');
        $btn.find('.btn-loader').removeClass('d-none');
        $btn.prop('disabled', true);
        
        // Simulate login verification
        setTimeout(function() {
            // Check credentials (simulated)
            if (username === 'admin' && password === 'admin123') {
                // Success - Store session
                sessionStorage.setItem('vetcare_logged_in', 'true');
                sessionStorage.setItem('vetcare_user', JSON.stringify({
                    username: 'admin',
                    name: 'Dr. Admin',
                    role: 'Administrador'
                }));
                
                // Remember me
                if ($('#rememberMe').is(':checked')) {
                    localStorage.setItem('vetcare_remember', username);
                } else {
                    localStorage.removeItem('vetcare_remember');
                }
                
                // Redirect to dashboard
                window.location.href = 'dashboard.html';
            } else {
                // Error
                showLoginError('Usuario o contraseña incorrectos');
                
                // Reset button
                $btn.find('.btn-text').removeClass('d-none');
                $btn.find('.btn-loader').addClass('d-none');
                $btn.prop('disabled', false);
            }
        }, 1500);
    });

    // ==========================================
    // Error Handling Functions
    // ==========================================
    function showError(field, message) {
        const $input = $(`#${field}`);
        const $error = $(`#${field}Error`);
        
        $input.addClass('is-invalid');
        $error.text(message).show();
    }

    function showLoginError(message) {
        const $alert = $('#loginError');
        const $text = $('#loginErrorText');
        
        $text.text(message);
        $alert.removeClass('d-none');
        
        // Shake animation
        $alert.addClass('animate__animated animate__shakeX');
        setTimeout(function() {
            $alert.removeClass('animate__animated animate__shakeX');
        }, 500);
    }

    function resetErrors() {
        $('.form-control').removeClass('is-invalid');
        $('.invalid-feedback').hide();
        $('#loginError').addClass('d-none');
    }

    // ==========================================
    // Remember Me - Auto-fill
    // ==========================================
    const rememberedUser = localStorage.getItem('vetcare_remember');
    if (rememberedUser) {
        $('#username').val(rememberedUser);
        $('#rememberMe').prop('checked', true);
        $('#password').focus();
    } else {
        $('#username').focus();
    }

    // ==========================================
    // Clear Errors on Input
    // ==========================================
    $('#username, #password').on('input', function() {
        $(this).removeClass('is-invalid');
        $(this).siblings('.invalid-feedback').hide();
        $('#loginError').addClass('d-none');
    });

    // ==========================================
    // Enter Key Navigation
    // ==========================================
    $('#username').on('keypress', function(e) {
        if (e.which === 13) {
            e.preventDefault();
            $('#password').focus();
        }
    });
});
