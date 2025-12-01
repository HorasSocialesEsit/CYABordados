@extends('layouts.app')

@section('title', 'Reabastecimiento de Stock')

@section('contenido')
    <div class="container-fluid">

        <h1 class="h3 mb-2 text-gray-800">Reabastecer Hilo</h1>
        <p class="mb-4">La tabla mostrará los hilos con stock menores a 21 unidades</p>

        <div class="card shadow mb-4">

            <div class="card-body">

                <form action="{{ route('inventario.reabastecimiento') }}" method="POST">
                    @csrf
                    <div class="table-responsive">
                        <table class="table table-hover align-middle" id="dataTable" width="100%" cellspacing="0">
                            <thead class="table-light">
                                <tr>
                                    <th>Nombre</th>
                                    <th>Codigo</th>
                                    <th>Stock</th>
                                    <th>Comprar (cantidad)</th>
                                    <th class="text-center">Accion</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($inventario as $material)
                                    <tr>
                                        <td>{{ $material->nombre }}</td>
                                        <td>{{ $material->codigo }}</td>
                                        <td>{{ $material->stock }}</td>
                                        <td>
                                            <input type="text" name="hilos_reabastecer[{{ $material->id }}]"
                                                class="form-control">
                                        </td>
                                        <td class="text-center">
                                            <input type="checkbox" name="seleccionados[]" value="{{ $material->id }}">
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>


                    <div class="mt-3 text-end">
                          <a href="{{ route('inventario.index') }}" class="btn btn-secondary me-2">Cancelar</a>
                        <button type="submit" class="btn btn-primary" id="btnEnviar" disabled>
                            Procesar Reabastecimiento
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