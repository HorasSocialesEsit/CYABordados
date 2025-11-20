@extends('layouts.app')

@section('title', 'Procesar Arte - ' . $orden->codigo_orden)

@section('contenido')
    <div class="container-fluid py-5">
        <div class="card shadow-lg border-0 rounded-4 mx-auto" style="max-width: 1300px;">
            <div class="card-body p-5">

                {{-- Encabezado --}}
                <div class="text-center mb-4">
                    <h3 class="fw-bold text-dark">
                        Procesar Arte - <span class="text-primary">{{ $orden->codigo_orden }}</span>
                    </h3>
                    <p class="text-muted">Visualiza las imágenes del arte y agrega observaciones o nuevas versiones.</p>
                </div>

                {{-- Mensajes --}}
                @if (session('success'))
                    <div class="alert alert-success shadow-sm">{{ session('success') }}</div>
                @endif
                @if (session('error'))
                    <div class="alert alert-danger shadow-sm">{{ session('error') }}</div>
                @endif

                <form method="POST" action="{{ route('ordenesCalculosArte.store', $orden->id) }}"
                    enctype="multipart/form-data">
                    @csrf

                    @php $detalle = $orden->detalles->first(); @endphp

                    {{-- IDs ocultos --}}
                    <input type="hidden" name="arte_id" value="{{ $detalle->id ?? '' }}">
                    <input type="hidden" name="orden_id_calculo" value="{{ $orden->id }}">

                    <div class="row g-4 align-items-start">

                        {{-- COLUMNA IZQUIERDA: IMÁGENES --}}
                        <div class="col-lg-6 col-md-12">
                            <div class="border rounded-4 p-3 bg-light shadow-sm">
                                <h5 class="fw-semibold text-secondary mb-3 text-center">Arte (Vista previa)</h5>
                                @if ($detalle && $detalle->imagenes->count()) {{-- Carrousel --}}
                                    <div id="carouselArte" class="carousel slide" data-bs-ride="carousel">
                                        <div class="carousel-inner">
                                            @foreach ($detalle->imagenes as $index => $img)
                                                <div class="carousel-item {{ $index === 0 ? 'active' : '' }}"> <img
                                                        src="{{ asset('storage/' . $img->ruta_imagen) }}"
                                                        class="d-block w-100 rounded-3 arte-img"
                                                        style="max-height: 420px; object-fit: contain;"> </div>
                                            @endforeach
                                        </div> <button class="carousel-control-prev" type="button"
                                            data-bs-target="#carouselArte" data-bs-slide="prev"> <span
                                                class="carousel-control-prev-icon"></span> </button> <button
                                            class="carousel-control-next" type="button" data-bs-target="#carouselArte"
                                            data-bs-slide="next"> <span class="carousel-control-next-icon"></span> </button>
                                    </div>
                                @else
                                    {{-- Vista estática cuando no hay imágenes --}} <div class="text-center"> <img id="imagen-estatica"
                                            src="{{ session('rutaImagenNueva')
                                                ? asset('storage/' . session('rutaImagenNueva'))
                                                : asset('img/admin/undraw_profile.svg') }}"
                                            class="img-fluid rounded-3 shadow-sm mb-3"
                                            style="max-height: 400px; object-fit: contain;">
                                        <p id="imagen_mensaje" class="text-muted"> No hay imágenes registradas para este
                                            arte. </p>
                                    </div>
                                @endif


                                {{-- Subir nueva imagen --}}
                                <div class="mt-3">
                                    <label class="form-label fw-semibold">Agregar imagen (opcional)</label>
                                    <input type="file" id="imagen_arte" name="imagen_arte" class="form-control"
                                        accept="image/*">

                                    {{-- Vista previa que reemplaza imagen existente --}}
                                    <div id="preview" class="mt-3"></div>
                                </div>

                            </div>
                        </div>

                        {{-- COLUMNA DERECHA: CAMPOS --}}
                        <div class="col-lg-6 col-md-12">
                            <div class="card border-dark h-100 shadow-sm">
                                <div class="card-header bg-dark text-white fw-bold">Detalle del Diseño / Bordado</div>

                                <div class="card-body">
                                    <div class="row g-3">

                                        {{-- DATOS DEL DETALLE --}}
                                        <div class="col-md-6">
                                            <label class="form-label">Nombre del Arte</label>
                                            <input type="text" class="form-control" value="{{ $detalle->nombre_arte }}"
                                                readonly>
                                        </div>

                                        <div class="col-md-6">
                                            <label class="form-label">Tamaño del Diseño</label>
                                            <input type="text" class="form-control"
                                                value="{{ $detalle->tamaño_diseño }}" readonly>
                                        </div>

                                        <div class="col-md-6">
                                            <label class="form-label">Ubicación en la Prenda</label>
                                            <input type="text" class="form-control"
                                                value="{{ $detalle->ubicacion_prenda }}" readonly>
                                        </div>

                                        <div class="col-md-6">
                                            <label class="form-label">Cantidad</label>
                                            <input type="text" class="form-control" value="{{ $detalle->cantidad }}"
                                                readonly>
                                        </div>

                                        {{-- CAMPOS DE CÁLCULO --}}
                                        <div class="col-md-6">
                                            <label class="form-label">Puntadas</label>
                                            <input type="number" class="form-control" name="puntadas" id="puntadas"
                                                placeholder="Ej: 25000">
                                        </div>

                                        <div class="col-md-6">
                                            <label class="form-label">Secuencias</label>
                                            <input type="number" class="form-control" name="secuencias" id="secuencias"
                                                placeholder="Ej: 10">
                                        </div>

                                        <div class="col-md-6">
                                            <label class="form-label">RPM</label>
                                            <input type="number" class="form-control" name="rpm" id="rpm"
                                                value="500">
                                        </div>

                                        <div class="col-md-6">
                                            <label class="form-label">Tiempo Estimado (minutos)</label>
                                            <input type="text" class="form-control" name="tiempo_ciclo"
                                                id="resultado" readonly>
                                        </div>

                                        {{-- Colores de hilo --}}
                                        <div class="col-12">
                                            <h5 class="fw-semibold text-secondary mb-3 text-center">
                                                Colores de Hilos
                                            </h5>

                                            <div class="row g-3">
                                                @foreach ($orden->detalles->pluck('color_hilo')->unique() as $color)
                                                    <div class="col-12">
                                                        <div class="card shadow-sm border-0 rounded-3 p-2 text-center">
                                                            <span class="fw-semibold"
                                                                style="color: {{ $color }}; font-size:18px;">
                                                                {{ $color }}
                                                            </span>
                                                        </div>
                                                    </div>
                                                @endforeach
                                            </div>
                                        </div>

                                        {{-- Notas --}}
                                        <div class="col-12">
                                            <label class="form-label">Notas adicionales</label>
                                            <textarea class="form-control" name="notaadicional" rows="3"></textarea>
                                        </div>

                                    </div>
                                </div>

                            </div>
                        </div>

                    </div>

                    {{-- BOTONES --}}
                    <div class="mt-5 text-center">
                        <button type="submit" class="btn btn-primary btn-lg px-5">
                            <i class="bi bi-save me-2"></i> Aprobar Diseño
                        </button>

                        <a href="{{ route('produccion.arte.index') }}" class="btn btn-outline-secondary btn-lg ms-2">
                            Cancelar
                        </a>
                    </div>
                </form>

            </div>
        </div>
    </div>

    {{-- SCRIPT: Cálculo y Previsualización --}}
    <script>
        function calcularTiempoBordado(puntadas, rpm, secuencias, tiempoCambio = 20, eficiencia = 0.85) {
            if (!puntadas || !rpm) return 0;
            const tiempoBase = puntadas / rpm;
            const tiempoSecuencias = secuencias * (tiempoCambio / 60);
            return (tiempoBase / eficiencia) + tiempoSecuencias;
        }

        document.querySelectorAll('#puntadas, #rpm, #secuencias').forEach(input => {
            input.addEventListener('input', () => {
                const puntadas = parseFloat(document.getElementById('puntadas').value);
                const rpm = parseFloat(document.getElementById('rpm').value);
                const secuencias = parseFloat(document.getElementById('secuencias').value);
                const tiempo = calcularTiempoBordado(puntadas, rpm, secuencias);


                document.getElementById('resultado').value = tiempo.toFixed(2);
            });
        });

        // Reemplazar imagen estática por previsualización
        document.getElementById('imagen_arte').addEventListener('change', function(event) {
            const preview = document.getElementById('preview');
            const imgEstatica = document.getElementById('imagen-estatica');
            const imgMensaje = document.getElementById('imagen_mensaje');

            preview.innerHTML = '';

            if (event.target.files.length > 0) {
                if (imgEstatica) imgEstatica.style.display = 'none';
                if (imgMensaje) imgMensaje.style.display = 'none';

                const file = event.target.files[0];
                const reader = new FileReader();

                reader.onload = e => {
                    preview.innerHTML = `
                        <img src="${e.target.result}"
                             class="img-fluid rounded-3 shadow-sm"
                             style="max-height: 400px; object-fit: contain;">
                    `;
                };

                reader.readAsDataURL(file);
            }
        });
    </script>

@endsection
