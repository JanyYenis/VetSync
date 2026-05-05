<!-- Modal: Crear/Editar Plan -->
<div class="modal fade" id="modalPlan" tabindex="-1">
    <div class="modal-dialog modal-lg modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">
                    <i class="bi bi-credit-card-2-front me-2"></i>
                    <span id="modalPlanTitle">Nuevo Plan</span>
                </h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <div class="modal-body">
                <form id="formPlan">
                    <input type="hidden" id="planId">

                    <!-- Basic Info -->
                    <div class="form-section">
                        <h6 class="form-section-title">Informacion Basica</h6>
                        <div class="row g-3">
                            <div class="col-md-6">
                                <label class="form-label">Nombre del Plan <span class="text-danger">*</span></label>
                                <input type="text" class="form-control" id="planNombre" required
                                    placeholder="Ej: Profesional">
                            </div>
                            <div class="col-md-6">
                                <label class="form-label">Estado</label>
                                <div class="form-check form-switch mt-2">
                                    <input class="form-check-input" type="checkbox" id="planActivo" checked>
                                    <label class="form-check-label" for="planActivo">Plan activo</label>
                                </div>
                            </div>
                            <div class="col-12">
                                <label class="form-label">Descripcion</label>
                                <textarea class="form-control" id="planDescripcion" rows="2" placeholder="Descripcion breve del plan..."></textarea>
                            </div>
                        </div>
                    </div>

                    <!-- Pricing -->
                    <div class="form-section">
                        <h6 class="form-section-title">Precios</h6>
                        <div class="row g-3">
                            <div class="col-md-6">
                                <label class="form-label">Precio Mensual <span class="text-danger">*</span></label>
                                <div class="input-group">
                                    <span class="input-group-text">$</span>
                                    <input type="number" class="form-control" id="planPrecioMensual" required
                                        placeholder="0">
                                    <span class="input-group-text">COP</span>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <label class="form-label">Precio Anual</label>
                                <div class="input-group">
                                    <span class="input-group-text">$</span>
                                    <input type="number" class="form-control" id="planPrecioAnual" placeholder="0">
                                    <span class="input-group-text">COP</span>
                                </div>
                                <small class="text-muted">Dejar vacio para calcular automaticamente (-20%)</small>
                            </div>
                        </div>
                    </div>

                    <!-- Limits -->
                    <div class="form-section">
                        <h6 class="form-section-title">Limites</h6>
                        <div class="row g-3">
                            <div class="col-md-3">
                                <label class="form-label">Usuarios</label>
                                <input type="number" class="form-control" id="planLimiteUsuarios"
                                    placeholder="Ilimitado" min="0">
                            </div>
                            <div class="col-md-3">
                                <label class="form-label">Sedes</label>
                                <input type="number" class="form-control" id="planLimiteSedes" placeholder="Ilimitado"
                                    min="0">
                            </div>
                            <div class="col-md-3">
                                <label class="form-label">Mascotas</label>
                                <input type="number" class="form-control" id="planLimiteMascotas"
                                    placeholder="Ilimitado" min="0">
                            </div>
                            <div class="col-md-3">
                                <label class="form-label">Almacenamiento (GB)</label>
                                <input type="number" class="form-control" id="planLimiteStorage"
                                    placeholder="Ilimitado" min="0">
                            </div>
                        </div>
                    </div>

                    <!-- Services -->
                    <div class="form-section">
                        <h6 class="form-section-title">Servicios Incluidos</h6>
                        <div class="services-selector" id="planServiciosSelector">
                            <!-- Services checkboxes will be rendered here -->
                        </div>
                    </div>

                    <!-- Badge -->
                    <div class="form-section">
                        <h6 class="form-section-title">Opciones Adicionales</h6>
                        <div class="row g-3">
                            <div class="col-md-6">
                                <label class="form-label">Badge/Etiqueta</label>
                                <select class="form-select" id="planBadge">
                                    <option value="">Sin badge</option>
                                    <option value="popular">Mas vendido</option>
                                    <option value="recommended">Recomendado</option>
                                    <option value="new">Nuevo</option>
                                    <option value="offer">Oferta</option>
                                </select>
                            </div>
                            <div class="col-md-6">
                                <label class="form-label">Color del Plan</label>
                                <select class="form-select" id="planColor">
                                    <option value="primary">Azul</option>
                                    <option value="success">Verde</option>
                                    <option value="warning">Naranja</option>
                                    <option value="info">Cyan</option>
                                    <option value="secondary">Gris</option>
                                </select>
                            </div>
                        </div>
                    </div>
                </form>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-outline-secondary" data-bs-dismiss="modal">Cancelar</button>
                <button type="button" class="btn btn-primary" id="btnSavePlan">
                    <i class="bi bi-check-lg me-2"></i>Guardar Plan
                </button>
            </div>
        </div>
    </div>
</div>
