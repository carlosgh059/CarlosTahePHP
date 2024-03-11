<?php

namespace App\Http\Controllers;

use App\Models\Pedidos;
use App\Http\Requests\UpdatePedidosRequest;
use App\Http\Resources\PedidosCollection;


class PedidosController extends Controller
{
//----------------------LISTAMOS TODOS LOS PEDIDOS----------------------
//con este metodo lo que hacemos es mostrar todas las listas d elos productos
    public function index()
    {
        // Mostamos  todos los pedidos con los productos asociados
        $pedidos = Pedidos::with(['productos', 'opciones', 'packs'])->get();
        return new PedidosCollection($pedidos);
    }
//-----------------------------------------------------------------------------

    public function create()
    {
    }
    public function show(Pedidos $pedidos)
    {
    }
    public function edit(Pedidos $pedidos)
    {
    }
    public function update(UpdatePedidosRequest $request, Pedidos $pedidos)
    {
    }
    public function destroy(Pedidos $pedidos)
    {
    }
}
