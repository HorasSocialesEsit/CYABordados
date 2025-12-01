@extends('layouts.app')

@section('title', 'Editar Proveedor')

@section('contenido')
    <div class="card shadow">
        <div class="card-header bg-info text-white">
            <h4>Editar Proveedor</h4>
        </div>
        <div class="card-body">
            @include('app.proveedor.formProveedor', ['proveedor' => $proveedor])
        </div>
    </div>
@endsection
