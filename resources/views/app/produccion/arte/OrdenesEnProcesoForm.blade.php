@extends('layouts.app')

@section('title', 'Producción de Orden')

@section('contenido')
    <div class="card shadow">
        <div class="card-header bg-primary text-white">
            <h4>Registrar Producción – Orden #{{ $data['id'] }}</h4>
        </div>

        <div class="card-body">

            <form action="{{ route('ordenProceso.update', $data['id']) }}" method="POST">
                @csrf
                @method('PUT')

                <div class="row">
                    <div class="col-md-4 mb-3">
                        <label class="form-label">Horas Trabajadas</label>
                        <input type="number" id="horas" name="horas" class="form-control" value="8" min="1" max="8">
                    </div>

                    {{-- mostramos la cantidad del pedido --}}
                    <div class="col-md-4 mb-3">
                        <label class="form-label">Unidades Totales</label>
                        <input type="number" id="cantidad_total" name="cantidad_total" class="form-control"
                            value="{{ $data['cantidad'] ?? 0 }}" readonly>
                    </div>

                    {{-- solicitamos todo lo que se producio --}}
                    <div class="col-md-4 mb-3">
                        <label class="form-label">Unidades producidas ahora</label>
                        <input type="number" id="producido" name="producido"
                            class="form-control @error('producido') is-invalid @enderror" min="1"
                            max="{{ $data['cantidad'] }}">
                        @error('producido')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    {{-- mostramos el pendiente es decir total - realizado --}}
                    <div class="col-md-4 mb-3">
                        <label class="form-label">Pendiente</label>
                        <input type="number" id="pendiente" class="form-control" readonly>
                    </div>

                </div>

                <div class="row">

                    {{-- Máquinas --}}
                    <div class="col-md-4 mb-3">
                        <label class="form-label">N° de máquinas</label>
                        <input type="number" id="maquinas" name="maquinas" class="form-control"
                            value="{{ $data['n_maquina'] }}" min="1" readonly>
                    </div>

                    {{-- Cabezales --}}
                    <div class="col-md-4 mb-3">
                        <label class="form-label">Cabezales por máquina</label>
                        <input type="number" id="cabezales" name="cabezales" class="form-control"
                            value="{{ $data['cabezales'] }}" min="1" readonly>
                    </div>

                    {{-- Minutos por ciclo --}}
                    <div class="col-md-4 mb-3">
                        <label class="form-label">Minutos por ciclo</label>
                        <input type="number" id="minutos_ciclo" name="minutos_ciclo" class="form-control"
                            value="{{ $data['minutos_ciclo'] }}" min="1">
                    </div>

                </div>
                <div class="row">

                    <div class="col-md-4 mb-3">
                        <label class="form-label">Ciclos necesarios</label>
                        <input type="number" id="ciclos" class="form-control" readonly>
                    </div>

                    <div class="col-md-4 mb-3">
                        <label class="form-label">Minutos totales</label>
                        <input type="number" id="minutos_totales" class="form-control" readonly>
                    </div>

                    <div class="col-md-4 mb-3">
                        <label class="form-label">Horas Invertidas</label>
                        <input type="text" id="horas_final" class="form-control" readonly>
                    </div>

                </div>

                <div class="d-flex justify-content-end mt-4">
                    <a href="{{ route('ordenProceso.index') }}" class="btn btn-secondary me-2">Cancelar</a>
                    <button type="submit" class="btn btn-primary">Guardar Producción</button>
                </div>

            </form>

        </div>
    </div>

    <script>
        const campos = ['producido', 'maquinas', 'cabezales', 'minutos_ciclo', 'horas'];
        campos.forEach(id => {
            document.getElementById(id).addEventListener("keyup", calcular);
        });

        function calcular() {
            const total = parseInt(document.getElementById('cantidad_total').value);
            const producido = parseInt(document.getElementById('producido').value || 0);
            const maquinas = parseInt(document.getElementById('maquinas').value);
            const cabezales = parseInt(document.getElementById('cabezales').value);
            const minCiclo = parseFloat(document.getElementById('minutos_ciclo').value);
            const horas = parseFloat(document.getElementById('horas').value);

            const minutos_invertido =
                horas > 8 ? 8 * 60 :
                    horas < 1 ? 1 * 60 :
                        horas * 60;

            let pendiente = total - producido;
            document.getElementById('pendiente').value = pendiente;

            let ciclos = Math.ceil(total / cabezales);
            document.getElementById('ciclos').value = ciclos;


            const minutosTotales = ciclos * minutos_invertido;
            document.getElementById('minutos_totales').value = minutosTotales;

            let dias = (minutosTotales / 60).toFixed(2);
            document.getElementById('horas_final').value = dias;
        }

    </script>

@endsection