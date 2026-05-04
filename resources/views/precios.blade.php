@extends('layouts.landing')

@section('imports')
    @vite(['resources/css/precios.css', 'resources/js/precios.js'])
@endsection

@section('content')
    <!-- Hero Section -->
    <section class="pricing-hero">
        <div class="hero-bg-pattern"></div>
        <div class="container position-relative">
            <div class="row justify-content-center text-center">
                <div class="col-lg-8">
                    <span class="badge bg-primary-subtle text-primary px-3 py-2 rounded-pill mb-3" data-aos="fade-up">
                        <i class="bi bi-tag-fill me-1"></i> Planes flexibles
                    </span>
                    <h1 class="display-4 fw-bold mb-4" data-aos="fade-up" data-aos-delay="100">
                        El plan perfecto para tu <span class="text-gradient">clinica veterinaria</span>
                    </h1>
                    <p class="lead text-muted mb-4" data-aos="fade-up" data-aos-delay="200">
                        Desde consultorios pequenos hasta hospitales veterinarios. Elige el plan que mejor se adapte a tus
                        necesidades y comienza a optimizar tu clinica hoy mismo.
                    </p>

                    <!-- Stats Counter -->
                    <div class="stats-row d-flex justify-content-center gap-5 mb-5" data-aos="fade-up" data-aos-delay="300">
                        <div class="stat-item text-center">
                            <h3 class="fw-bold text-primary mb-0 counter" data-target="2500">0</h3>
                            <small class="text-muted">Clinicas activas</small>
                        </div>
                        <div class="stat-item text-center">
                            <h3 class="fw-bold text-primary mb-0 counter" data-target="15000">0</h3>
                            <small class="text-muted">Veterinarios</small>
                        </div>
                        <div class="stat-item text-center">
                            <h3 class="fw-bold text-primary mb-0 counter" data-target="500000">0</h3>
                            <small class="text-muted">Mascotas registradas</small>
                        </div>
                    </div>

                    <!-- Billing Toggle -->
                    <div class="billing-toggle d-inline-flex align-items-center bg-white rounded-pill p-2 shadow-sm"
                        data-aos="fade-up" data-aos-delay="400">
                        <span class="billing-label me-3 ps-3" id="monthlyLabel">Mensual</span>
                        <div class="form-check form-switch mb-0">
                            <input class="form-check-input" type="checkbox" role="switch" id="billingToggle">
                        </div>
                        <span class="billing-label ms-2 pe-3" id="annualLabel">
                            Anual
                            <span class="badge bg-success ms-2">Ahorra 20%</span>
                        </span>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Pricing Cards Section -->
    <section class="pricing-section">
        <div class="container">
            <div class="row g-4 justify-content-center">
                <!-- Plan Basico -->
                <div class="col-lg-4 col-md-6" data-aos="fade-up" data-aos-delay="100">
                    <div class="pricing-card">
                        <div class="pricing-card-header">
                            <div class="plan-icon basic">
                                <i class="bi bi-building"></i>
                            </div>
                            <h4 class="plan-name">Basico</h4>
                            <p class="plan-description">Perfecto para consultorios pequenos</p>
                        </div>
                        <div class="pricing-card-body">
                            <div class="price-container">
                                <span class="currency">$</span>
                                <span class="price" data-monthly="89000" data-annual="71200">89.000</span>
                                <span class="period">COP/mes</span>
                            </div>
                            <p class="price-note">Facturado <span class="billing-period">mensualmente</span></p>

                            <ul class="features-list">
                                <li class="included">
                                    <i class="bi bi-check-circle-fill"></i>
                                    <span>1 sede</span>
                                </li>
                                <li class="included">
                                    <i class="bi bi-check-circle-fill"></i>
                                    <span>Hasta 3 usuarios</span>
                                </li>
                                <li class="included">
                                    <i class="bi bi-check-circle-fill"></i>
                                    <span>Clientes ilimitados</span>
                                </li>
                                <li class="included">
                                    <i class="bi bi-check-circle-fill"></i>
                                    <span>Mascotas ilimitadas</span>
                                </li>
                                <li class="included">
                                    <i class="bi bi-check-circle-fill"></i>
                                    <span>Historia clinica completa</span>
                                </li>
                                <li class="included">
                                    <i class="bi bi-check-circle-fill"></i>
                                    <span>Prescripciones digitales</span>
                                </li>
                                <li class="included">
                                    <i class="bi bi-check-circle-fill"></i>
                                    <span>Exportacion PDF</span>
                                </li>
                                <li class="included">
                                    <i class="bi bi-check-circle-fill"></i>
                                    <span>Soporte por email</span>
                                </li>
                                <li class="not-included">
                                    <i class="bi bi-x-circle"></i>
                                    <span>Dashboard con metricas</span>
                                </li>
                                <li class="not-included">
                                    <i class="bi bi-x-circle"></i>
                                    <span>Roles personalizados</span>
                                </li>
                                <li class="not-included">
                                    <i class="bi bi-x-circle"></i>
                                    <span>API Access</span>
                                </li>
                            </ul>
                        </div>
                        <div class="pricing-card-footer">
                            <a href="checkout.html?plan=basico"
                                class="btn btn-outline-primary btn-lg w-100 rounded-pill btn-checkout" data-plan="basico">
                                Comenzar ahora
                            </a>
                            <p class="trial-text">14 dias de prueba gratis</p>
                        </div>
                    </div>
                </div>

                <!-- Plan Profesional (Destacado) -->
                <div class="col-lg-4 col-md-6" data-aos="fade-up" data-aos-delay="200">
                    <div class="pricing-card featured">
                        <div class="popular-badge">
                            <i class="bi bi-star-fill me-1"></i> Mas Popular
                        </div>
                        <div class="pricing-card-header">
                            <div class="plan-icon professional">
                                <i class="bi bi-hospital"></i>
                            </div>
                            <h4 class="plan-name">Profesional</h4>
                            <p class="plan-description">Ideal para clinicas medianas</p>
                        </div>
                        <div class="pricing-card-body">
                            <div class="price-container">
                                <span class="currency">$</span>
                                <span class="price" data-monthly="199000" data-annual="159200">199.000</span>
                                <span class="period">COP/mes</span>
                            </div>
                            <p class="price-note">Facturado <span class="billing-period">mensualmente</span></p>

                            <ul class="features-list">
                                <li class="included">
                                    <i class="bi bi-check-circle-fill"></i>
                                    <span>Hasta 2 sedes</span>
                                </li>
                                <li class="included">
                                    <i class="bi bi-check-circle-fill"></i>
                                    <span>Usuarios ilimitados</span>
                                </li>
                                <li class="included">
                                    <i class="bi bi-check-circle-fill"></i>
                                    <span>Clientes ilimitados</span>
                                </li>
                                <li class="included">
                                    <i class="bi bi-check-circle-fill"></i>
                                    <span>Mascotas ilimitadas</span>
                                </li>
                                <li class="included">
                                    <i class="bi bi-check-circle-fill"></i>
                                    <span>Historia clinica completa</span>
                                </li>
                                <li class="included">
                                    <i class="bi bi-check-circle-fill"></i>
                                    <span>Prescripciones digitales</span>
                                </li>
                                <li class="included">
                                    <i class="bi bi-check-circle-fill"></i>
                                    <span>Exportacion PDF</span>
                                </li>
                                <li class="included highlight">
                                    <i class="bi bi-check-circle-fill"></i>
                                    <span>Dashboard con metricas</span>
                                </li>
                                <li class="included highlight">
                                    <i class="bi bi-check-circle-fill"></i>
                                    <span>Roles personalizados</span>
                                </li>
                                <li class="included highlight">
                                    <i class="bi bi-check-circle-fill"></i>
                                    <span>Soporte prioritario</span>
                                </li>
                                <li class="not-included">
                                    <i class="bi bi-x-circle"></i>
                                    <span>API Access</span>
                                </li>
                            </ul>
                        </div>
                        <div class="pricing-card-footer">
                            <a href="checkout.html?plan=profesional"
                                class="btn btn-primary btn-lg w-100 rounded-pill btn-checkout" data-plan="profesional">
                                Comenzar ahora
                            </a>
                            <p class="trial-text">14 dias de prueba gratis</p>
                        </div>
                    </div>
                </div>

                <!-- Plan Empresarial -->
                <div class="col-lg-4 col-md-6" data-aos="fade-up" data-aos-delay="300">
                    <div class="pricing-card">
                        <div class="pricing-card-header">
                            <div class="plan-icon enterprise">
                                <i class="bi bi-buildings"></i>
                            </div>
                            <h4 class="plan-name">Empresarial</h4>
                            <p class="plan-description">Para clinicas grandes y hospitales</p>
                        </div>
                        <div class="pricing-card-body">
                            <div class="price-container">
                                <span class="currency">$</span>
                                <span class="price" data-monthly="349000" data-annual="279200">349.000</span>
                                <span class="period">COP/mes</span>
                            </div>
                            <p class="price-note">Facturado <span class="billing-period">mensualmente</span></p>

                            <ul class="features-list">
                                <li class="included">
                                    <i class="bi bi-check-circle-fill"></i>
                                    <span>Sedes ilimitadas</span>
                                </li>
                                <li class="included">
                                    <i class="bi bi-check-circle-fill"></i>
                                    <span>Usuarios ilimitados</span>
                                </li>
                                <li class="included">
                                    <i class="bi bi-check-circle-fill"></i>
                                    <span>Clientes ilimitados</span>
                                </li>
                                <li class="included">
                                    <i class="bi bi-check-circle-fill"></i>
                                    <span>Mascotas ilimitadas</span>
                                </li>
                                <li class="included">
                                    <i class="bi bi-check-circle-fill"></i>
                                    <span>Historia clinica completa</span>
                                </li>
                                <li class="included">
                                    <i class="bi bi-check-circle-fill"></i>
                                    <span>Prescripciones digitales</span>
                                </li>
                                <li class="included">
                                    <i class="bi bi-check-circle-fill"></i>
                                    <span>Exportacion PDF</span>
                                </li>
                                <li class="included">
                                    <i class="bi bi-check-circle-fill"></i>
                                    <span>Dashboard con metricas</span>
                                </li>
                                <li class="included">
                                    <i class="bi bi-check-circle-fill"></i>
                                    <span>Roles personalizados</span>
                                </li>
                                <li class="included highlight">
                                    <i class="bi bi-check-circle-fill"></i>
                                    <span>Personalizacion de marca</span>
                                </li>
                                <li class="included highlight">
                                    <i class="bi bi-check-circle-fill"></i>
                                    <span>API Access completo</span>
                                </li>
                                <li class="included highlight">
                                    <i class="bi bi-check-circle-fill"></i>
                                    <span>Soporte dedicado 24/7</span>
                                </li>
                            </ul>
                        </div>
                        <div class="pricing-card-footer">
                            <a href="checkout.html?plan=empresarial"
                                class="btn btn-outline-primary btn-lg w-100 rounded-pill btn-checkout"
                                data-plan="empresarial">
                                Comenzar ahora
                            </a>
                            <p class="trial-text">Demo personalizada incluida</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Comparison Table Section -->
    <section class="comparison-section" id="comparar">
        <div class="container">
            <div class="row justify-content-center mb-5">
                <div class="col-lg-8 text-center">
                    <h2 class="display-6 fw-bold mb-3" data-aos="fade-up">Compara todos los planes</h2>
                    <p class="lead text-muted" data-aos="fade-up" data-aos-delay="100">
                        Encuentra el plan perfecto comparando todas las caracteristicas
                    </p>
                </div>
            </div>

            <div class="table-responsive" data-aos="fade-up" data-aos-delay="200">
                <table class="comparison-table">
                    <thead>
                        <tr>
                            <th class="feature-header">Caracteristicas</th>
                            <th class="plan-header">
                                <span class="plan-badge basic">Basico</span>
                            </th>
                            <th class="plan-header featured">
                                <span class="plan-badge professional">Profesional</span>
                                <span class="recommended-tag">Recomendado</span>
                            </th>
                            <th class="plan-header">
                                <span class="plan-badge enterprise">Empresarial</span>
                            </th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr class="category-row">
                            <td colspan="4"><i class="bi bi-building me-2"></i>Estructura</td>
                        </tr>
                        <tr>
                            <td>Numero de sedes</td>
                            <td>1</td>
                            <td class="featured-cell">2</td>
                            <td>Ilimitadas</td>
                        </tr>
                        <tr>
                            <td>Numero de usuarios</td>
                            <td>3</td>
                            <td class="featured-cell">Ilimitados</td>
                            <td>Ilimitados</td>
                        </tr>
                        <tr>
                            <td>Clientes</td>
                            <td><i class="bi bi-infinity"></i></td>
                            <td class="featured-cell"><i class="bi bi-infinity"></i></td>
                            <td><i class="bi bi-infinity"></i></td>
                        </tr>
                        <tr>
                            <td>Mascotas</td>
                            <td><i class="bi bi-infinity"></i></td>
                            <td class="featured-cell"><i class="bi bi-infinity"></i></td>
                            <td><i class="bi bi-infinity"></i></td>
                        </tr>
                        <tr class="category-row">
                            <td colspan="4"><i class="bi bi-clipboard2-pulse me-2"></i>Funcionalidades Clinicas</td>
                        </tr>
                        <tr>
                            <td>Historia clinica</td>
                            <td><i class="bi bi-check-lg text-success"></i></td>
                            <td class="featured-cell"><i class="bi bi-check-lg text-success"></i></td>
                            <td><i class="bi bi-check-lg text-success"></i></td>
                        </tr>
                        <tr>
                            <td>Prescripciones digitales</td>
                            <td><i class="bi bi-check-lg text-success"></i></td>
                            <td class="featured-cell"><i class="bi bi-check-lg text-success"></i></td>
                            <td><i class="bi bi-check-lg text-success"></i></td>
                        </tr>
                        <tr>
                            <td>Exportacion PDF</td>
                            <td><i class="bi bi-check-lg text-success"></i></td>
                            <td class="featured-cell"><i class="bi bi-check-lg text-success"></i></td>
                            <td><i class="bi bi-check-lg text-success"></i></td>
                        </tr>
                        <tr>
                            <td>Agenda de citas</td>
                            <td><i class="bi bi-check-lg text-success"></i></td>
                            <td class="featured-cell"><i class="bi bi-check-lg text-success"></i></td>
                            <td><i class="bi bi-check-lg text-success"></i></td>
                        </tr>
                        <tr>
                            <td>Recordatorios automaticos</td>
                            <td><i class="bi bi-x-lg text-danger"></i></td>
                            <td class="featured-cell"><i class="bi bi-check-lg text-success"></i></td>
                            <td><i class="bi bi-check-lg text-success"></i></td>
                        </tr>
                        <tr class="category-row">
                            <td colspan="4"><i class="bi bi-graph-up me-2"></i>Administracion</td>
                        </tr>
                        <tr>
                            <td>Dashboard con metricas</td>
                            <td><i class="bi bi-x-lg text-danger"></i></td>
                            <td class="featured-cell"><i class="bi bi-check-lg text-success"></i></td>
                            <td><i class="bi bi-check-lg text-success"></i></td>
                        </tr>
                        <tr>
                            <td>Roles y permisos</td>
                            <td><i class="bi bi-x-lg text-danger"></i></td>
                            <td class="featured-cell"><i class="bi bi-check-lg text-success"></i></td>
                            <td><i class="bi bi-check-lg text-success"></i></td>
                        </tr>
                        <tr>
                            <td>Reportes avanzados</td>
                            <td><i class="bi bi-x-lg text-danger"></i></td>
                            <td class="featured-cell"><i class="bi bi-check-lg text-success"></i></td>
                            <td><i class="bi bi-check-lg text-success"></i></td>
                        </tr>
                        <tr>
                            <td>Personalizacion de marca</td>
                            <td><i class="bi bi-x-lg text-danger"></i></td>
                            <td class="featured-cell"><i class="bi bi-x-lg text-danger"></i></td>
                            <td><i class="bi bi-check-lg text-success"></i></td>
                        </tr>
                        <tr class="category-row">
                            <td colspan="4"><i class="bi bi-code-slash me-2"></i>Integraciones</td>
                        </tr>
                        <tr>
                            <td>API Access</td>
                            <td><i class="bi bi-x-lg text-danger"></i></td>
                            <td class="featured-cell"><i class="bi bi-x-lg text-danger"></i></td>
                            <td><i class="bi bi-check-lg text-success"></i></td>
                        </tr>
                        <tr>
                            <td>Webhooks</td>
                            <td><i class="bi bi-x-lg text-danger"></i></td>
                            <td class="featured-cell"><i class="bi bi-x-lg text-danger"></i></td>
                            <td><i class="bi bi-check-lg text-success"></i></td>
                        </tr>
                        <tr>
                            <td>Integracion contable</td>
                            <td><i class="bi bi-x-lg text-danger"></i></td>
                            <td class="featured-cell"><i class="bi bi-check-lg text-success"></i></td>
                            <td><i class="bi bi-check-lg text-success"></i></td>
                        </tr>
                        <tr class="category-row">
                            <td colspan="4"><i class="bi bi-headset me-2"></i>Soporte</td>
                        </tr>
                        <tr>
                            <td>Soporte por email</td>
                            <td><i class="bi bi-check-lg text-success"></i></td>
                            <td class="featured-cell"><i class="bi bi-check-lg text-success"></i></td>
                            <td><i class="bi bi-check-lg text-success"></i></td>
                        </tr>
                        <tr>
                            <td>Soporte prioritario</td>
                            <td><i class="bi bi-x-lg text-danger"></i></td>
                            <td class="featured-cell"><i class="bi bi-check-lg text-success"></i></td>
                            <td><i class="bi bi-check-lg text-success"></i></td>
                        </tr>
                        <tr>
                            <td>Soporte 24/7</td>
                            <td><i class="bi bi-x-lg text-danger"></i></td>
                            <td class="featured-cell"><i class="bi bi-x-lg text-danger"></i></td>
                            <td><i class="bi bi-check-lg text-success"></i></td>
                        </tr>
                        <tr>
                            <td>Gerente de cuenta dedicado</td>
                            <td><i class="bi bi-x-lg text-danger"></i></td>
                            <td class="featured-cell"><i class="bi bi-x-lg text-danger"></i></td>
                            <td><i class="bi bi-check-lg text-success"></i></td>
                        </tr>
                    </tbody>
                    <tfoot>
                        <tr>
                            <td></td>
                            <td>
                                <a href="register.html" class="btn btn-outline-primary rounded-pill">Comenzar</a>
                            </td>
                            <td class="featured-cell">
                                <a href="register.html" class="btn btn-primary rounded-pill">Comenzar</a>
                            </td>
                            <td>
                                <a href="#contacto" class="btn btn-outline-primary rounded-pill">Contactar</a>
                            </td>
                        </tr>
                    </tfoot>
                </table>
            </div>
        </div>
    </section>

    <!-- Testimonials Section -->
    <section class="testimonials-section">
        <div class="container">
            <div class="row justify-content-center mb-5">
                <div class="col-lg-8 text-center">
                    <h2 class="display-6 fw-bold mb-3" data-aos="fade-up">Lo que dicen nuestros clientes</h2>
                    <p class="lead text-muted" data-aos="fade-up" data-aos-delay="100">
                        Miles de clinicas veterinarias ya confian en VetCare Pro
                    </p>
                </div>
            </div>

            <div class="row g-4">
                <div class="col-lg-4" data-aos="fade-up" data-aos-delay="100">
                    <div class="testimonial-card">
                        <div class="testimonial-rating">
                            <i class="bi bi-star-fill"></i>
                            <i class="bi bi-star-fill"></i>
                            <i class="bi bi-star-fill"></i>
                            <i class="bi bi-star-fill"></i>
                            <i class="bi bi-star-fill"></i>
                        </div>
                        <p class="testimonial-text">
                            "VetCare Pro transformo completamente la gestion de nuestra clinica. El dashboard nos da
                            visibilidad total de nuestras operaciones."
                        </p>
                        <div class="testimonial-author">
                            <div class="author-avatar">
                                <img src="https://ui-avatars.com/api/?name=Carlos+Rodriguez&background=2563eb&color=fff"
                                    alt="Dr. Carlos Rodriguez">
                            </div>
                            <div class="author-info">
                                <h6 class="mb-0">Dr. Carlos Rodriguez</h6>
                                <small class="text-muted">Clinica Veterinaria San Martin</small>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-lg-4" data-aos="fade-up" data-aos-delay="200">
                    <div class="testimonial-card">
                        <div class="testimonial-rating">
                            <i class="bi bi-star-fill"></i>
                            <i class="bi bi-star-fill"></i>
                            <i class="bi bi-star-fill"></i>
                            <i class="bi bi-star-fill"></i>
                            <i class="bi bi-star-fill"></i>
                        </div>
                        <p class="testimonial-text">
                            "La facilidad de uso es increible. Nuestro equipo lo adopto en solo una semana. El soporte es
                            excepcional."
                        </p>
                        <div class="testimonial-author">
                            <div class="author-avatar">
                                <img src="https://ui-avatars.com/api/?name=Maria+Gonzalez&background=10b981&color=fff"
                                    alt="Dra. Maria Gonzalez">
                            </div>
                            <div class="author-info">
                                <h6 class="mb-0">Dra. Maria Gonzalez</h6>
                                <small class="text-muted">Hospital Veterinario Central</small>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-lg-4" data-aos="fade-up" data-aos-delay="300">
                    <div class="testimonial-card">
                        <div class="testimonial-rating">
                            <i class="bi bi-star-fill"></i>
                            <i class="bi bi-star-fill"></i>
                            <i class="bi bi-star-fill"></i>
                            <i class="bi bi-star-fill"></i>
                            <i class="bi bi-star-half"></i>
                        </div>
                        <p class="testimonial-text">
                            "Pasamos de papel a digital en un mes. La exportacion de historiales clinicos a PDF nos ahorra
                            horas de trabajo."
                        </p>
                        <div class="testimonial-author">
                            <div class="author-avatar">
                                <img src="https://ui-avatars.com/api/?name=Andres+Lopez&background=7c3aed&color=fff"
                                    alt="Dr. Andres Lopez">
                            </div>
                            <div class="author-info">
                                <h6 class="mb-0">Dr. Andres Lopez</h6>
                                <small class="text-muted">VetCare Plus</small>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- FAQ Section -->
    <section class="faq-section" id="faq">
        <div class="container">
            <div class="row justify-content-center mb-5">
                <div class="col-lg-8 text-center">
                    <h2 class="display-6 fw-bold mb-3" data-aos="fade-up">Preguntas frecuentes</h2>
                    <p class="lead text-muted" data-aos="fade-up" data-aos-delay="100">
                        Encuentra respuestas a las preguntas mas comunes
                    </p>
                </div>
            </div>

            <div class="row justify-content-center">
                <div class="col-lg-8" data-aos="fade-up" data-aos-delay="200">
                    <div class="accordion faq-accordion" id="faqAccordion">
                        <div class="accordion-item">
                            <h2 class="accordion-header">
                                <button class="accordion-button" type="button" data-bs-toggle="collapse"
                                    data-bs-target="#faq1">
                                    <i class="bi bi-question-circle me-2"></i>
                                    Puedo cancelar mi suscripcion en cualquier momento?
                                </button>
                            </h2>
                            <div id="faq1" class="accordion-collapse collapse show" data-bs-parent="#faqAccordion">
                                <div class="accordion-body">
                                    Si, puedes cancelar tu suscripcion en cualquier momento desde tu panel de control. No
                                    hay contratos de permanencia ni penalizaciones. Tu cuenta permanecera activa hasta el
                                    final del periodo de facturacion actual.
                                </div>
                            </div>
                        </div>
                        <div class="accordion-item">
                            <h2 class="accordion-header">
                                <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse"
                                    data-bs-target="#faq2">
                                    <i class="bi bi-question-circle me-2"></i>
                                    Hay un periodo de prueba gratuito?
                                </button>
                            </h2>
                            <div id="faq2" class="accordion-collapse collapse" data-bs-parent="#faqAccordion">
                                <div class="accordion-body">
                                    Si! Todos nuestros planes incluyen 14 dias de prueba gratuita con acceso completo a
                                    todas las funcionalidades. No necesitas tarjeta de credito para comenzar.
                                </div>
                            </div>
                        </div>
                        <div class="accordion-item">
                            <h2 class="accordion-header">
                                <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse"
                                    data-bs-target="#faq3">
                                    <i class="bi bi-question-circle me-2"></i>
                                    Que incluye el soporte tecnico?
                                </button>
                            </h2>
                            <div id="faq3" class="accordion-collapse collapse" data-bs-parent="#faqAccordion">
                                <div class="accordion-body">
                                    <strong>Plan Basico:</strong> Soporte por email con respuesta en 24-48 horas.<br>
                                    <strong>Plan Profesional:</strong> Soporte prioritario por email y chat en vivo con
                                    respuesta en menos de 4 horas.<br>
                                    <strong>Plan Empresarial:</strong> Soporte 24/7 por telefono, email y chat, con un
                                    gerente de cuenta dedicado.
                                </div>
                            </div>
                        </div>
                        <div class="accordion-item">
                            <h2 class="accordion-header">
                                <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse"
                                    data-bs-target="#faq4">
                                    <i class="bi bi-question-circle me-2"></i>
                                    Puedo cambiar de plan en cualquier momento?
                                </button>
                            </h2>
                            <div id="faq4" class="accordion-collapse collapse" data-bs-parent="#faqAccordion">
                                <div class="accordion-body">
                                    Absolutamente. Puedes actualizar o cambiar tu plan cuando quieras. Si actualizas, el
                                    cambio se aplica inmediatamente y solo pagas la diferencia proporcional. Si bajas de
                                    plan, el cambio se aplica al siguiente ciclo de facturacion.
                                </div>
                            </div>
                        </div>
                        <div class="accordion-item">
                            <h2 class="accordion-header">
                                <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse"
                                    data-bs-target="#faq5">
                                    <i class="bi bi-question-circle me-2"></i>
                                    Mis datos estan seguros?
                                </button>
                            </h2>
                            <div id="faq5" class="accordion-collapse collapse" data-bs-parent="#faqAccordion">
                                <div class="accordion-body">
                                    La seguridad es nuestra prioridad. Utilizamos encriptacion SSL de 256 bits, copias de
                                    seguridad diarias automaticas, y cumplimos con las regulaciones de proteccion de datos.
                                    Tus datos nunca seran compartidos con terceros.
                                </div>
                            </div>
                        </div>
                        <div class="accordion-item">
                            <h2 class="accordion-header">
                                <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse"
                                    data-bs-target="#faq6">
                                    <i class="bi bi-question-circle me-2"></i>
                                    Que metodos de pago aceptan?
                                </button>
                            </h2>
                            <div id="faq6" class="accordion-collapse collapse" data-bs-parent="#faqAccordion">
                                <div class="accordion-body">
                                    Aceptamos tarjetas de credito y debito (Visa, Mastercard, American Express), PSE para
                                    transferencias bancarias directas, y pagos en efectivo a traves de Efecty y Baloto. Para
                                    planes empresariales, tambien ofrecemos facturacion directa.
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- CTA Section -->
    <section class="cta-section" id="contacto">
        <div class="cta-bg-pattern"></div>
        <div class="container position-relative">
            <div class="row justify-content-center">
                <div class="col-lg-8 text-center">
                    <h2 class="display-5 fw-bold text-white mb-4" data-aos="fade-up">
                        Listo para transformar tu clinica?
                    </h2>
                    <p class="lead text-white-50 mb-5" data-aos="fade-up" data-aos-delay="100">
                        Unete a mas de 2,500 clinicas veterinarias que ya optimizan su gestion con VetCare Pro. Comienza tu
                        prueba gratuita de 14 dias hoy mismo.
                    </p>
                    <div class="d-flex justify-content-center gap-3 flex-wrap" data-aos="fade-up" data-aos-delay="200">
                        <a href="register.html" class="btn btn-light btn-lg px-5 rounded-pill">
                            <i class="bi bi-rocket-takeoff me-2"></i>Empezar gratis
                        </a>
                        <a href="#" class="btn btn-outline-light btn-lg px-5 rounded-pill" data-bs-toggle="modal"
                            data-bs-target="#demoModal">
                            <i class="bi bi-play-circle me-2"></i>Solicitar demo
                        </a>
                    </div>
                    <p class="text-white-50 mt-4 small" data-aos="fade-up" data-aos-delay="300">
                        <i class="bi bi-credit-card me-1"></i> No requiere tarjeta de credito
                        <span class="mx-2">|</span>
                        <i class="bi bi-clock me-1"></i> Configuracion en 5 minutos
                        <span class="mx-2">|</span>
                        <i class="bi bi-x-circle me-1"></i> Cancela cuando quieras
                    </p>
                </div>
            </div>
        </div>
    </section>

    <!-- Demo Modal -->
    <div class="modal fade" id="demoModal" tabindex="-1" aria-labelledby="demoModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header border-0">
                    <h5 class="modal-title fw-bold" id="demoModalLabel">
                        <i class="bi bi-calendar-check text-primary me-2"></i>Solicitar Demo
                    </h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <form id="demoForm">
                        <div class="mb-3">
                            <label class="form-label">Nombre completo</label>
                            <input type="text" class="form-control" required>
                        </div>
                        <div class="mb-3">
                            <label class="form-label">Email corporativo</label>
                            <input type="email" class="form-control" required>
                        </div>
                        <div class="mb-3">
                            <label class="form-label">Telefono</label>
                            <input type="tel" class="form-control" required>
                        </div>
                        <div class="mb-3">
                            <label class="form-label">Nombre de la clinica</label>
                            <input type="text" class="form-control" required>
                        </div>
                        <div class="mb-3">
                            <label class="form-label">Tamano de la clinica</label>
                            <select class="form-select" required>
                                <option value="">Selecciona una opcion</option>
                                <option value="small">1-3 empleados</option>
                                <option value="medium">4-10 empleados</option>
                                <option value="large">11-25 empleados</option>
                                <option value="enterprise">Mas de 25 empleados</option>
                            </select>
                        </div>
                        <button type="submit" class="btn btn-primary w-100 rounded-pill">
                            <i class="bi bi-send me-2"></i>Solicitar Demo
                        </button>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection
