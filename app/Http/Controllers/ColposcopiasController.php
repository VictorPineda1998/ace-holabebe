<?php

namespace App\Http\Controllers;

use App\Models\Colposcopia;
use App\Models\Consulta;
use App\Models\Triaje;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class ColposcopiasController extends Controller
{
    //
    public function store(Request $request, $id)
    {
        $data = $request->all();
        $consulta = Consulta::findOrFail($id);

        // Decodifica la imagen de base64
        // $imagenCodificada = $data['imagen'];
        // // Separa la parte de la cadena que contiene la imagen codificada en base64
        // $partes = explode(";base64,", $imagenCodificada);
        // $imagenDecodificada = base64_decode($partes[1]);

        // // Guarda la imagen en la carpeta de almacenamiento
        // $rutaImagen = 'public/imagenes_colposcopia/' . uniqid() . '.png'; // Genera un nombre de archivo único
        // Storage::put($rutaImagen, $imagenDecodificada);
        // $array = explode('public', $rutaImagen);

        $ahf = [
            'cancer' => $data['cancer'] ?? ' ',
            'diabetes_heredica' => $data['diabetes_heredica'] ?? ' '
        ];

        $app = [
            'has' => $data['has'] ?? ' ',
            'cardiopatia' => $data['cardiopatia'] ?? ' ',
            'tabaquismo' => $data['has'] ?? ' ',
            'hipertension' => $data['hipertension'] ?? ' ',
            'alcoholismo' => $data['alcoholismo'] ?? ' ',
            'diabetes' => $data['diabetes'] ?? ' ',
            'alergicos' => $data['alergicos'] ?? ' ',
            'otros' => $data['otros'] ?? ' '
        ];

        $ago = [
            'menarca' => $data['menarca'] ?? ' ',
            'ritmo' => $data['ritmo'] ?? ' ',
            'ivsa' => $data['ivsa'] ?? ' ',
            'pSexuales' => $data['pSexuales'] ?? ' ',
            'gestas' => $data['gestas'] ?? ' ',
            'partos' => $data['partos'] ?? ' ',
            'cesareas' => $data['cesareas'] ?? ' ',
            'abortos' => $data['abortos'] ?? ' ',
            'pf' => $data['pf'] ?? ' ',
            'fur' => $data['fur'] ?? ' ',
            'citologia' => $data['citologia'] ?? ' ',
            'otros_antecendes' => $data['otros_antecendes'] ?? ' ',
            'capt' => $data['capt'] ?? ' ',
            'tx' => $data['tx'] ?? ' ',
            'resultados' => $data['resultados'] ?? ' ',
            'cuales' => $data['cuales'] ?? ' ', 'tx' => $data['tx'] ?? ' ',
            'fecha_de_toma' => $data['fecha_de_toma'] ?? ' ',
            'fecha_de_interpretacion' => $data['fecha_de_interpretacion'] ?? ' ',
            'fecha_de_envio' => $data['fecha_de_envio'] ?? ' '
        ];

        $ago2 = [
            'diagnostico_citologico' => $data['diagnostico_citologico'] ?? ' ',
            'sintomatologia' => $data['sintomatologia'] ?? ' ',
            'comentarios' => $data['comentarios'] ?? ' ',
            'indice_colposcopico_REID' => $data['indice_colposcopico_REID'] ?? ' ',
            'color' => $data['color'] ?? ' ',
            'margen' => $data['margen'] ?? ' ',
            'tincion_con_yodo' => $data['tincion_con_yodo'] ?? ' ',
            'vasos' => $data['vasos'] ?? ' ',
            'biopsia' => $data['biopsia'] ?? ' ',
            'radio' => $data['radio'] ?? ' ',
            'cepillado_endocervical' => $data['cepillado_endocervical'] ?? ' ',
            'dx' => $data['dx'] ?? ' ',
            'grado' => $data['grado'] ?? ' ',
            'otros_dx' => $data['otros_dx'] ?? ' ',
            'observaciones' => $data['observaciones'] ?? ' ',
            'proxima_cita' => $data['proxima_cita'] ?? ' ',
            'coordenadas' => $data['coordenadas'] ?? ' '
        ];

        $colposcopia = new Colposcopia([
            'ahf' => json_encode($ahf),
            'app' => json_encode($app),
            'ago' => json_encode($ago),
            'ago2' => json_encode($ago2),
            // 'ruta' => 'storage'.$array[1],
            'consulta_id' => $consulta->id,
            'usuario_id' => $request->user()->id,
        ]);
        $colposcopia->save();

        $consulta->colposcopia_id = $colposcopia->id;
        $consulta->save();
        $lugar = 'espera';
        return redirect()->route('consultas.show', compact('id', 'lugar'));
    }
    public function show($id, $lugar, $triaje_id)
    {
        $consulta = Consulta::find($id);
        $triaje = Triaje::find($triaje_id);
        if ($consulta->triaje_id != 0) {
            $triaje->observaciones = json_decode($triaje->observaciones);
            $triaje->interrogatorio = json_decode($triaje->interrogatorio);
            $triaje->signosVitales = json_decode($triaje->signos_vitales);
            $triaje->bienestarFetal = json_decode($triaje->bienestar_fetal);
        }
        $triaje->tomaSignosVitales = json_decode($triaje->toma_signos_vitales);
        $colposcopia = Colposcopia::find($consulta->colposcopia_id);

        $colposcopia->ahf = json_decode($colposcopia->ahf);
        $colposcopia->app = json_decode($colposcopia->app);
        $colposcopia->ago = json_decode($colposcopia->ago);
        $colposcopia->ago2 = json_decode($colposcopia->ago2);

        return view('consultas-show', compact('consulta', 'lugar', 'triaje', 'colposcopia'));
    }

    public function update(Request $request, $id)
    {
        $data = $request->all();
        $colposcopia = Colposcopia::findOrFail($id);

        $ahf = [
            'cancer' => $data['cancer'] ?? ' ',
            'diabetes_heredica' => $data['diabetes_heredica'] ?? ' '
        ];

        $app = [
            'has' => $data['has'] ?? ' ',
            'cardiopatia' => $data['cardiopatia'] ?? ' ',
            'tabaquismo' => $data['has'] ?? ' ',
            'hipertension' => $data['hipertension'] ?? ' ',
            'alcoholismo' => $data['alcoholismo'] ?? ' ',
            'diabetes' => $data['diabetes'] ?? ' ',
            'alergicos' => $data['alergicos'] ?? ' ',
            'otros' => $data['otros'] ?? ' '
        ];

        $ago = [
            'menarca' => $data['menarca'] ?? ' ',
            'ritmo' => $data['ritmo'] ?? ' ',
            'ivsa' => $data['ivsa'] ?? ' ',
            'pSexuales' => $data['pSexuales'] ?? ' ',
            'gestas' => $data['gestas'] ?? ' ',
            'partos' => $data['partos'] ?? ' ',
            'cesareas' => $data['cesareas'] ?? ' ',
            'abortos' => $data['abortos'] ?? ' ',
            'pf' => $data['pf'] ?? ' ',
            'fur' => $data['fur'] ?? ' ',
            'citologia' => $data['citologia'] ?? ' ',
            'otros_antecendes' => $data['otros_antecendes'] ?? ' ',
            'capt' => $data['capt'] ?? ' ',
            'tx' => $data['tx'] ?? ' ',
            'resultados' => $data['resultados'] ?? ' ',
            'cuales' => $data['cuales'] ?? ' ', 'tx' => $data['tx'] ?? ' ',
            'fecha_de_toma' => $data['fecha_de_toma'] ?? ' ',
            'fecha_de_interpretacion' => $data['fecha_de_interpretacion'] ?? ' ',
            'fecha_de_envio' => $data['fecha_de_envio'] ?? ' '
        ];

        $ago2 = [
            'diagnostico_citologico' => $data['diagnostico_citologico'] ?? ' ',
            'sintomatologia' => $data['sintomatologia'] ?? ' ',
            'comentarios' => $data['comentarios'] ?? ' ',
            'indice_colposcopico_REID' => $data['indice_colposcopico_REID'] ?? ' ',
            'color' => $data['color'] ?? ' ',
            'margen' => $data['margen'] ?? ' ',
            'tincion_con_yodo' => $data['tincion_con_yodo'] ?? ' ',
            'vasos' => $data['vasos'] ?? ' ',
            'biopsia' => $data['biopsia'] ?? ' ',
            'radio' => $data['radio'] ?? ' ',
            'cepillado_endocervical' => $data['cepillado_endocervical'] ?? ' ',
            'dx' => $data['dx'] ?? ' ',
            'grado' => $data['grado'] ?? ' ',
            'otros_dx' => $data['otros_dx'] ?? ' ',
            'observaciones' => $data['observaciones'] ?? ' ',
            'proxima_cita' => $data['proxima_cita'] ?? ' ',
            'coordenadas' => $data['coordenadas'] ?? ' '
        ];

        $colposcopia->ahf = json_encode($ahf);
        $colposcopia->app = json_encode($app);
        $colposcopia->ago = json_encode($ago);
        $colposcopia->ago2 = json_encode($ago2);

        $colposcopia->save();

        $id = $colposcopia->consulta_id;        
        $lugar = 'espera';
        
        return redirect()->route('consultas.show', compact('id', 'lugar'));
    }
}
