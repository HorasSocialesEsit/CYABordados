@extends('layouts.app')

@section('title', 'Lista de Clientes')

@section('contenido')
    <div class="container py-4">
        <div class="d-flex justify-content-between align-items-center mb-4">
            <h3 class="fw-bold text-primary mb-0">Lista de Clientes</h3>
            <a href="{{ route('clientes.create') }}" class="btn btn-success">
                <i class="bi bi-person-plus"></i> Nuevo Cliente
            </a>
        </div>

        <!-- Mensajes de éxito o error -->
        @if (session('success'))
            <div class="alert alert-success alert-dismissible fade show">
                {{ session('success') }}
                <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
            </div>
        @endif

        @if (session('error'))
            <div class="alert alert-danger alert-dismissible fade show">
                {{ session('error') }}
                <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
            </div>
        @endif

        <div class="card shadow-sm">
            <div class="card-body p-0">
                <div class="table-responsive">
                    <table class="table table-hover align-middle mb-0">
                        <thead class="table-light">
                            <tr>
                                <th>#</th>
                                <th>Código</th>
                                <th>Nombre</th>
                                <th>Correo</th>
                                <th>Teléfono</th>
                                <th>Tipo</th>
                                <th>Estado</th>
                                <th class="text-center">Acciones</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($clientes as $cliente)
                                <tr>
                                    <td>{{ $loop->iteration }}</td>
                                    <td><span class="badge bg-primary">{{ $cliente->codigo }}</span></td>
                                    <td>{{ $cliente->nombre }}</td>
                                    <td>{{ $cliente->correo }}</td>
                                    <td>{{ $cliente->telefono ?? '-' }}</td>
                                    <td>{{ $cliente->tipo_cliente }}</td>
                                    <td>
                                        <span
                                            class="badge {{ $cliente->estado == 'Activo' ? 'bg-success' : 'bg-secondary' }}">
                                            {{ $cliente->estado }}
                                        </span>
                                    </td>
                                    <td class="text-center">
                                        <a href="{{ route('clientes.edit', $cliente->id) }}"
                                            class="btn btn-sm btn-outline-primary">
                                            <i class="bi bi-pencil-square"></i>
                                        </a>

                                        <form action="{{ route('clientes.destroy', $cliente->id) }}" method="POST"
                                            class="d-inline"
                                            onsubmit="return confirm('¿Seguro que deseas eliminar este cliente?');">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="btn btn-sm btn-outline-danger">
                                                <i class="bi bi-trash"></i>
                                            </button>
                                        </form>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="8" class="text-center py-4 text-muted">
                                        <i class="bi bi-people fs-3"></i><br>
                                        No hay clientes registrados aún.
                                    </td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
@endsection
