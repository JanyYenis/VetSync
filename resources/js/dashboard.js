/* ========================================
   VetSync - Dashboard Scripts
   ======================================== */

let clientesChart, mascotasChart;

$(document).ready(function() {
    'use strict';

    // ==========================================
    // Initialize Application
    // ==========================================
    initDashboard();
    // initMascotas();
    // initHistorial();
    // initPrescripciones();

    // ==========================================
    // Dashboard Functions
    // ==========================================

    function initDashboard() {
        refreshDashboard();
    }

    function refreshDashboard() {
        const config = {
            'method': 'GET',
            'headers': {
                'Accept': generalidades.CONTENT_TYPE_JSON,
            },
        }

        const success = (response) => {
            if (response.estado == 'success') {
                // Update stat cards
                $('#totalClientes').text(response?.cantidad_clientes ?? 0);
                $('#totalMascotas').text(response?.cantidad_mascotas ?? 0);
                $('#totalPrescripciones').text(response?.cantidad_prescipciones ?? 0);

                // Render charts
                renderClientesChart(response?.label_clientes_por_mes, response?.serie_clientes_por_mes);
                renderMascotasChart(response?.label_tipo_mascotas, response?.serie_tipo_mascotas);
                renderUltimasConsultas(response?.ultimas_consultas);
            }
            generalidades.ocultarCargando('body');
            generalidades.toastrGenerico(response?.estado, response?.mensaje);
        }

        const error = (response) => {
            generalidades.ocultarCargando('body');
            generalidades.toastrGenerico(response?.estado, response?.mensaje);
        }

        generalidades.get(route('dashboard'), config, success, error);
        generalidades.mostrarCargando('body');
    }

    function renderClientesChart(label_clientes_por_mes, serie_clientes_por_mes) {
        const ctx = document.getElementById('clientesChart');
        if (!ctx) return;

        if (clientesChart) {
            clientesChart.destroy();
        }

        // Simulated monthly data
        const monthlyData = serie_clientes_por_mes;
        const labels = label_clientes_por_mes;

        clientesChart = new Chart(ctx, {
            type: 'line',
            data: {
                labels: labels,
                datasets: [{
                    label: 'Nuevos Clientes',
                    data: monthlyData,
                    borderColor: '#2563eb',
                    backgroundColor: 'rgba(37, 99, 235, 0.1)',
                    borderWidth: 2,
                    fill: true,
                    tension: 0.4,
                    pointRadius: 4,
                    pointBackgroundColor: '#2563eb'
                }]
            },
            options: {
                responsive: true,
                maintainAspectRatio: false,
                plugins: {
                    legend: {
                        display: false
                    }
                },
                scales: {
                    y: {
                        beginAtZero: true,
                        grid: {
                            color: 'rgba(0,0,0,0.05)'
                        }
                    },
                    x: {
                        grid: {
                            display: false
                        }
                    }
                }
            }
        });
    }

    function renderMascotasChart(label_tipo_mascotas, serie_tipo_mascotas) {
        const ctx = document.getElementById('mascotasChart');
        if (!ctx) return;

        if (mascotasChart) {
            mascotasChart.destroy();
        }

        const labels = label_tipo_mascotas;
        const data = serie_tipo_mascotas;
        const colors = ['#2563eb', '#10b981', '#f59e0b', '#ef4444', '#8b5cf6'];

        mascotasChart = new Chart(ctx, {
            type: 'doughnut',
            data: {
                labels: labels,
                datasets: [{
                    data: data,
                    backgroundColor: colors.slice(0, labels.length),
                    borderWidth: 0,
                    hoverOffset: 10
                }]
            },
            options: {
                responsive: true,
                maintainAspectRatio: false,
                plugins: {
                    legend: {
                        position: 'bottom',
                        labels: {
                            padding: 20,
                            usePointStyle: true
                        }
                    }
                },
                cutout: '65%'
            }
        });
    }

    function renderUltimasConsultas(ultimas_consultas) {
        const $container = $('#ultimasConsultas');
        $container.empty();

        if (ultimas_consultas.length === 0) {
            $container.html('<div class="p-4 text-center text-muted">No hay consultas registradas</div>');
            return;
        }

        ultimas_consultas.forEach(function(consulta) {
            const mascota = consulta?.historial?.mascota ?? '';
            const propietario = consulta?.historial?.propietario ?? '';
            const mascotaNombre = mascota?.nombre ? `${mascota?.nombre} - ${propietario?.nombre}` : 'Desconocido';
            const iconClass = mascota?.info_tipo?.icono ?? '';
            const bgClass = mascota?.info_tipo?.color ?? 'success';
            const textClass = mascota?.info_tipo?.color ?? 'success';

            $container.append(`
                <div class="activity-item">
                    <div class="activity-icon bg-${bgClass}-subtle">
                        <i class="fa ${iconClass} text-${textClass}"></i>
                    </div>
                    <div class="activity-info">
                        <h6>${mascotaNombre}</h6>
                        <p>${consulta.diagnostico.substring(0, 50)}...</p>
                    </div>
                    <span class="activity-time">${formatDate(consulta.fecha)}</span>
                </div>
            `);
        });
    }

    // ==========================================
    // Mascotas Module
    // ==========================================
    function initMascotas() {
        renderMascotasTable();
        populateClienteSelect();

        // Search
        $('#searchMascotas').on('input', function() {
            renderMascotasTable($(this).val());
        });

        // Form submit
        $('#mascotaForm').on('submit', function(e) {
            e.preventDefault();
            saveMascota();
        });

        // Reset modal on close
        $('#mascotaModal').on('hidden.bs.modal', function() {
            resetMascotaForm();
        });
    }

    function populateClienteSelect() {
        const $select = $('#mascotaCliente');
        $select.find('option:not(:first)').remove();

        VetData.clientes.forEach(function(cliente) {
            $select.append(`<option value="${cliente.id}">${cliente.nombre}</option>`);
        });
    }

    function renderMascotasTable(search = '') {
        const $tbody = $('#mascotasTableBody');
        $tbody.empty();

        let mascotas = VetData.mascotas;

        if (search) {
            const searchLower = search.toLowerCase();
            mascotas = mascotas.filter(m =>
                m.nombre.toLowerCase().includes(searchLower) ||
                m.tipo.toLowerCase().includes(searchLower) ||
                (m.raza && m.raza.toLowerCase().includes(searchLower))
            );
        }

        if (mascotas.length === 0) {
            $tbody.html('<tr><td colspan="7" class="text-center text-muted py-4">No se encontraron mascotas</td></tr>');
            return;
        }

        mascotas.forEach(function(mascota) {
            const cliente = VetData.getCliente(mascota.clienteId);
            const clienteNombre = cliente ? cliente.nombre : 'Sin propietario';
            const tipoIcon = mascota.tipo === 'Perro' ? 'bi-emoji-heart-eyes' : (mascota.tipo === 'Gato' ? 'bi-emoji-smile' : 'bi-heart');
            const tipoBg = mascota.tipo === 'Perro' ? 'bg-warning-subtle text-warning' : 'bg-info-subtle text-info';

            $tbody.append(`
                <tr>
                    <td><span class="badge bg-light text-dark">#${mascota.id}</span></td>
                    <td>
                        <div class="d-flex align-items-center gap-2">
                            <div class="avatar-sm ${tipoBg} rounded-circle d-flex align-items-center justify-content-center" style="width:36px;height:36px;">
                                <i class="bi ${tipoIcon}"></i>
                            </div>
                            <strong>${mascota.nombre}</strong>
                        </div>
                    </td>
                    <td><span class="badge ${tipoBg}">${mascota.tipo}</span></td>
                    <td>${mascota.raza || '-'}</td>
                    <td>${mascota.edad} año(s)</td>
                    <td>${clienteNombre}</td>
                    <td>
                        <div class="actions">
                            <button class="btn-action btn-edit" onclick="editMascota(${mascota.id})" title="Editar">
                                <i class="bi bi-pencil"></i>
                            </button>
                            <button class="btn-action btn-delete" onclick="confirmDelete('mascota', ${mascota.id})" title="Eliminar">
                                <i class="bi bi-trash"></i>
                            </button>
                        </div>
                    </td>
                </tr>
            `);
        });
    }

    window.editMascota = function(id) {
        const mascota = VetData.getMascota(id);
        if (!mascota) return;

        $('#mascotaModalTitle').text('Editar Mascota');
        $('#mascotaId').val(mascota.id);
        $('#mascotaNombre').val(mascota.nombre);
        $('#mascotaTipo').val(mascota.tipo);
        $('#mascotaRaza').val(mascota.raza || '');
        $('#mascotaEdad').val(mascota.edad);
        $('#mascotaPeso').val(mascota.peso || '');
        $('#mascotaCliente').val(mascota.clienteId);

        new bootstrap.Modal('#mascotaModal').show();
    };

    function saveMascota() {
        const id = $('#mascotaId').val();
        const data = {
            nombre: $('#mascotaNombre').val(),
            tipo: $('#mascotaTipo').val(),
            raza: $('#mascotaRaza').val(),
            edad: parseInt($('#mascotaEdad').val()),
            peso: parseFloat($('#mascotaPeso').val()) || null,
            clienteId: parseInt($('#mascotaCliente').val())
        };

        if (id) {
            VetData.updateMascota(parseInt(id), data);
            showToast('Mascota actualizada', 'success');
        } else {
            VetData.addMascota(data);
            showToast('Mascota creada', 'success');
        }

        bootstrap.Modal.getInstance('#mascotaModal').hide();
        renderMascotasTable();
        refreshDashboard();
    }

    function resetMascotaForm() {
        $('#mascotaModalTitle').text('Nueva Mascota');
        $('#mascotaForm')[0].reset();
        $('#mascotaId').val('');
    }

    // ==========================================
    // Historial Module
    // ==========================================
    function initHistorial() {
        renderHistorialTable();
        populateMascotaSelects();

        // Search
        $('#searchHistorial').on('input', function() {
            renderHistorialTable($(this).val(), $('#filterMascotaHistorial').val());
        });

        // Filter by mascota
        $('#filterMascotaHistorial').on('change', function() {
            renderHistorialTable($('#searchHistorial').val(), $(this).val());
        });

        // Form submit
        $('#historialForm').on('submit', function(e) {
            e.preventDefault();
            saveHistorial();
        });

        // Reset modal on close
        $('#historialModal').on('hidden.bs.modal', function() {
            resetHistorialForm();
        });

        // Set default date
        $('#historialFecha').val(new Date().toISOString().split('T')[0]);
    }

    function populateMascotaSelects() {
        const selects = ['#historialMascota', '#prescripcionMascota', '#filterMascotaHistorial'];

        selects.forEach(function(selector) {
            const $select = $(selector);
            $select.find('option:not(:first)').remove();

            VetData.mascotas.forEach(function(mascota) {
                const cliente = VetData.getCliente(mascota.clienteId);
                const label = cliente ? `${mascota.nombre} (${cliente.nombre})` : mascota.nombre;
                $select.append(`<option value="${mascota.id}">${label}</option>`);
            });
        });
    }

    function renderHistorialTable(search = '', filterMascota = '') {
        const $tbody = $('#historialTableBody');
        $tbody.empty();

        let historial = VetData.historial;

        if (filterMascota) {
            historial = historial.filter(h => h.mascotaId === parseInt(filterMascota));
        }

        if (search) {
            const searchLower = search.toLowerCase();
            historial = historial.filter(h =>
                h.diagnostico.toLowerCase().includes(searchLower) ||
                h.tratamiento.toLowerCase().includes(searchLower)
            );
        }

        // Sort by date descending
        historial.sort((a, b) => new Date(b.fecha) - new Date(a.fecha));

        if (historial.length === 0) {
            $tbody.html('<tr><td colspan="6" class="text-center text-muted py-4">No se encontraron registros</td></tr>');
            return;
        }

        historial.forEach(function(registro) {
            const mascota = VetData.getMascota(registro.mascotaId);
            const mascotaNombre = mascota ? mascota.nombre : 'Desconocido';

            $tbody.append(`
                <tr>
                    <td><span class="badge bg-light text-dark">#${registro.id}</span></td>
                    <td>${formatDate(registro.fecha)}</td>
                    <td><strong>${mascotaNombre}</strong></td>
                    <td>${registro.diagnostico.substring(0, 40)}${registro.diagnostico.length > 40 ? '...' : ''}</td>
                    <td>${registro.tratamiento.substring(0, 40)}${registro.tratamiento.length > 40 ? '...' : ''}</td>
                    <td>
                        <div class="actions">
                            <button class="btn-action btn-edit" onclick="editHistorial(${registro.id})" title="Editar">
                                <i class="bi bi-pencil"></i>
                            </button>
                            <button class="btn-action btn-delete" onclick="confirmDelete('historial', ${registro.id})" title="Eliminar">
                                <i class="bi bi-trash"></i>
                            </button>
                        </div>
                    </td>
                </tr>
            `);
        });
    }

    window.editHistorial = function(id) {
        const registro = VetData.historial.find(h => h.id === id);
        if (!registro) return;

        $('#historialModalTitle').text('Editar Consulta');
        $('#historialId').val(registro.id);
        $('#historialMascota').val(registro.mascotaId);
        $('#historialFecha').val(registro.fecha);
        $('#historialMotivo').val(registro.motivo || '');
        $('#historialDiagnostico').val(registro.diagnostico);
        $('#historialTratamiento').val(registro.tratamiento);
        $('#historialObservaciones').val(registro.observaciones || '');

        new bootstrap.Modal('#historialModal').show();
    };

    function saveHistorial() {
        const id = $('#historialId').val();
        const data = {
            mascotaId: parseInt($('#historialMascota').val()),
            fecha: $('#historialFecha').val(),
            motivo: $('#historialMotivo').val(),
            diagnostico: $('#historialDiagnostico').val(),
            tratamiento: $('#historialTratamiento').val(),
            observaciones: $('#historialObservaciones').val()
        };

        if (id) {
            VetData.updateHistorial(parseInt(id), data);
            showToast('Consulta actualizada', 'success');
        } else {
            VetData.addHistorial(data);
            showToast('Consulta registrada', 'success');
        }

        bootstrap.Modal.getInstance('#historialModal').hide();
        renderHistorialTable();
        refreshDashboard();
    }

    function resetHistorialForm() {
        $('#historialModalTitle').text('Nueva Consulta');
        $('#historialForm')[0].reset();
        $('#historialId').val('');
        $('#historialFecha').val(new Date().toISOString().split('T')[0]);
    }

    // ==========================================
    // Prescripciones Module
    // ==========================================
    function initPrescripciones() {
        renderPrescripcionesTable();

        // Search
        $('#searchPrescripciones').on('input', function() {
            renderPrescripcionesTable($(this).val());
        });

        // Form submit
        $('#prescripcionForm').on('submit', function(e) {
            e.preventDefault();
            savePrescripcion();
        });

        // Reset modal on close
        $('#prescripcionModal').on('hidden.bs.modal', function() {
            resetPrescripcionForm();
        });

        // Set default date
        $('#prescripcionFecha').val(new Date().toISOString().split('T')[0]);
    }

    function renderPrescripcionesTable(search = '') {
        const $tbody = $('#prescripcionesTableBody');
        $tbody.empty();

        let prescripciones = VetData.prescripciones;

        if (search) {
            const searchLower = search.toLowerCase();
            prescripciones = prescripciones.filter(p =>
                p.medicamentos.toLowerCase().includes(searchLower) ||
                p.indicaciones.toLowerCase().includes(searchLower)
            );
        }

        // Sort by date descending
        prescripciones.sort((a, b) => new Date(b.fecha) - new Date(a.fecha));

        if (prescripciones.length === 0) {
            $tbody.html('<tr><td colspan="6" class="text-center text-muted py-4">No se encontraron prescripciones</td></tr>');
            return;
        }

        prescripciones.forEach(function(prescripcion) {
            const mascota = VetData.getMascota(prescripcion.mascotaId);
            const mascotaNombre = mascota ? mascota.nombre : 'Desconocido';

            $tbody.append(`
                <tr>
                    <td><span class="badge bg-light text-dark">#${prescripcion.id}</span></td>
                    <td>${formatDate(prescripcion.fecha)}</td>
                    <td><strong>${mascotaNombre}</strong></td>
                    <td>${prescripcion.medicamentos.substring(0, 40)}${prescripcion.medicamentos.length > 40 ? '...' : ''}</td>
                    <td>${prescripcion.indicaciones.substring(0, 40)}${prescripcion.indicaciones.length > 40 ? '...' : ''}</td>
                    <td>
                        <div class="actions">
                            <button class="btn-action btn-pdf" onclick="exportPDF(${prescripcion.id})" title="Exportar PDF">
                                <i class="bi bi-file-earmark-pdf"></i>
                            </button>
                            <button class="btn-action btn-edit" onclick="editPrescripcion(${prescripcion.id})" title="Editar">
                                <i class="bi bi-pencil"></i>
                            </button>
                            <button class="btn-action btn-delete" onclick="confirmDelete('prescripcion', ${prescripcion.id})" title="Eliminar">
                                <i class="bi bi-trash"></i>
                            </button>
                        </div>
                    </td>
                </tr>
            `);
        });
    }

    window.editPrescripcion = function(id) {
        const prescripcion = VetData.prescripciones.find(p => p.id === id);
        if (!prescripcion) return;

        $('#prescripcionModalTitle').text('Editar Prescripción');
        $('#prescripcionId').val(prescripcion.id);
        $('#prescripcionMascota').val(prescripcion.mascotaId);
        $('#prescripcionFecha').val(prescripcion.fecha);
        $('#prescripcionMedicamentos').val(prescripcion.medicamentos);
        $('#prescripcionIndicaciones').val(prescripcion.indicaciones);
        $('#prescripcionProximaCita').val(prescripcion.proximaCita || '');

        new bootstrap.Modal('#prescripcionModal').show();
    };

    function savePrescripcion() {
        const id = $('#prescripcionId').val();
        const data = {
            mascotaId: parseInt($('#prescripcionMascota').val()),
            fecha: $('#prescripcionFecha').val(),
            medicamentos: $('#prescripcionMedicamentos').val(),
            indicaciones: $('#prescripcionIndicaciones').val(),
            proximaCita: $('#prescripcionProximaCita').val()
        };

        if (id) {
            VetData.updatePrescripcion(parseInt(id), data);
            showToast('Prescripción actualizada', 'success');
        } else {
            VetData.addPrescripcion(data);
            showToast('Prescripción creada', 'success');
        }

        bootstrap.Modal.getInstance('#prescripcionModal').hide();
        renderPrescripcionesTable();
        refreshDashboard();
    }

    function resetPrescripcionForm() {
        $('#prescripcionModalTitle').text('Nueva Prescripción');
        $('#prescripcionForm')[0].reset();
        $('#prescripcionId').val('');
        $('#prescripcionFecha').val(new Date().toISOString().split('T')[0]);
    }

    // ==========================================
    // PDF Export
    // ==========================================
    window.exportPDF = function(id) {
        const prescripcion = VetData.prescripciones.find(p => p.id === id);
        if (!prescripcion) return;

        const mascota = VetData.getMascota(prescripcion.mascotaId);
        const cliente = mascota ? VetData.getCliente(mascota.clienteId) : null;

        const { jsPDF } = window.jspdf;
        const doc = new jsPDF();

        // Header
        doc.setFillColor(37, 99, 235);
        doc.rect(0, 0, 210, 45, 'F');

        doc.setTextColor(255, 255, 255);
        doc.setFontSize(24);
        doc.setFont('helvetica', 'bold');
        doc.text('VetSync', 20, 25);

        doc.setFontSize(12);
        doc.setFont('helvetica', 'normal');
        doc.text('Clínica Veterinaria', 20, 35);

        // Contact info
        doc.setFontSize(10);
        doc.text('Tel: +1 234 567 890', 140, 20);
        doc.text('info@vetcarepro.com', 140, 27);
        doc.text('Av. Principal #123', 140, 34);

        // Title
        doc.setTextColor(0, 0, 0);
        doc.setFontSize(18);
        doc.setFont('helvetica', 'bold');
        doc.text('PRESCRIPCIÓN MÉDICA', 105, 60, { align: 'center' });

        // Prescription number and date
        doc.setFontSize(10);
        doc.setFont('helvetica', 'normal');
        doc.setTextColor(100, 100, 100);
        doc.text(`No. ${prescripcion.id.toString().padStart(5, '0')}`, 20, 70);
        doc.text(`Fecha: ${formatDate(prescripcion.fecha)}`, 150, 70);

        // Patient info box
        doc.setDrawColor(200, 200, 200);
        doc.setFillColor(248, 250, 252);
        doc.roundedRect(20, 80, 170, 35, 3, 3, 'FD');

        doc.setTextColor(0, 0, 0);
        doc.setFontSize(11);
        doc.setFont('helvetica', 'bold');
        doc.text('DATOS DEL PACIENTE', 25, 90);

        doc.setFont('helvetica', 'normal');
        doc.setFontSize(10);
        doc.text(`Nombre: ${mascota ? mascota.nombre : 'N/A'}`, 25, 100);
        doc.text(`Especie: ${mascota ? mascota.tipo : 'N/A'}`, 90, 100);
        doc.text(`Raza: ${mascota && mascota.raza ? mascota.raza : 'N/A'}`, 140, 100);
        doc.text(`Propietario: ${cliente ? cliente.nombre : 'N/A'}`, 25, 108);

        // Medications
        doc.setFontSize(11);
        doc.setFont('helvetica', 'bold');
        doc.text('MEDICAMENTOS:', 20, 130);

        doc.setFont('helvetica', 'normal');
        doc.setFontSize(10);
        const medicamentos = doc.splitTextToSize(prescripcion.medicamentos, 170);
        doc.text(medicamentos, 20, 140);

        const yAfterMeds = 140 + (medicamentos.length * 6);

        // Indications
        doc.setFontSize(11);
        doc.setFont('helvetica', 'bold');
        doc.text('INDICACIONES:', 20, yAfterMeds + 15);

        doc.setFont('helvetica', 'normal');
        doc.setFontSize(10);
        const indicaciones = doc.splitTextToSize(prescripcion.indicaciones, 170);
        doc.text(indicaciones, 20, yAfterMeds + 25);

        const yAfterInds = yAfterMeds + 25 + (indicaciones.length * 6);

        // Next appointment
        if (prescripcion.proximaCita) {
            doc.setFontSize(11);
            doc.setFont('helvetica', 'bold');
            doc.text('PRÓXIMA CITA:', 20, yAfterInds + 15);
            doc.setFont('helvetica', 'normal');
            doc.text(formatDate(prescripcion.proximaCita), 65, yAfterInds + 15);
        }

        // Signature line
        doc.setDrawColor(0, 0, 0);
        doc.line(120, 250, 190, 250);
        doc.setFontSize(10);
        doc.text('Firma del Veterinario', 155, 258, { align: 'center' });

        // Footer
        doc.setFillColor(248, 250, 252);
        doc.rect(0, 280, 210, 17, 'F');
        doc.setFontSize(8);
        doc.setTextColor(100, 100, 100);
        doc.text('Este documento es válido por 30 días a partir de la fecha de emisión.', 105, 288, { align: 'center' });
        doc.text('VetSync - Cuidamos a tu mejor amigo', 105, 294, { align: 'center' });

        // Save
        doc.save(`prescripcion_${prescripcion.id}_${mascota ? mascota.nombre : 'paciente'}.pdf`);
        showToast('PDF generado exitosamente', 'success');
    };

    // ==========================================
    // Delete Confirmation
    // ==========================================
    window.confirmDelete = function(type, id) {
        deleteType = type;
        deleteId = id;
        new bootstrap.Modal('#deleteModal').show();
    };

    $('#confirmDelete').on('click', function() {
        if (!deleteId || !deleteType) return;

        switch(deleteType) {
            case 'cliente':
                VetData.deleteCliente(deleteId);
                renderClientesTable();
                break;
            case 'mascota':
                VetData.deleteMascota(deleteId);
                renderMascotasTable();
                break;
            case 'historial':
                VetData.deleteHistorial(deleteId);
                renderHistorialTable();
                break;
            case 'prescripcion':
                VetData.deletePrescripcion(deleteId);
                renderPrescripcionesTable();
                break;
        }

        bootstrap.Modal.getInstance('#deleteModal').hide();
        showToast('Registro eliminado', 'success');
        refreshDashboard();

        deleteType = '';
        deleteId = null;
    });

    // ==========================================
    // Utility Functions
    // ==========================================
    function formatDate(dateString) {
        const options = { year: 'numeric', month: 'short', day: 'numeric' };
        return new Date(dateString).toLocaleDateString('es-ES', options);
    }

    function showToast(message, type = 'success') {
        const $toast = $('#toastNotification');
        const $icon = $('#toastIcon');
        const $title = $('#toastTitle');
        const $message = $('#toastMessage');

        $message.text(message);

        if (type === 'success') {
            $icon.removeClass().addClass('bi bi-check-circle text-success me-2');
            $title.text('Éxito');
        } else if (type === 'error') {
            $icon.removeClass().addClass('bi bi-x-circle text-danger me-2');
            $title.text('Error');
        } else {
            $icon.removeClass().addClass('bi bi-info-circle text-primary me-2');
            $title.text('Información');
        }

        const toast = new bootstrap.Toast($toast[0]);
        toast.show();
    }
});
