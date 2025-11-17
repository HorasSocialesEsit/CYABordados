@extends('layouts.app')

@section('title', 'Administracion de materias')

@section('contenido')
    <div class="container-fluid">

        <!-- Page Heading -->
        <h1 class="h3 mb-2 text-gray-800">Administración Materias</h1>


        <!-- DataTales Example -->
        <div class="card shadow mb-4">
            <div class="card-header py-3 d-flex justify-content-between align-items-center">
                <a class="btn btn-success">Nueva Materia</a>

            </div>
            <div class="card-body">
                <div class="table-responsive">
                    <table class="table table-hover align-middle" id="dataTable" width="100%" cellspacing="0">
                        <thead class="table-light">
                            <tr>
                                <th>Materias</th>
                                <th>Acciones</th>
                                <th>RPM</th>


                            </tr>
                        </thead>
                       <tbody>
                            @foreach ($materias as $materia)
                                <tr>
                                    <td>{{ $materia->nombre }}</td>
                                    <td>
                                        <a class="btn btn-primary btn-sm">Editar</a>

                                    </td>

                                </tr>
                            @endforeach
                       </tbody>

                    </table>
                </div>
            </div>
        </div>

    </div>

@section('scripts')
    <script>
        $(document).ready(function() {
            $('#dataTable').DataTable({
                "pageLength": 15,
                "lengthMenu": [50],
                "language": {
                    "url": "//cdn.datatables.net/plug-ins/1.13.6/i18n/es-ES.json"
                }
            });
        });
    </script>
@endsection
@endsection
