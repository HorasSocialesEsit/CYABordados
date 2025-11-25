<form action="{{ route('clientes.store') }}" method="POST">
    @csrf

    <input type="hidden" name="OrigenCrearOrdenes" value="ordenesCrearOrden">

    <div class="row g-3">

        <div class="col-md-6">
            <label class="form-label">Nombre completo o empresa</label>
            <input type="text" name="nombre" class="form-control" required>
        </div>

        <div class="col-md-6">
            <label class="form-label">Correo electrónico</label>
            <input type="email" name="correo" class="form-control" required>
        </div>

        <div class="col-md-4">
            <label class="form-label">Teléfono</label>
            <input type="text" name="telefono" class="form-control">
        </div>

        <div class="col-md-4">
            <label class="form-label">Teléfono alternativo</label>
            <input type="text" name="telefono_alt" class="form-control">
        </div>

        <div class="col-md-4">
            <label class="form-label">Tipo de cliente</label>
            <select name="tipo_cliente_id" class="form-select" required>
                <option value="">Seleccione tipo</option>
                @foreach ($tipoclientes as $tipo)
                    <option value="{{ $tipo->id }}">{{ $tipo->nombre_tipo_cliente }}</option>)
                @endforeach


            </select>
        </div>

        <div class="col-md-12">
            <label class="form-label">Dirección</label>
            <input type="text" name="direccion" class="form-control">
        </div>

        <div class="col-md-4">
            <label class="form-label">Departamento</label>
            <select name="id_departamento" id="modal_departamento" class="form-select" required>
                <option value="">Seleccione un departamento</option>
                @foreach ($departamentos as $dep)
                    <option value="{{ $dep->id }}">{{ $dep->nombre_departamento }}</option>
                @endforeach
            </select>
        </div>

        <div class="col-md-4">
            <label class="form-label">Municipio</label>
            <select name="id_municipio" id="modal_municipio" class="form-select" required disabled>
                <option value="">Seleccione un municipio</option>
            </select>
        </div>

        <div class="col-md-4">
            <label class="form-label">País</label>
            <input type="text" name="pais" class="form-control" value="El Salvador">
        </div>

        <div class="col-md-4">
            <label class="form-label">NIT</label>
            <input type="text" name="nit" class="form-control">
        </div>

        <div class="col-md-4">
            <label class="form-label">DUI</label>
            <input type="text" name="dui" class="form-control">
        </div>

        <div class="col-md-4">
            <label class="form-label">NRC</label>
            <input type="text" name="nrc" class="form-control">
        </div>

    </div>

    <div class="mt-4 text-end">
        <button class="btn btn-primary" type="submit">Guardar Cliente</button>
    </div>
</form>
