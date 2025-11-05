@extends('layouts.app')

@section('title', 'Acceso Denegado')

@section('contenido')
    <div class="text-center mt-5">
        <img src="{{ asset('img/errors/403.webp') }}" alt="403" style="width:200px;">
        <h1 class="display-4 mt-3">403 - Acceso Denegado</h1>
        <p class="lead">Lo sentimos, no tienes permiso para acceder a esta página.</p>
        <a href="{{ route('index.dashboardGeneral') }}" class="btn btn-warning mt-3">
            <i class="fas fa-arrow-left"></i> Volver al Dashboard
        </a>
    </div>
@endsection
