@extends('layouts.app')

@section('title', 'Crear Hilo')

@section('contenido')
    <div class="card shadow">
        <div class="card-header bg-primary text-white">
            <h4>Nuevo Hilo</h4>
        </div>
        <div class="card-body">
            @include('app.inventario.formInventario')
        </div>
    </div>
@endsection
