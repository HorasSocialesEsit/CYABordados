@extends('layouts.app')

@section('title', 'Producción - Ordenes con Arte Aprobado')

@section('contenido')
    <div class="container-fluid">

        <h1 class="h3 mb-2 text-dark-800">Estado: Artes Aprobados</h1>

        <div class="card shadow mb-4">
            <div class="card-header py-3 d-flex justify-content-between align-items-center">
                <h6 class="m-0 font-weight-bold text-primary">Listos para iniciar</h6>
            </div>
            <div class="card-body">

                <div class="table-responsive">
                    <table class="table table-hover align-middle" id="dataTable" width="100%" cellspacing="0">
                        <thead class="table-light">
                            <tr>
                                <th>Maquina</th>
                                <th>Orden</th>

                                <th>Fecha Entrega</th>
                                <th>puntadas</th>
                                <th>Tiempos</th>
                                <th>Arte</th>
                                <th>Acciones</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($ordenes as $calculo)
                                <tr>
                                    <td>{{ $calculo->maquina->nombre ?? 'sin asignar' }}</td>
                                    <td>{{ $calculo->orden->codigo_orden }}</td>

                                    <td>{{ $calculo->orden->fecha_entrega->format('d-m-y') }}</td>

                                    <td>{{ $calculo->puntadas }}</td>
                                    <td>{{ $calculo->tiempo_ciclo }}</td>
                                    <td>
                                        @if ($calculo->ruta_arte)
                                            @if (Str::startsWith($calculo->ruta_arte, 'arte/'))
                                                {{-- Imagen subida (en storage/app/public/arte) --}}
                                                <img src="{{ asset('storage/' . $calculo->ruta_arte) }}" class="img-fluid"
                                                    style="max-width: 100px; max-height: 100px;">
                                            @else
                                                {{-- Imagen por defecto (public/img/admin/) --}}
                                                <img src="{{ asset($calculo->ruta_arte) }}" class="img-fluid"
                                                    style="max-width: 100px; max-height: 100px;">
                                            @endif
                                        @endif

                                    <td>
                                        <form action="{{ route('ordenProceso.inicio', $calculo->orden->id) }}"
                                            method="POST" style="display:inline;">
                                            @csrf
                                            @method('PUT')

                                            <button type="submit" class="btn btn-success btn-sm">Iniciar</button>
                                        </form>

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
