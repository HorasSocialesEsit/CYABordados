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
                        <label class="form-label">RPM</label>
                        <input type="text" id="rpm" name="rpm" class="form-control @error('rpm') is-invalid @enderror"
                            value="{{ $data['rmp_maquina'] }}" readonly>
                        @error('rpm')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                    <div class="col-md-4 mb-3">
                        <label class="form-label">Puntadas</label>
                        <input type="text" id="puntadas" name="puntadas"
                            class="form-control @error('puntadas') is-invalid @enderror"
                            value="{{ $data['puntadas_maquina'] }}" readonly>
                        @error('puntadas')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                    <div class="col-md-4 mb-3">
                        <label class="form-label">Secuencias</label>
                        <input type="text" id="secuencia" name="secuencia"
                            class="form-control @error('secuencia') is-invalid @enderror"
                            value="{{ $data['secuencia_maquina'] }}" readonly>
                        @error('secuencia')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                    <div class="col-md-4 mb-3">
                        <label class="form-label">Unidades</label>
                        <input type="text" id="unidades" name="unidades"
                            class="form-control @error('unidades') is-invalid @enderror" value="{{ $data['cantidad'] }}" readonly>
                        @error('unidades')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                    {{-- Unidades producidas hoy --}}
                    <div class="col-md-4 mb-3">
                        <label class="form-label">Unidades producidas ahora</label>
                        <input type="text" id="producido" name="producido"
                            class="form-control @error('producido') is-invalid @enderror" min="1"
                            max="{{ $data['cantidad'] }}" >
                        @error('producido')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>


                    {{-- Pendiente --}}
                    <div class="col-md-4 mb-3">
                        <label class="form-label">Pendiente</label>
                        <input type="text" id="pendiente" name="pendiente"
                            class="form-control @error('pendiente') is-invalid @enderror" readonly>
                        @error('pendiente')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                </div>

                <div class="row">
                    <div class="col-md-4 mb-3">
                        <label class="form-label">Horas</label>
                        <input type="text" id="horas" name="horas" class="form-control @error('horas') is-invalid @enderror"
                            value="{{ $data['horas_laboradas'] }}" readonly>
                        @error('horas')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                    <div class="col-md-4 mb-3">
                        <label class="form-label">Minutos</label>
                        <input type="text" id="minutos" name="minutos"
                            class="form-control @error('minutos') is-invalid @enderror"
                            value="{{ $data['minutos_laboradas'] }}" readonly>
                        @error('minutos')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                    <div class="col-md-4 mb-3">
                        <label class="form-label">Cabezales</label>
                        <input type="text" id="cabezales" name="cabezales"
                            class="form-control @error('cabezales') is-invalid @enderror" value="{{ $data['cabezales'] }}"
                            readonly>
                        @error('cabezales')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                    <div class="col-md-4 mb-3">
                        <label class="form-label">Tiempo de Cambio</label>
                        <input type="text" id="tiempo_cambio" name="tiempo_cambio"
                            class="form-control @error('tiempo_cambio') is-invalid @enderror"
                            value="{{ $data['tiempo_de_cambio'] }}" readonly>
                        @error('tiempo_cambio')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                    <div class="col-md-4 mb-3">
                        <label class="form-label">Eficiencia</label>
                        <input type="text" id="eficiencia" name="eficiencia"
                            class="form-control @error('eficiencia') is-invalid @enderror" value="{{ $data['eficiencia'] }}"
                            readonly>
                        @error('eficiencia')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                </div>
                <h2>Resumen Calculado</h2>
                <div class="row">
                    <div class="col-md-4 mb-3">
                        <label class="form-label">Ciclos</label>
                        <input type="text" id="ciclos_calculo" name="ciclos_calculo"
                            class="form-control @error('ciclos_calculo') is-invalid @enderror" value="" readonly>
                        @error('ciclos_calculo')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                    <div class="col-md-4 mb-3">
                        <label class="form-label">Minutos Calculados de Orden</label>
                        <input type="number" id="minutos_calculo" name="minutos_calculo"
                            class="form-control @error('minutos_calculo') is-invalid @enderror" value="" readonly>
                        @error('minutos_calculo')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                    <div class="col-md-4 mb-3">
                        <label class="form-label">Dias Calculados de Orden</label>
                        <input type="text" id="dias_calculo" name="dias_calculo"
                            class="form-control @error('dias_calculo') is-invalid @enderror" value="" readonly>
                        @error('dias_calculo')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
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
        document.getElementById('horas').addEventListener('input', () => {
            const hora = document.getElementById('horas').value
            document.getElementById('minutos').value = (hora * 60).toFixed(0)

            // ejecutamos la funcion para actualizar toda la info
            calculoOrden()
        })
        const calculoOrden = () => {
            const cantidad = parseInt(document.getElementById('unidades').value)
            const cantidad_digitada = parseInt(document.getElementById('producido').value)

            const produccion_pendiente = cantidad - cantidad_digitada;
            document.getElementById('pendiente').value = produccion_pendiente || 0


            const cabezales = parseInt(document.getElementById('cabezales').value) // recuperamos cabezales
            const eficiencia = parseFloat(document.getElementById('eficiencia').value) // recuperamos eficiencia

            const tiempo_cambio = parseFloat(document.getElementById('tiempo_cambio').value) // recuperamos tiempo de cambio
            const rpm_maquina = parseInt(document.getElementById('rpm').value) // recuperamos rpm
            const puntadas_maquina = parseFloat(document.getElementById('puntadas').value) // recuperamos puntdas
            const secuencia_maquina = parseFloat(document.getElementById('secuencia').value) // recuperamos secuencia

            // recuperamos el tiempo
            const minutos = parseFloat(document.getElementById('minutos').value) // recuperamos tiempo en minutos
            // console.log({
            //     cabezales,
            //     eficiencia,
            //     tiempo_cambio,
            //     puntadas_maquina,
            //     secuencia_maquina,
            //     minutos
            // });

            // calculamos los ciclos
            const ciclos = parseFloat(cantidad_digitada / cabezales)
            // calculamos el tiempo base
            const tiempo_base = parseFloat(puntadas_maquina / rpm_maquina)
            // calculamos el tiempo secuencial
            const cal_tiempo_secuencial = tiempo_cambio / 60
            const tiempo_secuencial = parseFloat(secuencia_maquina * cal_tiempo_secuencial)
            // sacamos el total de minutos
            const total_minutos = (tiempo_base / eficiencia) + tiempo_secuencial;

            const total_minutos_orden_completa = total_minutos * ciclos;

            const dias_calculado = total_minutos_orden_completa / minutos;

            // console.log({
            //     ciclos,
            //     tiempo_base,
            //     cal_tiempo_secuencial,
            //     tiempo_secuencial,
            //     total_minutos,
            //     total_minutos_orden_completa,
            //     dias_calculado
            // });


            const ciclosValor = Math.ceil(ciclos);
            const minutosValor = Number(total_minutos_orden_completa).toFixed();
            const diasValor = Number(dias_calculado).toFixed(2);

            document.getElementById('ciclos_calculo').value = isNaN(ciclosValor) ? null : ciclosValor;
            document.getElementById('minutos_calculo').value = isNaN(minutosValor) ? null : minutosValor;
            document.getElementById('dias_calculo').value = isNaN(diasValor) ? null : diasValor;


        }
        const campos = ['producido', 'rpm', 'puntadas', 'secuencia', 'unidades'];
        campos.forEach(id => {
            document.getElementById(id).addEventListener("input", calculoOrden);
        });
        calculoOrden()
    </script>
@endsection