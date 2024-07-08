<?php

namespace App\Http\Controllers;

use App\Models\ConsumoHospital;
use App\Models\HojaHospital;
use App\Models\Hospitalizacion;
use App\Models\Paciente;
use App\Models\MongoHospitalizacion;
use Illuminate\Http\Request;

class HospitalizacionController extends Controller
{
    public function index(Request $request)
    {

        // Obtener el término de búsqueda del request
        $search = $request->input('search');

        // Modificar la consulta para incluir la búsqueda
        $pacientes = Paciente::when($search, function ($query, $search) {
            return $query->where('nombre', 'like', '%' . $search . '%');
        })
            ->orderBy('id', 'asc')
            ->paginate(5);

        $hospitalizaciones = Hospitalizacion::orderBy('id', 'desc')->get();

        return view('hospitalizaciones', compact('hospitalizaciones', 'pacientes'));
    }

    public function show(Request $request, $id)
    {
        // Obtener la hospitalización por su ID
        $hospitalizacion = Hospitalizacion::find($id);

        // Verificar si la hospitalización fue encontrada
        if (!$hospitalizacion) {
            return redirect()->route('hospitalizacion')->with('error', 'Hospitalización no encontrada');
        }

        $consumo = ConsumoHospital::where('hospitalizacion_id', $id)->first();

        if ($consumo) {
            $hoja = HojaHospital::where('hospitalizacion_id', $id)->first();

            if ($hoja) {

                $materiales = json_decode($hoja->materiales, true);
                $medicamentos = json_decode($hoja->medicamentos, true);
                $enfermeras = json_decode($hoja->guardias_henfermeria, true);
                $hospitalizacionSeccion = json_decode($hoja->hospitalizacion, true);
                $honorariosMedicos = json_decode($hoja->honorarios_medicos, true);
                return view('hospitalizacion-show', compact('hospitalizacion', 'materiales', 'medicamentos', 'enfermeras', 'hospitalizacionSeccion', 'honorariosMedicos'));
            } else {
            // Decodifica los campos JSON
            $materiales = json_decode($consumo->materiales, true);
            $medicamentos = json_decode($consumo->medicamentos, true);
            $enfermeras = json_decode($consumo->guardias_henfermeria, true);
            $hospitalizacionSeccion = json_decode($consumo->hospitalizacion, true);
            $honorariosMedicos = json_decode($consumo->honorarios_medicos, true);
            return view('hospitalizacion-show', compact('hospitalizacion', 'materiales', 'medicamentos', 'enfermeras', 'hospitalizacionSeccion', 'honorariosMedicos'));
            }
        } else {

            
                // Recoger inputs de búsqueda
                $searchMediMongoHospitalizacion = $request->input('searchMediMongoHospitalizacion');
                $searchMateMongoHospitalizacion = $request->input('searchMateMongoHospitalizacion');

                // Consulta para Medicamentos
                // $medicamentosMongoHospitalizacion = MongoHospitalizacion::where('tipo', 'medicamento')
                //     ->when($searchMediMongoHospitalizacion, function ($query, $searchMediMongoHospitalizacion) {
                //         return $query->where('concepto', 'like', '%' . $searchMediMongoHospitalizacion . '%');
                //     })->paginate(3);

                $medicamentosMongoHospitalizacionAll = MongoHospitalizacion::where('tipo', 'medicamento')
                    ->when($searchMediMongoHospitalizacion, function ($query, $searchMediMongoHospitalizacion) {
                        return $query->where('concepto', 'like', '%' . $searchMediMongoHospitalizacion . '%');
                    })
                    ->get();

                $fechaActual = now()->timestamp * 1000; // Obtener la fecha actual en milisegundos

                $medicamentosFiltrados = $medicamentosMongoHospitalizacionAll
                    ->groupBy('concepto') // Agrupar por concepto
                    ->map(function ($group) use ($fechaActual) {
                        return $group->sortByDesc('fecha') // Ordenar por fecha descendente
                            ->first(function ($item) use ($fechaActual) {
                                return strtotime($item->fecha) * 1000 <= $fechaActual; // Filtrar por fecha menor o igual a la actual
                            });
                    })
                    ->filter() // Eliminar elementos null
                    ->values(); // Obtener los valores del map como una colección

                $currentPage = \Illuminate\Pagination\Paginator::resolveCurrentPage() ?: 1;
                $itemsPerPage = 3;

                $collection = new \Illuminate\Support\Collection($medicamentosFiltrados);

                $medicamentosMongoHospitalizacion = new \Illuminate\Pagination\LengthAwarePaginator(
                    $collection->forPage($currentPage, $itemsPerPage),
                    $collection->count(),
                    $itemsPerPage,
                    $currentPage,
                    ['path' => \Illuminate\Pagination\Paginator::resolveCurrentPath()]
                );


                // Consulta para Materiales
                // $materialesMongoHospitalizacion = MongoHospitalizacion::where('tipo', 'material')
                //     ->when($searchMateMongoHospitalizacion, function ($query, $searchMateMongoHospitalizacion) {
                //         return $query->where('concepto', 'like', '%' . $searchMateMongoHospitalizacion . '%');
                //     })->paginate(3);

                $materialesMongoHospitalizacionAll = MongoHospitalizacion::where('tipo', 'material')
                    ->when($searchMateMongoHospitalizacion, function ($query, $searchMateMongoHospitalizacion) {
                        return $query->where('concepto', 'like', '%' . $searchMateMongoHospitalizacion . '%');
                    })
                    ->get();

                $fechaActual2 = now()->timestamp * 1000; // Obtener la fecha actual en milisegundos

                $materialsFiltrados = $materialesMongoHospitalizacionAll
                    ->groupBy('concepto') // Agrupar por concepto
                    ->map(function ($group2) use ($fechaActual2) {
                        return $group2->sortByDesc('fecha') // Ordenar por fecha descendente
                            ->first(function ($item2) use ($fechaActual2) {
                                return strtotime($item2->fecha) * 1000 >= $fechaActual2; // Filtrar por fecha menor o igual a la actual
                            });
                    })
                    ->filter() // Eliminar elementos null
                    ->values(); // Obtener los valores del map como una colección

                $currentPage2 = \Illuminate\Pagination\Paginator::resolveCurrentPage() ?: 1;
                $itemsPerPage2 = 3;

                $collection2 = new \Illuminate\Support\Collection($materialsFiltrados);

                $materialesMongoHospitalizacion = new \Illuminate\Pagination\LengthAwarePaginator(
                    $collection2->forPage($currentPage2, $itemsPerPage2),
                    $collection2->count(),
                    $itemsPerPage2,
                    $currentPage2,
                    ['path' => \Illuminate\Pagination\Paginator::resolveCurrentPath()]
                );


                // Si la hospitalización fue encontrada, mostrar la vista de detalles
                return view('hospitalizacion-show', compact('hospitalizacion', 'medicamentosMongoHospitalizacion', 'materialesMongoHospitalizacion'));
            }
        
    }

