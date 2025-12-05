@extends('layouts.app')

@section('title', 'Producción - Órdenes en Proceso')

@section('contenido')
    <div class="container-fluid">

        <!-- TÍTULO -->
        <div class="d-flex justify-content-between align-items-center mb-4">
            <h1 class="h3 text-gray-800">Órdenes en Proceso</h1>

            <button class="btn btn-primary shadow-sm">
                <i class="fas fa-exclamation-circle me-1"></i> Reportar Hilo Terminado
            </button>
        </div>

        <!-- CARD -->
        <div class="card shadow-sm border-0">
            <div class="card-header bg-light border-bottom d-flex justify-content-between align-items-center">
                <h6 class="m-0 fw-bold text-secondary">Listado de Órdenes en Producción</h6>
            </div>

            <div class="card-body">

                <!-- TABLA -->
                <div class="table-responsive">
                    <table class="table table-hover table-striped align-middle" id="dataTable">

                        <thead class="table-light">
                            <tr>
                                <th class="text-center">Máquina</th>
                                <th class="text-center">Orden</th>

                                {{-- <th class="text-center">Arte</th> --}}
                                <th class="text-center">Tiempo Total</th>
                                <th class="text-center">Hora/fecha Iniciado</th>
                                <th class="text-center">Hora/fecha finalizar</th>
                                <th class="text-center">Tiempo Restante</th>
                                <th class="text-center">Cantidad</th>
                                <th class="text-center">Restante</th>
                                <th class="text-center">Producción</th>
                                <th class="text-center">Acciones</th>
                            </tr>
                        </thead>

                        <tbody>
                            @foreach ($ordenes as $orden)
                                @php
                                    $detalle = $orden->detalles->first();
                                @endphp

                                <tr>
                                    <td class="text-center">
                                        {{ $orden->ordenCalculoArte->first()->maquina->nombre ?? 'Sin máquina' }}
                                    </td>

                                    <td class="text-center fw-bold">
                                        {{ $orden->codigo_orden }}
                                    </td>



                                    {{-- <td class="text-center">{{ $detalle->nombre_arte ?? '-' }}</td> --}}

                                    <td class="text-center">{{ ceil($orden->ordenCalculoArte->first()->tiempo_total_orden) }} min</td>
                                    <td class="text-center">{{ $orden->fecha_hora_inicio }} </td>
                                    <td class="text-center">{{ $orden->fecha_hora_fin }} </td>
                                   @php
                                       
                                        $inicio = \Carbon\Carbon::parse($orden->fecha_hora_inicio);
                                        $fin = \Carbon\Carbon::parse($orden->fecha_hora_fin);
                                        $actual = \Carbon\Carbon::now();
                                        $minutos_restantes = $actual->diffInMinutes($fin, false);
                                    @endphp

                                    <td class="text-center">{{ ceil($minutos_restantes) }} min</td>
                                    <td class="text-center">{{ $detalle->cantidad }} </td>
                                    <td class="text-center">{{ $detalle->cantidad-$orden->historial_sum_realizada }} </td>

                                    <!-- PRODUCCIÓN -->
                                    <td class="text-center">
                                        <form method="POST"
                                            action="{{ route('ordenProceso.produccionRealizadaOrden', [$orden->id, $detalle->cantidad,$orden->fecha_hora_inicio, $orden->fecha_hora_fin, $detalle->maquina_id]) }}">
                                            @csrf

                                            <div class="input-group input-group-sm">
                                                <input type="number" min="1" name="cantidad_produccion"
                                                    class="form-control" @if ($orden->estado_orden_id != 5) disabled @endif
                                                    required>

                                                @if ($orden->estado_orden_id == 5)
                                                    <button type="submit" class="btn btn-success">
                                                        Enviar
                                                    </button>
                                                @endif
                                            </div>
                                        </form>
                                    </td>

                                    <!-- ACCIONES -->
                                    <td class="text-center">
                                        <a href="{{ route('inventario.ordenStock', $orden->id) }}"
                                            class="btn btn-primary btn-sm">
                                            Control Hilos
                                        </a>
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

@section('styles')
    <style>
        /* Hover profesional */
        .table-hover tbody tr:hover {
            background-color: #eef3ff !important;
            transition: 0.2s ease-in-out;
            cursor: pointer;
        }
    </style>
@endsection

@section('scripts')
    <script>
        $(document).ready(function() {
            $('#dataTable').DataTable({
                pageLength: 10,
                language: {
                    url: "https://cdn.datatables.net/plug-ins/1.13.6/i18n/es-ES.json"
                }
            });
        });

        document.addEventListener('DOMContentLoaded', function() {
            console.log('{{ session('success') }}');
            console.log('{{ session('error') }}');

            @if (session('success'))
                Swal.fire({
                    icon: 'success',
                    title: 'Éxito',
                    text: '{{ session('success') }}',
                    showConfirmButton: true,
                    timer: 2000
                });
            @endif

            @if (session('error'))
                Swal.fire({
                    icon: 'error',
                    title: 'Error',
                    showConfirmButton: true,
                    text: '{{ session('error') }}'
                });
            @endif

        });
    </script>
@endsection
