@extends('layouts.app')

@section('title', 'Procesar Arte - ' . $orden->codigo_orden)

@section('contenido')

    <style>
        /* ===== ESTILO CORPORATIVO PREMIUM ===== */
        .erp-container {
            max-width: 1380px;
            margin: auto;
        }

        .erp-card {
            background: #ffffff;
            border-radius: 18px;
            padding: 40px;
            box-shadow: 0 8px 22px rgba(0, 0, 0, 0.08);
            border: 1px solid #e5e7eb;
        }

        .erp-title {
            font-size: 28px;
            font-weight: 700;
            letter-spacing: -0.5px;
            color: #1f2937;
        }

        .erp-subtitle {
            color: #6b7280;
            font-size: 15px;
            margin-top: 4px;
        }

        .section-title {
            font-size: 17px;
            font-weight: 700;
            color: #374151;
            text-transform: uppercase;
            margin-bottom: 15px;
            border-left: 4px solid #2563eb;
            padding-left: 10px;
        }

        /* Paneles */
        .panel {
            background: #f9fafb;
            border-radius: 14px;
            padding: 25px;
            border: 1px solid #e5e7eb;
            min-height: 420px;
        }

        .panel-title {
            font-weight: 600;
            color: #4b5563;
            margin-bottom: 20px;
            text-align: center;
            font-size: 16px;
        }

        .form-label {
            font-weight: 600;
            color: #374151;
        }

        .form-control,
        .form-select,
        textarea {
            border-radius: 10px !important;
            border: 1px solid #d1d5db !important;
            padding: 10px 14px !important;
            font-size: 14px !important;
        }

        /* Tabla elegante */
        table.erp-table {
            background: white;
            border-radius: 12px;
            overflow: hidden;
            border: 1px solid #e5e7eb;
        }

        table.erp-table thead {
            background: #111827;
            color: white;
            font-size: 14px;
        }

        table.erp-table tbody tr td {
            font-size: 14px;
            padding: 10px;
            color: #374151;
        }

        /* Botones */
        .btn-primary {
            background: #2563eb !important;
            border-radius: 10px;
            font-weight: 600;
            padding: 12px 32px;
            border: none;
        }

        .btn-outline-secondary {
            border-radius: 10px;
            padding: 12px 32px;
            font-weight: 600;
            border-width: 2px !important;
        }

        /* Imagen */
        .preview-img {
            max-height: 380px;
            object-fit: contain;
            border-radius: 12px;
            background: white;
            padding: 10px;
            border: 1px solid #e5e7eb;
        }
    </style>


    <div class="erp-container py-5">

        <div class="erp-card">

            {{-- ENCABEZADO --}}
            <div class="text-center mb-5">
                <h2 class="erp-title">
                    Procesamiento Técnico del Arte
                    <span class="text-primary">#{{ $orden->codigo_orden }}</span>
                </h2>
                <p class="erp-subtitle">
                    Revisión gráfica, cálculo técnico de bordado y disponibilidad de hilos.
                </p>
            </div>

            {{-- ALERTAS --}}
            @if (session('success'))
                <div class="alert alert-success shadow-sm">{{ session('success') }}</div>
            @endif
            @if (session('error'))
                <div class="alert alert-danger shadow-sm">{{ session('error') }}</div>
            @endif

            <form method="POST" action="{{ route('ordenesCalculosArte.store', $orden->id) }}" enctype="multipart/form-data">
                @csrf

                @php $detalle = $orden->detalles->first(); @endphp

                <input type="hidden" name="arte_id" value="{{ $detalle->id ?? '' }}">
                <input type="hidden" name="orden_id_calculo" value="{{ $orden->id }}">

                <div class="row g-4">

                    {{-- PANEL IZQUIERDO: IMÁGENES --}}
                    <div class="col-lg-6">
                        <div class="panel">

                            <h5 class="panel-title">Vista Previa del Arte</h5>

                            @if ($detalle && $detalle->imagenes->count())
                                <div id="carouselArte" class="carousel slide mb-3">
                                    <div class="carousel-inner">
                                        @foreach ($detalle->imagenes as $index => $img)
                                            <div class="carousel-item {{ $index === 0 ? 'active' : '' }}">
                                                <img src="{{ asset('storage/' . $img->ruta_imagen) }}"
                                                    class="d-block w-100 preview-img">
                                            </div>
                                        @endforeach
                                    </div>

                                    <button class="carousel-control-prev" type="button" data-bs-target="#carouselArte"
                                        data-bs-slide="prev">
                                        <span class="carousel-control-prev-icon"></span>
                                    </button>

                                    <button class="carousel-control-next" type="button" data-bs-target="#carouselArte"
                                        data-bs-slide="next">
                                        <span class="carousel-control-next-icon"></span>
                                    </button>
                                </div>
                            @else
                                <div class="text-center">
                                    <img id="imagen-estatica" src="{{ asset('img/admin/undraw_profile.svg') }}"
                                        class="preview-img mb-3">
                                    <p class="text-muted small">No se han subido imágenes para este arte.</p>
                                </div>
                            @endif

                            <label class="form-label mt-3">Agregar nueva imagen</label>
                            <input type="file" id="imagen_arte" name="imagen_arte" class="form-control" accept="image/*">
                            <div id="preview" class="mt-3"></div>

                        </div>
                    </div>

                    {{-- PANEL DERECHO: CAMPOS --}}
                    <div class="col-lg-6">
                        <div class="panel">

                            <h5 class="panel-title">Detalles Técnicos</h5>

                            <div class="row g-3">

                                <div class="col-md-6">
                                    <label class="form-label">Nombre del Arte</label>
                                    <input type="text" class="form-control" value="{{ $detalle->nombre_arte }}" readonly>
                                </div>

                                <div class="col-md-6">
                                    <label class="form-label">Tamaño</label>
                                    <input type="text" class="form-control" value="{{ $detalle->tamaño_diseño }}"
                                        readonly>
                                </div>

                                <div class="col-md-6">
                                    <label class="form-label">Ubicación</label>
                                    <input type="text" class="form-control" value="{{ $detalle->ubicacion_prenda }}"
                                        readonly>
                                </div>

                                <div class="col-md-6">
                                    <label class="form-label">Cantidad</label>
                                    <input id="cantidad" type="text" class="form-control"
                                        value="{{ $detalle->cantidad }}" readonly>
                                </div>

                                <div class="col-md-6">
                                    <label class="form-label">Máquina</label>
                                    <select class="form-select" name="maquina_id" id="maquina_id">
                                        <option selected disabled>Seleccione...</option>
                                        @foreach ($maquinas as $maquina)
                                            <option value="{{ $maquina->id }}">{{ $maquina->nombre }}</option>)
                                        @endforeach

                                    </select>
                                </div>

                                <div class="col-md-6">
                                    <label class="form-label">RPM</label>
                                    <input type="number" class="form-control" name="rpm" id="rpm" value=""
                                        readonly>
                                </div>

                                <div class="col-md-6">
                                    <label class="form-label">Cabezales Disponibles</label>
                                    <input type="number" class="form-control" name="cabezales" id="cabezales"
                                        value="" readonly>
                                </div>

                                <div class="col-md-6">
                                    <label class="form-label">Ciclos</label>
                                    <input type="number" class="form-control" name="ciclos" id="ciclos"
                                        value="" readonly>
                                </div>

                                <div class="col-md-6">
                                    <label class="form-label">Puntadas</label>
                                    <input type="number" class="form-control" name="puntadas" id="puntadas">
                                </div>

                                <div class="col-md-6">
                                    <label class="form-label">Secuencias</label>
                                    <input type="number" class="form-control" name="secuencias" id="secuencias">
                                </div>

                                <div class="col-md-6">
                                    <label class="form-label">Tiempo Ciclo (min)</label>
                                    <input type="text" class="form-control" id="resultado" name="tiempo_ciclo"
                                        readonly>
                                </div>

                                <div class="col-md-6">
                                    <label class="form-label">Tiempo Total Orden (min)</label>
                                    <input type="text" class="form-control" id="tiempoTotal" name="tiempoTotal"
                                        readonly>
                                </div>

                                <div class="col-12 mt-4">
                                    <h6 class="section-title">Hilos Utilizados</h6>

                                    <table class="table table-bordered erp-table">
                                        <thead>
                                            <tr>
                                                <th>Color</th>
                                                <th>Código</th>
                                                <th>Conos</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @foreach ($orden->detalles as $dt)
                                                @foreach ($dt->detalleHilo as $h)
                                                    <tr>
                                                        <td>{{ $h->material->nombre }}</td>
                                                        <td>{{ $h->material->codigo }}</td>
                                                        <td>{{ $h->material->stock }}</td>
                                                    </tr>
                                                @endforeach
                                            @endforeach
                                        </tbody>
                                    </table>
                                </div>

                                <div class="col-12">
                                    <label class="form-label">Notas adicionales</label>
                                    <textarea class="form-control" name="notaadicional" rows="3"></textarea>
                                </div>

                            </div>

                        </div>
                    </div>

                </div>

                {{-- BOTONES --}}
                <div class="text-center mt-5">
                    <button type="submit" class="btn btn-primary">Aprobar Diseño</button>
                    <a href="{{ route('produccion.arte.index') }}" class="btn btn-outline-secondary ms-2">
                        Cancelar
                    </a>
                </div>

            </form>

        </div>
    </div>

    <script>
        function calcularTiempoBordado(puntadas, rpm, secuencias, cambio = 20, eficiencia = 0.85) {
            if (!puntadas || !rpm) return 0;

            return ((puntadas / rpm) / eficiencia) + (secuencias * (cambio / 60));
        }

        // Escucha cambios en puntadas, RPM y secuencias
        function initCalculoTiempo() {
            document.querySelectorAll('#puntadas, #rpm, #secuencias').forEach(input => {
                input.addEventListener('input', () => {
                    const puntadas = parseFloat(document.getElementById('puntadas').value);
                    const rpm = parseFloat(document.getElementById('rpm').value);
                    const secuencias = parseFloat(document.getElementById('secuencias').value);

                    const tiempo = calcularTiempoBordado(puntadas, rpm, secuencias);
                    document.getElementById('resultado').value = tiempo.toFixed(2);

                    const tiempoTotal = tiempo * (parseInt(document.getElementById('ciclos').value) || 1);
                    document.getElementById('tiempoTotal').value = tiempoTotal.toFixed(2);
                });
            });
        }

        /* ============================================================
        3) FUNCIÓN PARA PREVIEW DE IMAGEN
        ============================================================ */
        function initPreview() {
            document.getElementById('imagen_arte').addEventListener('change', function(event) {
                const preview = document.getElementById('preview');
                const imgEstatica = document.getElementById('imagen-estatica');
                preview.innerHTML = '';

                if (event.target.files.length > 0) {
                    if (imgEstatica) imgEstatica.style.display = 'none';

                    const reader = new FileReader();
                    reader.onload = e => {
                        preview.innerHTML = `
                    <img src="${e.target.result}" class="img-fluid rounded-3 shadow-sm"
                         style="max-height: 400px; object-fit: contain;">
                `;
                    };
                    reader.readAsDataURL(event.target.files[0]);
                }
            });
        }

        function initMaquinaChange() {
            const selectMaquina = document.getElementById('maquina_id');

            selectMaquina.addEventListener('change', function() {
                const id = this.value;
                if (!id) return;

                fetch(`/maquinas/info/${id}`)
                    .then(res => res.json()
                        .then(data => {
                            document.getElementById('rpm').value = data.rpm;
                            document.getElementById('cabezales').value = data.cabezales_disponibles;
                            const cantidad = parseInt(document.getElementById('cantidad').value) || 1;
                            const ciclos = Math.ceil(cantidad / data.cabezales_disponibles);
                            document.getElementById('ciclos').value = ciclos;
                            // recalcular el tiempo cuanda la cambia la maquina
                            document.getElementById('puntadas').dispatchEvent(new Event('input'));

                        }))
                    .catch(err => console.error('error cargando maquina: ', err));
            });

        }

        ///iniciar las funciones
        document.addEventListener('DOMContentLoaded', function() {
            initCalculoTiempo();
            initMaquinaChange();
            initPreview();
        });
    </script>

@endsection
