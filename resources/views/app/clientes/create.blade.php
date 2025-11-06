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
                    <input type="text" name="nombre" class="form-control" required value="{{ old('nombre') }}">
                </div>

                <div class="col-md-6">
                    <label class="form-label">Correo electrónico</label>
                    <input type="email" name="correo" class="form-control" required value="{{ old('correo') }}">
                </div>

                <div class="col-md-4">
                    <label class="form-label">Teléfono principal</label>
                    <input type="text" name="telefono" class="form-control" value="{{ old('telefono') }}">
                </div>

                <div class="col-md-4">
                    <label class="form-label">Teléfono alternativo</label>
                    <input type="text" name="telefono_alt" class="form-control" value="{{ old('telefono_alt') }}">
                </div>

                <div class="col-md-4">
                    <label class="form-label">Tipo de cliente</label>
                    <select name="tipo_cliente" class="form-select" required>
                        <option value="Persona" {{ old('tipo_cliente') == 'Persona' ? 'selected' : '' }}>Persona</option>
                        <option value="Empresa" {{ old('tipo_cliente') == 'Empresa' ? 'selected' : '' }}>Empresa</option>
                    </select>
                </div>

                <!-- Dirección -->
                <div class="col-md-12">
                    <label class="form-label">Dirección</label>
                    <input type="text" name="direccion" class="form-control" value="{{ old('direccion') }}">
                </div>

                <div class="col-md-4">
                    <label class="form-label">Municipio</label>
                    <input type="text" name="municipio" class="form-control" value="{{ old('municipio') }}">
                </div>

                <div class="col-md-4">
                    <label class="form-label">Departamento</label>
                    <input type="text" name="departamento" class="form-control" value="{{ old('departamento') }}">
                </div>

                <div class="col-md-4">
                    <label class="form-label">País</label>
                    <input type="text" name="pais" class="form-control" value="{{ old('pais', 'El Salvador') }}">
                </div>

                <!-- Datos fiscales -->
                <div class="col-12 mt-3">
                    <h5 class="fw-semibold text-secondary">Datos Fiscales</h5>
                    <hr>
                </div>

                <div class="col-md-4">
                    <label class="form-label">NIT</label>
                    <input type="text" name="nit" class="form-control" value="{{ old('nit') }}">
                </div>

                <div class="col-md-4">
                    <label class="form-label">DUI</label>
                    <input type="text" name="dui" class="form-control" value="{{ old('dui') }}">
                </div>

                <div class="col-md-4">
                    <label class="form-label">NRC</label>
                    <input type="text" name="nrc" class="form-control" value="{{ old('nrc') }}">
                </div>
            </div>

            <div class="mt-4 d-flex justify-content-end">
                <a href="{{ route('clientes.index') }}" class="btn btn-secondary me-2">Cancelar</a>
                <button type="submit" class="btn btn-primary">Guardar Cliente</button>
            </div>
        </form>
    </div>
@endsection
