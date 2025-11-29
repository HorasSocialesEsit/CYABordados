@extends('layouts.app')

@section('title', 'Producción - Ordenes Nuevas')

@section('contenido')
    <div class="container-fluid">

        <h1 class="h3 mb-2 text-gray-800">Ordenes pendientes de Arte</h1>

        <div class="card shadow mb-4">

            <div class="card-body">
                <div class="table-responsive">
                    <table class="table table-hover align-middle" id="dataTable" width="100%" cellspacing="0">
                        <thead class="table-light">
                            <tr>
                                <th>Orden</th>
                                <th>Cliente</th>
                                <th>Fecha de Entrega</th>
                                <th>Arte</th>
                                <th>Acciones</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($ordenes as $orden)
                                <tr>
                                    <td>{{ $orden->codigo_orden }}</td>

                                    <th>{{ $orden->cliente->nombre }}</th>
                                    <td>{{ $orden->fecha_entrega->format('d/m/Y') }}</td>

                                    <td>{{ $orden->detalles->first()->nombre_arte ?? '-' }}</td>

                                    <td>

                                        <a href="{{ route('produccion.arte.edit', $orden->id) }}"
                                            class="btn btn-warning btn-sm">

                                            Diseño en proceso</a>

                                        <a href="{{ route('ordenes.reporteOrdenDisehno', $orden->id) }}" target="_blank"
                                            class="btn btn-secondary btn-sm"><i class="fa-solid fa-print"></i></a>
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
                "order": [], //
                "pageLength": 10,
                lengthMenu: [
                    [10, 20, 50, -1],
                    [10, 20, 50, "Todos"]
                ],
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
