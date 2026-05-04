<!-- Modal Mascota -->
<div class="modal fade" id="mascotaModal" tabindex="-1">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="mascotaModalTitle">Nueva Mascota</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <form id="mascotaForm">
                <div class="modal-body">
                    <div class="mb-3">
                        <label class="form-label">Nombre</label>
                        <input type="text" class="form-control" id="mascotaNombre" name="nombre" required
                            placeholder="Ingrese el nombre de la mascota">
                    </div>
                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <label class="form-label">Tipo</label>
                            <select class="form-select" id="mascotaTipo" name="tipo" required
                                data-control="select2" data-placeholder="Seleccione el tipo de mascota"
                                data-allow-clear="true" data-hide-search="true">
                                <option value=""></option>
                                @foreach ($tipos as $item)
                                    <option value="{{ $item?->codigo }}">{{ $item?->nombre ?? 'N/A' }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="col-md-6 mb-3">
                            <label class="form-label">Raza</label>
                            <input type="text" class="form-control" name="raza" id="mascotaRaza"
                                placeholder="Ingrese la raza de la mascota" required>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <label class="form-label">Genero</label>
                            <select class="form-select" id="selectGeneroMascota" name="genero" required
                                data-control="select2" data-placeholder="Seleccione el genero de la mascota"
                                data-allow-clear="true" data-hide-search="true">
                                <option value=""></option>
                                @foreach ($generos as $item)
                                    <option value="{{ $item?->codigo }}">{{ $item?->nombre ?? 'N/A' }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="col-md-6 mb-3">
                            <label class="form-label">Color</label>
                            <input type="text" class="form-control" id="mascotaColor" name="color"
                                placeholder="Ingrese el color de la mascota" required>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <label class="form-label">Edad (años)</label>
                            <input type="number" class="form-control" id="mascotaEdad" min="0" required
                                name="edad" placeholder="Ingrese la edad de la mascota">
                        </div>
                        <div class="col-md-6 mb-3">
                            <label class="form-label">Peso (kg)</label>
                            <input type="number" class="form-control" id="mascotaPeso" step="0.1" min="0"
                                required name="peso" placeholder="Ingrese el peso de la mascota">
                        </div>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Propietario</label>
                        <select class="form-select" id="mascotaCliente" name="cod_cliente" required>
                            <option value="">Seleccionar cliente...</option>
                        </select>
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
