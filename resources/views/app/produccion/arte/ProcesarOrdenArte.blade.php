@extends('layouts.app')

@section('title', 'Procesar Arte - ' . $orden->codigo_orden)

@section('contenido')
    <div class="container-fluid py-5">
        <div class="card shadow-lg border-0 rounded-4 mx-auto" style="max-width: 1300px;">
            <div class="card-body p-5">

                {{-- Encabezado --}}
                <div class="text-center mb-4">
                    <h3 class="fw-bold text-dark">Procesar Arte - <span class="text-primary">{{ $orden->codigo_orden }}</span>
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
                    {{-- ID del arte/detalle --}}
                    <input type="hidden" name="detalle_id" value="{{ $detalle->orden_id ?? '' }}">



                    <div class="row g-4 align-items-start">

                        {{-- ==========================
                        SECCIÓN DE IMÁGENES (CARRUSEL)
                    =========================== --}}
                        <div class="col-lg-6 col-md-12">
                            <div class="border rounded-4 p-3 bg-light shadow-sm">
                                <h5 class="fw-semibold text-secondary mb-3 text-center">Imágenes del Diseño</h5>

                                @if ($detalle && $detalle->imagenes && $detalle->imagenes->count() > 0)
                                    <div id="carouselArte" class="carousel slide" data-bs-ride="carousel">
                                        <div class="carousel-inner">
                                            @foreach ($detalle->imagenes as $index => $img)
                                                <div class="carousel-item {{ $index === 0 ? 'active' : '' }}">
                                                    <img src="{{ asset('storage/' . $img->ruta_imagen) }}"
                                                        class="d-block w-100 rounded-3"
                                                        style="max-height: 420px; object-fit: contain;">
                                                </div>
                                            @endforeach
                                        </div>
                                        <button class="carousel-control-prev" type="button" data-bs-target="#carouselArte"
                                            data-bs-slide="prev">
                                            <span class="carousel-control-prev-icon" aria-hidden="true"></span>
                                            <span class="visually-hidden">Anterior</span>
                                        </button>
                                        <button class="carousel-control-next" type="button" data-bs-target="#carouselArte"
                                            data-bs-slide="next">
                                            <span class="carousel-control-next-icon" aria-hidden="true"></span>
                                            <span class="visually-hidden">Siguiente</span>
                                        </button>
                                    </div>
                                @else
                                    <div class="text-center">
                                        <img src="{{ asset('img/admin/undraw_profile.svg') }}"
                                            class="img-fluid rounded-3 shadow-sm mb-3"
                                            style="max-height: 400px; object-fit: contain;">
                                        <p class="text-muted">No hay imágenes registradas para este arte.</p>
                                    </div>
                                @endif

                                <div class="mt-3">
                                    <label class="form-label fw-semibold">Agregar nuevas imágenes (opcional)</label>
                                    <input type="file" id="imagenes" name="imagenes[]" class="form-control" multiple
                                        accept="image/*">
                                    <div id="preview" class="mt-3"></div>
                                    <small class="text-muted">Esta es a imagen a subir</small>
                                </div>
                            </div>
                        </div>

                        {{-- ==========================
                        DETALLES DEL DISEÑO
                    =========================== --}}
                        <div class="col-lg-6 col-md-12">
                            <div class="card border-dark h-100 shadow-sm">
                                <div class="card-header bg-dark text-white fw-bold">Detalle del Diseño / Bordado</div>
                                <div class="card-body">
                                    <div class="row g-3">

                                        <div class="col-md-6">
                                            <label class="form-label">Nombre del Arte</label>
                                            <input type="text" class="form-control" name="detalles[0][nombre_arte]"
                                                value="{{ $detalle->nombre_arte ?? '' }}" readonly>
                                        </div>

                                        <div class="col-md-6">
                                            <label class="form-label">Tamaño del Diseño</label>
                                            <input type="text" class="form-control" name="detalles[0][tamaño_diseño]"
                                                value="{{ $detalle->tamaño_diseño ?? '' }}" readonly>
                                        </div>

                                        <div class="col-md-6">
                                            <label class="form-label">Ubicación en la Prenda</label>
                                            <input type="text" class="form-control" name="detalles[0][ubicacion_prenda]"
                                                value="{{ $detalle->ubicacion_prenda ?? '' }}" readonly>
                                        </div>

                                        <div class="col-md-6">
                                            <label class="form-label">Tamaño de Cuello</label>
                                            <input type="text" class="form-control" name="detalles[0][tamaño_cuello]"
                                                value="{{ $detalle->tamaño_cuello ?? '' }}" readonly>
                                        </div>
                                        <div class="col-md-6">
                                            <label class="form-label">Cantidad</label>
                                            <input type="text" class="form-control" name="detalles[0][cantidad]"
                                                value="{{ $detalle->cantidad ?? '' }}" readonly>
                                        </div>

                                        {{-- CAMPOS DE CÁLCULO --}}
                                        <div class="col-md-6">
                                            <label class="form-label">Cantidad de Puntadas</label>
                                            <input type="number" class="form-control" id="puntadas"
                                                placeholder="Ej: 25000">
                                        </div>

                                        <div class="col-md-6">
                                            <label class="form-label">Cantidad de Secuencias</label>
                                            <input type="number" class="form-control" id="secuencias"
                                                placeholder="Ej: 10">
                                        </div>

                                        <div class="col-md-6">
                                            <label class="form-label">Velocidad de Máquina (RPM)</label>
                                            <input type="number" class="form-control" id="rpm" value="500">
                                        </div>

                                        <div class="col-md-6">
                                            <label class="form-label">Tiempo Estimado (minutos)</label>
                                            <input type="text" class="form-control" id="resultado" readonly>
                                        </div>

                                        <div class="col-12">
                                            <label class="form-label">Notas adicionales</label>
                                            <textarea class="form-control" name="detalles[0][notas]" rows="3"></textarea>
                                        </div>

                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    {{-- BOTONES --}}
                    <div class="mt-5 text-center">
                        <button type="submit" class="btn btn-primary btn-lg px-5">
                            <i class="bi bi-save me-2"></i>Aprobar Diseño
                        </button>
                        <a href="{{ route('produccion.arte.index') }}"
                            class="btn btn-outline-secondary btn-lg ms-2">Cancelar</a>
                    </div>

                </form>
            </div>
        </div>
    </div>

    {{-- ==========================
    SCRIPT: CÁLCULO EN MINUTOS
=========================== --}}
    <script>
        function calcularTiempoBordado(puntadas, rpm, secuencias, tiempoCambio = 20, eficiencia = 0.85) {
            if (!puntadas || !rpm) return 0;
            // Tiempo base (minutos)
            const tiempoBase = puntadas / rpm;
            // Secuencias: cada cambio de hilo ~20 segundos = 0.333 minutos
            const tiempoSecuencias = secuencias * (tiempoCambio / 60);
            // Total ajustado por eficiencia
            const tiempoTotal = (tiempoBase / eficiencia) + tiempoSecuencias;
            return tiempoTotal;
        }

        document.querySelectorAll('#puntadas, #rpm, #secuencias').forEach(input => {
            input.addEventListener('input', () => {
                const puntadas = parseFloat(document.getElementById('puntadas').value);
                const rpm = parseFloat(document.getElementById('rpm').value);
                const secuencias = parseFloat(document.getElementById('secuencias').value);
                const tiempo = calcularTiempoBordado(puntadas, rpm, secuencias);
                document.getElementById('resultado').value = tiempo > 0 ? `${tiempo.toFixed(2)} min` : '';
            });
        });

        document.getElementById('imagenes').addEventListener('change', function(event) {
            const preview = document.getElementById('preview');
            preview.innerHTML = '';

            [...event.target.files].forEach(file => {
                const reader = new FileReader();
                reader.onload = e => {
                    preview.innerHTML += `
                    <img src="${e.target.result}" class="img-fluid rounded mb-2"
                         style="max-height: 180px; object-fit: contain;">
                `;
                };
                reader.readAsDataURL(file);
            });
        });
    </script>
@endsection
