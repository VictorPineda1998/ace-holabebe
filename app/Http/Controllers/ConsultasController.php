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
        // Validación de datos
        $request->validate([
            'tipo_consulta' => 'required',
            'otro_tipo_consulta' => 'nullable|required_if:tipo_consulta,Otro', // Requerido solo si el tipo de consulta es "Otro"
        ]);

        // Obtén el paciente según su ID
        $paciente = Paciente::findOrFail($id);

        // Crea una nueva consulta y asigna los valores
        $consulta = new Consulta();
        $consulta->tipo_consulta = $request->input('tipo_consulta');
        $consulta->detalles_consulta = $request->input('otro_tipo_consulta');
        $consulta->estado = 'proxima';
        $consulta->paciente_id = $id;
        if($request->fecha){
            $consulta->fecha = $request->fecha;
        }
        // Puedes agregar otros campos según tu modelo

        // Guarda la consulta 
        $consulta->save();
        // Redirige con un mensaje de éxito
        return redirect()->route('pacientes.show', ['id' => $paciente->id]);
    }

    public function show($id)
    {
        // Obtener el paciente por su ID
        //     $paciente = Paciente::find($id);

        //     // Verificar si el paciente fue encontrado
        //     if (!$paciente) {
        //         // Redireccionar o mostrar un error, dependiendo de tus necesidades
        //         return redirect()->route('pacientes')->with('error', 'Paciente no encontrado');
        //     }

        //     // Si el paciente fue encontrado, mostrar la vista de detalles
        //     return view('pacientes-show', compact('paciente'));
    }


    public function update(Request $request, $id, $estado, $p_id)
    {
        $consultas = Consulta::where('paciente_id', $p_id)->orderBy('created_at', 'desc')->get();
        $paciente = Paciente::find($p_id);
        $consulta = Consulta::findOrfail($id);

        if ($estado == 'confirmar') {

            $consulta->estado = 'confirmada';
            $consulta->save();
        }

        if ($estado == 'cancelar') {

            $consulta->estado = 'cancelada';
            $consulta->save();
        }
        if ($estado == 'reprogramar') {
            
            if($request->fecha or $request->tipo_consulta){
                if($request->tipo_consulta){
                    $consulta->tipo_consulta = $request->tipo_consulta;
                }
                if($request->fecha){
                    $consulta->fecha = $request->fecha;
                }
                $consulta->estado = 'proxima';
                $consulta->save();
            }
        }

        return redirect()->route('pacientes.show', $p_id);
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

            $consulta->estado = 'confirmada';
            $consulta->save();
        }

        if ($estado == 'cancelar') {

            $consulta->estado = 'cancelada';
            $consulta->save();
        }
        if ($estado == 'reprogramar') {
            
            if($request->fecha or $request->tipo_consulta){
                if($request->tipo_consulta){
                    $consulta->tipo_consulta = $request->tipo_consulta;
                    $consulta->detalles_consulta = $request->input('otro_tipo_consulta');
                }
                if($request->fecha){
                    $consulta->fecha = $request->fecha;
                }
                $consulta->estado = 'proxima';
                $consulta->save();
            }
        }

        return redirect()->route('consultas_dia');
    }

}
