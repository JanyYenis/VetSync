/**
 * ========================================
 * MÓDULO DE GESTIÓN DE CLÍNICAS
 * VetAdmin - Sistema Veterinario
 * ========================================
 *
 * Este módulo permite gestionar múltiples clínicas:
 * - Listar clínicas del usuario
 * - Seleccionar clínica activa
 * - Crear nuevas clínicas
 * - Editar información de clínicas
 * - Eliminar clínicas
 */

// ========================================
// DATOS SIMULADOS (En producción vendría del backend)
// ========================================
let clinicas = [
    {
        id: 1,
        nombre: "Clínica Veterinaria Patitas Felices",
        nit: "900.123.456-7",
        direccion: "Calle 123 #45-67, Barrio El Poblado",
        ciudad: "Medellín",
        correo: "contacto@patitasfelices.com",
        telefono: "+57 300 123 4567",
        redes: {
            instagram: "https://instagram.com/patitasfelices",
            facebook: "https://facebook.com/patitasfelices",
            tiktok: "https://tiktok.com/@patitasfelices"
        },
        logo: "https://images.unsplash.com/photo-1628009368231-7bb7cfcb0def?w=200&h=200&fit=crop",
        activa: true
    },
    {
        id: 2,
        nombre: "Centro Veterinario San Martín",
        nit: "800.987.654-3",
        direccion: "Carrera 50 #30-20, Centro",
        ciudad: "Bogotá",
        correo: "info@vetsanmartin.com",
        telefono: "+57 311 987 6543",
        redes: {
            instagram: "https://instagram.com/vetsanmartin",
            facebook: "",
            tiktok: ""
        },
        logo: "https://images.unsplash.com/photo-1612531386530-97286d97c2d2?w=200&h=200&fit=crop",
        activa: true
    },
    {
        id: 3,
        nombre: "Veterinaria Animal Planet",
        nit: "901.555.888-1",
        direccion: "Avenida 68 #15-30",
        ciudad: "Cali",
        correo: "hola@animalplanetvet.com",
        telefono: "+57 315 555 8888",
        redes: {
            instagram: "",
            facebook: "https://facebook.com/animalplanetvet",
            tiktok: ""
        },
        logo: "https://images.unsplash.com/photo-1548767797-d8c844163c4c?w=200&h=200&fit=crop",
        activa: false
    }
];

// ID de la clínica actualmente seleccionada
let clinicaActiva = 1;

// Referencias a modales de Bootstrap
let clinicModal;
let deleteModal;

// ========================================
// INICIALIZACIÓN
// ========================================

/**
 * Se ejecuta cuando el DOM está listo
 */
$(document).ready(function() {
    // Inicializar modales de Bootstrap
    clinicModal = new bootstrap.Modal(document.getElementById('clinicModal'));
    deleteModal = new bootstrap.Modal(document.getElementById('deleteModal'));

    // Renderizar la interfaz inicial
    renderClinics();
    updateClinicSelector();
    updateStats();
    updateActiveClinicDisplay();

    console.log('[VetAdmin] Módulo de clínicas inicializado correctamente');
});

// ========================================
// RENDERIZADO DE CLÍNICAS
// ========================================

/**
 * Renderiza todas las clínicas en el grid
 */
function renderClinics() {
    const $grid = $('#clinicsGrid');
    $grid.empty();

    // Si no hay clínicas, mostrar estado vacío
    if (clinicas.length === 0) {
        $grid.html(`
            <div class="col-12">
                <div class="empty-state">
                    <div class="empty-state-icon">
                        <i class="bi bi-hospital"></i>
                    </div>
                    <h3>No tienes clínicas registradas</h3>
                    <p>Agrega tu primera clínica para comenzar a gestionar tu negocio veterinario</p>
                    <button class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#clinicModal" onclick="openCreateModal()">
                        <i class="bi bi-plus-lg me-2"></i>Agregar Primera Clínica
                    </button>
                </div>
            </div>
        `);
        return;
    }

    // Renderizar cada clínica como una card
    clinicas.forEach((clinica, index) => {
        const isCurrentActive = clinica.id === clinicaActiva;
        const cardHtml = createClinicCard(clinica, isCurrentActive);
        $grid.append(cardHtml);
    });
}

