<?php

namespace App\Http\Controllers;

use App\Models\Consulta;
use App\Models\Diagnostico;
use Illuminate\Http\Request;

class DiagnosticosController extends Controller
{
    public function store(Request $request, $id)
    {
        
        $consulta = Consulta::findOrFail($id);

        $diagnostico = new Diagnostico();
        $diagnostico->diagnostico = $request->input('diagnostico');
        $diagnostico->receta_medica = $request->input('receta_medica');
        $diagnostico->consulta_id = $id;
        $diagnostico->usuario_id = $request->user()->id;
        $diagnostico->save();

        $consulta->estado = 'Finalizada';
        $consulta->diagnostico_id = $diagnostico->id;
        $consulta->save();
        
        $lugar = 'espera';
        return redirect()->route('consultas.show', ['id' => $consulta->id, 'lugar' => $lugar])
                                        ->with('success', 'Operación realizada correctamente.');
    }

    public function update(Request $request, $id)
    {
        
        $diagnostico = Diagnostico::findOrFail($id);

        $diagnostico->diagnostico = $request->input('diagnostico');
        $diagnostico->receta_medica = $request->input('receta_medica');
        
        $diagnostico->save();
        
        $consulta_id = $diagnostico->consulta_id;
        $lugar = 'espera';
        return redirect()->route('consultas.show', ['id' => $consulta_id, 'lugar' => $lugar]);
    }
}
