<!-- ========================================
         MODAL: CONFIRMAR ELIMINACIÓN
    ======================================== -->
<div class="modal fade" id="deleteModal" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-body text-center py-5">
                <div class="delete-icon mb-4">
                    <i class="bi bi-exclamation-triangle"></i>
                </div>
                <h4 class="mb-3">¿Eliminar clínica?</h4>
                <p class="text-muted mb-4">Esta acción no se puede deshacer. Se eliminarán todos los datos asociados a
                    <strong id="deleteClinicName"></strong>.</p>
                <input type="hidden" id="deleteClinicId">
                <div class="d-flex justify-content-center gap-3">
                    <button type="button" class="btn btn-outline-secondary px-4" data-bs-dismiss="modal">
                        Cancelar
                    </button>
                    <button type="button" class="btn btn-danger px-4" onclick="confirmDelete()">
                        <i class="bi bi-trash me-1"></i>Eliminar
                    </button>
                </div>
            </div>
        </div>
    </div>
</div>
