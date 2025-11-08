<?php

namespace App\Http\Controllers;

use App\Models\Cliente;
use App\Models\Departamentos;
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
        $departamentos = Departamentos::all();
        return view('app.clientes.create', compact('departamentos'));
    }

    /**
     * Guardar un nuevo cliente.
     */
    public function store(Request $request)
    {
        // agregamos mensajes personalizados, nit, dui, nrc, telefono y tambien el alternativa con expresiones regulares
        $request->validate([
            'nombre' => 'required|string|max:100',
            'correo' => 'required|email|unique:clientes,correo',

            'telefono' => [
                'nullable',
                'digits:8',
                'regex:/^[0-9]{8}$/'
            ],
            'telefono_alt' => [
                'nullable',
                'digits:8',
                'regex:/^[0-9]{8}$/'
            ],

            'direccion' => 'nullable|string|max:255',
            'id_municipio' => 'required|exists:municipios,id',
            'pais' => 'nullable|string|max:100',
            'tipo_cliente' => 'required|string|max:50',

            'nit' => [
                'nullable',
                'digits:14',
                'unique:clientes,nit',
                'regex:/^[0-9]{14}$/'
            ],
            'dui' => [
                'nullable',
                'digits:9',
                'unique:clientes,dui',
                'regex:/^[0-9]{9}$/'
            ],
            'nrc' => [
                'nullable',
                'digits:14',
                'unique:clientes,nrc',
                'regex:/^[0-9]{14}$/'
            ],
        ], [
            'nombre.required' => 'El nombre del cliente es obligatorio.',
            'nombre.max' => 'El nombre no debe superar los 100 caracteres.',

            'correo.required' => 'El correo electrónico es obligatorio.',
            'correo.email' => 'El correo electrónico no tiene un formato válido.',
            'correo.unique' => 'Este correo ya está registrado en el sistema.',

            'telefono.digits' => 'El teléfono debe contener exactamente 8 dígitos.',
            'telefono.regex' => 'El teléfono solo debe contener números, sin guiones ni espacios.',

            'telefono_alt.digits' => 'El teléfono alternativo debe contener exactamente 8 dígitos.',
            'telefono_alt.regex' => 'El teléfono alternativo solo debe contener números, sin guiones ni espacios.',

            'id_municipio.required' => 'Debe seleccionar un municipio.',
            'id_municipio.exists' => 'El municipio seleccionado no es válido.',

            'tipo_cliente.required' => 'Debe seleccionar el tipo de cliente.',

            'nit.digits' => 'El NIT debe contener exactamente 14 dígitos sin guiones.',
            'nit.regex' => 'El NIT solo debe contener números, sin letras ni guiones.',
            'nit.unique' => 'Este NIT ya está registrado en el sistema.',

            'dui.digits' => 'El DUI debe contener exactamente 9 dígitos sin guiones.',
            'dui.regex' => 'El DUI solo debe contener números, sin letras ni guiones.',
            'dui.unique' => 'Este DUI ya está registrado en el sistema.',

            'nrc.digits' => 'El NRC debe contener exactamente 14 dígitos sin guiones.',
            'nrc.regex' => 'El NRC solo debe contener números, sin letras ni guiones.',
            'nrc.unique' => 'Este NRC ya está registrado en el sistema.',
        ]);

        $codigo = 'CLI-' . strtoupper(Str::random(5));

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
            'correo' => 'required|email|unique:clientes,correo,' . $cliente->id,
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
