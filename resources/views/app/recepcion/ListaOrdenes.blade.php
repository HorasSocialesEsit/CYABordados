@extends('layouts.app')

@section('title', 'CYABordados Admin Ordenes')

@section('contenido')
    <div class="container-fluid">

        <h1 class="h3 mb-2 text-gray-800">Administración de Ordenes</h1>

        <div class="card shadow mb-4">
            <div class="card-header py-3 d-flex justify-content-between align-items-center">
                <h6 class="m-0 font-weight-bold text-primary">Detalle de Ordenes</h6>
            </div>


            <div class="card-header py-3 d-flex justify-content-between align-items-center" style="gap: .3rem;">
                <a href="{{ route('ordenes.create') }}" class="btn btn-success">
                    <i class="fa-solid fa-circle-plus"></i>Nueva Orden
                </a>

            </div>

            <div class="card-body">
                <div class="table-responsive">
                    <table class="table table-hover align-middle" id="dataTable" width="100%" cellspacing="0">
                        <thead class="table-light">
                            <tr>
                                <th>Orden</th>
                                <th>Estado</th>
                                <th>Precio</th>
                                <th>Fecha de Entrega</th>
                                <th>Entregar</th>
                                <th>Arte</th>
                                <th>Acciones</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($ordenes as $orden)
                                <tr>
                                    <td>{{ $orden->codigo_orden }}</td>
                                    <td>{{ $orden->estado->nombre_estado_orden }}</td>
                                    <td>${{ number_format($orden->precio_total, 2) }}</td>
                                    <td>{{ $orden->fecha_entrega->format('d/m/Y') }}</td>
                                    <td> {{ $orden->dias_atraso }} días</td>
                                    <td>{{ $orden->detalles->first()->nombre_arte ?? '-' }}</td>

                                    <td>
                                        <a href="{{ route('produccion.arte.edit', $orden->id) }}"
                                            class="btn btn-success btn-sm">
                                            <i class="fa-solid fa-play"></i>
                                            Iniciar Diseño</a>

                                        <a href="{{ route('ordenes.edit', $orden->id) }}"
                                            class="btn btn-secondary btn-sm"><i class="fa-regular fa-pen-to-square"></i></a>
                                        <a href="{{ route('ordenes.reporteOrden', $orden->id) }}" target="_blank"
                                            class="btn btn-warning btn-sm"><i class="fa-solid fa-print"></i></a>
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
        $(document).ready(function() {
            // Inicializar DataTables
            $('#dataTable').DataTable({
                'ordering': false, // falso para que respete el orden del servidor
                "pageLength": 10,
                "lengthMenu": [20, 50, 20, 10, 10, 30],
                "language": {
                    "url": "//cdn.datatables.net/plug-ins/1.13.6/i18n/es-ES.json"
                }
            });
        });

        // Mensajes SweetAlert2
        document.addEventListener('DOMContentLoaded', function() {
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
                    icon: 'error',
                    title: 'Oops...',
                    text: '{{ session('error') }}'
                });
            @endif
        });
    </script>
@endsection
