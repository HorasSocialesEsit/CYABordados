@extends('layouts.app')

@section('title', 'Producción - Ordenes en Proceso')

@section('contenido')
    <div class="container-fluid">

        <h1 class="h3 mb-2 text-gray-800">Estado: Ordenes en Proceso</h1>

        <div class="card shadow mb-4">
            <div class="card-header py-3 d-flex justify-content-between align-items-center">
                <h6 class="m-0 font-weight-bold text-primary">Ordenes para proceso</h6>
                <button class="btn btn-primary">Reportar Hilo Terminado</button>
            </div>
            <div class="card-body">
                <div class="table-responsive">
                    <table class="table table-hover align-middle" id="dataTable" width="100%" cellspacing="0">
                        <thead class="table-light">
                            <tr>
                                <td>maquinas</td>
                                <th>Orden</th>

                                <th>Fecha de Entrega</th>

                                <th>Arte</th>
                                <th>Tiempo para producir en minutos </th>
                                <th>Tiempo restante en minutos </th>
                                <th>Ingresar Cantidad produccion</th>
                                <th>Acciones</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($ordenes as $orden)
                                <tr>
                                    <td>01</td>
                                    <td>{{ $orden->codigo_orden }}</td>


                                    <td>{{ $orden->fecha_entrega->format('d/m/Y') }}</td>

                                    <td>{{ $orden->detalles->first()->nombre_arte ?? '-' }}</td>
                                    <td>145</td>
                                    <td>100</td>
                                    <td><input type="number" name="cantidad_produccion" id="cantidad_produccion"></td>

                                    <td>

                                        <a href="{{ route('ordenProceso.edit', $orden->id) }}"
                                            class="btn btn-primary btn-sm">Ingresar</a>
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
