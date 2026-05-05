<!-- Modal: Crear/Editar Servicio -->
<div class="modal fade" id="modalServicio" tabindex="-1">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">
                    <i class="bi bi-puzzle me-2"></i>
                    <span id="modalServicioTitle">Nuevo Servicio</span>
                </h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <div class="modal-body">
                <form id="formServicio">
                    <input type="hidden" id="servicioId">
                    <div class="mb-3">
                        <label class="form-label">Nombre del Servicio <span class="text-danger">*</span></label>
                        <input type="text" class="form-control" id="servicioNombre" required
                            placeholder="Ej: Gestion de Clientes">
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Descripcion</label>
                        <textarea class="form-control" id="servicioDescripcion" rows="2" placeholder="Descripcion del servicio..."></textarea>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Categoria</label>
                        <select class="form-select" id="servicioCategoria">
                            <option value="estructura">Estructura</option>
                            <option value="clinico">Funcionalidades Clinicas</option>
                            <option value="admin">Administracion</option>
                            <option value="integraciones">Integraciones</option>
                            <option value="soporte">Soporte</option>
                        </select>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Icono</label>
                        <select class="form-select" id="servicioIcono">
                            <option value="bi-people">Personas</option>
                            <option value="bi-heart">Corazon</option>
                            <option value="bi-clipboard2-pulse">Historial</option>
                            <option value="bi-file-earmark-medical">Documento</option>
                            <option value="bi-file-pdf">PDF</option>
                            <option value="bi-graph-up">Grafico</option>
                            <option value="bi-building">Edificio</option>
                            <option value="bi-person-badge">Roles</option>
                            <option value="bi-code-slash">API</option>
                            <option value="bi-headset">Soporte</option>
                            <option value="bi-cloud-upload">Nube</option>
                            <option value="bi-calendar-check">Calendario</option>
                        </select>
                    </div>
                    <div class="form-check form-switch">
                        <input class="form-check-input" type="checkbox" id="servicioActivo" checked>
                        <label class="form-check-label" for="servicioActivo">Servicio activo</label>
                    </div>
                </form>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-outline-secondary" data-bs-dismiss="modal">Cancelar</button>
                <button type="button" class="btn btn-primary" id="btnSaveServicio">
                    <i class="bi bi-check-lg me-2"></i>Guardar Servicio
                </button>
            </div>
        </div>
    </div>
</div>
