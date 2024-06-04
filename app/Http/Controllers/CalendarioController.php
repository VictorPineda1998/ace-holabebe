<?php

namespace App\Http\Controllers;

use App\Models\Consulta;
use App\Models\Paciente;
use Carbon\Carbon;
use Illuminate\Http\Request;

class CalendarioController extends Controller
{
    public function index(Request $request)
    {
        $search = $request->input('searchCalendario');
        if ($search) {
            $pacientes = Paciente::when($search, function ($query, $search) {
                return $query->where('nombre', 'like', '%' . $search . '%');
            })->orderBy('id', 'asc')->paginate(5);
        } else {
            $pacientes = false;
        }

        $all_Consultas = Consulta::where(function ($query) {
            $query->where('estado', 'Sin confirmar')
                ->orWhere('estado', 'Confirmada');
        })->orderBy('fecha')->get();

        $consultas_por_dia = [];
        foreach ($all_Consultas as $consulta) {
            $fecha = Carbon::parse($consulta->fecha)->format('Y-m-d');
            if (!isset($consultas_por_dia[$fecha])) {
                $consultas_por_dia[$fecha] = [];
            }
            $consultas_por_dia[$fecha][] = $consulta;
        }

        $consultas = [];
        $i = 0;

        foreach ($consultas_por_dia as $fecha => $consultas_del_dia) {

            $cantidad_consultas = 0;

            foreach ($consultas_del_dia as $consulta) {

                $cantidad_consultas++;

                $consultas[] = [
                    'paciente_id' => $consulta->paciente_id,
                    'title'       => $consulta->paciente->nombre . ' ' . $consulta->paciente->apellido_P . ' ' . $consulta->paciente->apellido_M,
                    'start'       => $consulta->fecha,
                    'end'         => $consulta->fecha,                    
                    'url'         => route('pacientes.show', $consulta->paciente_id)  // Añadir la URL de redirección
                ];

                if ($cantidad_consultas === 15) {
                    $consultas[] = [
                        'paciente_id' => ' ',
                        'start' => $consulta->fecha,
                        'color' => 'red'
                    ];
                }
            }
            if ($cantidad_consultas != 15) {
                $consultas[] = [
                    'paciente_id' => ' ',
                    'start' => $consulta->fecha,
                    'color' => 'transparent'
                ];
            }
        }
        // echo '<pre>';
        // echo json_encode($all_Consultas, JSON_PRETTY_PRINT);
        // echo '</pre>';
        // echo '<pre>'; 
        // echo json_encode($consultas, JSON_PRETTY_PRINT);
        // echo '</pre>';
        // dd($consultas);
        return view('calendario-show', compact('consultas', 'pacientes'));
    }

    public function store(Request $request, $id )
    {
        // Validación de datos
        $request->validate([
            'tipo_consulta' => 'required',
            'otro_tipo_consulta' => 'nullable|required_if:tipo_consulta,Otro', // Requerido solo si el tipo de consulta es "Otro"
        ], [
            'tipo_consulta.required' => 'El campo Tipo consulta es obligatorio.',
            'otro_tipo_consulta.required_if' => 'El campo Detalles es obligatorio.',
        ]);
    
        $consultaPacienteCount = Consulta::where('paciente_id', $id)
            ->where(function ($query) {
                $query->where('estado', 'Sin confirmar')
                    ->orWhere('estado', 'Confirmada');
            })->count();

            if($consultaPacienteCount != 0){
                return redirect()->back()->with('error', "Ya existe un consulta proxima para este paciente");
            }
        // Contar cuántas consultas "Confirmadas" existen para la fecha proporcionada
        $fecha = $request->fecha;
        $consultaCount = Consulta::where('fecha', $fecha)
            ->where(function ($query) {
                $query->where('estado', 'Sin confirmar')
                    ->orWhere('estado', 'Confirmada');
            })->count();

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

            // Guarda la consulta 
            $consulta->save();
            // Redirige 
            $fechaActual = Carbon::now()->format('Y-m-d');
            if ($consulta->fecha == $fechaActual) {
                return redirect()->route('consultas.show', ['id' => $consulta, 'paciente'])->with('success', 'Consulta creada exitosamente');
            } else {
                return redirect()->route('calendario')->with('success', 'Consulta creada exitosamente');
            }
        } else {
            // Retornar con un mensaje de error si ya hay 15 consultas para esa fecha
            $fecha = Carbon::parse($fecha)->format('d-m-Y');
            return redirect()->back()->with('error', "No se pueden crear más de 15 consultas para esta fecha: {$fecha}");
        }
    }
}
