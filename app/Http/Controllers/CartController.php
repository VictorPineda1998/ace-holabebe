<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Cart;
use App\Models\ConsumoHospital;
use App\Models\Hospitalizacion;
use App\Models\MongoHospitalizacion;
use Carbon\Carbon;
use Hamcrest\Core\HasToString;

class CartController extends Controller
{
    public function add(Request $request)
    {
        $medicamento = MongoHospitalizacion::find($request->medicamento_id);
        $material = MongoHospitalizacion::find($request->material_id);

        if (!$medicamento && !$material) {
            return back()->with('error', 'Medicamento o material encontrado.');
        }

        $cart = Cart::firstOrCreate(
            ['hospitalizacion_id' => $request->hospitalizacion_id],
            ['items' => []]
        );

        $items = $cart->items;

        if ($medicamento) {
            $stockMedi = (int)$medicamento->cantidad - (int)$request->cantidad;
            if ($stockMedi > 0) {
                if (isset($items[$medicamento->id])) {
                    $items[$medicamento->id]['cantidad'] += $request->cantidad;
                } else {
                    $items[$medicamento->id] = [
                        "id" => $medicamento->id,
                        "nombre" => $medicamento->concepto,
                        "cantidad" => $request->cantidad,
                        "tipo" => 'medicamento',
                        "precio" => $medicamento->costoP,
                        "fecha" => date('d-m-Y'),
                    ];
                }
                $nuevaCantidadMedi = (int)$medicamento->cantidad - (int)$request->cantidad;
                $medicamento->cantidad = strval($nuevaCantidadMedi); // Convertir el resultado a cadena
                $medicamento->save();
            } else {
                return back()->with('error', 'Cantidad insuficiente de medicamento.');
            }
        }


        if ($material) {
            $stockMate = (int)$material->cantidad - (int)$request->cantidad;
            if ($stockMate > 0) {
                if (isset($items[$material->id])) {
                    $items[$material->id]['cantidad'] += $request->cantidad;
                } else {
                    $items[$material->id] = [
                        "id" => $material->id,
                        "nombre" => $material->concepto,
                        "cantidad" => $request->cantidad,
                        "tipo" => 'material',
                        "precio" => $material->costoP,
                        "fecha" => date('d-m-Y'),
                    ];
                }

                $nuevaCantidad = (int)$material->cantidad - (int)$request->cantidad;
                $material->cantidad = strval($nuevaCantidad); // Convertir el resultado a cadena
                $material->save();
            } else {
                return back()->with('error', 'Cantidad insuficiente de material.');
            }
        }

        $cart->items = $items;
        $cart->save();

        return back()->with('success', 'Artículo(s) añadido(s) al carrito.');
    }
    public function addEnfermera(Request $request)
    {
        $cart = Cart::firstOrCreate(
            ['hospitalizacion_id' => $request->hospitalizacion_id],
            ['items' => []]
        );

        $items = $cart->items;

        if (isset($items[$request->nombreEnfermera])) {
            $items[$request->nombreEnfermera]['cantidad'] += $request->cantidadEnfermera;
        } else {
            $items[$request->nombreEnfermera] = [
                "nombre" => $request->nombreEnfermera,
                "turno" => $request->turnoEnfermera,
                "cantidad" => $request->cantidadEnfermera,
                "tipo" => "Enfermera",
                "fecha" => date('d-m-Y'),
            ];
        }
        $cart->items = $items;
        $cart->save();

        return back()->with('success', 'Enfermera(s) añadida(s) al carrito.');
    }

    public function addArticuloHospi(Request $request)
    {
        $cart = Cart::firstOrCreate(
            ['hospitalizacion_id' => $request->hospitalizacion_id],
            ['items' => []]
        );

        $items = $cart->items;

        if (isset($items[$request->articuloHospi])) {
            $items[$request->articuloHospi]['cantidadArticuloHospi'] += $request->cantidadArticuloHospi;
        } else {
            $items[$request->articuloHospi] = [
                "nombre" => $request->articuloHospi,
                "cantidadArticuloHospi" => $request->cantidadArticuloHospi,
                "tipo" => "articuloHospi",
                "fecha" => date('d-m-Y'),
            ];
        }
        $cart->items = $items;
        $cart->save();

        return back()->with('success', 'Concepto(s) añadido(s) al carrito.');
    }

    public function addArticuloHonorario(Request $request)
    {
        $cart = Cart::firstOrCreate(
            ['hospitalizacion_id' => $request->hospitalizacion_id],
            ['items' => []]
        );

        $items = $cart->items;

        if (isset($items[$request->articuloHonorario])) {
            $items[$request->articuloHonorario]['cantidadArticuloHonorario'] += $request->cantidadArticuloHonorario;
        } else {
            $items[$request->articuloHonorario] = [
                "nombre" => $request->articuloHonorario,
                "cantidadArticuloHonorario" => $request->cantidadArticuloHonorario,
                "tipo" => "articuloHonorario",
                "fecha" => date('d-m-Y'),
            ];
        }
        $cart->items = $items;
        $cart->save();

        return back()->with('success', 'Concepto(s) añadido(s) al carrito.');
    }

    public function show($hospitalizacion_id)
    {
        $cart = Cart::where('hospitalizacion_id', $hospitalizacion_id)->first();

        if (!$cart) {
            return back()->with('error', 'No se encontraron artículos en el carrito.');
        }

        return view('cart-show', [
            'items' => $cart->items
        ], compact('hospitalizacion_id'));
    }

