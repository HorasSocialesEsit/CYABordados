<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <title>Inventario</title>
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
            height: 150px;
            width: 150px;
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
</head>

<body>

    <header>
        <div class="logo-empresa">

            <img src="{{ public_path('lOGOCYABORDADOS.png') }}" alt="Logo">
        </div>
        <div class="info">
            <h2>INVENTARIO</h2>
            <p><strong>Fecha:</strong> {{ $fecha }}</p>
            <p><strong>Inventario realizado por:</strong> {{ $nombre_persona }}</p>
        </div>
    </header>
    <table class="table">
        <thead>
            <tr>
                <th>#</th>
                <th>Nombre</th>
                <th>Codigo</th>
                <th>Descripcion</th>
                <th>Stock</th>
                <th>Tipo de Hilo</th>
            </tr>
        </thead>
        <tbody>
            @foreach($inventario as  $hilo)
                <tr>
                    <td>{{ $loop->iteration }}</td>
                    <td>{{ $hilo->nombre }}</td>
                    <td>{{ $hilo->codigo }}</td>
                    <td>{{ $hilo->descripcion }}</td>
                    <td style="text-align: center;">{{ $hilo->stock }}</td>
                    <td>{{ $hilo->tipoHilo }}</td>
                </tr>
            @endforeach
        </tbody>
    </table>
</body>

</html>