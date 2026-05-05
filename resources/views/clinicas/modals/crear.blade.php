<!-- ========================================
         MODAL: CREAR/EDITAR CLÍNICA
    ======================================== -->
<div class="modal fade" id="clinicModal" tabindex="-1" aria-labelledby="clinicModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg modal-dialog-centered modal-dialog-scrollable">
        <div class="modal-content">
            <div class="modal-header border-0 pb-0">
                <h5 class="modal-title" id="clinicModalLabel">
                    <i class="bi bi-hospital me-2"></i>Nueva Clínica
                </h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form id="clinicForm">
                    <input type="hidden" id="clinicId" value="">

                    <!-- Logo Upload -->
                    <div class="logo-upload-section mb-4">
                        <div class="row align-items-center">
                            <div class="col-auto">
                                <div class="logo-preview-container">
                                    <img src="placeholder-logo.png" alt="Logo preview" id="logoPreview"
                                        class="logo-preview">
                                    <label for="logoInput" class="logo-upload-btn">
                                        <i class="bi bi-camera"></i>
                                    </label>
                                </div>
                            </div>
                            <div class="col">
                                <h6 class="mb-1">Logo de la clínica</h6>
                                <p class="text-muted small mb-2">Sube una imagen PNG o JPG. Máximo 2MB.</p>
                                <input type="file" id="logoInput" class="d-none" accept="image/*"
                                    onchange="previewLogo(this)">
                                <button type="button" class="btn btn-outline-primary btn-sm"
                                    onclick="document.getElementById('logoInput').click()">
                                    <i class="bi bi-upload me-1"></i>Subir imagen
                                </button>
                            </div>
                        </div>
                    </div>

                    <hr class="my-4">

                    <!-- Información básica -->
                    <h6 class="form-section-title mb-3">
                        <i class="bi bi-info-circle me-2"></i>Información Básica
                    </h6>

                    <div class="row g-3">
                        <div class="col-md-6">
                            <label for="nombre" class="form-label">Nombre o Razón Social *</label>
                            <div class="input-group">
                                <span class="input-group-text"><i class="bi bi-building"></i></span>
                                <input type="text" class="form-control" id="nombre"
                                    placeholder="Ej: Clínica Veterinaria Patitas" required>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <label for="nit" class="form-label">NIT *</label>
                            <div class="input-group">
                                <span class="input-group-text"><i class="bi bi-card-text"></i></span>
                                <input type="text" class="form-control" id="nit"
                                    placeholder="Ej: 900.123.456-7" required>
                            </div>
                        </div>
                        <div class="col-12">
                            <label for="direccion" class="form-label">Dirección *</label>
                            <div class="input-group">
                                <span class="input-group-text"><i class="bi bi-geo-alt"></i></span>
                                <input type="text" class="form-control" id="direccion"
                                    placeholder="Ej: Calle 123 #45-67, Bogotá" required>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <label for="ciudad" class="form-label">Ciudad *</label>
                            <div class="input-group">
                                <span class="input-group-text"><i class="bi bi-pin-map"></i></span>
                                <input type="text" class="form-control" id="ciudad" placeholder="Ej: Bogotá"
                                    required>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <label for="telefono" class="form-label">Teléfono *</label>
                            <div class="input-group">
                                <span class="input-group-text"><i class="bi bi-telephone"></i></span>
                                <input type="text" class="form-control" id="telefono"
                                    placeholder="Ej: +57 300 123 4567" required>
                            </div>
                        </div>
                        <div class="col-12">
                            <label for="correo" class="form-label">Correo Electrónico *</label>
                            <div class="input-group">
                                <span class="input-group-text"><i class="bi bi-envelope"></i></span>
                                <input type="email" class="form-control" id="correo"
                                    placeholder="Ej: contacto@veterinaria.com" required>
                            </div>
                        </div>
                    </div>

                    <hr class="my-4">

                    <!-- Redes sociales -->
                    <h6 class="form-section-title mb-3">
                        <i class="bi bi-share me-2"></i>Redes Sociales
                    </h6>

                    <div class="row g-3">
                        <div class="col-md-4">
                            <label for="instagram" class="form-label">Instagram</label>
                            <div class="input-group">
                                <span class="input-group-text social-icon instagram">
                                    <i class="bi bi-instagram"></i>
                                </span>
                                <input type="url" class="form-control" id="instagram"
                                    placeholder="https://instagram.com/...">
                            </div>
                        </div>
                        <div class="col-md-4">
                            <label for="facebook" class="form-label">Facebook</label>
                            <div class="input-group">
                                <span class="input-group-text social-icon facebook">
                                    <i class="bi bi-facebook"></i>
                                </span>
                                <input type="url" class="form-control" id="facebook"
                                    placeholder="https://facebook.com/...">
                            </div>
                        </div>
                        <div class="col-md-4">
                            <label for="tiktok" class="form-label">TikTok</label>
                            <div class="input-group">
                                <span class="input-group-text social-icon tiktok">
                                    <i class="bi bi-tiktok"></i>
                                </span>
                                <input type="url" class="form-control" id="tiktok"
                                    placeholder="https://tiktok.com/...">
                            </div>
                        </div>
                    </div>

                    <hr class="my-4">

                    <!-- Estado -->
                    <div class="form-check form-switch">
                        <input class="form-check-input" type="checkbox" id="activa" checked>
                        <label class="form-check-label" for="activa">
                            <strong>Clínica Activa</strong>
                            <span class="text-muted d-block small">Las clínicas inactivas no aparecerán en el
                                sistema</span>
                        </label>
                    </div>
                </form>
            </div>
            <div class="modal-footer border-0 pt-0">
                <button type="button" class="btn btn-outline-secondary" data-bs-dismiss="modal">
                    <i class="bi bi-x-lg me-1"></i>Cancelar
                </button>
                <button type="button" class="btn btn-primary" onclick="saveClinic()">
                    <i class="bi bi-check-lg me-1"></i>Guardar Clínica
                </button>
            </div>
        </div>
    </div>
</div>