    public function confirmar($hospitalizacion_id)
    {
        $hospitalizacionId = $hospitalizacion_id;

        // Obtén el carrito correspondiente a la hospitalización
        $cart = Cart::where('hospitalizacion_id', $hospitalizacionId)->first();
        $hospitalizacion1 = Hospitalizacion::find($hospitalizacionId);


        if (!$cart) {
            return back()->with('error', 'No hay artículos en el carrito para esta hospitalización.');
        }

        $articulos = $cart->items;

        $materiales = [];
        $medicamentos = [];
        $enfermeras = [];
        $hospitalizacion = [];
        $honorariosMedicos = [];

        foreach ($articulos as $articulo) {
            switch ($articulo['tipo']) {
                case 'material':
                    $materiales[] = $articulo;
                    break;
                case 'medicamento':
                    $medicamentos[] = $articulo;
                    break;
                case 'Enfermera':
                    $enfermeras[] = $articulo;
                    break;
                case 'articuloHospi':
                    $hospitalizacion[] = $articulo;
                    break;
                case 'articuloHonorario':
                    $honorariosMedicos[] = $articulo;
                    break;
            }
        }

        ConsumoHospital::create([
            'hospitalizacion_id' => $hospitalizacionId,
            'materiales' => json_encode($materiales),
            'medicamentos' => json_encode($medicamentos),
            'guardias_henfermeria' => json_encode($enfermeras),
            'hospitalizacion' => json_encode($hospitalizacion),
            'honorarios_medicos' => json_encode($honorariosMedicos),
        ]);

        $cart->delete();
        $hospitalizacion1->fecha_alta = Carbon::now();
        $hospitalizacion1->save();

        return redirect()->route('hospitalizacion.show', ['id' => $hospitalizacion_id])->with('success', 'Consumo de hospitalización guardado correctamente.');
    }

    public function update(Request $request, $nombre, $hospitalizacion_id)
    {
        $cart = Cart::where('hospitalizacion_id', $hospitalizacion_id)->first();
        $items = $cart->items;

        $diferencia = 0;
        if ($items[$nombre]['tipo'] == 'material') {
            $material = MongoHospitalizacion::find($items[$nombre]['id']);

            if ($request->cantidadUpdate == 0) {                
                $mateUpdate = (int)$material->cantidad  + $items[$nombre]['cantidad'];
                $material->cantidad = strval($mateUpdate); // Convertir el resultado a cadena
                $material->save();
                unset($items[$nombre]);
            } else if ($items[$nombre]['cantidad'] != $request->cantidadUpdate){
                if ($items[$nombre]['cantidad'] > $request->cantidadUpdate) {
                    $diferencia = $items[$nombre]['cantidad'] - $request->cantidadUpdate;
                    $mateUpdate = (int)$material->cantidad + $diferencia;
                    // if (($items[$nombre]['cantidad'] - $diferencia) == 0) {
                    //     unset($items[$nombre]);
                    // }
                } else if ($items[$nombre]['cantidad'] < $request->cantidadUpdate) {
                    $diferencia =$request->cantidadUpdate - $items[$nombre]['cantidad'];
                    if($diferencia > (int)$material->cantidad){
                        return back()->with('error', 'Cantidad insuficiente de material.');
                    }else{
                        $mateUpdate = (int)$material->cantidad - $diferencia;
                    }
                    
                    // if ($diferencia == 0) {
                    //     unset($items[$nombre]);
                    // }
                }
                $material->cantidad = strval($mateUpdate); // Convertir el resultado a cadena
                $material->save();
                $items[$nombre]['cantidad'] = $request->cantidadUpdate;
            }
        } else if ($items[$nombre]['tipo'] == 'medicamento') {
            $medicamento = MongoHospitalizacion::find($items[$nombre]['id']);

            if ($request->cantidadUpdate == 0) {                
                $mediUpdate = (int)$medicamento->cantidad  + $items[$nombre]['cantidad'];
                $medicamento->cantidad = strval($mediUpdate); // Convertir el resultado a cadena
                $medicamento->save();
                unset($items[$nombre]);
            } else if ($items[$nombre]['cantidad'] != $request->cantidadUpdate){
                if ($items[$nombre]['cantidad'] > $request->cantidadUpdate) {
                    $diferencia = $items[$nombre]['cantidad'] - $request->cantidadUpdate;
                    $mediUpdate = (int)$medicamento->cantidad + $diferencia;
                    // if ($diferencia == 0) {
                    //     unset($items[$nombre]);
                    // }
                } else if ($items[$nombre]['cantidad'] < $request->cantidadUpdate) {
                    $diferencia = $request->cantidadUpdate - $items[$nombre]['cantidad'];
                    if($diferencia > (int)$medicamento->cantidad){
                        return back()->with('error', 'Cantidad insuficiente de medicamento.');
                    }else{
                        $mediUpdate = (int)$medicamento->cantidad - $diferencia;
                    }
                    
                    // if ($diferencia == 0) {
                    //     unset($items[$nombre]);
                    // }
                }
                $medicamento->cantidad = strval($mediUpdate); // Convertir el resultado a cadena
                $medicamento->save();
                $items[$nombre]['cantidad'] = $request->cantidadUpdate;
            }
        }

        $cart->items = $items;
        $cart->save();
        return redirect()->route('cart.show', $hospitalizacion_id)->with('success', 'Consumo de hospitalización actualizado correctamente.');
    }
}
