<?php

namespace App\Http\Controllers;

use App\Models\Archivo;
use App\Models\Paciente;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class ArchivosController extends Controller
{
    //
    public function index($id)
    {   
        $archivos = Archivo::where('paciente_id', $id)->orderBy('created_at', 'desc')->get();
        // $user = auth()->user();
        $paciente = Paciente::find($id);
        return view('archivos-show', compact('archivos', 'paciente'));
    }

    public function store(Request $request, $id)
    {
        $request->validate([
            'archivo' => 'required|mimes:pdf|max:2048', // Validación de tipo y tamaño del archivo
        ]);

        $file = $request->file('archivo');
        $nombre = $request->nombre == null ? $file->getClientOriginalName() : $request->nombre;
        $filePath = $file->store('public/files'); // Almacenar el archivo 
        $array = explode('public', $filePath);

        $pdf = new Archivo();
        $pdf->nombre = $nombre;
        $pdf->tipo = $request->tipo;
        $pdf->ruta = 'storage'.$array[1];
        $pdf->paciente_id = $id;
        $pdf->save();
        return redirect()->route('archivos', $id);
    }

    public function update(Request $request, $id, $paciente_id)
    {
        $file = $request->file('archivoUpdate');

        if($file){
            $request->validate([
                'archivoUpdate' => 'required|mimes:pdf|max:2048', // Validación de tipo y tamaño del archivo
            ]);
        }
        
       if($request->nombreUpdate){
        $nombre = $request->nombreUpdate;
       }else if($file){
        $nombre = $file->getClientOriginalName();
       }
        if($file){
        $filePath = $file->store('public/files'); // Almacenar el archivo 
        $array = explode('public', $filePath);
        }

        $pdf = Archivo::findOrFail($id);
        if($request->tipoUpdate){$pdf->tipo = $request->tipoUpdate;}
        if(isset($nombre)){$pdf->nombre = $nombre;}
        
        if($file){$pdf->ruta = 'storage'.$array[1];}
        $pdf->save();
        return redirect()->route('archivos', $paciente_id);
    }

    public function destroy($id, $paciente_id)
    {
        // Lógica para eliminar al archivo
        $archivo = Archivo::find($id);
        $ruta = str_replace('storage', 'public', $archivo->ruta);
        Storage::delete($ruta);
        $archivo->delete();
        return redirect()->route('archivos', $paciente_id);
    }
}