/**
 * Crea el HTML de una card de clínica
 * @param {Object} clinica - Datos de la clínica
 * @param {Boolean} isCurrentActive - Si es la clínica activa actual
 * @returns {String} HTML de la card
 */
function createClinicCard(clinica, isCurrentActive) {
    // Determinar clases de estado
    const activeClass = isCurrentActive ? 'is-active' : '';
    const statusBadge = clinica.activa
        ? '<span class="badge badge-active">Activa</span>'
        : '<span class="badge badge-inactive">Inactiva</span>';
    const currentBadge = isCurrentActive
        ? '<span class="badge badge-current ms-1"><i class="bi bi-check2 me-1"></i>Actual</span>'
        : '';

    // Generar enlaces de redes sociales
    const socialLinks = generateSocialLinks(clinica.redes);

    return `
        <div class="col-lg-4 col-md-6">
            <div class="clinic-card ${activeClass}" data-clinic-id="${clinica.id}">
                <div class="clinic-card-header">
                    <img src="${clinica.logo || 'placeholder-logo.png'}" alt="Logo ${clinica.nombre}" class="clinic-logo" style="margin-top: 1.5rem;">
                    <div class="clinic-info" style="margin-top: 1.5rem;">
                        <h5 class="clinic-name" title="${clinica.nombre}">${clinica.nombre}</h5>
                        <p class="clinic-nit">NIT: ${clinica.nit}</p>
                        <p class="clinic-location">
                            <i class="bi bi-geo-alt-fill"></i>
                            ${clinica.ciudad}
                        </p>
                    </div>
                    <div class="active-badge">
                        ${statusBadge}
                        ${currentBadge}
                    </div>
                </div>

                <div class="clinic-card-body">
                    <div class="clinic-contact">
                        <div class="contact-item">
                            <i class="bi bi-envelope"></i>
                            <a href="mailto:${clinica.correo}">${clinica.correo}</a>
                        </div>
                        <div class="contact-item">
                            <i class="bi bi-telephone"></i>
                            <a href="tel:${clinica.telefono}">${clinica.telefono}</a>
                        </div>
                        <div class="contact-item">
                            <i class="bi bi-geo-alt"></i>
                            <span>${clinica.direccion}</span>
                        </div>
                    </div>

                    <div class="clinic-social">
                        ${socialLinks}
                    </div>
                </div>

                <div class="clinic-card-footer">
                    ${!isCurrentActive ? `
                        <button class="btn btn-outline-primary btn-sm" onclick="selectClinic(${clinica.id})">
                            <i class="bi bi-check2-circle me-1"></i>Seleccionar
                        </button>
                    ` : `
                        <button class="btn btn-primary btn-sm" disabled>
                            <i class="bi bi-check2-circle me-1"></i>Seleccionada
                        </button>
                    `}
                    <button class="btn btn-outline-secondary btn-sm" onclick="openEditModal(${clinica.id})">
                        <i class="bi bi-pencil me-1"></i>Editar
                    </button>
                    <button class="btn btn-outline-danger btn-sm" onclick="openDeleteModal(${clinica.id})">
                        <i class="bi bi-trash"></i>
                    </button>
                </div>
            </div>
        </div>
    `;
}

/**
 * Genera los enlaces de redes sociales
 * @param {Object} redes - Objeto con URLs de redes sociales
 * @returns {String} HTML de los enlaces
 */
