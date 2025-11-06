<?php

namespace App\Http\Controllers;

use App\Models\Cliente;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class ClienteController extends Controller
{
    /**
     * Listado de clientes.
     */
    public function index()
    {
        $clientes = Cliente::orderBy('nombre')->get();

        return view('app.clientes.index', compact('clientes'));
    }

    /**
     * Formulario de creación.
     */
    public function create()
    {
        return view('app.clientes.create');
    }

    /**
     * Guardar un nuevo cliente.
     */
    public function store(Request $request)
    {
        $request->validate([
            'nombre' => 'required|string|max:100',
            'correo' => 'required|email|unique:clientes,correo',
            'telefono' => 'nullable|string|max:25',
            'telefono_alt' => 'nullable|string|max:25',
            'direccion' => 'nullable|string|max:255',
            'municipio' => 'nullable|string|max:100',
            'departamento' => 'nullable|string|max:100',
            'pais' => 'nullable|string|max:100',
            'tipo_cliente' => 'required|string|max:50',
            'nit' => 'nullable|string|max:30',
            'dui' => 'nullable|string|max:15',
            'nrc' => 'nullable|string|max:20',
        ]);

        $codigo = 'CLI-'.strtoupper(Str::random(5));

        Cliente::create(array_merge($request->all(), [
            'codigo' => $codigo,
        ]));

        return redirect()->route('clientes.index')->with('success', 'Cliente registrado correctamente.');
    }

    /**
     * Editar cliente.
     */
    public function edit($id)
    {
        $cliente = Cliente::findOrFail($id);

        return view('app.clientes.edit', compact('cliente'));
    }

    /**
     * Actualizar cliente.
     */
    public function update(Request $request, $id)
    {
        $cliente = Cliente::findOrFail($id);

        $request->validate([
            'nombre' => 'required|string|max:100',
            'correo' => 'required|email|unique:clientes,correo,'.$cliente->id,
            'telefono' => 'nullable|string|max:25',
            'telefono_alt' => 'nullable|string|max:25',
            'direccion' => 'nullable|string|max:255',
            'municipio' => 'nullable|string|max:100',
            'departamento' => 'nullable|string|max:100',
            'pais' => 'nullable|string|max:100',
            'tipo_cliente' => 'required|string|max:50',
            'nit' => 'nullable|string|max:30',
            'dui' => 'nullable|string|max:15',
            'nrc' => 'nullable|string|max:20',
        ]);

        $cliente->update($request->all());

        return redirect()->route('clientes.index')->with('success', 'Cliente actualizado correctamente.');
    }

    /**
     * Eliminar cliente.
     */
    public function destroy($id)
    {
        Cliente::destroy($id);

        return redirect()->route('clientes.index')->with('success', 'Cliente eliminado correctamente.');
    }
}
