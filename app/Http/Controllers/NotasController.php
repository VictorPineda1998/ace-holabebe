<?php

namespace App\Http\Controllers;

use App\Models\Consulta;
use App\Models\Nota;
use Illuminate\Http\Request;

class NotasController extends Controller
{
    public function store(Request $request, $id)
    {
        
        $consulta = Consulta::findOrFail($id);

        $nota = new Nota();
        $nota->contenido = $request->input('contenido');

        $nota->consulta_id = $id;
        $nota->save();

        $consulta->nota_id = $nota->id;
        $consulta->save();
        
        $lugar = 'hoy';
        return redirect()->route('consultas.show', ['id' => $consulta->id, 'lugar' => $lugar]);
    }

    public function update(Request $request, $id)
    {
        
        $nota = Nota::findOrFail($id);

        $nota->contenido = $request->input('contenido');
        
        $nota->save();
        
        $consulta_id = $nota->consulta_id;
        $lugar = 'hoy';
        return redirect()->route('consultas.show', ['id' => $consulta_id, 'lugar' => $lugar]);
    }
}