function generateSocialLinks(redes) {
    let html = '';

    // Instagram
    if (redes.instagram) {
        html += `<a href="${redes.instagram}" target="_blank" class="social-link instagram" title="Instagram">
            <i class="bi bi-instagram"></i>
        </a>`;
    } else {
        html += `<span class="social-link disabled" title="Instagram no configurado">
            <i class="bi bi-instagram"></i>
        </span>`;
    }

    // Facebook
    if (redes.facebook) {
        html += `<a href="${redes.facebook}" target="_blank" class="social-link facebook" title="Facebook">
            <i class="bi bi-facebook"></i>
        </a>`;
    } else {
        html += `<span class="social-link disabled" title="Facebook no configurado">
            <i class="bi bi-facebook"></i>
        </span>`;
    }

    // TikTok
    if (redes.tiktok) {
        html += `<a href="${redes.tiktok}" target="_blank" class="social-link tiktok" title="TikTok">
            <i class="bi bi-tiktok"></i>
        </a>`;
    } else {
        html += `<span class="social-link disabled" title="TikTok no configurado">
            <i class="bi bi-tiktok"></i>
        </span>`;
    }

    return html;
}

// ========================================
// SELECTOR DE CLÍNICA ACTIVA
// ========================================

/**
 * Actualiza el dropdown del selector de clínicas
 */
function updateClinicSelector() {
    const $menu = $('#clinicDropdownMenu');
    $menu.empty();

    clinicas.forEach(clinica => {
        const isActive = clinica.id === clinicaActiva;
        const activeClass = isActive ? 'active' : '';
        const checkIcon = isActive ? '<i class="bi bi-check-lg ms-auto"></i>' : '';

        $menu.append(`
            <li>
                <a class="dropdown-item ${activeClass}" href="#" onclick="selectClinic(${clinica.id}); return false;">
                    <img src="${clinica.logo || 'placeholder-logo.png'}" alt="${clinica.nombre}">
                    <div class="flex-grow-1">
                        <div class="fw-medium">${clinica.nombre}</div>
                        <small class="text-muted">${clinica.ciudad}</small>
                    </div>
                    ${checkIcon}
                </a>
            </li>
        `);
    });
}

/**
 * Actualiza la visualización de la clínica activa en el navbar
 */
function updateActiveClinicDisplay() {
    const clinica = clinicas.find(c => c.id === clinicaActiva);

    if (clinica) {
        $('#activeClinicLogo').attr('src', clinica.logo || 'placeholder-logo.png');
        $('#activeClinicName').text(clinica.nombre);
    } else {
        $('#activeClinicLogo').attr('src', 'placeholder-logo.png');
        $('#activeClinicName').text('Seleccionar clínica');
    }
}

/**
 * Selecciona una clínica como activa
 * @param {Number} id - ID de la clínica a seleccionar
 */
function selectClinic(id) {
    const clinica = clinicas.find(c => c.id === id);

    if (!clinica) {
        showError('Clínica no encontrada');
        return;
    }

    clinicaActiva = id;

    // Actualizar toda la interfaz
    renderClinics();
    updateClinicSelector();
    updateActiveClinicDisplay();

    // Mostrar mensaje de éxito
    showSuccess(`Clínica "${clinica.nombre}" seleccionada como activa`);

    // Añadir efecto visual de highlight
    $(`.clinic-card[data-clinic-id="${id}"]`).addClass('highlight');
    setTimeout(() => {
        $(`.clinic-card[data-clinic-id="${id}"]`).removeClass('highlight');
    }, 600);

    console.log(`[VetAdmin] Clínica activa cambiada a: ${clinica.nombre} (ID: ${id})`);
}

// ========================================
// ESTADÍSTICAS
// ========================================

/**
 * Actualiza las estadísticas mostradas
 */
function updateStats() {
    const total = clinicas.length;
    const activas = clinicas.filter(c => c.activa).length;
    const inactivas = total - activas;

    $('#totalClinics').text(total);
    $('#activeClinics').text(activas);
    $('#inactiveClinics').text(inactivas);
}

