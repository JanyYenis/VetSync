<input type="hidden" name="id" value="{{ $cliente?->id }}">
<div class="modal-body">
    <div class="mb-3">
        <label class="form-label">Nombre Completo</label>
        <input type="text" class="form-control" placeholder="Ingrese el nombre completo" name="nombre"
            required value="{{ $cliente?->nombre ?? '' }}">
    </div>
    <div class="mb-3">
        <label class="form-label">Tipo de Identificación</label>
        <select class="form-select" id="selectTipoIdentificacion" data-control="select2"
            data-placeholder="Seleccione el tipo de identificación" data-allow-clear="true" data-hide-search="true"
            name="tipo_identificacion" required>
            <option value=""></option>
            @foreach ($tipo_documentos as $item)
                <option value="{{ $item?->codigo }}"
                    {{ $item?->codigo == $cliente?->tipo_identificacion ? 'selected' : '' }}>
                    {{ $item?->nombre ?? 'N/A' }}
                </option>
            @endforeach
        </select>
    </div>
    <div class="mb-3">
        <label class="form-label">Identificación</label>
        <input type="text" class="form-control" value="{{ $cliente?->identificacion ?? '' }}"
            placeholder="Ingrese el numero de identificación" name="identificacion" required>
    </div>
    <div class="mb-3">
        <label class="form-label">Teléfono</label>
        <input type="tel" class="form-control" id="telefonoEditar"
            value="+{{ $cliente?->telefono ?? '' }}" name="telefono" required>
    </div>
    <div class="mb-3">
        <label class="form-label">Email</label>
        <input type="email" class="form-control" name="email" required placeholder="Ingrese el email"
            value="{{ $cliente?->email ?? '' }}">
    </div>
    <div class="mb-3">
        <label class="form-label">Dirección</label>
        <textarea class="form-control" name="direccion" rows="2" placeholder="Ingrese la dirección">{{ $cliente?->direccion ?? '' }}</textarea>
    </div>
    <div class="mb-3">
        <div class="form-check form-switch form-check-custom form-check-solid">
            <input class="form-check-input" type="checkbox" {{ $cliente?->estado == 1 ? 'checked' : '' }} value="1" name="estado" id="checkEstado"/>
            <label class="form-check-label" for="checkEstado">
                Estado {{ $cliente?->estado == 1 ? 'Activo' : 'Inactivo' }}
            </label>
        </div>
    </div>
</div>
