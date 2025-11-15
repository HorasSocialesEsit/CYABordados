@extends('layouts.app')

@section('title', 'Crear Maquina')

@section('contenido')
    <div class="card shadow">
        <div class="card-header bg-primary text-white">
            <h4>Nueva Maquina</h4>
        </div>
        <div class="card-body">
            @include('app.configuraciones.maquinas.formMaquina')
        </div>
    </div>
@endsection
