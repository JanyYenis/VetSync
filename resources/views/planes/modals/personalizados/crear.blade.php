<!-- Modal: Plan Personalizado -->
<div class="modal fade" id="modalPersonalizado" tabindex="-1">
    <div class="modal-dialog modal-xl modal-dialog-centered modal-dialog-scrollable">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">
                    <i class="bi bi-sliders me-2"></i>
                    <span id="modalPersonalizadoTitle">Nuevo Plan Personalizado</span>
                </h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <div class="modal-body">
                <form id="formPersonalizado">
                    <input type="hidden" id="personalizadoId">

                    <div class="row">
                        <!-- Left Column: Configuration -->
                        <div class="col-lg-7">
                            <!-- Client Selection -->
                            <div class="form-section">
                                <h6 class="form-section-title">Cliente</h6>
                                <div class="row g-3">
                                    <div class="col-md-6">
                                        <label class="form-label">Seleccionar Cliente <span
                                                class="text-danger">*</span></label>
                                        <select class="form-select" id="personalizadoCliente" required>
                                            <option value="">Seleccionar...</option>
                                            <option value="1">Clinica Veterinaria San Martin</option>
                                            <option value="2">Hospital Animal Care</option>
                                            <option value="3">Pet Center Colombia</option>
                                            <option value="4">Veterinaria El Campestre</option>
                                            <option value="5">Centro Medico Mascotas Felices</option>
                                        </select>
                                    </div>
                                    <div class="col-md-6">
                                        <label class="form-label">Plan Base <span class="text-danger">*</span></label>
                                        <select class="form-select" id="personalizadoPlanBase" required>
                                            <option value="">Seleccionar plan base...</option>
                                        </select>
                                    </div>
                                </div>
                            </div>

                            <!-- Custom Pricing -->
                            <div class="form-section">
                                <h6 class="form-section-title">Precio Personalizado</h6>
                                <div class="row g-3">
                                    <div class="col-md-6">
                                        <label class="form-label">Precio Mensual</label>
                                        <div class="input-group">
                                            <span class="input-group-text">$</span>
                                            <input type="number" class="form-control" id="personalizadoPrecio"
                                                placeholder="0">
                                            <span class="input-group-text">COP</span>
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <label class="form-label">Descuento (%)</label>
                                        <div class="input-group">
                                            <input type="number" class="form-control" id="personalizadoDescuento"
                                                placeholder="0" min="0" max="100">
                                            <span class="input-group-text">%</span>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <!-- Custom Limits -->
                            <div class="form-section">
                                <h6 class="form-section-title">Limites Personalizados</h6>
                                <div class="row g-3">
                                    <div class="col-md-3">
                                        <label class="form-label">Usuarios</label>
                                        <input type="number" class="form-control" id="personalizadoUsuarios"
                                            placeholder="Ilimitado" min="0">
                                    </div>
                                    <div class="col-md-3">
                                        <label class="form-label">Sedes</label>
                                        <input type="number" class="form-control" id="personalizadoSedes"
                                            placeholder="Ilimitado" min="0">
                                    </div>
                                    <div class="col-md-3">
                                        <label class="form-label">Mascotas</label>
                                        <input type="number" class="form-control" id="personalizadoMascotas"
                                            placeholder="Ilimitado" min="0">
                                    </div>
                                    <div class="col-md-3">
                                        <label class="form-label">Storage (GB)</label>
                                        <input type="number" class="form-control" id="personalizadoStorage"
                                            placeholder="Ilimitado" min="0">
                                    </div>
                                </div>
                            </div>

                            <!-- Services Toggle -->
                            <div class="form-section">
                                <h6 class="form-section-title">Servicios</h6>
                                <p class="text-muted small mb-3">Activa o desactiva servicios para este cliente</p>
                                <div class="services-toggle-grid" id="personalizadoServicios">
                                    <!-- Services toggles will be rendered here -->
                                </div>
                            </div>
                        </div>

                        <!-- Right Column: Preview -->
                        <div class="col-lg-5">
                            <div class="plan-preview-card sticky-top" style="top: 1rem;">
                                <div class="preview-header">
                                    <h6><i class="bi bi-eye me-2"></i>Vista Previa del Plan</h6>
                                </div>
                                <div class="preview-body">
                                    <div class="preview-client mb-3">
                                        <small class="text-muted">Cliente</small>
                                        <p class="mb-0 fw-semibold" id="previewCliente">-</p>
                                    </div>
                                    <div class="preview-plan mb-3">
                                        <small class="text-muted">Plan Base</small>
                                        <p class="mb-0" id="previewPlanBase">-</p>
                                    </div>
                                    <div class="preview-price mb-3">
                                        <small class="text-muted">Precio Mensual</small>
                                        <h3 class="mb-0 text-primary" id="previewPrecio">$0</h3>
                                        <small class="text-success" id="previewDescuento" style="display: none;">
                                            <i class="bi bi-tag-fill me-1"></i><span></span>
                                        </small>
                                    </div>
                                    <hr>
                                    <div class="preview-limits mb-3">
                                        <small class="text-muted d-block mb-2">Limites</small>
                                        <div class="limits-grid" id="previewLimites">
                                            <div class="limit-item">
                                                <i class="bi bi-people"></i>
                                                <span>- usuarios</span>
                                            </div>
                                            <div class="limit-item">
                                                <i class="bi bi-building"></i>
                                                <span>- sedes</span>
                                            </div>
                                            <div class="limit-item">
                                                <i class="bi bi-heart"></i>
                                                <span>- mascotas</span>
                                            </div>
                                            <div class="limit-item">
                                                <i class="bi bi-cloud"></i>
                                                <span>- GB</span>
                                            </div>
                                        </div>
                                    </div>
                                    <hr>
                                    <div class="preview-services">
                                        <small class="text-muted d-block mb-2">Servicios Incluidos (<span
                                                id="previewServiciosCount">0</span>)</small>
                                        <ul class="services-list" id="previewServiciosList">
                                            <!-- Services will be listed here -->
                                        </ul>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </form>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-outline-secondary" data-bs-dismiss="modal">Cancelar</button>
                <button type="button" class="btn btn-primary" id="btnSavePersonalizado">
                    <i class="bi bi-check-lg me-2"></i>Guardar Plan Personalizado
                </button>
            </div>
        </div>
    </div>
</div>
