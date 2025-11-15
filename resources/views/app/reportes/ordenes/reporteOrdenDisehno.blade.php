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

    h2,
    .info p {
        color: var(--color-titulo);
    }


    .logo-empresa img {
        width: 100%;

        height: auto;
    }


    .info {
        margin-bottom: 20px;
    }

    /* estilos para la seccion de imagenes de diseño */
    .container-img-arte {
        width: 100%;
    }

    .container-img-arte div {}

    .container-img-arte div img {
        height: 100%;
        width: 100%;
        object-fit: contain;
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
        padding: 14px 16px;
        text-align: left;
        /* color: var(--color-titulo); */
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
            <h2>Procesar Arte - {{ $data['codigo_orden'] }}</h2>
            <p>{{ $fecha }}</p>
        </div>
    </header>


    <div class="container" style="width: 100%;">
        {{-- creamos la columna 1 para las fotos --}}
        <div style="width: 35%;float: left;margin-right: 2%;">


            <div class="container-imagenes" style="margin: 5px 0;padding: 10px;border: 1px solid #ccc;">
               <div class="card-header" style="background: #5A5C69;color: #fff; padding: 5px; margin: 5px 0;">
                    DISEÑOS
                </div>

                <div class="container-img-arte" style="text-align: center;">
                    <div
                        style="width: 160px;height: 160px;margin-bottom: 10px;border: 1px solid #ddd;background-color: #f9f9f9;">
                        <img src="{{ public_path('lOGOCYABORDADOS.png') }}" alt="foto del arte"
                            style="width: 100%;height: 100%;object-fit: contain;">
                    </div>
                    <div
                        style="width: 160px;height: 160px;margin-bottom: 10px;border: 1px solid #ddd;background-color: #f9f9f9;">
                        <img src="{{ public_path('lOGOCYABORDADOS.png') }}" alt="foto del arte"
                            style="width: 100%;height: 100%;object-fit: contain;">
                    </div>


                    <div style="clear: both;"></div>
                </div>
            </div>

        </div>

        {{-- creamos la columna 2 con un 63% del ancho total --}}
        <div style="width: 63%;float: left;">

            <div class="card">
                <div class="card-header" style="background: #5A5C69;color: #fff; padding: 5px; margin: 5px 0;">
                    Detalle del Diseño / Bordado
                </div>
                <div>
                    <table class="table">
                        <thead style="background: #5A5C69; color: #fff !important;">
                            <tr>
                                <th>Nombre del Arte</th>
                                <th>Tamaño del Diseño</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr>
                                <td>{{ $data['nombre_arte'] }}</td>
                                <td>{{ $data['tamano_diseno'] }}</td>
                            </tr>
                        </tbody>
                    </table>
                    <table class="table">
                        <thead style="background: #5A5C69; color: #fff !important;">
                            <tr>

                                <th>Ubicación en la Prenda</th>
                                <th>Tamaño de Cuello</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr>
                                <td>{{ $data['ubicacion_prenda'] }}</td>
                                <td>{{ $data['tamano_cuello'] }}</td>
                            </tr>
                        </tbody>
                    </table>

                    <table class="table">
                        <thead style="background: #5A5C69; color: #fff !important;">
                            <tr>
                                <th>Cantidad Puntadas*</th>
                                <th>Cantidad de Secuencia*</th>

                            </tr>
                        </thead>
                        <tbody>
                            <tr>
                                <td>{{ $data['cantidad'] }}</td>
                                <td>{{ $data['codigo_orden'] }}</td>
                            </tr>
                        </tbody>
                    </table>
                    <table class="table">
                        <thead style="background: #5A5C69; color: #fff !important;">
                            <tr>

                                <th>Tiempo Estimado</th>
                                <th>Velocidad de Maquina (RPM)</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr>
                                <td>{{ $data['codigo_orden'] }}</td>
                                <td>{{ $data['codigo_orden'] }}</td>
                            </tr>
                        </tbody>
                    </table>


                    <table class="table">
                        <thead style="background: #5A5C69; color: #fff !important;">
                            <tr>
                                <th>Notas adicionales</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr>
                                <td>{{ $data['notas'] }}</td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </div>

        </div>

        <div style="clear: both;"></div>
    </div>

</body>

</html>