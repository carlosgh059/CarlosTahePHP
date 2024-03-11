<?php

namespace App\Http\Controllers;

use App\Models\Ofertas;
use App\Http\Requests\StoreOfertasRequest;
use App\Http\Requests\UpdateOfertasRequest;
use App\Http\Resources\OfertasCollection;
use App\Http\Resources\OfertasResource;
use App\Models\Opciones;
use App\Models\Productos;
use Illuminate\Http\Request;

class OfertasController extends Controller
{
//-----------------LISTAMOS TODOS LAS OFERTAS---------------
//con este metodo lo que hacemos es mostrar todas las listas d elos productos
    public function index()
    {
        //mostramos la lista de de tosos las ofertas que hay con sus productos
        $ofertas = Ofertas::with(['productos', 'opciones'])->get();
        return new OfertasCollection($ofertas);
    }
//-------------------------------------------------------------

//-------------------------------CREAMOS UNA NUEVA OFERTA-------------------------------
//Creamos una nueva oferta, la cual tiene fecha de inicio y fin, y precio y porcentaje.
    public function store(StoreOfertasRequest $request)
    {
        $oferta  = Ofertas::create($request->all());
        return response()->json(['Mensaje' => 'oferta creado correctamente', 'oferta' => new OfertasResource($oferta)], 201);
    }
//--------------------------------------------------------------------

//---------------------ASOCIAR UN PRODUCTO/OPCION A LA OFERTAS----------------
//estos metodos son paara asociar un producto a una opcion y demas
    //Metodo para asociar un producto a una oferta
    public function asociarProductoOferta($oferta_id, $producto_id)
    {
        //Buscamos la oferta la oferta y el producto
        $oferta = Ofertas::findOrFail($oferta_id);

        //el producto con la oferta a traves de la tabla intermedia
        $oferta->productos()->attach($producto_id);

        //devolvemos una respuesta indicando que el producto se ha asociado correctamente a la oferta
        return response()->json(['message' => 'Producto asociado correctamente a la oferta.'], 200);
    }

    //Metodo para asociar una opcion a una oferta
    public function asociarOpcionOferta($oferta_id, $opcion_id)
    {
        //Oferta la buscamos y la guaradmos variable
        $oferta = Ofertas::findOrFail($oferta_id);

        // Asociar la opcion con la oferta a trave de la tabla intermedia
        $oferta->opciones()->attach($opcion_id);

        //Retornamos una respuesta indicando que la opcion se ha asociado correctamente a la oferta
        return response()->json(['message' => 'Opción asociada correctamente a la oferta.'], 200);
    }
//------------------------------------------------------------------------------------
    public function create()
    {
    }
    public function show(Ofertas $ofertas)
    {
    }
    public function edit(Ofertas $ofertas)
    {
    }
    public function update(UpdateOfertasRequest $request, Ofertas $ofertas)
    {
    }
    public function destroy(Ofertas $ofertas)
    {
    }
}
