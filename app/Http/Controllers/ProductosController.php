<?php

namespace App\Http\Controllers;

use App\Models\Productos;
use App\Http\Requests\StoreProductosRequest;
use App\Http\Requests\UpdateProductosRequest;
use App\Http\Resources\ProductosCollection;
use App\Http\Resources\ProductosResource;
use Illuminate\Http\Request;

class ProductosController extends Controller
{
//------------------MOSTRAMOS LA LISTA DE LOS PRODUCTOS---------------------
//con este metodo lo que hacemos es mostrar todas las listas d elos productos
    public function index()
    {
        // mostramos todos los productos con sus opciones categorias y demas
        $productos = Productos::with(['opciones', 'categorias', 'ofertas', 'ofertas'])->get();
        return new ProductosCollection($productos);
    }
//------------------------------------------------------------------------

//----------------CREAMOS UN PRODUCTO VACIO----------------------------------
//este metodo es para crear un producto vacio, al que luego le podemos ir añadiendo opciones
//el metodo añadir opcion al producto esta en la clase OpcionesController.
    public function store(StoreProductosRequest $request)
    {

        $producto = Productos::create($request->all());
        //devolvemos la respuesta en un json con lo creado
        return response()->json(['Mensaje' => 'producto creado correctamente', 'producto' => new ProductosResource($producto)], 201);

    }
//------------------------------------------------------------------------

    public function show(Productos $productos)
    {
    }
    public function edit(Productos $productos)
    {
    }
    public function update(UpdateProductosRequest $request, Productos $productos)
    {
    }
    public function destroy(Productos $productos)
    {
    }
}
