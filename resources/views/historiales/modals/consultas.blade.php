<!-- Modal para agregar/editar consulta -->
<div class="modal fade" id="modalConsulta" tabindex="-1">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header bg-primary text-white">
                <h5 class="modal-title" id="modalConsultaTitulo">
                    <i class="bi bi-plus-circle me-2"></i>Agregar Consulta
                </h5>
                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
            </div>
            <div class="modal-body">
                <form id="formConsulta">
                    <input type="hidden" id="consultaIndex">
                    <div class="row g-3">
                        <div class="col-md-6">
                            <label class="form-label">Fecha <span class="text-danger">*</span></label>
                            <input type="date" class="form-control" id="consultaFecha" required>
                        </div>
                        <div class="col-md-6">
                            <label class="form-label">Veterinario <span class="text-danger">*</span></label>
                            <input type="text" class="form-control" id="consultaVeterinario" readonly disabled required>
                        </div>
                        <div class="col-12">
                            <label class="form-label">Motivo de consulta <span class="text-danger">*</span></label>
                            <input type="text" class="form-control" id="consultaMotivo" required
                                placeholder="Ej: Revisión general, vacunación, emergencia...">
                        </div>
                        <div class="col-12">
                            <label class="form-label">Diagnóstico</label>
                            <textarea class="form-control" id="consultaDiagnostico" rows="2" placeholder="Diagnóstico detallado..."></textarea>
                        </div>
                        <div class="col-12">
                            <label class="form-label">Tratamiento</label>
                            <textarea class="form-control" id="consultaTratamiento" rows="2"
                                placeholder="Tratamiento indicado, medicamentos, dosis..."></textarea>
                        </div>
                    </div>
                </form>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancelar</button>
                <button type="button" class="btn btn-primary" id="btnGuardarConsulta">
                    <i class="bi bi-check-lg me-1"></i>Guardar Consulta
                </button>
            </div>
        </div>
    </div>
</div>