// ========================================
// MODAL: CREAR CLÍNICA
// ========================================

/**
 * Abre el modal en modo creación
 */
function openCreateModal() {
    // Limpiar formulario
    $('#clinicForm')[0].reset();
    $('#clinicId').val('');
    $('#logoPreview').attr('src', 'placeholder-logo.png');
    $('#activa').prop('checked', true);

    // Actualizar título del modal
    $('#clinicModalLabel').html('<i class="bi bi-hospital me-2"></i>Nueva Clínica');

    console.log('[VetAdmin] Abriendo modal para crear nueva clínica');
}

// ========================================
// MODAL: EDITAR CLÍNICA
// ========================================

/**
 * Abre el modal en modo edición con los datos de una clínica
 * @param {Number} id - ID de la clínica a editar
 */
function openEditModal(id) {
    const clinica = clinicas.find(c => c.id === id);

    if (!clinica) {
        showError('Clínica no encontrada');
        return;
    }

    // Cargar datos en el formulario
    $('#clinicId').val(clinica.id);
    $('#nombre').val(clinica.nombre);
    $('#nit').val(clinica.nit);
    $('#direccion').val(clinica.direccion);
    $('#ciudad').val(clinica.ciudad);
    $('#correo').val(clinica.correo);
    $('#telefono').val(clinica.telefono);
    $('#instagram').val(clinica.redes.instagram || '');
    $('#facebook').val(clinica.redes.facebook || '');
    $('#tiktok').val(clinica.redes.tiktok || '');
    $('#activa').prop('checked', clinica.activa);
    $('#logoPreview').attr('src', clinica.logo || 'placeholder-logo.png');

    // Actualizar título del modal
    $('#clinicModalLabel').html('<i class="bi bi-pencil me-2"></i>Editar Clínica');

    // Abrir modal
    clinicModal.show();

    console.log(`[VetAdmin] Abriendo modal para editar clínica: ${clinica.nombre}`);
}

// ========================================
// GUARDAR CLÍNICA
// ========================================

/**
 * Guarda los cambios de la clínica (crear o actualizar)
 */
function saveClinic() {
    // Validar formulario
    const form = document.getElementById('clinicForm');
    if (!form.checkValidity()) {
        form.reportValidity();
        return;
    }

    // Obtener datos del formulario
    const id = $('#clinicId').val();
    const clinicaData = {
        nombre: $('#nombre').val().trim(),
        nit: $('#nit').val().trim(),
        direccion: $('#direccion').val().trim(),
        ciudad: $('#ciudad').val().trim(),
        correo: $('#correo').val().trim(),
        telefono: $('#telefono').val().trim(),
        redes: {
            instagram: $('#instagram').val().trim(),
            facebook: $('#facebook').val().trim(),
            tiktok: $('#tiktok').val().trim()
        },
        logo: $('#logoPreview').attr('src'),
        activa: $('#activa').is(':checked')
    };

    // Simular guardado con un pequeño delay
    showLoading(true);

    setTimeout(() => {
        if (id) {
            // Actualizar clínica existente
            const index = clinicas.findIndex(c => c.id === parseInt(id));
            if (index !== -1) {
                clinicaData.id = parseInt(id);
                clinicas[index] = clinicaData;
                showSuccess('Clínica actualizada correctamente');
                console.log(`[VetAdmin] Clínica actualizada: ${clinicaData.nombre}`);
            }
        } else {
            // Crear nueva clínica
            const newId = Math.max(...clinicas.map(c => c.id), 0) + 1;
            clinicaData.id = newId;
            clinicas.push(clinicaData);
            showSuccess('Clínica creada correctamente');
            console.log(`[VetAdmin] Nueva clínica creada: ${clinicaData.nombre} (ID: ${newId})`);
        }

        // Actualizar interfaz
        renderClinics();
        updateClinicSelector();
        updateStats();
        updateActiveClinicDisplay();

        // Cerrar modal
        clinicModal.hide();
        showLoading(false);
    }, 500);
}

