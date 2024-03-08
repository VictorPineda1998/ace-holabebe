<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Paciente;

class PacientesController extends Controller
{
    public function index()
    {   
        $user = auth()->user();
        $pacientes = Paciente::orderBy('created_at', 'desc')->get();
        return view('gestion-pacientes', compact('user'), compact('pacientes'));
    }

    public function store(Request $request, $id /* CreatesNewUsers $creator*/)
    {
        // Validación de datos
        $request->validate([
            'nombre' => 'required|string|max:255',
            'telefono' => 'required|string',
            'fecha_nacimiento' => 'required|date',
            'edad' => 'required|integer',
            'lugar_procedencia' => 'required|string|max:255',
        ]);

        // Procesar el número de teléfono para eliminar caracteres no numéricos
        $telefono = preg_replace("/[^0-9]/", "", $request->input('telefono'));

        // Crear un nuevo paciente con los datos del formulario
        $paciente = new Paciente([
            'nombre' => $request->input('nombre'),
            'telefono' => $telefono,
            'fecha_nacimiento' => $request->input('fecha_nacimiento'),
            'edad' => $request->input('edad'),
            'lugar_procedencia' => $request->input('lugar_procedencia'),
            'user_id' => $id,
        ]);

        // Guardar el paciente en la base de datos
        $paciente->save();

        // Redireccionar a la vista de detalles del paciente recién creado
        return redirect()->route('pacientes');
    }
    public function show($id)
    {
        // Obtener el paciente por su ID
        $paciente = Paciente::find($id);

        // Verificar si el paciente fue encontrado
        if (!$paciente) {
            // Redireccionar o mostrar un error, dependiendo de tus necesidades
            return redirect()->route('pacientes')->with('error', 'Paciente no encontrado');
        }

        // Si el paciente fue encontrado, mostrar la vista de detalles
        return view('pacientes-show', compact('paciente'));
    }


    public function update(Request $request, $id)
    {
        $validarDatos =$request->validate([
            'nombre' => 'required|string|max:255',
            'telefono' => 'required|string',
            'fecha_nacimiento' => 'required|date',
            'edad' => 'required|integer',
            'lugar_procedencia' => 'required|string|max:255',
        ]);

        // Procesar el número de teléfono para eliminar caracteres no numéricos
        $telefono = preg_replace("/[^0-9]/", "", $request->input('telefono'));
        $paciente = Paciente::findOrFail($request->id);
        // Crear un nuevo paciente con los datos del formulario
        $paciente->nombre = $validarDatos['nombre'];
        $paciente->telefono = $validarDatos['telefono'];
        $paciente->fecha_nacimiento = $validarDatos['fecha_nacimiento'];
        $paciente->edad = $validarDatos['edad'];
        $paciente->lugar_procedencia = $validarDatos['lugar_procedencia'];
        

        // Guardar el paciente en la base de datos
        $paciente->save();

        // Redireccionar a la vista de detalles del paciente recién creado
        return redirect()->route('pacientes');
    }

    public function destroy($id)
    {
        $paciente = Paciente::destroy($id);
        return redirect()->route('pacientes');
    }
}
