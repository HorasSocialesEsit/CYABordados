<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Reporte de Orden</title>

</head>

<style>
    :root {
        --color-titulo: #6b7280;
    }

    @page {
        /* quitamos el margen pora aplicar a toda la pagina del pdf */
        /* margin: 0; */

    }

    body {
        font-family: Arial, sans-serif;

        /* agregamos fondo a todas las pginas */
        /* background: gray; */
        /* agregamos padding de todos los lados; */
        /* padding: 35px 30px; */
    }

    header {
        position: relative;
    }

    .logo-empresa {
        position: absolute;
        right: 0;
        top: 0;
        text-align: center;
        margin-bottom: 20px;
        border-radius: 50%;
        height: 120px;
        width: 120px;
        overflow: hidden;
    }

    h2 {
        color: var(--color-titulo);
    }

    .logo-empresa img {
        width: 100%;

        height: auto;
    }

    .info {
        margin-bottom: 20px;
    }

    .table {
        width: 100%;
        border-collapse: separate;
        border-spacing: 0;
        overflow: hidden;
        color: #111827;
        font-size: 14px;
    }

    /* Encabezado */
    .table thead th {
        position: sticky;
        top: 0;
        padding: 14px 16px;
        text-align: left;
        color: var(--color-titulo);
        font-weight: 600;
        letter-spacing: 0.02em;
        text-transform: uppercase;
        font-size: 12px;

    }

    .table tbody td {
        padding: 14px 16px;
        border-bottom: 1px dashed rgba(15, 23, 42, 0.04);
    }
</style>

<body>

    <header>
        <div class="logo-empresa">

            <img src="{{ public_path('lOGOCYABORDADOS.png') }}" alt="Logo">
        </div>
        <div class="info">
            <h2>REPORTE DE DETALLES DE ORDEN</h2>
            <p>{{ $fecha }}</p>
        </div>
    </header>

    <div class="container">
        <div class="container-imagenes" style="margin: 5px 0;padding: 10px;border: 1px solid #ccc;">
            <div class="card-header" style="background: #5A5C69;color: #fff; padding: 5px; margin: 5px 0;">
                DISEÑO
            </div>

            <div class="container-img-arte" style="text-align: center;">
                <div
                    style="width: 160px;height: 160px;margin-bottom: 10px;border: 1px solid #ddd;background-color: #f9f9f9;">
                    <img src="{{ public_path('lOGOCYABORDADOS.png') }}" alt="foto del arte"
                        style="width: 100%;height: 100%;object-fit: contain;">
                </div>
                <div style="clear: both;"></div>
            </div>
        </div>
        <div class="" style="max-width: 1200px;">

            <div class="card-body">
                <div class="card">
                    <div class="card-header" style="background: #4E73DF; color: #fff; padding: 5px;">
                        Datos del Cliente
                    </div>
                    <div class="">
                        <table class="table ">
                            <thead class="">
                                <tr>
                                    <th>Cliente</th>
                                    <th>Fecha de Entrega</th>
                                    <th>Tipo de Cliente</th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr>
                                    <td>{{ $orden_buscada->cliente->nombre }}</td>
                                    <td>{{ \Carbon\Carbon::parse($orden_buscada->fecha_entrega)->format('d/m/Y') }}</td>
                                    <td>{{ $orden_buscada->cliente->tipoCliente }}</td>
                                </tr>

                            </tbody>
                        </table>
                        <table class="table">
                            <thead class="">
                                <tr>
                                    <th>Correo</th>
                                    <th>Teléfono</th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr>
                                    <td>{{ $orden_buscada->cliente->correo }}</td>
                                    <td>{{ $orden_buscada->cliente->telefono ?? '—' }}</td>
                                    {{-- <td>{{ $orden_buscada->usuario->name }}</td> --}}
                                </tr>

                            </tbody>
                        </table>
                    </div>
                </div>

                @foreach ($orden_buscada->detalles as $detalle)
                    <div class="card">
                        <div class="card-header" style="background: #5A5C69;color: #fff; padding: 5px;">
                            Detalle del Diseño / Bordado
                        </div>
                        <div class="">
                            <table class="table ">
                                <thead class="">
                                    <tr>
                                        <th>Nombre del Arte</th>
                                        <th>Tamaño del Diseño</th>
                                        <th>Ubicación en la Prenda</th>
                                        <th>Tamaño de Cuello</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <tr>
                                        <td>{{ $detalle->nombre_arte }}</td>
                                        <td>{{ $detalle->tamaño_diseño ?? '—' }}</td>
                                        <td>{{ $detalle->ubicacion_prenda ?? '—' }}</td>
                                        <td>{{ $detalle->tamaño_cuello ?? '—' }}</td>
                                    </tr>

                                </tbody>
                            </table>


                            <table class="table ">
                                <thead class="">
                                    <tr>
                                        <th>Cantidad</th>
                                        <th>Precio Unitario</th>
                                        <th>Total</th>
                                        <th>Notas adicionales</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <tr>
                                        <td>{{ $detalle->cantidad }}</td>
                                        <td>${{ number_format($detalle->precio_unitario, 2) }}</td>
                                        <td>${{ number_format($detalle->total, 2) }}</td>
                                        <td>{{ $detalle->notas ?? '—' }}</td>
                                    </tr>

                                </tbody>
                            </table>
                        </div>
                    </div>
                    <div class="card">
                        <div class="card-header " style="background: #36B9CC;color: #fff; padding: 5px;">
                            Hilos Utilizados en el Diseño
                        </div>
                        <div class="card-body">
                            <table class="table ">
                                <thead class="">
                                    <tr>
                                        <th>Código</th>
                                        <th>Nombre del Hilo</th>
                                        <th>Tipo</th>
                                        <th>Stock</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @forelse ($detalle->hilos as $hilo)
                                        <tr>
                                            <td>{{ $hilo->material->codigo }}</td>
                                            <td>{{ $hilo->material->nombre }}</td>
                                            <td>{{ $hilo->material->tipoHilo }}</td>
                                            <td>{{ $hilo->material->stock }}</td>
                                        </tr>
                                    @empty
                                        <tr>
                                            <td colspan="4" class="">No se registraron hilos.</td>
                                        </tr>
                                    @endforelse
                                </tbody>
                            </table>
                        </div>
                    </div>
                @endforeach
                <div class="card">
                    <div class="card-header" style="background: #1CC88A; color: #fff; padding: 5px;">
                        Datos del Pago
                    </div>
                    <div class="card-body">
                        @if ($orden_buscada->pagos->isNotEmpty())
                            @php
                                $pago = $orden_buscada->pagos->first();
                            @endphp
                            <table class="table ">
                                <thead class="">
                                    <tr>
                                        <th>Monto Pagado</th>
                                        <th>Tipo de Pago</th>
                                        <th>Saldo Pendiente</th>
                                        <th>Nota</th>
                                    </tr>
                                </thead>
                                <tbody>

                                    <tr>
                                        <td>${{ number_format($pago->monto, 2) }}</td>
                                        <td>{{ ucfirst($pago->tipo) }}</td>
                                        <td>${{ number_format($pago->saldo_restante, 2) }}</td>
                                        <td>{{ $pago->nota ?? '—' }}</td>
                                    </tr>

                                </tbody>
                            </table>
                        @else
                            <div class="">
                                <p class="">No se registraron pagos para esta orden.</p>
                            </div>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </div>
</body>

</html>