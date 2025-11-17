@extends('layouts.app')

@section('title', 'Editar Maquina')

@section('contenido')
    <div class="card shadow">
        <div class="card-header bg-info text-white">
            <h4>Editar Maquina</h4>
        </div>
        <div class="card-body">
            @include('app.configuraciones.maquinas.formMaquina', ['maquina' => $maquina])
        </div>
    </div>
@endsection
