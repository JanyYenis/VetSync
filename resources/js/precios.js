/**
 * VetSync - Pricing Page JavaScript
 * Handles billing toggle, animations, and interactions
 */

$(document).ready(function() {
    // Navbar scroll effect
    $(window).on('scroll', function() {
        if ($(this).scrollTop() > 50) {
            $('.navbar').addClass('scrolled');
        } else {
            $('.navbar').removeClass('scrolled');
        }
    });

    // Counter animation for stats
    function animateCounters() {
        $('.counter').each(function() {
            const $this = $(this);
            const target = parseInt($this.data('target'));
            const duration = 2000;
            const step = target / (duration / 16);
            let current = 0;

            const timer = setInterval(function() {
                current += step;
                if (current >= target) {
                    current = target;
                    clearInterval(timer);
                }

                // Format number with thousands separator
                let formatted;
                if (target >= 1000000) {
                    formatted = (current / 1000000).toFixed(1) + 'M';
                } else if (target >= 1000) {
                    formatted = Math.floor(current).toLocaleString('es-CO');
                } else {
                    formatted = Math.floor(current);
                }

                $this.text(formatted);
            }, 16);
        });
    }

    // Trigger counter animation when stats are visible
    const statsObserver = new IntersectionObserver((entries) => {
        entries.forEach(entry => {
            if (entry.isIntersecting) {
                animateCounters();
                statsObserver.unobserve(entry.target);
            }
        });
    }, { threshold: 0.5 });

    const statsRow = document.querySelector('.stats-row');
    if (statsRow) {
        statsObserver.observe(statsRow);
    }

    // Billing toggle functionality
    const $billingToggle = $('#billingToggle');
    const $monthlyLabel = $('#monthlyLabel');
    const $annualLabel = $('#annualLabel');
    const $prices = $('.price');
    const $billingPeriods = $('.billing-period');

    function updatePrices(isAnnual) {
        $prices.each(function() {
            const $price = $(this);
            const monthly = parseInt($price.data('monthly'));
            const annual = parseInt($price.data('annual'));

            // Add animation class
            $price.addClass('changing');

            setTimeout(() => {
                const newPrice = isAnnual ? annual : monthly;
                $price.text(newPrice.toLocaleString('es-CO'));
                $price.removeClass('changing');
            }, 150);
        });

        // Update billing period text
        $billingPeriods.text(isAnnual ? 'anualmente' : 'mensualmente');

        // Update label styles
        if (isAnnual) {
            $monthlyLabel.removeClass('active');
            $annualLabel.addClass('active');
        } else {
            $monthlyLabel.addClass('active');
            $annualLabel.removeClass('active');
        }
    }

    // Set initial state
    $monthlyLabel.addClass('active');

    // Toggle event
    $billingToggle.on('change', function() {
        updatePrices($(this).is(':checked'));
    });

    // Click on labels to toggle
    $monthlyLabel.on('click', function() {
        $billingToggle.prop('checked', false).trigger('change');
    });

    $annualLabel.on('click', function() {
        $billingToggle.prop('checked', true).trigger('change');
    });

    // Smooth scroll for anchor links
    $('a[href^="#"]').on('click', function(e) {
        const target = $(this.getAttribute('href'));
        if (target.length) {
            e.preventDefault();
            $('html, body').animate({
                scrollTop: target.offset().top - 80
            }, 800);
        }
    });

    // Demo form submission
    $('#demoForm').on('submit', function(e) {
        e.preventDefault();

        const $btn = $(this).find('button[type="submit"]');
        const originalText = $btn.html();

        // Show loading state
        $btn.prop('disabled', true).html('<span class="spinner-border spinner-border-sm me-2"></span>Enviando...');

        // Simulate form submission
        setTimeout(() => {
            // Show success state
            $btn.html('<i class="bi bi-check-circle me-2"></i>Solicitud enviada!');
            $btn.removeClass('btn-primary').addClass('btn-success');

            // Reset form
            setTimeout(() => {
                $('#demoModal').modal('hide');
                $(this)[0].reset();
                $btn.prop('disabled', false).html(originalText);
                $btn.removeClass('btn-success').addClass('btn-primary');

                // Show toast notification
                showToast('Solicitud enviada', 'Nos pondremos en contacto contigo pronto.', 'success');
            }, 2000);
        }, 1500);
    });

    // Toast notification function
    function showToast(title, message, type = 'info') {
        const toastHtml = `
            <div class="toast-container position-fixed top-0 end-0 p-3" style="z-index: 9999;">
                <div class="toast show" role="alert">
                    <div class="toast-header bg-${type === 'success' ? 'success' : 'primary'} text-white">
                        <i class="bi bi-${type === 'success' ? 'check-circle' : 'info-circle'} me-2"></i>
                        <strong class="me-auto">${title}</strong>
                        <button type="button" class="btn-close btn-close-white" data-bs-dismiss="toast"></button>
                    </div>
                    <div class="toast-body">${message}</div>
                </div>
            </div>
        `;

        const $toast = $(toastHtml);
        $('body').append($toast);

        setTimeout(() => {
            $toast.fadeOut(300, function() {
                $(this).remove();
            });
        }, 4000);
    }

    // Pricing card hover effects
    $('.pricing-card').on('mouseenter', function() {
        if (!$(this).hasClass('featured')) {
            $(this).find('.btn-outline-primary').addClass('btn-primary').removeClass('btn-outline-primary');
        }
    }).on('mouseleave', function() {
        if (!$(this).hasClass('featured')) {
            $(this).find('.btn-primary:not(.pricing-card.featured .btn-primary)').addClass('btn-outline-primary').removeClass('btn-primary');
        }
    });

    // Comparison table row hover effect
    $('.comparison-table tbody tr:not(.category-row)').on('mouseenter', function() {
        $(this).find('td').css('background-color', '');
    });

    // FAQ accordion custom behavior
    $('.faq-accordion .accordion-button').on('click', function() {
        const $icon = $(this).find('.bi');
        if ($(this).hasClass('collapsed')) {
            $icon.removeClass('bi-dash-circle').addClass('bi-question-circle');
        } else {
            $icon.removeClass('bi-question-circle').addClass('bi-dash-circle');
        }
    });

    // Scroll progress indicator
    const $scrollIndicator = $('<div class="scroll-indicator"></div>');
    $('body').prepend($scrollIndicator);

    $(window).on('scroll', function() {
        const scrollTop = $(this).scrollTop();
        const docHeight = $(document).height() - $(window).height();
        const scrollPercent = (scrollTop / docHeight) * 100;
        $scrollIndicator.css('width', scrollPercent + '%');
    });

    // Keyboard navigation for pricing cards
    $('.pricing-card').attr('tabindex', '0').on('keypress', function(e) {
        if (e.which === 13) { // Enter key
            $(this).find('.btn').first().click();
        }
    });

    // Animate elements on scroll
    const animateOnScroll = function() {
        $('.pricing-card, .testimonial-card, .faq-accordion').each(function() {
            const elementTop = $(this).offset().top;
            const windowBottom = $(window).scrollTop() + $(window).height();

            if (elementTop < windowBottom - 100) {
                $(this).addClass('animate-in');
            }
        });
    };

    $(window).on('scroll', animateOnScroll);
    animateOnScroll(); // Run on load

    // Mobile menu close on link click
    $('.navbar-nav .nav-link').on('click', function() {
        if ($(window).width() < 992) {
            $('.navbar-collapse').collapse('hide');
        }
    });

    // Parallax effect for hero section
    $(window).on('scroll', function() {
        const scrolled = $(this).scrollTop();
        $('.hero-bg-pattern').css('transform', 'translateY(' + (scrolled * 0.3) + 'px)');
    });

    // Feature highlight tooltip
    $('.features-list li.highlight').attr('title', 'Caracteristica destacada de este plan');

    // Initialize Bootstrap tooltips
    const tooltipTriggerList = [].slice.call(document.querySelectorAll('[data-bs-toggle="tooltip"]'));
    tooltipTriggerList.map(function(tooltipTriggerEl) {
        return new bootstrap.Tooltip(tooltipTriggerEl);
    });

    // Plan selection tracking (for analytics simulation)
    $('.pricing-card .btn').on('click', function(e) {
        const planName = $(this).closest('.pricing-card').find('.plan-name').text();
        const isAnnual = $billingToggle.is(':checked');
        const billingType = isAnnual ? 'annual' : 'monthly';

        console.log('Plan selected:', {
            plan: planName,
            billing: billingType,
            timestamp: new Date().toISOString()
        });

        // Store selection in sessionStorage
        sessionStorage.setItem('selectedPlan', JSON.stringify({
            plan: planName,
            billing: billingType
        }));
    });

    // Check if coming from a specific plan selection
    const urlParams = new URLSearchParams(window.location.search);
    const planParam = urlParams.get('plan');

    if (planParam) {
        setTimeout(() => {
            const $targetCard = $(`.pricing-card:has(.plan-name:contains("${planParam}"))`);
            if ($targetCard.length) {
                $('html, body').animate({
                    scrollTop: $targetCard.offset().top - 150
                }, 800);
                $targetCard.addClass('pulse-highlight');
            }
        }, 500);
    }

    // Accessibility improvements
    $('button, a, input, select').on('focus', function() {
        $(this).css('outline', '2px solid var(--primary)');
    }).on('blur', function() {
        $(this).css('outline', '');
    });

    // Print-friendly styles
    window.matchMedia('print').addListener(function(mql) {
        if (mql.matches) {
            $('.pricing-card').css('break-inside', 'avoid');
        }
    });
});
