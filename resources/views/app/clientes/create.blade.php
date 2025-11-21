@extends('layouts.app')

@section('title', 'Registrar Cliente')

@section('contenido')
    <div class="container py-4">
        <h3 class="mb-4 text-primary fw-bold">Registrar Nuevo Cliente</h3>

        <form action="{{ route('clientes.store') }}" method="POST">
            @csrf

            <div class="row g-3">

                <!-- Datos principales -->
                <div class="col-md-6">
                    <label class="form-label">Nombre completo o empresa</label>
                    <input type="text" name="nombre" class="form-control @error('nombre') is-invalid @enderror"
                        value="{{ old('nombre') }}" required>
                    @error('nombre')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <div class="col-md-6">
                    <label class="form-label">Correo electrónico</label>
                    <input type="email" name="correo" class="form-control @error('correo') is-invalid @enderror"
                        value="{{ old('correo') }}" required>
                    @error('correo')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <div class="col-md-4">
                    <label class="form-label">Teléfono principal</label>
                    <input type="text" name="telefono" class="form-control @error('telefono') is-invalid @enderror"
                        value="{{ old('telefono') }}">
                    @error('telefono')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <div class="col-md-4">
                    <label class="form-label">Teléfono alternativo</label>
                    <input type="text" name="telefono_alt" class="form-control @error('telefono_alt') is-invalid @enderror"
                        value="{{ old('telefono_alt') }}">
                    @error('telefono_alt')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <div class="col-md-4">
                    <label class="form-label">Tipo de cliente</label>
                    <select name="tipo_cliente" class="form-select @error('tipo_cliente') is-invalid @enderror" required>
                        <option value="">Seleccione tipo</option>
                        @foreach ($tipos_cliente as $tipo)
                            <option value="{{ $tipo->id }}"> {{ $tipo->nombre_tipo_cliente }}</option>
                        @endforeach
                    </select>
                    @error('tipo_cliente')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <!-- Dirección -->
                <div class="col-md-12">
                    <label class="form-label">Dirección</label>
                    <input type="text" name="direccion" class="form-control @error('direccion') is-invalid @enderror"
                        value="{{ old('direccion') }}">
                    @error('direccion')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <div class="col-md-4">
                    <label class="form-label">Departamento</label>
                    <select name="id_departamento" id="departamento"
                        class="form-select @error('id_departamento') is-invalid @enderror" required>
                        <option value="">Seleccione un departamento</option>
                        @foreach ($departamentos as $dep)
                            <option value="{{ $dep->id }}" {{ old('id_departamento') == $dep->id ? 'selected' : '' }}>
                                {{ $dep->nombre_departamento }}
                            </option>
                        @endforeach
                    </select>
                    @error('id_departamento')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <div class="col-md-4">
                    <label class="form-label">Municipio</label>
                    <select name="id_municipio" id="municipio"
                        class="form-select @error('id_municipio') is-invalid @enderror" required {{ old('id_departamento') ? '' : 'disabled' }}>
                        <option value="">Seleccione un municipio</option>
                    </select>
                    @error('id_municipio')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <div class="col-md-4">
                    <label class="form-label">País</label>
                    <input type="text" name="pais" class="form-control @error('pais') is-invalid @enderror"
                        value="{{ old('pais', 'El Salvador') }}">
                    @error('pais')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <!-- Datos fiscales -->
                <div class="col-12 mt-3">
                    <h5 class="fw-semibold text-secondary">Datos Fiscales</h5>
                    <hr>
                </div>

                <div class="col-md-4">
                    <label class="form-label">NIT</label>
                    <input type="text" name="nit" class="form-control @error('nit') is-invalid @enderror"
                        value="{{ old('nit') }}">
                    @error('nit')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <div class="col-md-4">
                    <label class="form-label">DUI</label>
                    <input type="text" name="dui" class="form-control @error('dui') is-invalid @enderror"
                        value="{{ old('dui') }}">
                    @error('dui')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <div class="col-md-4">
                    <label class="form-label">NRC</label>
                    <input type="text" name="nrc" class="form-control @error('nrc') is-invalid @enderror"
                        value="{{ old('nrc') }}">
                    @error('nrc')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

            </div>

            <div class="mt-4 d-flex justify-content-end">
                <a href="{{ route('clientes.index') }}" class="btn btn-secondary me-2">Cancelar</a>
                <button type="submit" class="btn btn-primary">Guardar Cliente</button>
            </div>
        </form>
    </div>
@endsection

<script>
    document.addEventListener('DOMContentLoaded', function () {
        // recuperamos los select de departamento y municipio
        const departamentoSelect = document.getElementById('departamento');
        const municipioSelect = document.getElementById('municipio');

        // por cada departamento seleccionado buscamos sus municipio
        departamentoSelect.addEventListener('change', function () {
            const idDepartamento = this.value;

            municipioSelect.innerHTML = '<option value="">Cargando...</option>';
            municipioSelect.disabled = true;

            if (!idDepartamento) {
                municipioSelect.innerHTML = '<option value="">Seleccione un municipio</option>';
                return;
            }

            // hacemos la petición para obtener los municipios del departamento
            fetch(`/municipios/${idDepartamento}`)
                .then(response => response.json())
                .then(data => {

                    // mostramos los muncipios obtenidos
                    municipioSelect.innerHTML = '<option value="">Seleccione un municipio</option>';

                    data.forEach(municipio => {
                        const option = document.createElement('option');
                        option.value = municipio.id;
                        option.textContent = municipio.nombre_municipio;
                        municipioSelect.appendChild(option);
                    });

                    municipioSelect.disabled = false;
                })
                .catch(() => {
                    // mostramos un error si no se pudieron cargar
                    municipioSelect.innerHTML = '<option value="">Error al cargar</option>';
                });
        });
    });
</script>