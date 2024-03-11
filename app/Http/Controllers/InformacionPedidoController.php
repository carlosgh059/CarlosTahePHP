<?php

namespace App\Http\Controllers;

use App\Models\InformacionPedido;
use App\Http\Requests\StoreInformacionPedidoRequest;
use App\Http\Requests\UpdateInformacionPedidoRequest;
use App\Http\Resources\InformacionPedidoCollection;
use App\Models\Pedidos;
use Illuminate\Http\Request;

class InformacionPedidoController extends Controller
{
    //-------------------------LISTAMOS TODOS LAS INFORAMCIONES DEL PEDIDO----------------
//con este metodo lo que hacemos es mostrar todas las listas d elos productos
    public function index()
    {
        //oBTENEMOS todos los registros de la tabla de inforamcion de los pedidos
        $informacionPedidos = InformacionPedido::with([
            'pedido.productos',
            'pedido.opciones',
            'pedido.packs.productos',
            'pedido.packs.opciones',
            'user'
        ])->get();
        //la retornamos en una nueva coleccion
        return new InformacionPedidoCollection($informacionPedidos);
    }
//-----------------------------------------------------------------------------------

    public function create()
    {
    }
    public function store(StoreInformacionPedidoRequest $request)
    {
    }
    public function show(InformacionPedido $informacionPedido)
    {
    }
    public function edit(InformacionPedido $informacionPedido)
    {
    }
    public function update(UpdateInformacionPedidoRequest $request, InformacionPedido $informacionPedido)
    {
    }
    public function destroy(InformacionPedido $informacionPedido)
    {
    }
}
