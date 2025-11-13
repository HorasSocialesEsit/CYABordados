@extends('layouts.app')
@section('title', 'CYABordados Dashboard')
@section('contenido')
    <div class="container py-5">
        <!-- Page Heading -->
        <div class="d-sm-flex align-items-center justify-content-between mb-4">
            <h1 class="h3 mb-0 text-gray-800">Control de Ingreso</h1>
        </div>

        <div class="row">
            <!-- Alumnos Totales -->
            <div class="col-xl-3 col-md-6 mb-4">
                <div class="card border-left-primary shadow h-100 py-2">
                    <div class="card-body text-center">
                        <a href="#">
                            <div class="text-xs font-weight-bold text-primary text-uppercase mb-1">Ordenes Nuevas</div>
                            <div class="h5 mb-0 font-weight-bold text-gray-800">{{ $ordenesNuevas }}</div>

                            <i class="fa-solid fa-users fa-2x mt-2" style="color: #63E6BE;"></i>
                        </a>
                    </div>
                </div>
            </div>

            <!-- Matriculados en Cursos -->
            <div class="col-xl-3 col-md-6 mb-4">
                <div class="card border-left-success shadow h-100 py-2">
                    <div class="card-body text-center">
                        <a href="#">
                            <div class="text-xs font-weight-bold text-success text-uppercase mb-1">Ordenes Completadas
                            </div>
                            <div class="h5 mb-0 font-weight-bold text-gray-800">{{ $ordenesCompletadas }}</div>


                            <i class="fa-solid fa-clipboard-check fa-2xl mt-2" style="color: #10e922;"></i>
                        </a>

                    </div>
                </div>
            </div>

            <!-- Refuerzos (ejemplo) -->
            <div class="col-xl-3 col-md-6 mb-4">
                <div class="card border-left-info shadow h-100 py-2">
                    <div class="card-body text-center">
                        <div class="text-xs font-weight-bold text-info text-uppercase mb-1">Ordenes Atrazadas</div>
                        <div class="h5 mb-0 font-weight-bold text-gray-800">{{ $ordenesAtrazadas }}</div>

                        <i class="fa-solid fa-hand fa-2xl mt-2" style="color: #f73808;"></i>
                    </div>
                </div>
            </div>

            <!-- Reprobados (ejemplo) -->
            <div class="col-xl-3 col-md-6 mb-4">
                <div class="card border-left-warning shadow h-100 py-2">
                    <div class="card-body text-center">
                        <div class="text-xs font-weight-bold text-warning text-uppercase mb-1">Ventas</div>
                        <div class="h5 mb-0 font-weight-bold text-gray-800">0</div>

                        <i class="fa-solid fa-money-check-dollar fa-2xl mt-2" style="color: #44a854;"></i>
                    </div>
                </div>
            </div>
        </div>


        <div class="col-xl-3 col-md-6 mb-4">
            <div class="card border-left-warning shadow h-100 py-2">
                <div class="card-body text-center">
                    <div class="text-xs font-weight-bold text-warning text-uppercase mb-1">Maquinas Operando</div>
                    <div class="h5 mb-0 font-weight-bold text-gray-800">0</div>

                    <i class="fa-solid fa-plug-circle-check fa-2xl mt-2" style="color: #4302f7;"></i>
                </div>
            </div>
        </div>
        <div class="col-xl-3 col-md-6 mb-4">
            <div class="card border-left-warning shadow h-100 py-2">
                <div class="card-body text-center">
                    <div class="text-xs font-weight-bold text-warning text-uppercase mb-1">Materiales Bajos</div>
                    <div class="h5 mb-0 font-weight-bold text-gray-800">0</div>


                    <i class="fa-solid fa-triangle-exclamation fa-2xl mt-2" style="color: #f76402;"></i>
                </div>
            </div>
        </div>



    </div>

    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/chartjs-plugin-datalabels@2"></script>

    <script>
        const ctx = document.getElementById('alumnosChart').getContext('2d');
        const alumnosChart = new Chart(ctx, {
            type: 'bar',
            data: {
                labels: @json($materiaNombres),
                datasets: [{
                    label: 'Cantidad de Unidades',
                    data: @json($cantidadAlumnos),
                    backgroundColor: 'rgba(0, 100, 0, 0.7)',
                    borderColor: 'rgba(0, 100, 0, 1)',
                    borderWidth: 1,
                    borderRadius: 5
                }]
            },
            options: {
                responsive: true,
                maintainAspectRatio: false,
                plugins: {
                    legend: {
                        display: true,
                        position: 'top'
                    },
                    tooltip: {
                        enabled: true
                    }
                },
                scales: {
                    y: {
                        beginAtZero: true,
                        title: {
                            display: true,
                            text: 'Cantidad de Produccion'
                        },
                        ticks: {
                            stepSize: 1, // sube de 1 en 1
                            callback: function(value) {
                                if (Number.isInteger(value)) {
                                    return value; // muestra solo enteros
                                }
                            }
                        }
                    },
                    x: {
                        title: {
                            display: true,
                            text: 'Maquina'
                        }
                    }
                },
                plugins: [ChartDataLabels]
            }
        });
    </script>
@endsection
