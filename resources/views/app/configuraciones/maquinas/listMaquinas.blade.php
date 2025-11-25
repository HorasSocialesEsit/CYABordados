@extends('layouts.app')

@section('title', 'Maquinas')

@section('contenido')
    <div class="container-fluid">

        <h1 class="h3 mb-2 text-gray-800">Maquinas en establecimiento</h1>
        <p class="mb-4">La tabla mostrará los detalles de las maquinas</p>

        <div class="card shadow mb-4">
            <div class="card-header py-3 d-flex justify-content-between align-items-center">
                <h6 class="m-0 font-weight-bold text-primary">Maquinas</h6>
                <div class="card-header py-3 d-flex justify-content-between align-items-center" style="gap: .3rem;">
                    <a href="{{ route('maquinas.create') }}" class="btn btn-success">
                        <i class="fa-solid fa-material-plus"></i> Nueva Maquina
                    </a>

                </div>
            </div>
            <div class="card-body">
                <div class="table-responsive">
                    <table class="table table-hover align-middle" id="dataTable" width="100%" cellspacing="0">
                        <thead class="table-light">
                            <tr>
                                <th>ID</th>
                                <th>Nombre</th>
                                <th>Cabezales</th>
                                <th>Cabezales Dañados</th>
                                <th>RPM</th>
                                <th class="text-center">Acciones</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($maquinas as $maquina)
                                <tr>
                                    <td>{{ $maquina->id }}</td>
                                    <td>{{ $maquina->nombre }}</td>
                                    <td>{{ $maquina->cabezales }}</td>
                                    <td>{{ $maquina->cabezales_danado }}</td>
                                    <td>{{ $maquina->rpm }}</td>


                                    <td class="text-center">
                                        <a href="{{ route('maquinas.edit', $maquina->id) }}"
                                            class="btn btn-warning btn-sm me-1">
                                            <i class="fa-solid fa-pencil"></i>
                                        </a>

                                        {{-- @if (!$material->hasRole('admin')) --}}
                                        <form action="{{ route('maquinas.destroy', $maquina->id) }}" method="POST"
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
