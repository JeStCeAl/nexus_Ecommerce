<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Detalle;
use Illuminate\Support\Facades\Validator;
class DetallesController extends Controller
{
    /**
     * Display a listing of the resource.
     */
   public function index()
    {
        $detalles = Detalle::all();
        return response()->json($detalles);
    }


    public function store(Request $request)
    {
        $validator = Validator::make($request->all(),[
          'cantidad' => 'required|boolean',
          'nombre' => 'required|string|max:255',
          'precioUnitario' => 'required|double',
          'total' => 'required|double',
          'pedido_id' => 'required|integer|exists:pedidos,id',
          'producto_id' => 'required|integer|exists:productos,id'
        ]);
    
        if ($validator->fails()){
            return response()->json($validator->errors(), 422);
        }

        $detalles = Detalle::create($validator->validated());
        return response()->json($detalles, 201);
    }

    
    public function show(string $id)
    {
        $detalles = Detalle::find($id);
        if (!$detalles){
            return response()->json(['message'=> 'detalle no encontrado'],404);
        }
        return response()->json($detalles);
    }

    
    public function update(Request $request, string $id)
    {
        $detalles = Detalle::find($id);
        if (!$detalles){
            return response()->json(['message'=> 'detalle no encontrado'],404);
        }
        $validator = Validator::make($request->all(),[
            'cantidad' => 'boolean',
            'nombre' => 'string|max:255',
            'precioUnitario' => 'double',
            'total' => 'double',
            'pedido_id' => 'integer|exists:pedidos,id',
            'producto_id' => 'integer|exists:productos,id'
        ]);
        if ($validator->fails()){
            return response()->json($validator->errors(), 422);
        }
        $detalles->update($validator->validated());
        return response()->json($detalles);
    }

    public function destroy(string $id)
    {

        $detalles = Detalle::find($id);
        if (!$detalles){
            return response()->json(['message'=> 'detalle no encontrado'],404);
        }
        $detalles->delete();
        return response()->json(['message' => 'detalle eliminado con exito']);

    }
}
