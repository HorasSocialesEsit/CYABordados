<form action="{{ isset($proveedor) ? route('proveedor.update', $proveedor->id) : route('proveedor.store') }}" method="POST"
    enctype="multipart/form-data">
    @csrf
    @if (isset($proveedor))
        @method('PUT')
    @endif

    <div class="row">
        <div class="col-md-6 mb-3">
            <label for="nombre" class="form-label">Nombre</label>
            <input type="text" name="nombre" id="nombre" class="form-control @error('nombre') is-invalid @enderror"
                value="{{ old('nombre', $proveedor->nombre ?? '') }}" required>
            @error('nombre')
                <div class="invalid-feedback">{{ $message }}</div>
            @enderror
        </div>

        <div class="col-md-6 mb-3">
            <label for="telefono" class="form-label">Telefono</label>
            <input type="text" name="telefono" id="telefono" class="form-control @error('telefono') is-invalid @enderror"
                value="{{ old('telefono', $proveedor->telefono ?? '') }}" required>
            @error('telefono')
                <div class="invalid-feedback">{{ $message }}</div>
            @enderror
        </div>
    </div>

    <div class="row">
        <div class="col-md-6 mb-3">
            <label for="email" class="form-label">email</label>
            <input type="email" name="email" id="email" class="form-control @error('email') is-invalid @enderror"
                value="{{ old('email', $proveedor->email ?? '') }}" required min="0">
            @error('email')
                <div class="invalid-feedback">{{ $message }}</div>
            @enderror
        </div>

    </div>

    <div class="d-flex justify-content-end mt-4" style="gap: 1rem;">
        <a href="{{ route('proveedor.index') }}" class="btn btn-secondary me-2">Cancelar</a>
        <button type="submit" class="btn btn-primary">
            {{ isset($proveedor) ? 'Actualizar' : 'Crear' }}
        </button>
    </div>
</form>