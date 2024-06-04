<?php

namespace App\Http\Controllers;

use App\Models\Consulta;
use Illuminate\Http\Request;
use App\Models\Paciente;

class PacientesController extends Controller
{
    public function index(Request $request)
    {
        $user = auth()->user();
        // Obtener el término de búsqueda del request
        $search = $request->input('search');

        // Modificar la consulta para incluir la búsqueda
        $pacientes = Paciente::when($search, function ($query, $search) {
            return $query->where('nombre', 'like', '%' . $search . '%');
        })
            ->orderBy('id', 'asc')
            ->paginate(15);
        // $pacientes = Paciente::orderBy('created_at', 'desc')->paginate(2);
        // $pacientes = Paciente::orderBy('created_at', 'asc')->paginate(1);
        return view('gestion-pacientes', compact('user'), compact('pacientes'));
    }

    public function store(Request $request, $id)
    {
        // Validación de datos
        $request->validate([
            'nombre' => 'required|string|max:255',
            'apellidoP' => 'required|string|max:255',
            'apellidoM' => 'required|string|max:255',
            'telefono' => 'required|string|min:10|max:10',
            'fecha_nacimiento' => 'required|date',
            // 'edad' => 'required|integer',
            'lugar_procedencia' => 'required|string|max:255',
        ], [
            'telefono' => 'El numero de telefono debe contener 10 digitos'
        ]);

        // Procesar el número de teléfono para eliminar caracteres no numéricos
        $telefono = preg_replace("/[^0-9]/", "", $request->input('telefono'));

        // Crear un nuevo paciente con los datos del formulario
        $paciente = new Paciente([
            'nombre' => $request->input('nombre'),
            'apellido_P' => $request->input('apellidoP'),
            'apellido_M' => $request->input('apellidoM'),
            'telefono' => $telefono,
            'fecha_nacimiento' => $request->input('fecha_nacimiento'),
            // 'edad' => $request->input('edad'),
            'lugar_procedencia' => $request->input('lugar_procedencia'),
            'user_id' => $id,
        ]);

        // Guardar el paciente en la base de datos
        $paciente->save();

        // Redireccionar a la vista de detalles del paciente recién creado
        return redirect()->route('pacientes')->with('success', 'Paciente registrado correctamente.');
    }
    public function show($id)
    {
        // Obtener el paciente por su ID
        $paciente = Paciente::find($id);
        // Obtener las consultas del paciente por su ID
        // $consultas = Consulta::where('paciente_id', $id)->orderBy('created_at', 'desc')->get();
        $consultas = Consulta::where('paciente_id', $id)->orderBy('created_at', 'desc')->paginate(8);


        // Verificar si el paciente fue encontrado
        if (!$paciente) {
            // Redireccionar o mostrar un error, dependiendo de tus necesidades
            return redirect()->route('pacientes')->with('error', 'Paciente no encontrado');
        }

        // Si el paciente fue encontrado, mostrar la vista de detalles
        return view('pacientes-show', compact('paciente', 'consultas'));
    }


    public function update(Request $request, $id)
    {
        $validarDatos = $request->validate([
            'nombre' => 'required|string|max:255',
            'apellidoP' => 'required|string|max:255',
            'apellidoM' => 'required|string|max:255',
            'telefono' => 'required|string|min:10|max:10',
            'fecha_nacimiento' => 'required|date',
            // 'edad' => 'required|integer',
            'lugar_procedencia' => 'required|string|max:255',
        ], [
            'telefono' => 'El numero de telefono debe contener 10 digitos'
        ]);

        // Procesar el número de teléfono para eliminar caracteres no numéricos
        $telefono = preg_replace("/[^0-9]/", "", $request->input('telefono'));
        $paciente = Paciente::findOrFail($request->id);
        // Crear un nuevo paciente con los datos del formulario
        $paciente->nombre = $validarDatos['nombre'];
        $paciente->apellido_P = $validarDatos['apellidoP'];
        $paciente->apellido_M = $validarDatos['apellidoM'];
        $paciente->telefono = $validarDatos['telefono'];
        $paciente->fecha_nacimiento = $validarDatos['fecha_nacimiento'];
        // $paciente->edad = $validarDatos['edad'];
        $paciente->lugar_procedencia = $validarDatos['lugar_procedencia'];


        // Guardar el paciente en la base de datos
        $paciente->save();

        $paciente = Paciente::find($id);

        // Obtener las consultas del paciente por su ID
        // $consultas = Consulta::where('paciente_id', $id)->orderBy('created_at', 'desc')->get();
        $consultas = Consulta::where('paciente_id', $id)->orderBy('created_at', 'desc')->paginate(8);

        // Redireccionar a la vista de detalles del paciente recién creado

        // Si el paciente fue encontrado, mostrar la vista de detalles
        return view('pacientes-show', compact('paciente', 'consultas'))->with('success', 'Paciente actualizado correctamente.');
    }

    public function destroy($id)
    {
        $paciente = Paciente::destroy($id);
        return redirect()->route('pacientes')->with('success', 'Paciente eliminado correctamente.');
    }
}
