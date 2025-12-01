@extends('layouts.app')

@section('title', 'Crear Proveedor')

@section('contenido')
    <div class="card shadow">
        <div class="card-header bg-primary text-white">
            <h4>Nuevo Proveedor</h4>
        </div>
        <div class="card-body">
            @include('app.proveedor.formProveedor')
        </div>
    </div>
@endsection