// ========================================
// ELIMINAR CLÍNICA
// ========================================

/**
 * Abre el modal de confirmación para eliminar
 * @param {Number} id - ID de la clínica a eliminar
 */
function openDeleteModal(id) {
    const clinica = clinicas.find(c => c.id === id);

    if (!clinica) {
        showError('Clínica no encontrada');
        return;
    }

    $('#deleteClinicId').val(id);
    $('#deleteClinicName').text(clinica.nombre);
    deleteModal.show();

    console.log(`[VetAdmin] Solicitando confirmación para eliminar: ${clinica.nombre}`);
}

/**
 * Confirma y ejecuta la eliminación de una clínica
 */
function confirmDelete() {
    const id = parseInt($('#deleteClinicId').val());
    const clinica = clinicas.find(c => c.id === id);

    if (!clinica) {
        showError('Clínica no encontrada');
        deleteModal.hide();
        return;
    }

    // Simular eliminación con delay
    showLoading(true);

    setTimeout(() => {
        // Eliminar del array
        clinicas = clinicas.filter(c => c.id !== id);

        // Si se eliminó la clínica activa, seleccionar otra
        if (clinicaActiva === id) {
            clinicaActiva = clinicas.length > 0 ? clinicas[0].id : null;
        }

        // Actualizar interfaz
        renderClinics();
        updateClinicSelector();
        updateStats();
        updateActiveClinicDisplay();

        // Cerrar modal y mostrar mensaje
        deleteModal.hide();
        showLoading(false);
        showSuccess(`Clínica "${clinica.nombre}" eliminada correctamente`);

        console.log(`[VetAdmin] Clínica eliminada: ${clinica.nombre}`);
    }, 500);
}

// ========================================
// PREVIEW DE LOGO
// ========================================

/**
 * Muestra una vista previa del logo seleccionado
 * @param {HTMLInputElement} input - Input file del logo
 */
function previewLogo(input) {
    if (input.files && input.files[0]) {
        const reader = new FileReader();

        reader.onload = function(e) {
            $('#logoPreview').attr('src', e.target.result);
            console.log('[VetAdmin] Logo preview actualizado');
        };

        reader.readAsDataURL(input.files[0]);
    }
}

// ========================================
// UTILIDADES
// ========================================

/**
 * Muestra un toast de éxito
 * @param {String} message - Mensaje a mostrar
 */
function showSuccess(message) {
    $('#successMessage').text(message);
    const toast = new bootstrap.Toast(document.getElementById('successToast'));
    toast.show();
}

/**
 * Muestra un toast de error
 * @param {String} message - Mensaje a mostrar
 */
function showError(message) {
    $('#errorMessage').text(message);
    const toast = new bootstrap.Toast(document.getElementById('errorToast'));
    toast.show();
}

/**
 * Muestra u oculta el estado de carga
 * @param {Boolean} show - Si mostrar o no el loading
 */
function showLoading(show) {
    if (show) {
        $('body').addClass('loading');
    } else {
        $('body').removeClass('loading');
    }
}

// ========================================
// TOGGLE ESTADO ACTIVA/INACTIVA
// ========================================

/**
 * Cambia el estado activa/inactiva de una clínica
 * @param {Number} id - ID de la clínica
 */
function toggleClinicStatus(id) {
    const clinica = clinicas.find(c => c.id === id);

    if (!clinica) {
        showError('Clínica no encontrada');
        return;
    }

    clinica.activa = !clinica.activa;

    // Actualizar interfaz
    renderClinics();
    updateStats();

    const status = clinica.activa ? 'activada' : 'desactivada';
    showSuccess(`Clínica ${status} correctamente`);

    console.log(`[VetAdmin] Estado de clínica cambiado: ${clinica.nombre} - ${status}`);
}
