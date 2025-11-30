@extends('layouts.app')

@section('title', 'Hilos de Orden')

@section('contenido')
    <div class="container-fluid">

        <h1 class="h3 mb-2 text-gray-800">Hilos de Orden</h1>
        <p class="mb-4">La tabla mostrará los hilos ocupados en la orden</p>

        <div class="card shadow mb-4">

            <div class="card-body">

                <form action="{{ route('inventario.ordenStockDescuento') }}" method="POST">
                    @csrf

                    <input type="text" hidden name="orden_id" value="{{ $id }}">
                    <div class="table-responsive">
                        <table class="table table-hover align-middle" id="dataTable" width="100%" cellspacing="0">
                            <thead class="table-light">
                                <tr>
                                    <th>Nombre</th>
                                    <th>Codigo</th>
                                    <th>Stock</th>
                                    <th>Hilos Finalizados</th>
                                    <th class="text-center">Accion</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($inventario as $material)
                                    <tr>
                                        <td>{{ $material->nombre }}</td>
                                        <td>{{ $material->codigo }}</td>
                                        <td>{{ $material->stock }}</td>

                                        {{-- Input text con ID dinámico --}}
                                        <td>
                                            <input type="text" name="hilos_finalizados[{{ $material->id }}]"
                                                class="form-control">
                                        </td>

                                        {{-- Checkbox con valor del ID --}}
                                        <td class="text-center">
                                            <input type="checkbox" name="seleccionados[]" value="{{ $material->id }}">
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>


                    <div class="mt-3 text-end">
                          <a href="{{ route('ordenProceso.index') }}" class="btn btn-secondary me-2">Cancelar</a>
                        <button type="submit" class="btn btn-primary" id="btnEnviar" disabled>
                            Procesar Descuento
                        </button>

                    </div>

                </form>

            </div>
        </div>

    </div>
@endsection

<script>
    // validamos de que se seleccione un checkbox
    document.addEventListener('DOMContentLoaded', function () {
        const checkboxes = document.querySelectorAll('input[name="seleccionados[]"]');
        const boton = document.getElementById('btnEnviar');

        function verificarSeleccion() {
            const algunoMarcado = Array.from(checkboxes).some(cb => cb.checked);
            boton.disabled = !algunoMarcado;
        }

        checkboxes.forEach(cb => cb.addEventListener('change', verificarSeleccion));
    });
</script>


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
                text: '{{ session(key: 'error') }}',
                showConfirmButton: true,
                timer: 4000
            });
        @endif

    </script>
@endsection