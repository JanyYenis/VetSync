@extends('layouts.landing', ['title' => 'Landing'])

@section('content')
    <!-- Hero Section -->
    <section id="inicio" class="hero-section">
        <div class="hero-bg"></div>
        <div class="container position-relative">
            <div class="row align-items-center min-vh-100">
                <div class="col-lg-6">
                    <span class="badge bg-primary-subtle text-primary px-3 py-2 rounded-pill mb-3">
                        <i class="bi bi-star-fill me-1"></i> Clínica Veterinaria Premium
                    </span>
                    <h1 class="display-3 fw-bold mb-4">
                        Cuidamos a tu <span class="text-gradient">mejor amigo</span>
                    </h1>
                    <p class="lead text-muted mb-4">
                        Ofrecemos atención veterinaria de primera calidad con tecnología avanzada
                        y un equipo de profesionales dedicados al bienestar de tu mascota.
                    </p>
                    <div class="d-flex gap-3 flex-wrap">
                        <a href="#servicios" class="btn btn-primary btn-lg px-4 rounded-pill">
                            <i class="bi bi-arrow-right me-2"></i>Ver Servicios
                        </a>
                        <a href="#contacto" class="btn btn-outline-dark btn-lg px-4 rounded-pill">
                            <i class="bi bi-calendar-check me-2"></i>Agendar Cita
                        </a>
                    </div>
                    <div class="mt-5 d-flex align-items-center gap-4">
                        <div class="text-center">
                            <h3 class="fw-bold text-primary mb-0">15+</h3>
                            <small class="text-muted">Años de experiencia</small>
                        </div>
                        <div class="vr"></div>
                        <div class="text-center">
                            <h3 class="fw-bold text-primary mb-0">5000+</h3>
                            <small class="text-muted">Mascotas atendidas</small>
                        </div>
                        <div class="vr"></div>
                        <div class="text-center">
                            <h3 class="fw-bold text-primary mb-0">100%</h3>
                            <small class="text-muted">Satisfacción</small>
                        </div>
                    </div>
                </div>
                <div class="col-lg-6 d-none d-lg-block">
                    <div class="hero-image-container">
                        <div class="hero-image-bg"></div>
                        <img src="https://images.unsplash.com/photo-1587300003388-59208cc962cb?w=600&h=700&fit=crop"
                             alt="Perro feliz" class="hero-image">
                        <div class="floating-card card-1">
                            <i class="bi bi-heart-fill text-danger"></i>
                            <span>Atención 24/7</span>
                        </div>
                        <div class="floating-card card-2">
                            <i class="bi bi-shield-check text-success"></i>
                            <span>Certificados</span>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Servicios -->
    <section id="servicios" class="py-6 bg-light">
        <div class="container">
            <div class="text-center mb-5">
                <span class="badge bg-primary-subtle text-primary px-3 py-2 rounded-pill mb-3">
                    Nuestros Servicios
                </span>
                <h2 class="display-5 fw-bold">Servicios de <span class="text-gradient">Primera Calidad</span></h2>
                <p class="lead text-muted mx-auto" style="max-width: 600px;">
                    Contamos con equipos de última generación y profesionales altamente capacitados
                </p>
            </div>
            <div class="row g-4">
                <!-- Consulta General -->
                <div class="col-lg-3 col-md-6">
                    <div class="service-card">
                        <div class="service-icon">
                            <i class="bi bi-clipboard2-pulse"></i>
                        </div>
                        <img src="https://images.unsplash.com/photo-1628009368231-7bb7cfcb0def?w=400&h=200&fit=crop"
                             alt="Consulta General" class="service-img">
                        <h5 class="fw-bold mt-3">Consulta General</h5>
                        <p class="text-muted small">Evaluación completa del estado de salud de tu mascota</p>
                        <a href="#contacto" class="btn btn-sm btn-outline-primary rounded-pill">
                            Más Info <i class="bi bi-arrow-right"></i>
                        </a>
                    </div>
                </div>
                <!-- Vacunación -->
                <div class="col-lg-3 col-md-6">
                    <div class="service-card">
                        <div class="service-icon bg-success-subtle">
                            <i class="bi bi-shield-plus text-success"></i>
                        </div>
                        <img src="https://images.unsplash.com/photo-1612531386530-97286d97c2d2?w=400&h=200&fit=crop"
                             alt="Vacunación" class="service-img">
                        <h5 class="fw-bold mt-3">Vacunación</h5>
                        <p class="text-muted small">Esquemas de vacunación personalizados y actualizados</p>
                        <a href="#contacto" class="btn btn-sm btn-outline-primary rounded-pill">
                            Más Info <i class="bi bi-arrow-right"></i>
                        </a>
                    </div>
                </div>
                <!-- Cirugías -->
                <div class="col-lg-3 col-md-6">
                    <div class="service-card">
                        <div class="service-icon bg-danger-subtle">
                            <i class="bi bi-heart-pulse text-danger"></i>
                        </div>
                        <img src="https://images.unsplash.com/photo-1551190822-a9333d879b1f?w=400&h=200&fit=crop"
                             alt="Cirugías" class="service-img">
                        <h5 class="fw-bold mt-3">Cirugías</h5>
                        <p class="text-muted small">Procedimientos quirúrgicos con tecnología avanzada</p>
                        <a href="#contacto" class="btn btn-sm btn-outline-primary rounded-pill">
                            Más Info <i class="bi bi-arrow-right"></i>
                        </a>
                    </div>
                </div>
                <!-- Peluquería -->
                <div class="col-lg-3 col-md-6">
                    <div class="service-card">
                        <div class="service-icon bg-warning-subtle">
                            <i class="bi bi-scissors text-warning"></i>
                        </div>
                        <img src="https://images.unsplash.com/photo-1516734212186-a967f81ad0d7?w=400&h=200&fit=crop"
                             alt="Peluquería" class="service-img">
                        <h5 class="fw-bold mt-3">Peluquería</h5>
                        <p class="text-muted small">Estética y cuidado profesional para tu mascota</p>
                        <a href="#contacto" class="btn btn-sm btn-outline-primary rounded-pill">
                            Más Info <i class="bi bi-arrow-right"></i>
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Galería -->
    <section id="galeria" class="py-6">
        <div class="container">
            <div class="text-center mb-5">
                <span class="badge bg-primary-subtle text-primary px-3 py-2 rounded-pill mb-3">
                    Galería
                </span>
                <h2 class="display-5 fw-bold">Nuestros <span class="text-gradient">Pacientes Felices</span></h2>
            </div>
            <div class="row g-3">
                <div class="col-lg-4 col-md-6">
                    <a href="https://images.unsplash.com/photo-1587300003388-59208cc962cb?w=800"
                       data-lightbox="gallery" data-title="Golden Retriever">
                        <div class="gallery-item">
                            <img src="https://images.unsplash.com/photo-1587300003388-59208cc962cb?w=400&h=300&fit=crop"
                                 alt="Golden Retriever">
                            <div class="gallery-overlay">
                                <i class="bi bi-zoom-in"></i>
                            </div>
                        </div>
                    </a>
                </div>
                <div class="col-lg-4 col-md-6">
                    <a href="https://images.unsplash.com/photo-1514888286974-6c03e2ca1dba?w=800"
                       data-lightbox="gallery" data-title="Gato Naranja">
                        <div class="gallery-item">
                            <img src="https://images.unsplash.com/photo-1514888286974-6c03e2ca1dba?w=400&h=300&fit=crop"
                                 alt="Gato">
                            <div class="gallery-overlay">
                                <i class="bi bi-zoom-in"></i>
                            </div>
                        </div>
                    </a>
                </div>
                <div class="col-lg-4 col-md-6">
                    <a href="https://images.unsplash.com/photo-1583511655857-d19b40a7a54e?w=800"
                       data-lightbox="gallery" data-title="Bulldog Francés">
                        <div class="gallery-item">
                            <img src="https://images.unsplash.com/photo-1583511655857-d19b40a7a54e?w=400&h=300&fit=crop"
                                 alt="Bulldog">
                            <div class="gallery-overlay">
                                <i class="bi bi-zoom-in"></i>
                            </div>
                        </div>
                    </a>
                </div>
                <div class="col-lg-4 col-md-6">
                    <a href="https://images.unsplash.com/photo-1573865526739-10659fec78a5?w=800"
                       data-lightbox="gallery" data-title="Gato Gris">
                        <div class="gallery-item">
                            <img src="https://images.unsplash.com/photo-1573865526739-10659fec78a5?w=400&h=300&fit=crop"
                                 alt="Gato Gris">
                            <div class="gallery-overlay">
                                <i class="bi bi-zoom-in"></i>
                            </div>
                        </div>
                    </a>
                </div>
                <div class="col-lg-4 col-md-6">
                    <a href="https://images.unsplash.com/photo-1561037404-61cd46aa615b?w=800"
                       data-lightbox="gallery" data-title="Labrador">
                        <div class="gallery-item">
                            <img src="https://images.unsplash.com/photo-1561037404-61cd46aa615b?w=400&h=300&fit=crop"
                                 alt="Labrador">
                            <div class="gallery-overlay">
                                <i class="bi bi-zoom-in"></i>
                            </div>
                        </div>
                    </a>
                </div>
                <div class="col-lg-4 col-md-6">
                    <a href="https://images.unsplash.com/photo-1543466835-00a7907e9de1?w=800"
                       data-lightbox="gallery" data-title="Border Collie">
                        <div class="gallery-item">
                            <img src="https://images.unsplash.com/photo-1543466835-00a7907e9de1?w=400&h=300&fit=crop"
                                 alt="Border Collie">
                            <div class="gallery-overlay">
                                <i class="bi bi-zoom-in"></i>
                            </div>
                        </div>
                    </a>
                </div>
            </div>
        </div>
    </section>

    <!-- Testimonios -->
    <section id="testimonios" class="py-6 bg-light">
        <div class="container">
            <div class="text-center mb-5">
                <span class="badge bg-primary-subtle text-primary px-3 py-2 rounded-pill mb-3">
                    Testimonios
                </span>
                <h2 class="display-5 fw-bold">Lo que dicen <span class="text-gradient">nuestros clientes</span></h2>
            </div>
            <div id="testimonialCarousel" class="carousel slide" data-bs-ride="carousel">
                <div class="carousel-inner">
                    <div class="carousel-item active">
                        <div class="row justify-content-center">
                            <div class="col-lg-8">
                                <div class="testimonial-card text-center">
                                    <div class="testimonial-avatar">
                                        <img src="https://images.unsplash.com/photo-1494790108377-be9c29b29330?w=100&h=100&fit=crop" alt="Cliente">
                                    </div>
                                    <div class="stars mb-3">
                                        <i class="bi bi-star-fill text-warning"></i>
                                        <i class="bi bi-star-fill text-warning"></i>
                                        <i class="bi bi-star-fill text-warning"></i>
                                        <i class="bi bi-star-fill text-warning"></i>
                                        <i class="bi bi-star-fill text-warning"></i>
                                    </div>
                                    <p class="lead mb-4">"Excelente atención para mi perrito Max. El Dr. García es muy profesional y cariñoso con los animales. Totalmente recomendado."</p>
                                    <h5 class="fw-bold mb-0">María González</h5>
                                    <small class="text-muted">Dueña de Max</small>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="carousel-item">
                        <div class="row justify-content-center">
                            <div class="col-lg-8">
                                <div class="testimonial-card text-center">
                                    <div class="testimonial-avatar">
                                        <img src="https://images.unsplash.com/photo-1507003211169-0a1dd7228f2d?w=100&h=100&fit=crop" alt="Cliente">
                                    </div>
                                    <div class="stars mb-3">
                                        <i class="bi bi-star-fill text-warning"></i>
                                        <i class="bi bi-star-fill text-warning"></i>
                                        <i class="bi bi-star-fill text-warning"></i>
                                        <i class="bi bi-star-fill text-warning"></i>
                                        <i class="bi bi-star-fill text-warning"></i>
                                    </div>
                                    <p class="lead mb-4">"Mi gata Luna fue operada aquí y el resultado fue excelente. Las instalaciones son modernas y el equipo muy amable."</p>
                                    <h5 class="fw-bold mb-0">Carlos Rodríguez</h5>
                                    <small class="text-muted">Dueño de Luna</small>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="carousel-item">
                        <div class="row justify-content-center">
                            <div class="col-lg-8">
                                <div class="testimonial-card text-center">
                                    <div class="testimonial-avatar">
                                        <img src="https://images.unsplash.com/photo-1438761681033-6461ffad8d80?w=100&h=100&fit=crop" alt="Cliente">
                                    </div>
                                    <div class="stars mb-3">
                                        <i class="bi bi-star-fill text-warning"></i>
                                        <i class="bi bi-star-fill text-warning"></i>
                                        <i class="bi bi-star-fill text-warning"></i>
                                        <i class="bi bi-star-fill text-warning"></i>
                                        <i class="bi bi-star-fill text-warning"></i>
                                    </div>
                                    <p class="lead mb-4">"Llevan el control de vacunas de mis 3 mascotas. Siempre me recuerdan cuando toca cada vacuna. Servicio de primera."</p>
                                    <h5 class="fw-bold mb-0">Ana Martínez</h5>
                                    <small class="text-muted">Dueña de Rocky, Mia y Coco</small>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <button class="carousel-control-prev" type="button" data-bs-target="#testimonialCarousel" data-bs-slide="prev">
                    <span class="carousel-control-prev-icon bg-primary rounded-circle p-3"></span>
                </button>
                <button class="carousel-control-next" type="button" data-bs-target="#testimonialCarousel" data-bs-slide="next">
                    <span class="carousel-control-next-icon bg-primary rounded-circle p-3"></span>
                </button>
            </div>
        </div>
    </section>

    <!-- Contacto -->
    <section id="contacto" class="py-6">
        <div class="container">
            <div class="row g-5">
                <div class="col-lg-6">
                    <span class="badge bg-primary-subtle text-primary px-3 py-2 rounded-pill mb-3">
                        Contacto
                    </span>
                    <h2 class="display-5 fw-bold mb-4">¿Tienes alguna <span class="text-gradient">pregunta?</span></h2>
                    <p class="text-muted mb-4">Estamos aquí para ayudarte. Contáctanos y te responderemos lo antes posible.</p>

                    <div class="d-flex align-items-center mb-4">
                        <div class="contact-icon">
                            <i class="bi bi-geo-alt"></i>
                        </div>
                        <div>
                            <h6 class="fw-bold mb-0">Dirección</h6>
                            <p class="text-muted mb-0">Av. Principal #123, Ciudad</p>
                        </div>
                    </div>
                    <div class="d-flex align-items-center mb-4">
                        <div class="contact-icon">
                            <i class="bi bi-telephone"></i>
                        </div>
                        <div>
                            <h6 class="fw-bold mb-0">Teléfono</h6>
                            <p class="text-muted mb-0">+57 317 178 9584</p>
                        </div>
                    </div>
                    <div class="d-flex align-items-center mb-4">
                        <div class="contact-icon">
                            <i class="bi bi-envelope"></i>
                        </div>
                        <div>
                            <h6 class="fw-bold mb-0">Email</h6>
                            <p class="text-muted mb-0">info@gijac.com</p>
                        </div>
                    </div>
                    <div class="d-flex align-items-center">
                        <div class="contact-icon">
                            <i class="bi bi-clock"></i>
                        </div>
                        <div>
                            <h6 class="fw-bold mb-0">Horario</h6>
                            <p class="text-muted mb-0">Lun - Sáb: 8:00 AM - 8:00 PM</p>
                        </div>
                    </div>
                </div>
                <div class="col-lg-6">
                    <div class="contact-form-card">
                        <form id="contactForm">
                            <div class="mb-3">
                                <label class="form-label fw-medium">Nombre Completo</label>
                                <input type="text" class="form-control form-control-lg" placeholder="Tu nombre" required>
                            </div>
                            <div class="mb-3">
                                <label class="form-label fw-medium">Correo Electrónico</label>
                                <input type="email" class="form-control form-control-lg" placeholder="tu@email.com" required>
                            </div>
                            <div class="mb-3">
                                <label class="form-label fw-medium">Mensaje</label>
                                <textarea class="form-control form-control-lg" rows="4" placeholder="¿En qué podemos ayudarte?" required></textarea>
                            </div>
                            <button type="submit" class="btn btn-primary btn-lg w-100 rounded-pill">
                                <i class="bi bi-send me-2"></i>Enviar Mensaje
                            </button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </section>
@endsection
