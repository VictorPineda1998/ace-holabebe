<?php

namespace App\Http\Controllers;

use App\Models\Colposcoia;
use App\Models\Colposcopia;
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
        $consulta = Consulta::findOrFail($id);
        // Procesar los datos para almacenarlos como JSON
        if ($consulta->tipo_consulta == 'Control prenatal'){
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
        }
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
            'observaciones' => isset($observaciones) ? json_encode($observaciones) : null,
            'interrogatorio' => isset($interrogatorio) ? json_encode($interrogatorio) : null,
            'signos_vitales' => isset($signosVitales) ? json_encode($signosVitales) : null,
            'bienestar_fetal' => isset($bienestarFetal) ? json_encode($bienestarFetal) : null,
            'toma_signos_vitales' => json_encode($tomaSignosVitales),
            'resultado' => $data['resultado'] ?? null,
            'consulta_id' => $consulta->id,
            'usuario_id' => auth()->user()->id,
        ]);
        $triaje->save();

        $consulta->triaje_id = $triaje->id;
        $consulta->estado = 'Confirmada';
        $consulta->save();
        $lugar = 'hoy';
        return redirect()->route('consultas.show', ['id' => $consulta->id, 'lugar' => $lugar]);
        
        // return view('welcome', compact('observaciones'));
    }
    public function show($id, $lugar)
    {
        $consulta = Consulta::find($id);
        
        $triaje = Triaje::find($consulta->triaje_id);
        if($consulta->colposcopia == true){
            $triaje_id = $triaje->id;
            return redirect()->route('colposcopia.show', compact('id', 'lugar', 'triaje_id'));
        }
        if($consulta->triaje_id !=0){
            $triaje->observaciones = json_decode($triaje->observaciones);
            $triaje->interrogatorio = json_decode($triaje->interrogatorio);
            $triaje->signosVitales = json_decode($triaje->signos_vitales);
            $triaje->bienestarFetal = json_decode($triaje->bienestar_fetal);
        }        
        $triaje->tomaSignosVitales = json_decode($triaje->toma_signos_vitales);
        // $consultas = Consulta::where('paciente_id', $consulta->paciente_id)->orderBy('created_at', 'desc')->get();
        $consultas = Consulta::where('paciente_id', $consulta->paciente_id)->orderBy('created_at', 'desc')->paginate(8);
        return view('consultas-show', compact('consulta', 'lugar', 'triaje', 'consultas'));
    }


    public function update(Request $request, $id)
    {
        $triaje = Triaje::find($id);
        $data = $request->all();
        $tomaSignosVitales = [
            'tension_arterial_toma' => $data['tension_arterial_toma'] ?? null,
            'frecuencia_cardiaca_toma' => $data['frecuencia_cardiaca_toma'] ?? null,
            'talla' => $data['talla'] ?? null,
            'peso' => $data['peso'] ?? null,
            'frecuencia_respiratoria_toma' => $data['frecuencia_respiratoria_toma'] ?? null,
            'temperatura_toma' => $data['temperatura_toma'] ?? null,
            'frecuencia_cardiaca_fetal_toma' => $data['frecuencia_cardiaca_fetal_toma'] ?? null
        ];
        $triaje->toma_signos_vitales = json_encode($tomaSignosVitales);
        $triaje->save();

        return redirect()->route('consultas_dia');
    }

    public function destroy($id)
    {
        // $paciente = Paciente::destroy($id);
        // return redirect()->route('pacientes');
    }
}
