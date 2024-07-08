<?php

namespace App\Http\Controllers;

use App\Models\ConsumoHospital;
use App\Models\HojaHospital;
use Illuminate\Http\Request;

class HojaHospitalController extends Controller
{
    public function store(Request $request, $hospitalizacion_id)
    {    
        $consumoHospital = ConsumoHospital::where('hospitalizacion_id', $hospitalizacion_id)->first();
        
        $guardias_henfermeria = json_decode($consumoHospital->guardias_henfermeria, true);
        $hospitalizacion = json_decode($consumoHospital->hospitalizacion, true);
        $honorarios_medicos = json_decode($consumoHospital->honorarios_medicos, true);

        $i = 1;

        foreach ($guardias_henfermeria as &$guardia) {
            $nombreEnfermeras = 'Enfermeras' . $i;
            $guardia['precio'] = $request->$nombreEnfermeras;
            $i++;
        }
        $i = 1;
        foreach ($hospitalizacion as &$hospital) {
            $nombreHospitalizacion = 'Hospitalizacion' . $i;
            $hospital['precio'] = $request->$nombreHospitalizacion; 
            $i++;
        }
        $i = 1;
        foreach ($honorarios_medicos as &$honorario) {
            $nombreHonorariosMedicos = 'HonorariosMedicos' . $i;
            $honorario['precio'] = $request->$nombreHonorariosMedicos; 
            $i++;
        }

        $hojaHospital = new HojaHospital();
        $hojaHospital->hospitalizacion_id = $hospitalizacion_id;
        $hojaHospital->materiales = $consumoHospital->materiales;
        $hojaHospital->medicamentos = $consumoHospital->medicamentos;
        $hojaHospital->guardias_henfermeria = json_encode($guardias_henfermeria);
        $hojaHospital->hospitalizacion = json_encode($hospitalizacion);
        $hojaHospital->honorarios_medicos = json_encode($honorarios_medicos);

        $hojaHospital->save();

        return redirect()->back()->with('success', 'Datos guardados correctamente.');
    }
}
