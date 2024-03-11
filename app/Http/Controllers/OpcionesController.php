<?php

namespace App\Http\Controllers;

use App\Models\Opciones;
use App\Http\Requests\StoreOpcionesRequest;
use App\Http\Requests\UpdateOpcionesRequest;
use App\Http\Resources\OpcionesCollection;
use App\Http\Resources\OpcionesResource;
use App\Models\Productos;

class OpcionesController extends Controller
{
//------------------------LISTAMOS TODAS LAS OPCIONES-------------
    //este metodo es para mostrar todas las listas y mostrarlas
    public function index()
    {
        // Recuperar todas las opciones de la base de datos
        $opciones = Opciones::with('categorias', 'ofertas')->get();
        return new OpcionesCollection($opciones);
    }
//------------------------------------------------------------------

//--------------------CREAMOS UNA NUEVA OPCION----------------------------------------------
    public function store(StoreOpcionesRequest $request)
    {
            // Creamos un nuevo pack con los datos proporcionados
    $opcion = Opciones::create($request->all());
    return response()->json(['Mensaje' => 'Opcion creado correctamente', 'opcion' => new OpcionesResource($opcion)], 201);
    }
//------------------------------------------------------------------

//----------------------AGREGAMOS UNA OPCION AL PRODUCO----------------------------------------
//este metodo lo que hace es agregar una opcion al producto es decir
//el producto puede tener muchas opciones y este metodo se encarga de realizar esto
    public function agregarOpcionAProducto($opcion_id, $producto_id)
    {
        //Encontramos  el producto y la opción a traves del id
        $opcion = Opciones::findOrFail($opcion_id);

        //Asignamos la opción al producto
        $opcion->productos_id = $producto_id;
        //Establecer el estado como "si"  para saber que si esta asociado al producto
        $opcion->asociadoProducto = 'Si'; 
        $opcion->save();

        //Retoirnamos una respuesta correcta 
        return response()->json(['message' => 'Opción agregada al producto correctamente.'], 200);
    }
//------------------------------------------------------------------
    public function show(Opciones $opciones)
    {
    }
    public function edit(Opciones $opciones)
    {
    }
    public function update(UpdateOpcionesRequest $request, Opciones $opciones)
    {
    }
    public function destroy(Opciones $opciones)
    {
    }
    public function create()
    {
    }
}
