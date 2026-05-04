<!-- Modal Cliente -->
<div class="modal fade" id="clienteModal" tabindex="-1">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="clienteModalTitle">Nuevo Cliente</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <form id="clienteForm">
                <div class="modal-body">
                    <div class="mb-3">
                        <label class="form-label">Nombre Completo</label>
                        <input type="text" class="form-control" id="clienteNombre"
                            placeholder="Ingrese el nombre completo" name="nombre" required>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Tipo de Identificación</label>
                        <select class="form-select" id="tipoId" data-control="select2"
                            data-placeholder="Seleccione el tipo de identificación" data-allow-clear="true"
                            data-hide-search="true" name="tipo_identificacion" required>
                            <option value=""></option>
                            @foreach ($tipo_documentos as $item)
                                <option value="{{ $item?->codigo }}">{{ $item?->nombre ?? 'N/A' }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Identificación</label>
                        <input type="text" class="form-control" id="clienteItentificacion"
                            placeholder="Ingrese el numero de identificación" name="identificacion" required>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Teléfono</label>
                        <input type="tel" class="form-control" id="clienteTelefono" name="telefono"
                            required>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Email</label>
                        <input type="email" class="form-control" id="clienteEmail" name="email" required
                            placeholder="Ingrese el email">
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Dirección</label>
                        <textarea class="form-control" id="clienteDireccion" name="direccion" rows="2"
                            placeholder="Ingrese la dirección"></textarea>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-outline-secondary" data-bs-dismiss="modal">Cancelar</button>
                    <button type="submit" class="btn btn-primary">Guardar</button>
                </div>
            </form>
        </div>
    </div>
</div>