    public function create($id)
    {
        $paciente = Paciente::findOrFail($id);
        return view('hospitalizacion-create', compact('paciente'));
    }

    public function store(Request $request, $id)
    {
        // Validación de datos
        $request->validate([
            'habitacion' => 'required|string|max:255',
            'servicio' => 'required|string|max:255',
            'procedimiento' => 'required|string|max:255',
            'medico_tratante' => 'required|string|max:255',
            'dietas' => 'required|string|max:255',
        ]);

        $hospitalizacion = new Hospitalizacion();
        $hospitalizacion->habitacion = $request->habitacion;
        $hospitalizacion->servicio = $request->servicio;
        $hospitalizacion->procedimiento = $request->procedimiento;
        $hospitalizacion->medico_tratante = $request->medico_tratante;
        $hospitalizacion->dietas = $request->dietas;
        $hospitalizacion->paciente_id = $id;
        $hospitalizacion->save();
        return redirect()->route('hospitalizacion')->with('success', 'Hospitalizacion registrada exitosamente');
    }

    public function update(Request $request, $id)
    {
        $hospitalizacion = Hospitalizacion::find($id);
        $hospitalizacion->habitacion = $request->habitacion;
        $hospitalizacion->servicio = $request->servicio;
        $hospitalizacion->procedimiento = $request->procedimiento;
        $hospitalizacion->medico_tratante = $request->medico_tratante;
        $hospitalizacion->dietas = $request->dietas;
        // $hospitalizacion->fecha_ingreso = $request->fecha_ingreso;
        $hospitalizacion->save();
        return redirect()->route('hospitalizacion.show', ['id' => $hospitalizacion->id])->with('success', 'Hospitalizacion actualizada exitosamente');
    }
    public function destroy($id){
        $hospitalizacion = Hospitalizacion::destroy($id);
        return redirect()->route('hospitalizacion')->with('success', 'Hospitalizacion eliminada correctamente.');
    }
}
