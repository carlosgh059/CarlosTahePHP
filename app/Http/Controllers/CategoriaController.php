<?php

namespace App\Http\Controllers;

use App\Models\Categoria;
use App\Http\Requests\StoreCategoriaRequest;
use App\Http\Requests\UpdateCategoriaRequest;
use App\Http\Resources\CategoriaCollection;
use App\Http\Resources\CategoriaResource;
use App\Models\Opciones;
use App\Models\Productos;
use Illuminate\Http\Request;
use Illuminate\Http\Response;

class CategoriaController extends Controller
{
    //------------Vemos todos las categorias-------------
    //este metodo es para mostrar todas las listas y mostrarlas
    public function index(Request $request)
    {
        // Obtener todas las categorías
        $categorias = Categoria::with(['productos', 'opciones'])->get();
        return new CategoriaCollection($categorias);
    }
    //------------------AQUI ASOCIAMOS UNA CATEGORIA A UNA OPCION/PRODUCTO-------------
    //este metodo se encarga de asociar una categoria a un producto
    public function asociarCategoriaProducto(Request $request, $categoria_id, $producto_id)
    {
        //Guardamos en la variable la categoría y el producto y lo guardamos en la variables 
        $categoria = Categoria::findOrFail($categoria_id);
        $producto = Productos::findOrFail($producto_id);

        //attach sirve asociar, es como un update. 
        $producto->categorias()->attach($categoria_id);

        //Retornamos una respuesta indicando que la categoria se ha asociado correctamente al producto con un 200 que eso es bueno ok
        return response()->json(['message' => 'Categoría asociada correctamente al producto.'], 200);
    }
    //------------                                                              ----------
    //este metodo se encarga de asociar una opcion a una categoria
    public function asociarCategoriaOpcion(Request $request, $categoria_id, $opcion_id)
    {
        //Guardamos la categoriaa y la opcion
        $categoria = Categoria::findOrFail($categoria_id);
        $opcion = Opciones::findOrFail($opcion_id);

        //Asociamos la categoría con la opcion con attach
        $opcion->categorias()->attach($categoria_id);

        //Retornamos una respuesta indicando que la categoria se ha asociado correctamente al producto con un 200 que eso es bueno ok
        return response()->json(['message' => 'Categoría asociada correctamente a la opción.'], 200);
    }

    //-----------------------------CREAMOS UNA CATEGORIA----------------------------------------
    //este metodo es para crear una categoria desde cero.
    public function store(StoreCategoriaRequest $request)
    {
        $categoria = Categoria::create($request->all());
        //devolvemos la respuesta en un json con lo creado
        return response()->json(['Mensaje' => 'categoria creado correctamente', 'categoria' => new CategoriaResource($categoria)], 201);
       
    }
    //--------------------------------------------------------------------------------------------------

    public function create(Request $request)
    {
    }

    public function show(Categoria $categoria)
    {
    }

    public function edit(Categoria $categoria)
    {
    }

    public function update(UpdateCategoriaRequest $request, Categoria $categoria)
    {
    }

    public function destroy(Categoria $categoria)
    {
    }
}
