@extends('layouts.app')

@section('title', 'Inventario de Hilo')

@section('contenido')
    <div class="container-fluid">

        <h1 class="h3 mb-2 text-gray-800">Inventario de hilos</h1>
        <p class="mb-4">La tabla mostrará los detalles de los hilos</p>

        <div class="card shadow mb-4">
            <div class="card-header py-3 d-flex justify-content-between align-items-center">
                <h6 class="m-0 font-weight-bold text-primary">Usuarios</h6>
                <div class="card-header py-3 d-flex justify-content-between align-items-center" style="gap: .3rem;">
                    <a href="{{ route('inventario.create') }}" class="btn btn-success">
                        <i class="fa-solid fa-material-plus"></i> Nuevo Hilo
                    </a>
                    <a href="{{ route('inventario.reporte') }}" class="btn btn-success" target="_blank">
                        <i class="fa-solid fa-material-plus"></i> Reporte
                    </a>
                </div>
            </div>
            <div class="card-body">
                <div class="table-responsive">
                    <table class="table table-hover align-middle" id="dataTable" width="100%" cellspacing="0">
                        <thead class="table-light">
                            <tr>
                                <th>Nombre</th>
                                <th>Codigo</th>
                                <th>Descripcion</th>
                                <th>Stock</th>
                                <th>Tipo Hilo</th>
                                <th>Estado</th>
                                <th class="text-center">Acciones</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($inventario as $material)
                                <tr>
                                    <td>{{ $material->nombre }}</td>
                                    <td>{{ $material->codigo }}</td>
                                    <td>{{ $material->descripcion }}</td>
                                    <td>{{ $material->stock }}</td>
                                    <td>{{ $material->tipoHilo }}</td>
                                    <td>
                                        @php
                                            $badgeClass = 'bg-success';
                                            $mensaje = 'Disponible';

                                            if ($material->stock <= 0) {
                                                $badgeClass = 'bg-danger';
                                                $mensaje = 'Agotado';
                                            } elseif ($material->stock < 5) {
                                                $badgeClass = 'bg-warning text-dark';
                                                $mensaje = 'Insuficiente';
                                            }
                                        @endphp

                                        <span class="badge {{ $badgeClass }} text-white">
                                            {{ $mensaje }}
                                        </span>
                                    </td>

                                    <td class="text-center">
                                        <a href="{{ route('inventario.edit', $material->id) }}"
                                            class="btn btn-warning btn-sm me-1">
                                            <i class="fa-solid fa-pencil"></i>
                                        </a>

                                        {{-- @if (!$material->hasRole('admin')) --}}
                                        <form action="{{ route('inventario.destroy', $material->id) }}" method="POST"
                                            class="d-inline delete-material-form">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="btn btn-danger btn-sm">
                                                <i class="fa-solid fa-trash"></i>
                                            </button>
                                        </form>
                                        {{-- @endif --}}
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>

    </div>
@endsection

@section('scripts')
    <script>
        // DataTables
        $(document).ready(function () {
            $('#dataTable').DataTable({
                "pageLength": 6,
                "lengthMenu": [5, 10, 25, 50],
                "language": {
                    "url": "//cdn.datatables.net/plug-ins/1.13.6/i18n/es-ES.json"
                }
            });
        });

        // SweetAlert2 - Confirmación de eliminación
        document.addEventListener('DOMContentLoaded', function () {
            document.querySelectorAll('.delete-material-form').forEach(form => {
                form.addEventListener('submit', function (e) {
                    e.preventDefault();
                    Swal.fire({
                        title: '¿Estás seguro?',
                        text: "¡Esta acción no se puede deshacer!",
                        icon: 'warning',
                        showCancelButton: true,
                        confirmButtonColor: '#d33',
                        cancelButtonColor: '#3085d6',
                        confirmButtonText: 'Sí, eliminar',
                        cancelButtonText: 'Cancelar'
                    }).then((result) => {
                        if (result.isConfirmed) {
                            form.submit();
                        }
                    })
                });
            });
        });

        // SweetAlert2 - Mensajes de éxito y error
        @if (session('success'))
            Swal.fire({
                icon: 'success',
                title: '¡Éxito!',
                text: '{{ session('success') }}',
                showConfirmButton: false,
                timer: 2000
            });
        @endif
        @if (session('error'))
            Swal.fire({
                icon: 'warning',
                title: 'Error!',
                text: '{{ session('error') }}',
                showConfirmButton: false,
                timer: 2000
            });
        @endif

        @if ($errors->any())
            Swal.fire({
                icon: 'error',
                title: 'Oops...',
                html: `@foreach ($errors->all() as $error)
                    <div>{{ $error }}</div>
                @endforeach`,
            });
        @endif
    </script>
@endsection