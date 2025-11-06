@extends('layouts.app')

@section('title', 'Editar Hilo')

@section('contenido')
    <div class="card shadow">
        <div class="card-header bg-info text-white">
            <h4>Editar Hilo</h4>
        </div>
        <div class="card-body">
            @include('app.administrador.inventario.formInventario', ['tiposHilo' => $tiposHilo, 'hilo' => $hilo])
        </div>
    </div>
@endsection
