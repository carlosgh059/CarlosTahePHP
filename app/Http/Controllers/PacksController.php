<?php

namespace App\Http\Controllers;

use App\Models\Packs;
use App\Http\Requests\StorePacksRequest;
use App\Http\Requests\UpdatePacksRequest;
use App\Http\Resources\PacksCollection;
use App\Http\Resources\PacksResource;
use App\Models\Opciones;
use App\Models\Productos;

class PacksController extends Controller
{
//--------------------LISTAMOS TODOS LOS PACKS---------------------
    //este metodo es para mostrar todas las listas y mostrarlas
    public function index()
    {
        //Obtenemos todos los packs con los productos y opciones asociados y los mostramos
        $packs = Packs::with(['productos', 'opciones'])->get();
        return new PacksCollection($packs);
    }
//-------------------------------------------------------------

//--------------------------CREAMOS UN PACK NUEVO Y VACIO---------------------
//este metodo te crea un pack nuevo y vacio y luego con los otros metodos agregamos
//las opciones y productos que deseamos al pack, los metodos estan mas debajo
public function store(StorePacksRequest $request)
{
    $pack = Packs::create($request->all());
    //devolvemos la respuesta en un json con lo creado
    return response()->json(['Mensaje' => 'Pack creado correctamente', 'pack' => new PacksResource($pack)], 201);
}
//--------------------------------------------------------------------------------

//---------------AGREGAMOS UN PDODUCTO / OPCION AL PACK------------------------
//con estos metodos agregamos los productos y las opciones al pack
    //Agregamos un producto al pack deseado
    public function agregarProductoPack($pack_id, $producto_id)
    {
        //Buscamos el producto
        $producto = Productos::findOrFail($producto_id);

        //Guradamos y asignamos el pack_id al producto
        $producto->pack_id = $pack_id;
        $producto->save();
        //retornamos una respuesta con el producto agregado correctamente al pack
        return response()->json(['message' => 'Producto agregado al pack correctamente'], 200);
    }

    //Agregamos una opcion al pack deseado
    public function agregarOpcionPack($pack_id, $opcion_id)
    {
        //Buscamos la opcion con el id
        $opcion = Opciones::findOrFail($opcion_id);

        // Asignamos y guardamos el pack_id a la opcion
        $opcion->pack_id = $pack_id;
        $opcion->save();

        return response()->json(['message' => 'Opción agregada al pack correctamente'], 200);
    }
//-------------------------------------------------------------------------------------------------

    public function show(Packs $packs)
    {
    }
    public function edit(Packs $packs)
    {
    }
    public function update(UpdatePacksRequest $request, Packs $packs)
    {
    }
    public function destroy(Packs $packs)
    {
    }
    public function create()
    {
    }
}
