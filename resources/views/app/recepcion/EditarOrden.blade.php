@extends('layouts.app')

@section('title', 'Editar Orden de Bordado')

@section('contenido')
    <div class="container-fluid py-5">
        <div class="card shadow-lg mx-auto" style="max-width: 1200px;">
            <div class="card-body p-4">
                <h4 class="text-center mb-4 fw-bold">Editar Orden #{{ $orden->codigo_orden }}</h4>

                @if (session('success'))
                    <div class="alert alert-success">{{ session('success') }}</div>
                @endif
                @if (session('error'))
                    <div class="alert alert-danger">{{ session('error') }}</div>
                @endif

                <form method="POST" action="{{ route('ordenes.update', $orden->id) }}" enctype="multipart/form-data">
                    @csrf
                    @method('PUT')

                    {{-- ===========================
                    1️⃣ DATOS DEL CLIENTE
                ============================ --}}
                    <div class="card mb-4 border-primary">
                        <div class="card-header bg-primary text-white fw-bold">Datos del Cliente</div>
                        <div class="card-body row g-3">
                            <div class="col-md-6">
                                <label for="cliente_id" class="form-label">Cliente</label>
                                <select class="form-select" id="cliente_id" name="cliente_id" required>
                                    <option value="">Seleccione un cliente</option>
                                    @foreach ($clientes as $cliente)
                                        <option value="{{ $cliente->id }}"
                                            {{ $orden->cliente_id == $cliente->id ? 'selected' : '' }}>
                                            {{ $cliente->nombre }}
                                        </option>
                                    @endforeach
                                </select>
                            </div>

                            <div class="col-md-6">
                                <label for="fecha_entrega" class="form-label">Fecha de Entrega</label>
                                <input type="date" class="form-control" id="fecha_entrega" name="fecha_entrega"
                                    value="{{ $orden->fecha_entrega->format('Y-m-d') }}" required>
                            </div>
                        </div>
                    </div>

                    {{-- ===========================
                    2️⃣ DETALLE DEL DISEÑO
                ============================ --}}
                    <div class="card mb-4 border-dark">
                        <div class="card-header bg-dark text-white fw-bold">Detalle del Diseño / Bordado</div>
                        <div class="card-body row g-3">
                            @php $detalle = $orden->detalles->first(); @endphp

                            <div class="col-md-4">
                                <label class="form-label">Nombre del Arte</label>
                                <input type="text" class="form-control" name="detalles[0][nombre_arte]"
                                    value="{{ $detalle->nombre_arte ?? '' }}" required>
                            </div>

                            <div class="col-md-4">
                                <label class="form-label">Tamaño del Diseño</label>
                                <input type="text" class="form-control" name="detalles[0][tamaño_diseño]"
                                    value="{{ $detalle->tamaño_diseño ?? '' }}">
                            </div>

                            <div class="col-md-4">
                                <label class="form-label">Ubicación en la Prenda</label>
                                <input type="text" class="form-control" name="detalles[0][ubicacion_prenda]"
                                    value="{{ $detalle->ubicacion_prenda ?? '' }}">
                            </div>

                            <div class="col-md-3">
                                <label class="form-label">Tamaño de Cuello</label>
                                <select name="detalles[0][tamaño_cuello]" class="form-select">
                                    <option value="">-- no aplica --</option>
                                    <option value="12" {{ $detalle->tamaño_cuello == 12 ? 'selected' : '' }}>12
                                    </option>
                                    <option value="14" {{ $detalle->tamaño_cuello == 14 ? 'selected' : '' }}>14
                                    </option>
                                    <option value="16" {{ $detalle->tamaño_cuello == 16 ? 'selected' : '' }}>16
                                    </option>
                                </select>
                            </div>

                            <div class="col-md-3">
                                <label class="form-label">Cantidad</label>
                                <input type="number" class="form-control" name="detalles[0][cantidad]" id="cantidad"
                                    value="{{ $detalle->cantidad ?? 1 }}" min="1" required>
                            </div>

                            <div class="col-md-3">
                                <label class="form-label">Precio Unitario</label>
                                <input type="number" step="0.01" class="form-control" id="precio_unitario"
                                    name="detalles[0][precio_unitario]" value="{{ $detalle->precio_unitario ?? 0 }}"
                                    required>
                            </div>

                            <div class="col-md-3">
                                <label class="form-label">Total</label>
                                <input id="precio_total" type="text" class="form-control"
                                    value="{{ $detalle->total ?? 0 }}" readonly>
                            </div>

                            <div class="col-md-12">
                                <label class="form-label">Notas adicionales</label>
                                <textarea class="form-control" name="detalles[0][notas]" rows="2">{{ $detalle->notas ?? '' }}</textarea>
                            </div>

                            <div class="col-md-12">
                                <label class="form-label">Actualizar Imagen del Diseño (opcional)</label>
                                <input type="file" name="imagenes[]" class="form-control" multiple accept="image/*">
                            </div>
                        </div>
                    </div>

                    {{-- ===========================
3️⃣ DATOS DEL PAGO
============================ --}}
                    @php $pago = $orden->pagos->last(); @endphp
                    <div class="card mb-4 border-success">
                        <div class="card-header bg-success text-white fw-bold">Datos del Pago</div>
                        <div class="card-body row g-3">
                            <div class="col-md-3">
                                <label class="form-label">Monto Pagado</label>
                                <input type="number" step="0.01" class="form-control" id="montoPagado"
                                    name="pago[monto]" value="{{ $pago->monto ?? 0 }}" placeholder="0.00">
                            </div>

                            <div class="col-md-3">
                                <label class="form-label">Tipo de Pago</label>
                                <select name="pago[tipo]" class="form-select">
                                    <option value="anticipo" {{ $pago->tipo == 'anticipo' ? 'selected' : '' }}>Anticipo
                                    </option>
                                    <option value="abono" {{ $pago->tipo == 'abono' ? 'selected' : '' }}>Abono</option>
                                    <option value="saldo" {{ $pago->tipo == 'saldo' ? 'selected' : '' }}>Saldo Final
                                    </option>
                                </select>
                            </div>

                            <div class="col-md-3">
                                <label class="form-label">Saldo Pendiente</label>
                                <input type="number" step="0.01" class="form-control" id="saldoPendiente"
                                    name="pago[saldo_restante]" value="{{ $pago->saldo_restante ?? 0 }}"
                                    placeholder="0.00">
                            </div>


                        </div>
                    </div>


                    {{-- ===========================
                    4️⃣ BOTÓN GUARDAR
                ============================ --}}
                    <div class="d-grid">
                        <button type="submit" class="btn btn-primary btn-lg">Actualizar Orden</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

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

        // Inicializar totales al cargar la página
        actualizarTotales();
    </script>
@endsection
