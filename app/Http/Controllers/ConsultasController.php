<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Consulta;
use App\Models\Paciente;

class ConsultasController extends Controller
{

    public function store(Request $request, $id /* CreatesNewUsers $creator*/)
    {
        // Validación de datos
        $request->validate([
            'tipo_consulta' => 'required',
            'otro_tipo_consulta' => 'nullable|required_if:tipo_consulta,Otro', // Requerido solo si el tipo de consulta es "Otro"
        ],[
            'tipo_consulta.required' => 'El campo Tipo consulta es obligatorio.',
            'otro_tipo_consulta.required_if' => 'El campo Detalles es obligatorio.',
        ]);

        // Obtén el paciente según su ID
        $paciente = Paciente::findOrFail($id);

        // Contar cuántas consultas "Confirmadas" existen para la fecha proporcionada
        $fecha = $request->fecha;
        $consultaCount = Consulta::where('fecha', $fecha)
            ->where(function ($query) {
                $query->where('estado', 'Sin confirmar')
                      ->orWhere('estado', 'Confirmada');
            })
            ->count();

        // Verificar si el número de consultas es menor a 15
        if ($consultaCount < 15) {


            // Crea una nueva consulta y asigna los valores
            $consulta = new Consulta();
            $consulta->tipo_consulta = $request->input('tipo_consulta');
            $consulta->detalles_consulta = $request->input('otro_tipo_consulta');
            $consulta->estado = 'Sin confirmar';
            $consulta->paciente_id = $id;
            if ($request->fecha) {
                $consulta->fecha = $request->fecha;
            }
            // Puedes agregar otros campos según tu modelo

            // Guarda la consulta 
            $consulta->save();
            // Redirige 
            return redirect()->route('consultas.show', ['id' => $consulta, 'paciente'])->with('success', 'Consulta creada exitosamente');
        } else {
            // Retornar con un mensaje de error si ya hay 15 consultas para esa fecha
            return redirect()->back()->with('error', 'No se pueden crear más de 15 consultas para esta fecha');
        }
    }

    public function show($id, $lugar)
    {
        // Obtener el la consulta por su ID
        $consulta = Consulta::find($id);

        if ($consulta->triaje == true) {
            return redirect()->route('triajes.show', compact('id', 'lugar'));
        }
        // $consultas = Consulta::where('paciente_id', $consulta->paciente_id)->orderBy('created_at', 'desc')->get();
        $consultas = Consulta::where('paciente_id', $consulta->paciente_id)->orderBy('created_at', 'desc')->paginate(3);
        //  Mostrar la vista de detalles
        return view('consultas-show', compact('consulta', 'lugar', 'consultas'));
    }


    public function update(Request $request, $id, $estado, $p_id)
    {
        $consultas = Consulta::where('paciente_id', $p_id)->orderBy('created_at', 'desc')->get();
        $paciente = Paciente::find($p_id);
        $consulta = Consulta::findOrfail($id);

        if ($estado == 'confirmar') {

            $consulta->estado = 'Confirmada';
            $consulta->save();
        }

        if ($estado == 'cancelar') {

            $consulta->estado = 'Cancelada';
            $consulta->save();
        }
        if ($estado == 'reprogramar') {

            // Contar cuántas consultas "Confirmadas" existen para la fecha proporcionada
            $fecha = $request->fecha;
            $consultaCount = Consulta::where('fecha', $fecha)
                ->where(function ($query) {
                    $query->where('estado', 'Sin confirmar')
                          ->orWhere('estado', 'Confirmada');
                })
                ->count();

            // Verificar si el número de consultas es menor a 15
            if ($consultaCount < 15) {


                if ($request->fecha or $request->tipo_consulta) {
                    if ($request->tipo_consulta) {
                        $consulta->tipo_consulta = $request->tipo_consulta;
                        if ($request->tipo_consulta == 'Otro') {
                            $consulta->detalles_consulta = $request->input('otro_tipo_consulta') ?? 'Otro tipo de consulta';                        } else {
                            $consulta->detalles_consulta = null;
                        }
                    }
                    if ($request->fecha) {
                        $consulta->fecha = $request->fecha;
                    }
                    $consulta->estado = 'Sin confirmar';
                    $consulta->save();
                }

                return redirect()->route('pacientes.show', $p_id)->with('success', 'Consulta reprogramada exitosamente');
            } else {
                // Retornar con un mensaje de error si ya hay 15 consultas para esa fecha
                return redirect()->back()->with('error', 'No se pueden crear más de 15 consultas para esta fecha');
            }
        }
        return redirect()->route('pacientes.show', $p_id)->with('success', 'Consulta cancelada exitosamente');
    }

    public function destroy($id)
    {
        // $paciente = Paciente::destroy($id);
        // return redirect()->route('pacientes');
    }

    public function updateHoy(Request $request, $id, $estado)
    {
        $consulta = Consulta::findOrfail($id);

        if ($estado == 'confirmar') {
            $consulta->estado = 'Confirmada';
            $consulta->save();
        }

        if ($estado == 'cancelar') {
            $consulta->estado = 'Cancelada';
            $consulta->save();
        }
        if ($estado == 'reprogramar') {
            // Contar cuántas consultas "Confirmadas" existen para la fecha proporcionada
            $fecha = $request->fecha;
            $consultaCount = Consulta::where('fecha', $fecha)
                ->where('estado', 'Sin confirmar')
                ->count();

            // Verificar si el número de consultas es menor a 15
            if ($consultaCount < 15) {
                
                if ($request->fecha or $request->tipo_consulta) {
                    if ($request->tipo_consulta) {
                        $consulta->tipo_consulta = $request->tipo_consulta;
                        if ($request->tipo_consulta == 'Otro') {
                            $consulta->detalles_consulta = $request->input('otro_tipo_consulta') ?? 'Otro tipo de consulta';

                        } else {
                            $consulta->detalles_consulta = null;
                        }
                    }
                    if ($request->fecha) {
                        $consulta->fecha = $request->fecha;
                    }
                    $consulta->estado = 'Sin confirmar';
                    $consulta->save();
                }
                return redirect()->route('consultas_dia')->with('success', 'Consulta actualizada exitosamente');
            } else {
                // Retornar con un mensaje de error si ya hay 15 consultas para esa fecha
                return redirect()->back()->with('error', 'No se pueden crear más de 15 consultas para esta fecha');
            }
        }
        return redirect()->route('consultas_dia')->with('success', 'Consulta cancelada exitosamente');
    }

    public function consultas_dia()
    {
        $consultas = Consulta::where('fecha', now()->toDateString())
            ->where(function ($query) {
                $query->where('estado', 'Sin confirmar')
                    ->orWhere('estado', 'Confirmada');
            })->get();
        return view('lista-consultas-dia', compact('consultas'));
    }

    public function consultas_espera()
    {
        $consultas = Consulta::where('fecha', now()->toDateString())
            ->Where('estado', 'Confirmada')->get();
        return view('lista-consultas-espera', compact('consultas'));
    }
}
