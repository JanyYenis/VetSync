<input type="hidden" name="id" value="{{ $mascota?->id ?? '' }}">
<div class="modal-body">
    <div class="mb-3">
        <label class="form-label">Nombre</label>
        <input type="text" class="form-control" value="{{ $mascota?->nombre ?? '' }}" name="nombre" required
            placeholder="Ingrese el nombre de la mascota">
    </div>
    <div class="row">
        <div class="col-md-6 mb-3">
            <label class="form-label">Tipo</label>
            <select class="form-select" id="selectTipoEdit" name="tipo" required data-control="select2"
                data-placeholder="Seleccione el tipo de mascota" data-allow-clear="true" data-hide-search="true">
                <option value=""></option>
                @foreach ($tipos as $item)
                    <option value="{{ $item?->codigo }}" {{ $item?->codigo == $mascota?->tipo ? 'selected' : '' }}>
                        {{ $item?->nombre ?? 'N/A' }}
                    </option>
                @endforeach
            </select>
        </div>
        <div class="col-md-6 mb-3">
            <label class="form-label">Raza</label>
            <input type="text" class="form-control" name="raza" value="{{ $mascota?->raza ?? '' }}"
                placeholder="Ingrese la raza de la mascota" required>
        </div>
    </div>
    <div class="row">
        <div class="col-md-6 mb-3">
            <label class="form-label">Genero</label>
            <select class="form-select" id="selectGeneroMascotaEditar" name="genero" required data-control="select2"
                data-placeholder="Seleccione el genero de la mascota" data-allow-clear="true" data-hide-search="true">
                <option value=""></option>
                @foreach ($generos as $item)
                    <option value="{{ $item?->codigo }}" {{ $item?->codigo == $mascota?->genero ? 'selected' : '' }}>
                        {{ $item?->nombre ?? 'N/A' }}
                    </option>
                @endforeach
            </select>
        </div>
        <div class="col-md-6 mb-3">
            <label class="form-label">Color</label>
            <input type="text" class="form-control" value="{{ $mascota?->color ?? '' }}" name="color"
                placeholder="Ingrese el color de la mascota" required>
        </div>
    </div>
    <div class="row">
        <div class="col-md-6 mb-3">
            <label class="form-label">Edad (años)</label>
            <input type="number" class="form-control" value="{{ $mascota?->edad ?? '' }}" min="0" required name="edad"
                placeholder="Ingrese la edad de la mascota">
        </div>
        <div class="col-md-6 mb-3">
            <label class="form-label">Peso (kg)</label>
            <input type="number" class="form-control" value="{{ $mascota?->peso ?? '' }}" step="0.1" min="0" required
                name="peso" placeholder="Ingrese el peso de la mascota">
        </div>
    </div>
    <div class="mb-3">
        <label class="form-label">Propietario</label>
        <select class="form-select" id="selectPropietarioEditar" data-id="{{ $mascota?->cod_cliente }}"
            data-text="{{ $mascota?->propietario?->nombre }}" name="cod_cliente" required>
            <option value="">Seleccionar cliente...</option>
        </select>
    </div>
    <div class="mb-3">
        <div class="form-check form-switch form-check-custom form-check-solid">
            <input class="form-check-input" type="checkbox" {{ $mascota?->estado == 1 ? 'checked' : '' }} value="1" name="estado" id="checkEstado"/>
            <label class="form-check-label" for="checkEstado">
                Estado {{ $mascota?->estado == 1 ? 'Activo' : 'Inactivo' }}
            </label>
        </div>
    </div>
</div>
