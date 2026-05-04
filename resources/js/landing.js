/* ========================================
   VetCare Pro - Landing Page Scripts
   ======================================== */

$(document).ready(function() {
    'use strict';

    // ==========================================
    // Navbar Scroll Effect
    // ==========================================
    $(window).on('scroll', function() {
        if ($(this).scrollTop() > 50) {
            $('.navbar').addClass('scrolled');
        } else {
            $('.navbar').removeClass('scrolled');
        }
    });

    // ==========================================
    // Smooth Scroll for Navigation Links
    // ==========================================
    $('a[href^="#"]').on('click', function(e) {
        const target = $(this.getAttribute('href'));
        if (target.length) {
            e.preventDefault();
            $('html, body').animate({
                scrollTop: target.offset().top - 80
            }, 800);
            
            // Close mobile menu if open
            $('.navbar-collapse').collapse('hide');
        }
    });

    // ==========================================
    // Active Navigation Link on Scroll
    // ==========================================
    $(window).on('scroll', function() {
        const scrollPos = $(this).scrollTop();
        
        $('section[id]').each(function() {
            const top = $(this).offset().top - 100;
            const bottom = top + $(this).outerHeight();
            const id = $(this).attr('id');
            
            if (scrollPos >= top && scrollPos < bottom) {
                $('.nav-link').removeClass('active');
                $(`.nav-link[href="#${id}"]`).addClass('active');
            }
        });
    });

    // ==========================================
    // Lightbox Configuration
    // ==========================================
    if (typeof lightbox !== 'undefined') {
        lightbox.option({
            'resizeDuration': 200,
            'wrapAround': true,
            'albumLabel': 'Imagen %1 de %2',
            'fadeDuration': 300,
            'imageFadeDuration': 300
        });
    }

    // ==========================================
    // Testimonials Carousel
    // ==========================================
    const testimonialCarousel = document.getElementById('testimonialCarousel');
    if (testimonialCarousel) {
        new bootstrap.Carousel(testimonialCarousel, {
            interval: 5000,
            wrap: true
        });
    }

    // ==========================================
    // Contact Form Handling
    // ==========================================
    $('#contactForm').on('submit', function(e) {
        e.preventDefault();
        
        const $form = $(this);
        const $btn = $form.find('button[type="submit"]');
        const originalText = $btn.html();
        
        // Show loading state
        $btn.html('<span class="spinner-border spinner-border-sm me-2"></span>Enviando...');
        $btn.prop('disabled', true);
        
        // Simulate form submission
        setTimeout(function() {
            // Reset form
            $form[0].reset();
            
            // Show success message
            $btn.html('<i class="bi bi-check-lg me-2"></i>Mensaje Enviado');
            $btn.removeClass('btn-primary').addClass('btn-success');
            
            // Reset button after 3 seconds
            setTimeout(function() {
                $btn.html(originalText);
                $btn.removeClass('btn-success').addClass('btn-primary');
                $btn.prop('disabled', false);
            }, 3000);
        }, 1500);
    });

    // ==========================================
    // Animation on Scroll (Simple Implementation)
    // ==========================================
    const animateOnScroll = function() {
        const elements = document.querySelectorAll('.service-card, .gallery-item, .testimonial-card');
        
        elements.forEach(function(el) {
            const elementTop = el.getBoundingClientRect().top;
            const windowHeight = window.innerHeight;
            
            if (elementTop < windowHeight - 100) {
                el.style.opacity = '1';
                el.style.transform = 'translateY(0)';
            }
        });
    };

    // Initialize elements with hidden state
    $('.service-card, .gallery-item').css({
        'opacity': '0',
        'transform': 'translateY(20px)',
        'transition': 'all 0.5s ease'
    });

    // Run animation check
    animateOnScroll();
    $(window).on('scroll', animateOnScroll);

    // ==========================================
    // Counter Animation for Stats
    // ==========================================
    const animateCounters = function() {
        $('.hero-section h3').each(function() {
            const $this = $(this);
            const text = $this.text();
            const match = text.match(/(\d+)/);
            
            if (match && !$this.hasClass('counted')) {
                const target = parseInt(match[0]);
                $this.addClass('counted');
                
                $({ count: 0 }).animate({ count: target }, {
                    duration: 2000,
                    easing: 'swing',
                    step: function() {
                        const value = Math.ceil(this.count);
                        $this.text(text.replace(/\d+/, value));
                    },
                    complete: function() {
                        $this.text(text);
                    }
                });
            }
        });
    };

    // Check if hero section is visible
    const heroSection = document.querySelector('.hero-section');
    if (heroSection) {
        const observer = new IntersectionObserver(function(entries) {
            entries.forEach(function(entry) {
                if (entry.isIntersecting) {
                    animateCounters();
                    observer.unobserve(entry.target);
                }
            });
        }, { threshold: 0.5 });
        
        observer.observe(heroSection);
    }

    // ==========================================
    // WhatsApp Button Tooltip
    // ==========================================
    const whatsappBtn = document.querySelector('.whatsapp-btn');
    if (whatsappBtn) {
        new bootstrap.Tooltip(whatsappBtn, {
            title: '¿Necesitas ayuda?',
            placement: 'left'
        });
    }
});
