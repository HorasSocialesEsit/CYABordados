<form action="{{ isset($hilo) ? route('inventario.update', $hilo->id) : route('inventario.store') }}" method="POST"
    enctype="multipart/form-data">
    @csrf
    @if (isset($hilo))
        @method('PUT')
    @endif

    <div class="row">
        <div class="col-md-6 mb-3">
            <label for="nombre" class="form-label">Nombre</label>
            <input type="text" name="nombre" id="nombre" class="form-control @error('nombre') is-invalid @enderror"
                value="{{ old('nombre', $hilo->nombre ?? '') }}" required>
            @error('nombre')
                <div class="invalid-feedback">{{ $message }}</div>
            @enderror
        </div>

        <div class="col-md-6 mb-3">
            <label for="codigo" class="form-label">Código</label>
            <input type="text" name="codigo" id="codigo" class="form-control @error('codigo') is-invalid @enderror"
                value="{{ old('codigo', $hilo->codigo ?? '') }}" required>
            @error('codigo')
                <div class="invalid-feedback">{{ $message }}</div>
            @enderror
        </div>
    </div>

    <div class="row">
        <div class="col-md-6 mb-3">
            <label for="tipoHilo" class="form-label">Tipo de Hilo</label>
            <select name="tipoHilo" id="tipoHilo" class="form-control @error('tipoHilo') is-invalid @enderror" required>
                <option value="">Selecciona un tipo</option>
                @foreach ($tiposHilo as $tipo)
                    <option value="{{ $tipo }}" {{ old('tipoHilo', $hilo->tipoHilo ?? '') == $tipo ? 'selected' : '' }}>
                        {{ ucfirst($tipo) }}
                    </option>
                @endforeach
            </select>
            @error('tipoHilo')
                <div class="invalid-feedback">{{ $message }}</div>
            @enderror
        </div>
        <div class="col-md-6 mb-3">
            <label for="stock" class="form-label">Stock</label>
            <input type="number" name="stock" id="stock" class="form-control @error('stock') is-invalid @enderror"
                value="{{ old('stock', $hilo->stock ?? '') }}" required min="0">
            @error('stock')
                <div class="invalid-feedback">{{ $message }}</div>
            @enderror
        </div>

    </div>

    <div class="row">
        <div class="col-md-6 mb-3">
            <label for="descripcion" class="form-label">Descripción</label>
            <textarea name="descripcion" id="descripcion" rows="3"
                class="form-control @error('descripcion') is-invalid @enderror"
                required>{{ old('descripcion', $hilo->descripcion ?? '') }}</textarea>
            @error('descripcion')
                <div class="invalid-feedback">{{ $message }}</div>
            @enderror
        </div>
    </div>

    <div class="d-flex justify-content-end mt-4" style="gap: 1rem;">
        <a href="{{ route('inventario.index') }}" class="btn btn-secondary me-2">Cancelar</a>
        <button type="submit" class="btn btn-primary">
            {{ isset($hilo) ? 'Actualizar Hilo' : 'Crear Hilo' }}
        </button>
    </div>
</form>