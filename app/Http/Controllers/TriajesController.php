<?php

namespace App\Http\Controllers;

use App\Models\Consulta;
use App\Models\Triaje;
use Illuminate\Http\Request;

class TriajesController extends Controller
{
    public function index()
    {   
        // $user = auth()->user();
        // $triaje = Paciente::orderBy('created_at', 'desc')->get();
        // return view('gestion-pacientes', compact('user'), compact('pacientes'));
    }

    public function store(Request $request, $id)
    {
        $data = $request->all();
        // Procesar los datos para almacenarlos como JSON
        $observaciones = [
            'estado_conciencia' => $data['estado_conciencia'] ?? null,
            'hemorragia' => $data['hemorragia'] ?? null,
            'crisis_convulsivas' => $data['crisis_convulsivas'] ?? null,
            'respiración' => $data['respiración'] ?? null,
            'color_de_piel' => $data['color_de_piel'] ?? null
        ];
    
        $interrogatorio = [
            'sangrado_transvaginal' => $data['sangrado_transvaginal'] ?? null,
            'crisis_convulsiva' => $data['crisis_convulsiva'] ?? null,
            'cefalea' => $data['cefalea'] ?? null,
            'acufenos_fosfenos' => $data['acufenos_fosfenos'] ?? null,
            'epigastralgia_amaurosis' => $data['epigastralgia_amaurosis'] ?? null,
            'sindrome_febril' => $data['sindrome_febril'] ?? null,
            'salida_de_liquido_amniotico' => $data['salida_de_liquido_amniotico'] ?? null,
            'motilidad_fetal' => $data['motilidad_fetal'] ?? null,
            'emfermedades_cronicas' => $data['emfermedades_cronicas'] ?? null
        ];
        $signosVitales = [
            'hipertension' => $data['hipertension'] ?? null,
            'hipotension' => $data['hipotension'] ?? null,
            'frecuencia_cardiaca' => $data['frecuencia_cardiaca'] ?? null,
            'indice_de_choque' => $data['indice_de_choque'] ?? null,
            'frecuencia_respiratoria' => $data['frecuencia_respiratoria'] ?? null,
            'temperatura' => $data['temperatura'] ?? null

        ];
        $bienestarFetal = [
            'frecuencia_cardiaca_fetal' => $data['frecuencia_cardiaca_fetal'] ?? null,
            'contracciones_uterinas' => $data['contracciones_uterinas'] ?? null
        ];
        $tomaSignosVitales = [
            'tension_arterial_toma' => $data['tension_arterial_toma'] ?? null,
            'frecuencia_cardiaca_toma' => $data['frecuencia_cardiaca_toma'] ?? null,
            'talla' => $data['talla'] ?? null,
            'peso' => $data['peso'] ?? null,
            'frecuencia_respiratoria_toma' => $data['frecuencia_respiratoria_toma'] ?? null,
            'temperatura_toma' => $data['temperatura_toma'] ?? null,
            'frecuencia_cardiaca_fetal_toma' => $data['frecuencia_cardiaca_fetal_toma'] ?? null
        ];
    
        // Agregar los datos para signos_vitales y bienestar_fetal
        

        $triaje = new Triaje([
            'observaciones' => json_encode($observaciones),
            'interrogatorio' => json_encode($interrogatorio),
            'signos_vitales' => json_encode($signosVitales),
            'bienestar_fetal' => json_encode($bienestarFetal),
            'toma_signos_vitales' => json_encode($tomaSignosVitales),
            'resultado' => $data['resultado'] ?? null,
            'consulta_id' => $id,
            'usuario_id' => auth()->user()->id,
        ]);
        $triaje->save();

        $consulta = Consulta::findOrFail($id);
        $consulta->triaje_id = $triaje->id;
        $consulta->save();
    
        return redirect()->route('consultas_dia');
        
        // return view('welcome', compact('observaciones'));
    }
    public function show($id, $lugar)
    {
        $consulta = Consulta::find($id);
        $triaje = Triaje::find($consulta->triaje_id);
        $triaje->observaciones = json_decode($triaje->observaciones);
        $triaje->interrogatorio = json_decode($triaje->interrogatorio);
        $triaje->signosVitales = json_decode($triaje->signos_vitales);
        $triaje->bienestarFetal = json_decode($triaje->bienestar_fetal);
        $triaje->tomaSignosVitales = json_decode($triaje->toma_signos_vitales);

        return view('consultas-show', compact('consulta', 'lugar', 'triaje'));
        // Obtener el paciente por su ID
        // $paciente = Paciente::find($id);
        // // Obtener las consultas del paciente por su ID
        // $consultas = Consulta::where('paciente_id', $id)->orderBy('created_at', 'desc')->get();

        // // Verificar si el paciente fue encontrado
        // if (!$paciente) {
        //     // Redireccionar o mostrar un error, dependiendo de tus necesidades
        //     return redirect()->route('pacientes')->with('error', 'Paciente no encontrado');
        // }

        // // Si el paciente fue encontrado, mostrar la vista de detalles
        // return view('pacientes-show', compact('paciente', 'consultas'));
    }


    public function update(Request $request, $id)
    {
        // $validarDatos =$request->validate([
        //     'nombre' => 'required|string|max:255',
        //     'telefono' => 'required|string',
        //     'fecha_nacimiento' => 'required|date',
        //     'edad' => 'required|integer',
        //     'lugar_procedencia' => 'required|string|max:255',
        // ]);

        // // Procesar el número de teléfono para eliminar caracteres no numéricos
        // $telefono = preg_replace("/[^0-9]/", "", $request->input('telefono'));
        // $paciente = Paciente::findOrFail($request->id);
        // // Crear un nuevo paciente con los datos del formulario
        // $paciente->nombre = $validarDatos['nombre'];
        // $paciente->telefono = $validarDatos['telefono'];
        // $paciente->fecha_nacimiento = $validarDatos['fecha_nacimiento'];
        // $paciente->edad = $validarDatos['edad'];
        // $paciente->lugar_procedencia = $validarDatos['lugar_procedencia'];
        

        // // Guardar el paciente en la base de datos
        // $paciente->save();
        
        // $paciente = Paciente::find($id);
        
        // // Obtener las consultas del paciente por su ID
        // $consultas = Consulta::where('paciente_id', $id)->orderBy('created_at', 'desc')->get();
        // // Redireccionar a la vista de detalles del paciente recién creado
        
        // // Si el paciente fue encontrado, mostrar la vista de detalles
        // return view('pacientes-show', compact('paciente', 'consultas'));
    }

    public function destroy($id)
    {
        // $paciente = Paciente::destroy($id);
        // return redirect()->route('pacientes');
    }
}
