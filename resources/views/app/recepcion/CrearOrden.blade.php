@extends('layouts.app')
@section('title', 'Registro de Orden')

@section('contenido')
    <div class="container-fluid py-5">
        <div class="card shadow-lg mx-auto" style="max-width: 1200px;">
            <div class="card-body p-4">
                <h4 class="text-center mb-4 fw-bold">Registro de Nueva Orden de Bordado</h4>

                @if (session('success'))
                    <div class="alert alert-success">{{ session('success') }}</div>
                @endif
                @if (session('error'))
                    <div class="alert alert-danger">{{ session('error') }}</div>
                @endif

                <form method="POST" action="{{ route('ordenes.store') }}" enctype="multipart/form-data">
                    @csrf

                    {{-- ===========================
                    1️⃣ DATOS DEL CLIENTE
                ============================ --}}
                    <div class="card mb-4 border-primary">
                        <div class="card-header bg-primary text-white fw-bold">
                            Datos del Cliente
                        </div>
                        <div class="card-body row g-3">
                            <div class="col-md-6">
                                <label for="cliente_id" class="form-label">Cliente</label>
                                <div class="input-group">
                                    <select class="form-select" id="cliente_id" name="cliente_id" required>
                                        <option value="">Seleccione un cliente</option>
                                        @foreach ($clientes as $cliente)
                                            <option value="{{ $cliente->id }}">{{ $cliente->nombre }}</option>
                                        @endforeach
                                    </select>

                                    <a href="{{ route('clientes.create') }}" class="btn btn-outline-success"
                                        type="button">Nuevo</a>
                                </div>
                            </div>

                            <div id="nuevoClienteForm" class="col-md-12 mt-3" style="display:none;">
                                <input type="text" class="form-control mb-2" placeholder="Nombre del nuevo cliente"
                                    name="nuevo_cliente_nombre">
                                <input type="text" class="form-control mb-2" placeholder="Teléfono"
                                    name="nuevo_cliente_telefono">
                                <input type="email" class="form-control mb-2" placeholder="Correo electrónico"
                                    name="nuevo_cliente_correo">
                            </div>

                            <div class="col-md-6">
                                <label for="fecha_entrega" class="form-label">Fecha de Entrega</label>
                                <input type="date" class="form-control" id="fecha_entrega" name="fecha_entrega" required>
                            </div>
                        </div>
                    </div>

                    {{-- ===========================
                    2️⃣ DETALLE DEL DISEÑO / BORDADO
                ============================ --}}
                    <div class="card mb-4 border-dark">
                        <div class="card-header bg-dark text-white fw-bold">
                            Detalle del Diseño / Bordado
                        </div>
                        <div class="card-body row g-3">
                            <div class="col-md-4">
                                <label class="form-label">Nombre del Arte</label>
                                <input type="text" class="form-control" name="detalles[0][nombre_arte]" required>
                            </div>

                            <div class="col-md-4">
                                <label class="form-label">Tamaño del Diseño</label>
                                <input type="text" class="form-control" name="detalles[0][tamaño_diseño]"
                                    placeholder="Ej: 10x12 cm">
                            </div>

                            <div class="col-md-4">
                                <label class="form-label">Ubicación en la Prenda</label>
                                <input type="text" class="form-control" name="detalles[0][ubicacion_prenda]"
                                    placeholder="Ej: Pecho izquierdo">
                            </div>

                            <div class="col-md-3">
                                <label class="form-label">Tamaño de Cuello</label>
                                <select name="detalles[0][tamaño_cuello]" class="form-select">
                                    <option value="">-- no aplica --</option>
                                    <option value="12">12</option>
                                    <option value="14">14</option>
                                    <option value="16">16</option>
                                </select>
                            </div>

                            <div class="col-md-3">
                                <label class="form-label">Cantidad</label>
                                <input type="number" class="form-control" id="cantidad" name="detalles[0][cantidad]"
                                    min="1" required>
                            </div>

                            <div class="col-md-3">
                                <label class="form-label">Precio Unitario</label>
                                <input type="number" step="0.01" class="form-control" id="precio_unitario"
                                    name="detalles[0][precio_unitario]" required>
                            </div>

                            <div class="col-md-3">
                                <label class="form-label">Total</label>
                                <input type="text" class="form-control" id="precio_total" readonly>
                            </div>

                            <div class="col-md-12">
                                <label class="form-label">Notas adicionales</label>
                                <textarea class="form-control" name="detalles[0][notas]" rows="2" placeholder="Observaciones del diseño..."></textarea>
                            </div>

                            <div class="col-md-12">
                                <label class="form-label">Subir Imagen del Diseño</label>
                                <input type="file" name="imagenes[]" class="form-control" multiple accept="image/*">
                            </div>
                        </div>
                    </div>

                    {{-- ===========================
                    3️⃣ TABLA DE HILOS USADOS
                ============================ --}}
                    <div class="card mb-4 border-info">
                        <div class="card-header bg-info text-white fw-bold">
                            Hilos Utilizados en el Diseño
                        </div>
                        <div class="card-body">
                            <div class="row align-items-end mb-3">
                                <div class="col-md-6">
                                    <label class="form-label">Seleccionar Hilo</label>
                                    <select id="hiloSelect" class="form-select">
                                        <option value="">Seleccione un hilo</option>
                                        @foreach ($hilos as $hilo)
                                            <option value="{{ $hilo->id }}" data-nombre="{{ $hilo->nombre }}"
                                                data-stock="{{ $hilo->stock }}">
                                                {{ $hilo->codigo }} - {{ $hilo->nombre }} (Stock: {{ $hilo->stock }})
                                            </option>
                                        @endforeach
                                    </select>
                                </div>
                                <div class="col-md-3">
                                    <button type="button" class="btn btn-primary" id="agregarHilo">Agregar Hilo</button>
                                </div>
                            </div>

                            <table class="table table-bordered" id="tablaHilos">
                                <thead class="table-light">
                                    <tr>
                                        <th>Código</th>
                                        <th>Nombre del Hilo</th>
                                        <th>Cantidad Stock</th>
                                        <th>Acción</th>
                                    </tr>
                                </thead>
                                <tbody></tbody>
                            </table>
                        </div>
                    </div>

                    {{-- ===========================
                    4️⃣ DATOS DEL PAGO
                ============================ --}}
                    <div class="card mb-4 border-success">
                        <div class="card-header bg-success text-white fw-bold">
                            Datos del Pago
                        </div>
                        <div class="card-body row g-3">
                            <div class="col-md-4">
                                <label class="form-label">Monto Pagado</label>
                                <input onchange="RecalcularTotal()" type="number" step="0.01" class="form-control"
                                    id="montoPagado" name="pago[monto]" placeholder="0.00">
                            </div>
                            <div class="col-md-4">
                                <label class="form-label">Tipo de Pago</label>
                                <select name="pago[tipo]" class="form-select">
                                    <option value="anticipo">Anticipo</option>
                                    <option value="abono">Abono</option>
                                    <option value="saldo">Saldo Final</option>
                                </select>
                            </div>
                            <div class="col-md-4">
                                <label class="form-label">Saldo Pendiente</label>
                                <input type="number" class="form-control" id="saldoPendiente" name="saldoPendiente"
                                    placeholder="0.00">
                            </div>
                            <div class="col-md-12">
                                <label class="form-label">Nota</label>
                                <textarea class="form-control" name="pago[nota]" rows="2" placeholder="Detalles del pago..."></textarea>
                            </div>
                        </div>
                    </div>

                    {{-- ===========================
                    5️⃣ BOTÓN GUARDAR
                ============================ --}}
                    <div class="d-grid">
                        <button type="submit" class="btn btn-success btn-lg">
                            Registrar Orden
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    {{-- ===========================
    JAVASCRIPT
=========================== --}}
    <script>
        // Calcular total automáticamente
        document.getElementById('cantidad').addEventListener('input', actualizarTotales);
        document.getElementById('precio_unitario').addEventListener('input', actualizarTotales);
        document.getElementById('montoPagado').addEventListener('input', actualizarTotales);



        function actualizarTotales() {
            const cantidad = parseFloat(document.getElementById('cantidad').value) || 0;
            const precio = parseFloat(document.getElementById('precio_unitario').value) || 0;
            const montoPagado = parseFloat(document.getElementById('montoPagado').value) || 0;

            const precioTotal = cantidad * precio;
            const saldoPendiente = precioTotal - montoPagado;

            document.getElementById('precio_total').value = precioTotal.toFixed(2);
            document.getElementById('saldoPendiente').value = saldoPendiente.toFixed(2);
        }

        // Agregar hilos a la tabla
        document.getElementById('agregarHilo').addEventListener('click', () => {
            const select = document.getElementById('hiloSelect');
            const hilo = select.options[select.selectedIndex];
            if (!hilo.value) return;

            const tabla = document.querySelector('#tablaHilos tbody');
            const row = document.createElement('tr');

            row.innerHTML = `
        <td>${hilo.text.split(' - ')[0]}</td>
        <td>${hilo.dataset.nombre}</td>
        <td>${hilo.dataset.stock}</td>
        <td>
            <input type="hidden" name="hilos[]" value="${hilo.value}">
            <button type="button" class="btn btn-danger btn-sm" onclick="this.closest('tr').remove()">Eliminar</button>
        </td>
    `;

            tabla.appendChild(row);
            select.value = '';
        });
    </script>
@endsection
