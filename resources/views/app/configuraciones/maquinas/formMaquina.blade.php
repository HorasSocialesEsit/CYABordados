<form action="{{ isset($maquina) ? route('maquinas.update', $maquina->id) : route('maquinas.store') }}" method="POST"
    enctype="multipart/form-data">
    @csrf
    @if (isset($maquina))
        @method('PUT')
    @endif

    <div class="row">
        <div class="col-md-6 mb-3">
            <label for="nombre" class="form-label">Nombre</label>
            <input type="text" name="nombre" id="nombre" class="form-control @error('nombre') is-invalid @enderror"
                value="{{ old('nombre', $maquina->nombre ?? '') }}" required>
            @error('nombre')
                <div class="invalid-feedback">{{ $message }}</div>
            @enderror
        </div>

        <div class="col-md-6 mb-3">
            <label for="rpm" class="form-label">RPM</label>
            <input type="text" name="rpm" id="rpm" class="form-control @error('rpm') is-invalid @enderror"
                value="{{ old('rpm', default: $maquina->rpm ?? '') }}" required>
            @error('rpm')
                <div class="invalid-feedback">{{ $message }}</div>
            @enderror
        </div>
        <div class="col-md-6 mb-3">
            <label for="cabezales" class="form-label">Cabezales</label>
            <input type="text" name="cabezales" id="cabezales"
                class="form-control @error('cabezales') is-invalid @enderror"
                value="{{ old('cabezales', default: $maquina->cabezales ?? '') }}" required>
            @error('cabezales')
                <div class="invalid-feedback">{{ $message }}</div>
            @enderror
        </div>
        <div class="col-md-6 mb-3">
            <label for="cabezales_danado" class="form-label">Cabezales Dañados</label>
            <input type="text" name="cabezales_danado" id="cabezales_danado"
                class="form-control @error('cabezales_danado') is-invalid @enderror"
                value="{{ old('cabezales_danado', default: $maquina->cabezales_danado ?? '') }}" required>
            @error('cabezales_danado')
                <div class="invalid-feedback">{{ $message }}</div>
            @enderror
        </div>

    </div>


    <div class="d-flex justify-content-end mt-4" style="gap: 1rem;">
        <a href="{{ route('maquinas.index') }}" class="btn btn-secondary me-2">Cancelar</a>
        <button type="submit" class="btn btn-primary">
            {{ isset($maquina) ? 'Actualizar Maquina' : 'Crear Maquina' }}
        </button>
    </div>
</form>