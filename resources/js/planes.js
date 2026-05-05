/**
 * VetSync - Plans Admin Module
 * Gestion de planes, servicios y planes personalizados
 */

$(document).ready(function() {
    // =====================================================
    // DATA STORE (Simulated Backend)
    // =====================================================

    // Categorias de servicios
    const categorias = {
        estructura: { nombre: 'Estructura', icono: 'bi-diagram-3' },
        clinico: { nombre: 'Funcionalidades Clinicas', icono: 'bi-clipboard2-pulse' },
        admin: { nombre: 'Administracion', icono: 'bi-gear' },
        integraciones: { nombre: 'Integraciones', icono: 'bi-plug' },
        soporte: { nombre: 'Soporte', icono: 'bi-headset' }
    };

    // Servicios disponibles
    let servicios = [
        { id: 1, nombre: 'Gestion de Clientes', descripcion: 'Administra tu cartera de clientes', categoria: 'estructura', icono: 'bi-people', activo: true },
        { id: 2, nombre: 'Gestion de Mascotas', descripcion: 'Registro completo de pacientes', categoria: 'estructura', icono: 'bi-heart', activo: true },
        { id: 3, nombre: 'Historia Clinica', descripcion: 'Expedientes medicos digitales', categoria: 'clinico', icono: 'bi-clipboard2-pulse', activo: true },
        { id: 4, nombre: 'Prescripciones', descripcion: 'Recetas medicas digitales', categoria: 'clinico', icono: 'bi-file-earmark-medical', activo: true },
        { id: 5, nombre: 'Citas y Agenda', descripcion: 'Calendario de citas', categoria: 'clinico', icono: 'bi-calendar-check', activo: true },
        { id: 6, nombre: 'Exportacion PDF', descripcion: 'Genera documentos PDF', categoria: 'admin', icono: 'bi-file-pdf', activo: true },
        { id: 7, nombre: 'Dashboard de Metricas', descripcion: 'Analisis y estadisticas', categoria: 'admin', icono: 'bi-graph-up', activo: true },
        { id: 8, nombre: 'Facturacion', descripcion: 'Gestion de pagos y facturas', categoria: 'admin', icono: 'bi-receipt', activo: true },
        { id: 9, nombre: 'Multiples Sedes', descripcion: 'Administra varias sucursales', categoria: 'estructura', icono: 'bi-building', activo: true },
        { id: 10, nombre: 'Roles de Usuario', descripcion: 'Control de permisos', categoria: 'admin', icono: 'bi-person-badge', activo: true },
        { id: 11, nombre: 'API REST', descripcion: 'Integracion con terceros', categoria: 'integraciones', icono: 'bi-code-slash', activo: true },
        { id: 12, nombre: 'Soporte Prioritario', descripcion: 'Atencion preferencial 24/7', categoria: 'soporte', icono: 'bi-headset', activo: true },
        { id: 13, nombre: 'Backup Automatico', descripcion: 'Respaldos en la nube', categoria: 'integraciones', icono: 'bi-cloud-upload', activo: true },
        { id: 14, nombre: 'Notificaciones SMS', descripcion: 'Alertas por mensaje de texto', categoria: 'integraciones', icono: 'bi-chat-dots', activo: true },
        { id: 15, nombre: 'Reportes Avanzados', descripcion: 'Informes personalizados', categoria: 'admin', icono: 'bi-bar-chart-line', activo: true }
    ];

    // Planes estandar
    let planes = [
        {
            id: 1,
            nombre: 'Basico',
            descripcion: 'Ideal para clinicas pequenas',
            precioMensual: 89000,
            precioAnual: 854400,
            activo: true,
            color: 'secondary',
            badge: '',
            limites: { usuarios: 2, sedes: 1, mascotas: 500, storage: 5 },
            servicios: [1, 2, 3, 4, 6]
        },
        {
            id: 2,
            nombre: 'Profesional',
            descripcion: 'Para clinicas en crecimiento',
            precioMensual: 199000,
            precioAnual: 1910400,
            activo: true,
            color: 'primary',
            badge: 'popular',
            limites: { usuarios: 10, sedes: 3, mascotas: 0, storage: 25 },
            servicios: [1, 2, 3, 4, 5, 6, 7, 8, 10]
        },
        {
            id: 3,
            nombre: 'Empresarial',
            descripcion: 'Solucion completa para hospitales',
            precioMensual: 349000,
            precioAnual: 3350400,
            activo: true,
            color: 'success',
            badge: 'recommended',
            limites: { usuarios: 0, sedes: 0, mascotas: 0, storage: 0 },
            servicios: [1, 2, 3, 4, 5, 6, 7, 8, 9, 10, 11, 12, 13, 14, 15]
        }
    ];

    // Planes personalizados
    let planesPersonalizados = [
        {
            id: 1,
            clienteId: 1,
            clienteNombre: 'Clinica Veterinaria San Martin',
            planBaseId: 2,
            precioPersonalizado: 175000,
            descuento: 12,
            limites: { usuarios: 15, sedes: 5, mascotas: 0, storage: 50 },
            servicios: [1, 2, 3, 4, 5, 6, 7, 8, 9, 10],
            activo: true
        },
        {
            id: 2,
            clienteId: 3,
            clienteNombre: 'Pet Center Colombia',
            planBaseId: 3,
            precioPersonalizado: 299000,
            descuento: 15,
            limites: { usuarios: 0, sedes: 10, mascotas: 0, storage: 100 },
            servicios: [1, 2, 3, 4, 5, 6, 7, 8, 9, 10, 11, 12, 13, 14, 15],
            activo: true
        }
    ];

    // Clientes simulados
    const clientes = [
        { id: 1, nombre: 'Clinica Veterinaria San Martin' },
        { id: 2, nombre: 'Hospital Animal Care' },
        { id: 3, nombre: 'Pet Center Colombia' },
        { id: 4, nombre: 'Veterinaria El Campestre' },
        { id: 5, nombre: 'Centro Medico Mascotas Felices' }
    ];

    // =====================================================
    // INITIALIZATION
    // =====================================================

    let currentDeleteType = null;
    let currentDeleteId = null;

    init();

    function init() {
        renderPlanes();
        renderServicios();
        renderPersonalizados();
        updateStats();
        bindEvents();
    }

    // =====================================================
    // RENDER FUNCTIONS
    // =====================================================

    function renderPlanes() {
        const grid = $('#planesGrid');
        grid.empty();

        planes.forEach(plan => {
            const serviciosIncluidos = plan.servicios.length;
            const badgeHtml = plan.badge ? `<span class="badge-${plan.badge}">${getBadgeText(plan.badge)}</span>` : '';

            grid.append(`
                <div class="plan-card ${plan.activo ? '' : 'inactive'}" data-id="${plan.id}">
                    ${badgeHtml}
                    <div class="plan-header bg-${plan.color}-gradient">
                        <h4 class="plan-name">${plan.nombre}</h4>
                        <p class="plan-description">${plan.descripcion}</p>
                    </div>
                    <div class="plan-price">
                        <div class="price-amount">
                            <span class="currency">$</span>${formatPrice(plan.precioMensual)}
                        </div>
                        <div class="price-period">COP / mes</div>
                        <div class="price-annual">$${formatPrice(plan.precioAnual)} / ano</div>
                    </div>
                    <div class="plan-features">
                        <div class="plan-features-title">Limites</div>
                        <div class="plan-limits">
                            <div class="limit-item">
                                <i class="bi bi-people"></i>
                                <span>${plan.limites.usuarios || 'Ilimitado'} usuarios</span>
                            </div>
                            <div class="limit-item">
                                <i class="bi bi-building"></i>
                                <span>${plan.limites.sedes || 'Ilimitado'} sedes</span>
                            </div>
                            <div class="limit-item">
                                <i class="bi bi-heart"></i>
                                <span>${plan.limites.mascotas || 'Ilimitado'} mascotas</span>
                            </div>
                            <div class="limit-item">
                                <i class="bi bi-cloud"></i>
                                <span>${plan.limites.storage || 'Ilimitado'} GB</span>
                            </div>
                        </div>
                        <div class="services-count">
                            <i class="bi bi-check-circle-fill"></i>
                            <span>${serviciosIncluidos} servicios incluidos</span>
                        </div>
                        <div class="mt-2">
                            <span class="plan-status ${plan.activo ? 'active' : 'inactive'}">
                                <i class="bi bi-circle-fill"></i>
                                ${plan.activo ? 'Activo' : 'Inactivo'}
                            </span>
                        </div>
                    </div>
                    <div class="plan-actions">
                        <button class="btn btn-outline-primary btn-view-plan" data-id="${plan.id}">
                            <i class="bi bi-eye me-1"></i>Ver
                        </button>
                        <button class="btn btn-outline-secondary btn-edit-plan" data-id="${plan.id}">
                            <i class="bi bi-pencil me-1"></i>Editar
                        </button>
                        <button class="btn btn-outline-secondary btn-icon btn-clone-plan" data-id="${plan.id}" title="Duplicar">
                            <i class="bi bi-copy"></i>
                        </button>
                        <button class="btn btn-outline-danger btn-icon btn-delete-plan" data-id="${plan.id}" title="Eliminar">
                            <i class="bi bi-trash"></i>
                        </button>
                    </div>
                </div>
            `);
        });
    }

    function renderServicios() {
        const container = $('#serviciosContainer');
        container.empty();

        Object.keys(categorias).forEach(catKey => {
            const cat = categorias[catKey];
            const serviciosCat = servicios.filter(s => s.categoria === catKey);

            if (serviciosCat.length > 0) {
                const catHtml = `
                    <div class="service-category" data-categoria="${catKey}">
                        <div class="category-header">
                            <h6 class="category-title">
                                <i class="bi ${cat.icono}"></i>
                                ${cat.nombre}
                            </h6>
                            <span class="category-count">${serviciosCat.length} servicios</span>
                        </div>
                        <div class="services-list-grid">
                            ${serviciosCat.map(s => `
                                <div class="service-item ${s.activo ? '' : 'opacity-50'}" data-id="${s.id}">
                                    <div class="service-info">
                                        <div class="service-icon">
                                            <i class="bi ${s.icono}"></i>
                                        </div>
                                        <div class="service-details">
                                            <h6>${s.nombre}</h6>
                                            <p>${s.descripcion}</p>
                                        </div>
                                    </div>
                                    <div class="service-actions">
                                        <div class="form-check form-switch">
                                            <input class="form-check-input toggle-servicio" type="checkbox" data-id="${s.id}" ${s.activo ? 'checked' : ''}>
                                        </div>
                                        <button class="btn btn-outline-secondary btn-icon btn-edit-servicio" data-id="${s.id}">
                                            <i class="bi bi-pencil"></i>
                                        </button>
                                        <button class="btn btn-outline-danger btn-icon btn-delete-servicio" data-id="${s.id}">
                                            <i class="bi bi-trash"></i>
                                        </button>
                                    </div>
                                </div>
                            `).join('')}
                        </div>
                    </div>
                `;
                container.append(catHtml);
            }
        });
    }

    function renderPersonalizados() {
        const tbody = $('#personalizadosBody');
        tbody.empty();

        if (planesPersonalizados.length === 0) {
            tbody.append(`
                <tr>
                    <td colspan="7" class="text-center py-5 text-muted">
                        <i class="bi bi-sliders display-6 d-block mb-3"></i>
                        No hay planes personalizados
                    </td>
                </tr>
            `);
            return;
        }

        planesPersonalizados.forEach(pp => {
            const planBase = planes.find(p => p.id === pp.planBaseId);
            const planBaseNombre = planBase ? planBase.nombre : 'N/A';

            tbody.append(`
                <tr data-id="${pp.id}">
                    <td>
                        <div class="client-info">
                            <div class="client-avatar">${pp.clienteNombre.charAt(0)}</div>
                            <span class="client-name">${pp.clienteNombre}</span>
                        </div>
                    </td>
                    <td>
                        <span class="badge-plan bg-${planBase ? planBase.color : 'secondary'}-light text-${planBase ? planBase.color : 'secondary'}">
                            ${planBaseNombre}
                        </span>
                    </td>
                    <td>
                        <strong>$${formatPrice(pp.precioPersonalizado)}</strong>
                        ${pp.descuento ? `<br><small class="text-success">-${pp.descuento}% dto</small>` : ''}
                    </td>
                    <td>
                        <span class="text-primary">${pp.servicios.length} activos</span>
                    </td>
                    <td>
                        <div class="limits-tags">
                            <span class="limit-tag">${pp.limites.usuarios || '∞'} usuarios</span>
                            <span class="limit-tag">${pp.limites.sedes || '∞'} sedes</span>
                        </div>
                    </td>
                    <td>
                        <span class="plan-status ${pp.activo ? 'active' : 'inactive'}">
                            <i class="bi bi-circle-fill"></i>
                            ${pp.activo ? 'Activo' : 'Inactivo'}
                        </span>
                    </td>
                    <td>
                        <div class="d-flex gap-1">
                            <button class="btn btn-sm btn-outline-primary btn-view-personalizado" data-id="${pp.id}">
                                <i class="bi bi-eye"></i>
                            </button>
                            <button class="btn btn-sm btn-outline-secondary btn-edit-personalizado" data-id="${pp.id}">
                                <i class="bi bi-pencil"></i>
                            </button>
                            <button class="btn btn-sm btn-outline-danger btn-delete-personalizado" data-id="${pp.id}">
                                <i class="bi bi-trash"></i>
                            </button>
                        </div>
                    </td>
                </tr>
            `);
        });
    }

    function renderServiciosSelector() {
        const container = $('#planServiciosSelector');
        container.empty();

        servicios.filter(s => s.activo).forEach(s => {
            container.append(`
                <label class="service-checkbox">
                    <input type="checkbox" name="planServicios" value="${s.id}">
                    <span class="service-checkbox-content">
                        <i class="bi ${s.icono} me-1"></i>${s.nombre}
                    </span>
                    <span class="checkbox-indicator"><i class="bi bi-check"></i></span>
                </label>
            `);
        });
    }

    function renderServiciosToggle(serviciosActivos = []) {
        const container = $('#personalizadoServicios');
        container.empty();

        servicios.filter(s => s.activo).forEach(s => {
            const isActive = serviciosActivos.includes(s.id);
            container.append(`
                <div class="service-toggle-item ${isActive ? 'active' : ''}" data-id="${s.id}">
                    <div class="service-toggle-info">
                        <i class="bi ${s.icono}"></i>
                        <span>${s.nombre}</span>
                    </div>
                    <div class="form-check form-switch m-0">
                        <input class="form-check-input personalizado-servicio-toggle" type="checkbox" data-id="${s.id}" ${isActive ? 'checked' : ''}>
                    </div>
                </div>
            `);
        });
    }

    function renderPlanesBaseSelect() {
        const select = $('#personalizadoPlanBase');
        select.empty().append('<option value="">Seleccionar plan base...</option>');

        planes.filter(p => p.activo).forEach(p => {
            select.append(`<option value="${p.id}" data-precio="${p.precioMensual}">${p.nombre} - $${formatPrice(p.precioMensual)}/mes</option>`);
        });
    }

    // =====================================================
    // EVENT HANDLERS
    // =====================================================

    function bindEvents() {
        // Sidebar toggle
        $('#sidebarToggle, #sidebarClose').on('click', function() {
            $('#sidebar').toggleClass('show');
        });

        // Tab navigation from sidebar
        $('[data-section]').on('click', function(e) {
            e.preventDefault();
            const section = $(this).data('section');
            $(`#${section}-tab`).tab('show');
        });

        // New Plan
        $('#btnNewPlan').on('click', function() {
            openPlanModal();
        });

        // Edit Plan
        $(document).on('click', '.btn-edit-plan', function() {
            const id = $(this).data('id');
            openPlanModal(id);
        });

        // View Plan
        $(document).on('click', '.btn-view-plan', function() {
            const id = $(this).data('id');
            viewPlanDetail(id);
        });

        // Clone Plan
        $(document).on('click', '.btn-clone-plan', function() {
            const id = $(this).data('id');
            clonePlan(id);
        });

        // Delete Plan
        $(document).on('click', '.btn-delete-plan', function() {
            const id = $(this).data('id');
            confirmDelete('plan', id);
        });

        // Save Plan
        $('#btnSavePlan').on('click', function() {
            savePlan();
        });

        // New Service
        $('#btnNewServicio').on('click', function() {
            openServicioModal();
        });

        // Edit Service
        $(document).on('click', '.btn-edit-servicio', function() {
            const id = $(this).data('id');
            openServicioModal(id);
        });

        // Toggle Service
        $(document).on('change', '.toggle-servicio', function() {
            const id = $(this).data('id');
            toggleServicio(id);
        });

        // Delete Service
        $(document).on('click', '.btn-delete-servicio', function() {
            const id = $(this).data('id');
            confirmDelete('servicio', id);
        });

        // Save Service
        $('#btnSaveServicio').on('click', function() {
            saveServicio();
        });

        // Search Services
        $('#searchServicios').on('input', function() {
            const term = $(this).val().toLowerCase();
            filterServicios(term);
        });

        // New Personalizado
        $('#btnNewPersonalizado').on('click', function() {
            openPersonalizadoModal();
        });

        // Edit Personalizado
        $(document).on('click', '.btn-edit-personalizado', function() {
            const id = $(this).data('id');
            openPersonalizadoModal(id);
        });

        // View Personalizado
        $(document).on('click', '.btn-view-personalizado', function() {
            const id = $(this).data('id');
            viewPersonalizadoDetail(id);
        });

        // Delete Personalizado
        $(document).on('click', '.btn-delete-personalizado', function() {
            const id = $(this).data('id');
            confirmDelete('personalizado', id);
        });

        // Save Personalizado
        $('#btnSavePersonalizado').on('click', function() {
            savePersonalizado();
        });

        // Personalizado - Plan Base Change
        $('#personalizadoPlanBase').on('change', function() {
            const planId = parseInt($(this).val());
            if (planId) {
                const plan = planes.find(p => p.id === planId);
                if (plan) {
                    $('#personalizadoPrecio').val(plan.precioMensual);
                    $('#personalizadoUsuarios').val(plan.limites.usuarios || '');
                    $('#personalizadoSedes').val(plan.limites.sedes || '');
                    $('#personalizadoMascotas').val(plan.limites.mascotas || '');
                    $('#personalizadoStorage').val(plan.limites.storage || '');
                    renderServiciosToggle(plan.servicios);
                }
            }
            updatePersonalizadoPreview();
        });

        // Personalizado - Cliente Change
        $('#personalizadoCliente').on('change', function() {
            updatePersonalizadoPreview();
        });

        // Personalizado - Price/Discount Change
        $('#personalizadoPrecio, #personalizadoDescuento').on('input', function() {
            updatePersonalizadoPreview();
        });

        // Personalizado - Limits Change
        $('#personalizadoUsuarios, #personalizadoSedes, #personalizadoMascotas, #personalizadoStorage').on('input', function() {
            updatePersonalizadoPreview();
        });

        // Personalizado - Service Toggle
        $(document).on('change', '.personalizado-servicio-toggle', function() {
            const $item = $(this).closest('.service-toggle-item');
            $item.toggleClass('active', $(this).is(':checked'));
            updatePersonalizadoPreview();
        });

        // Confirm Delete
        $('#btnConfirmDelete').on('click', function() {
            executeDelete();
        });

        // Search Personalizados
        $('#searchPersonalizados').on('input', function() {
            const term = $(this).val().toLowerCase();
            filterPersonalizados(term);
        });
    }

    // =====================================================
    // MODAL FUNCTIONS
    // =====================================================

    function openPlanModal(id = null) {
        const modal = new bootstrap.Modal('#modalPlan');

        // Reset form
        $('#formPlan')[0].reset();
        $('#planId').val('');
        renderServiciosSelector();

        if (id) {
            const plan = planes.find(p => p.id === id);
            if (plan) {
                $('#modalPlanTitle').text('Editar Plan');
                $('#planId').val(plan.id);
                $('#planNombre').val(plan.nombre);
                $('#planDescripcion').val(plan.descripcion);
                $('#planPrecioMensual').val(plan.precioMensual);
                $('#planPrecioAnual').val(plan.precioAnual);
                $('#planActivo').prop('checked', plan.activo);
                $('#planLimiteUsuarios').val(plan.limites.usuarios || '');
                $('#planLimiteSedes').val(plan.limites.sedes || '');
                $('#planLimiteMascotas').val(plan.limites.mascotas || '');
                $('#planLimiteStorage').val(plan.limites.storage || '');
                $('#planBadge').val(plan.badge);
                $('#planColor').val(plan.color);

                // Check services
                plan.servicios.forEach(sid => {
                    $(`#planServiciosSelector input[value="${sid}"]`).prop('checked', true);
                });
            }
        } else {
            $('#modalPlanTitle').text('Nuevo Plan');
        }

        modal.show();
    }

    function openServicioModal(id = null) {
        const modal = new bootstrap.Modal('#modalServicio');

        // Reset form
        $('#formServicio')[0].reset();
        $('#servicioId').val('');

        if (id) {
            const servicio = servicios.find(s => s.id === id);
            if (servicio) {
                $('#modalServicioTitle').text('Editar Servicio');
                $('#servicioId').val(servicio.id);
                $('#servicioNombre').val(servicio.nombre);
                $('#servicioDescripcion').val(servicio.descripcion);
                $('#servicioCategoria').val(servicio.categoria);
                $('#servicioIcono').val(servicio.icono);
                $('#servicioActivo').prop('checked', servicio.activo);
            }
        } else {
            $('#modalServicioTitle').text('Nuevo Servicio');
        }

        modal.show();
    }

    function openPersonalizadoModal(id = null) {
        const modal = new bootstrap.Modal('#modalPersonalizado');

        // Reset form
        $('#formPersonalizado')[0].reset();
        $('#personalizadoId').val('');
        renderPlanesBaseSelect();
        renderServiciosToggle([]);
        resetPersonalizadoPreview();

        if (id) {
            const pp = planesPersonalizados.find(p => p.id === id);
            if (pp) {
                $('#modalPersonalizadoTitle').text('Editar Plan Personalizado');
                $('#personalizadoId').val(pp.id);
                $('#personalizadoCliente').val(pp.clienteId);
                $('#personalizadoPlanBase').val(pp.planBaseId);
                $('#personalizadoPrecio').val(pp.precioPersonalizado);
                $('#personalizadoDescuento').val(pp.descuento || '');
                $('#personalizadoUsuarios').val(pp.limites.usuarios || '');
                $('#personalizadoSedes').val(pp.limites.sedes || '');
                $('#personalizadoMascotas').val(pp.limites.mascotas || '');
                $('#personalizadoStorage').val(pp.limites.storage || '');

                renderServiciosToggle(pp.servicios);
                updatePersonalizadoPreview();
            }
        } else {
            $('#modalPersonalizadoTitle').text('Nuevo Plan Personalizado');
        }

        modal.show();
    }

    // =====================================================
    // CRUD FUNCTIONS
    // =====================================================

    function savePlan() {
        const id = $('#planId').val();
        const nombre = $('#planNombre').val().trim();
        const descripcion = $('#planDescripcion').val().trim();
        const precioMensual = parseInt($('#planPrecioMensual').val()) || 0;
        let precioAnual = parseInt($('#planPrecioAnual').val()) || 0;
        const activo = $('#planActivo').is(':checked');
        const badge = $('#planBadge').val();
        const color = $('#planColor').val();

        // Validations
        if (!nombre) {
            showToast('El nombre del plan es requerido', 'error');
            return;
        }

        if (precioMensual <= 0) {
            showToast('El precio mensual debe ser mayor a 0', 'error');
            return;
        }

        // Auto calculate annual price if not set
        if (!precioAnual) {
            precioAnual = Math.round(precioMensual * 12 * 0.8);
        }

        // Get selected services
        const serviciosSeleccionados = [];
        $('#planServiciosSelector input:checked').each(function() {
            serviciosSeleccionados.push(parseInt($(this).val()));
        });

        // Get limits
        const limites = {
            usuarios: parseInt($('#planLimiteUsuarios').val()) || 0,
            sedes: parseInt($('#planLimiteSedes').val()) || 0,
            mascotas: parseInt($('#planLimiteMascotas').val()) || 0,
            storage: parseInt($('#planLimiteStorage').val()) || 0
        };

        if (id) {
            // Update existing
            const index = planes.findIndex(p => p.id === parseInt(id));
            if (index !== -1) {
                planes[index] = {
                    ...planes[index],
                    nombre,
                    descripcion,
                    precioMensual,
                    precioAnual,
                    activo,
                    badge,
                    color,
                    limites,
                    servicios: serviciosSeleccionados
                };
            }
        } else {
            // Create new
            const newId = Math.max(...planes.map(p => p.id), 0) + 1;
            planes.push({
                id: newId,
                nombre,
                descripcion,
                precioMensual,
                precioAnual,
                activo,
                badge,
                color,
                limites,
                servicios: serviciosSeleccionados
            });
        }

        bootstrap.Modal.getInstance('#modalPlan').hide();
        renderPlanes();
        updateStats();
        showToast('Plan guardado correctamente', 'success');
    }

    function saveServicio() {
        const id = $('#servicioId').val();
        const nombre = $('#servicioNombre').val().trim();
        const descripcion = $('#servicioDescripcion').val().trim();
        const categoria = $('#servicioCategoria').val();
        const icono = $('#servicioIcono').val();
        const activo = $('#servicioActivo').is(':checked');

        if (!nombre) {
            showToast('El nombre del servicio es requerido', 'error');
            return;
        }

        if (id) {
            const index = servicios.findIndex(s => s.id === parseInt(id));
            if (index !== -1) {
                servicios[index] = { ...servicios[index], nombre, descripcion, categoria, icono, activo };
            }
        } else {
            const newId = Math.max(...servicios.map(s => s.id), 0) + 1;
            servicios.push({ id: newId, nombre, descripcion, categoria, icono, activo });
        }

        bootstrap.Modal.getInstance('#modalServicio').hide();
        renderServicios();
        updateStats();
        showToast('Servicio guardado correctamente', 'success');
    }

    function savePersonalizado() {
        const id = $('#personalizadoId').val();
        const clienteId = parseInt($('#personalizadoCliente').val());
        const planBaseId = parseInt($('#personalizadoPlanBase').val());
        const precioPersonalizado = parseInt($('#personalizadoPrecio').val()) || 0;
        const descuento = parseInt($('#personalizadoDescuento').val()) || 0;

        if (!clienteId) {
            showToast('Debe seleccionar un cliente', 'error');
            return;
        }

        if (!planBaseId) {
            showToast('Debe seleccionar un plan base', 'error');
            return;
        }

        const cliente = clientes.find(c => c.id === clienteId);
        const clienteNombre = cliente ? cliente.nombre : '';

        const limites = {
            usuarios: parseInt($('#personalizadoUsuarios').val()) || 0,
            sedes: parseInt($('#personalizadoSedes').val()) || 0,
            mascotas: parseInt($('#personalizadoMascotas').val()) || 0,
            storage: parseInt($('#personalizadoStorage').val()) || 0
        };

        const serviciosActivos = [];
        $('.personalizado-servicio-toggle:checked').each(function() {
            serviciosActivos.push(parseInt($(this).data('id')));
        });

        if (id) {
            const index = planesPersonalizados.findIndex(p => p.id === parseInt(id));
            if (index !== -1) {
                planesPersonalizados[index] = {
                    ...planesPersonalizados[index],
                    clienteId,
                    clienteNombre,
                    planBaseId,
                    precioPersonalizado,
                    descuento,
                    limites,
                    servicios: serviciosActivos,
                    activo: true
                };
            }
        } else {
            const newId = Math.max(...planesPersonalizados.map(p => p.id), 0) + 1;
            planesPersonalizados.push({
                id: newId,
                clienteId,
                clienteNombre,
                planBaseId,
                precioPersonalizado,
                descuento,
                limites,
                servicios: serviciosActivos,
                activo: true
            });
        }

        bootstrap.Modal.getInstance('#modalPersonalizado').hide();
        renderPersonalizados();
        updateStats();
        showToast('Plan personalizado guardado correctamente', 'success');
    }

    function toggleServicio(id) {
        const index = servicios.findIndex(s => s.id === id);
        if (index !== -1) {
            servicios[index].activo = !servicios[index].activo;
            renderServicios();
            showToast(`Servicio ${servicios[index].activo ? 'activado' : 'desactivado'}`, 'success');
        }
    }

    function clonePlan(id) {
        const plan = planes.find(p => p.id === id);
        if (plan) {
            const newId = Math.max(...planes.map(p => p.id), 0) + 1;
            const clonedPlan = {
                ...JSON.parse(JSON.stringify(plan)),
                id: newId,
                nombre: `${plan.nombre} (Copia)`,
                badge: ''
            };
            planes.push(clonedPlan);
            renderPlanes();
            updateStats();
            showToast('Plan duplicado correctamente', 'success');
        }
    }

    function confirmDelete(type, id) {
        currentDeleteType = type;
        currentDeleteId = id;

        let message = '';
        switch (type) {
            case 'plan':
                const plan = planes.find(p => p.id === id);
                message = `Esta seguro de eliminar el plan "${plan?.nombre}"?`;
                break;
            case 'servicio':
                const servicio = servicios.find(s => s.id === id);
                message = `Esta seguro de eliminar el servicio "${servicio?.nombre}"?`;
                break;
            case 'personalizado':
                const pp = planesPersonalizados.find(p => p.id === id);
                message = `Esta seguro de eliminar el plan personalizado de "${pp?.clienteNombre}"?`;
                break;
        }

        $('#deleteMessage').text(message);
        new bootstrap.Modal('#modalConfirmDelete').show();
    }

    function executeDelete() {
        switch (currentDeleteType) {
            case 'plan':
                planes = planes.filter(p => p.id !== currentDeleteId);
                renderPlanes();
                break;
            case 'servicio':
                servicios = servicios.filter(s => s.id !== currentDeleteId);
                renderServicios();
                break;
            case 'personalizado':
                planesPersonalizados = planesPersonalizados.filter(p => p.id !== currentDeleteId);
                renderPersonalizados();
                break;
        }

        bootstrap.Modal.getInstance('#modalConfirmDelete').hide();
        updateStats();
        showToast('Elemento eliminado correctamente', 'success');

        currentDeleteType = null;
        currentDeleteId = null;
    }

    // =====================================================
    // VIEW FUNCTIONS
    // =====================================================

    function viewPlanDetail(id) {
        const plan = planes.find(p => p.id === id);
        if (!plan) return;

        const serviciosIncluidos = servicios.filter(s => plan.servicios.includes(s.id) && s.activo);

        const html = `
            <div class="detail-header">
                <span class="detail-badge standard">Plan Estandar</span>
                <h3 class="detail-name">${plan.nombre}</h3>
                <p class="detail-description">${plan.descripcion}</p>
                <div class="detail-price">
                    <span class="amount">$${formatPrice(plan.precioMensual)}</span>
                    <span class="period">COP / mes</span>
                </div>
                <span class="plan-status ${plan.activo ? 'active' : 'inactive'}">
                    <i class="bi bi-circle-fill"></i>
                    ${plan.activo ? 'Activo' : 'Inactivo'}
                </span>
            </div>

            <div class="detail-section">
                <h6 class="detail-section-title">Limites</h6>
                <div class="detail-limits">
                    <div class="detail-limit-item">
                        <i class="bi bi-people"></i>
                        <span class="value">${plan.limites.usuarios || '∞'}</span>
                        <span class="label">Usuarios</span>
                    </div>
                    <div class="detail-limit-item">
                        <i class="bi bi-building"></i>
                        <span class="value">${plan.limites.sedes || '∞'}</span>
                        <span class="label">Sedes</span>
                    </div>
                    <div class="detail-limit-item">
                        <i class="bi bi-heart"></i>
                        <span class="value">${plan.limites.mascotas || '∞'}</span>
                        <span class="label">Mascotas</span>
                    </div>
                    <div class="detail-limit-item">
                        <i class="bi bi-cloud"></i>
                        <span class="value">${plan.limites.storage || '∞'}</span>
                        <span class="label">GB Storage</span>
                    </div>
                </div>
            </div>

            <div class="detail-section">
                <h6 class="detail-section-title">Servicios Incluidos (${serviciosIncluidos.length})</h6>
                <div class="detail-services">
                    ${serviciosIncluidos.map(s => `
                        <div class="detail-service-item">
                            <i class="bi bi-check-circle-fill"></i>
                            ${s.nombre}
                        </div>
                    `).join('')}
                </div>
            </div>
        `;

        $('#detallePlanBody').html(html);
        new bootstrap.Modal('#modalDetallePlan').show();
    }

    function viewPersonalizadoDetail(id) {
        const pp = planesPersonalizados.find(p => p.id === id);
        if (!pp) return;

        const planBase = planes.find(p => p.id === pp.planBaseId);
        const serviciosIncluidos = servicios.filter(s => pp.servicios.includes(s.id) && s.activo);

        const html = `
            <div class="detail-header">
                <span class="detail-badge custom">Plan Personalizado</span>
                <h3 class="detail-name">${pp.clienteNombre}</h3>
                <p class="detail-description">Basado en: ${planBase?.nombre || 'N/A'}</p>
                <div class="detail-price">
                    <span class="amount">$${formatPrice(pp.precioPersonalizado)}</span>
                    <span class="period">COP / mes</span>
                    ${pp.descuento ? `<br><small class="text-success">Descuento: ${pp.descuento}%</small>` : ''}
                </div>
                <span class="plan-status ${pp.activo ? 'active' : 'inactive'}">
                    <i class="bi bi-circle-fill"></i>
                    ${pp.activo ? 'Activo' : 'Inactivo'}
                </span>
            </div>

            <div class="detail-section">
                <h6 class="detail-section-title">Limites Personalizados</h6>
                <div class="detail-limits">
                    <div class="detail-limit-item">
                        <i class="bi bi-people"></i>
                        <span class="value">${pp.limites.usuarios || '∞'}</span>
                        <span class="label">Usuarios</span>
                    </div>
                    <div class="detail-limit-item">
                        <i class="bi bi-building"></i>
                        <span class="value">${pp.limites.sedes || '∞'}</span>
                        <span class="label">Sedes</span>
                    </div>
                    <div class="detail-limit-item">
                        <i class="bi bi-heart"></i>
                        <span class="value">${pp.limites.mascotas || '∞'}</span>
                        <span class="label">Mascotas</span>
                    </div>
                    <div class="detail-limit-item">
                        <i class="bi bi-cloud"></i>
                        <span class="value">${pp.limites.storage || '∞'}</span>
                        <span class="label">GB Storage</span>
                    </div>
                </div>
            </div>

            <div class="detail-section">
                <h6 class="detail-section-title">Servicios Activos (${serviciosIncluidos.length})</h6>
                <div class="detail-services">
                    ${serviciosIncluidos.map(s => `
                        <div class="detail-service-item">
                            <i class="bi bi-check-circle-fill"></i>
                            ${s.nombre}
                        </div>
                    `).join('')}
                </div>
            </div>
        `;

        $('#detallePlanBody').html(html);
        new bootstrap.Modal('#modalDetallePlan').show();
    }

    // =====================================================
    // PREVIEW FUNCTIONS
    // =====================================================

    function updatePersonalizadoPreview() {
        const clienteId = $('#personalizadoCliente').val();
        const planBaseId = $('#personalizadoPlanBase').val();
        const precio = parseInt($('#personalizadoPrecio').val()) || 0;
        const descuento = parseInt($('#personalizadoDescuento').val()) || 0;

        // Cliente
        const cliente = clientes.find(c => c.id === parseInt(clienteId));
        $('#previewCliente').text(cliente ? cliente.nombre : '-');

        // Plan Base
        const planBase = planes.find(p => p.id === parseInt(planBaseId));
        $('#previewPlanBase').text(planBase ? planBase.nombre : '-');

        // Precio
        $('#previewPrecio').text(`$${formatPrice(precio)}`);

        // Descuento
        if (descuento > 0) {
            $('#previewDescuento').show().find('span').text(`${descuento}% descuento`);
        } else {
            $('#previewDescuento').hide();
        }

        // Limites
        const usuarios = $('#personalizadoUsuarios').val() || '∞';
        const sedes = $('#personalizadoSedes').val() || '∞';
        const mascotas = $('#personalizadoMascotas').val() || '∞';
        const storage = $('#personalizadoStorage').val() || '∞';

        $('#previewLimites').html(`
            <div class="limit-item"><i class="bi bi-people"></i><span>${usuarios} usuarios</span></div>
            <div class="limit-item"><i class="bi bi-building"></i><span>${sedes} sedes</span></div>
            <div class="limit-item"><i class="bi bi-heart"></i><span>${mascotas} mascotas</span></div>
            <div class="limit-item"><i class="bi bi-cloud"></i><span>${storage} GB</span></div>
        `);

        // Servicios
        const serviciosActivos = [];
        $('.personalizado-servicio-toggle:checked').each(function() {
            const id = parseInt($(this).data('id'));
            const servicio = servicios.find(s => s.id === id);
            if (servicio) serviciosActivos.push(servicio);
        });

        $('#previewServiciosCount').text(serviciosActivos.length);

        if (serviciosActivos.length > 0) {
            $('#previewServiciosList').html(
                serviciosActivos.map(s => `<li><i class="bi bi-check-circle-fill"></i>${s.nombre}</li>`).join('')
            );
        } else {
            $('#previewServiciosList').html('<li class="text-muted">Sin servicios seleccionados</li>');
        }
    }

    function resetPersonalizadoPreview() {
        $('#previewCliente').text('-');
        $('#previewPlanBase').text('-');
        $('#previewPrecio').text('$0');
        $('#previewDescuento').hide();
        $('#previewLimites').html(`
            <div class="limit-item"><i class="bi bi-people"></i><span>- usuarios</span></div>
            <div class="limit-item"><i class="bi bi-building"></i><span>- sedes</span></div>
            <div class="limit-item"><i class="bi bi-heart"></i><span>- mascotas</span></div>
            <div class="limit-item"><i class="bi bi-cloud"></i><span>- GB</span></div>
        `);
        $('#previewServiciosCount').text('0');
        $('#previewServiciosList').html('<li class="text-muted">Sin servicios seleccionados</li>');
    }

    // =====================================================
    // FILTER FUNCTIONS
    // =====================================================

    function filterServicios(term) {
        $('.service-item').each(function() {
            const nombre = $(this).find('.service-details h6').text().toLowerCase();
            const descripcion = $(this).find('.service-details p').text().toLowerCase();
            const matches = nombre.includes(term) || descripcion.includes(term);
            $(this).toggle(matches);
        });

        // Hide empty categories
        $('.service-category').each(function() {
            const visibleItems = $(this).find('.service-item:visible').length;
            $(this).toggle(visibleItems > 0);
        });
    }

    function filterPersonalizados(term) {
        $('#personalizadosBody tr').each(function() {
            const cliente = $(this).find('.client-name').text().toLowerCase();
            const matches = cliente.includes(term);
            $(this).toggle(matches);
        });
    }

    // =====================================================
    // UTILITY FUNCTIONS
    // =====================================================

    function updateStats() {
        $('#totalPlanes').text(planes.filter(p => p.activo).length);
        $('#totalServicios').text(servicios.filter(s => s.activo).length);
        $('#totalPersonalizados').text(planesPersonalizados.length);
    }

    function formatPrice(price) {
        return price.toString().replace(/\B(?=(\d{3})+(?!\d))/g, '.');
    }

    function getBadgeText(badge) {
        const texts = {
            popular: 'Mas vendido',
            recommended: 'Recomendado',
            new: 'Nuevo',
            offer: 'Oferta'
        };
        return texts[badge] || '';
    }

    function showToast(message, type = 'success') {
        const toast = $('#toast');
        const icon = $('#toastIcon');
        const msg = $('#toastMessage');

        toast.removeClass('success error warning').addClass(type);

        const icons = {
            success: 'bi-check-circle-fill',
            error: 'bi-x-circle-fill',
            warning: 'bi-exclamation-triangle-fill'
        };

        icon.attr('class', `bi ${icons[type]} me-2`);
        msg.text(message);

        const bsToast = new bootstrap.Toast(toast);
        bsToast.show();
    }
});
