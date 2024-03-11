<?php

namespace App\Http\Controllers;

use App\Models\Cesta;
use App\Http\Requests\StoreCestaRequest;
use App\Http\Requests\UpdateCestaRequest;
use App\Http\Resources\CestaCollection;
use App\Models\InformacionPedido;
use App\Models\Ofertas;
use App\Models\Opciones;
use App\Models\Packs;
use App\Models\Pedidos;
use App\Models\Productos;
use Carbon\Carbon;
use Illuminate\Http\Request;

class CestaController extends Controller
{

 //---------------OBTENEMOS TOOS LAS CESTAS CON SUS PRODUCTOS Y OPCIONES-------------------
//con este metodo lo que hacemos es mostrar todas las listas d elos productos
    public function index()
    {
        //Obtenemos todas las categorías
        $cesta = Cesta::with(['productos', 'opciones', 'packs.productos', 'packs.opciones', 'user'])->get();
        return new CestaCollection($cesta);
    }
    //-------------------------AÑADISMOS OPCION/PRODUCTO A  CESTA------------------------------------
    public function añadirProductoCesta(Request $request, $cesta_id, $producto_id)
    {
        // Buscamos  la cesta correspondiente
        $cesta = Cesta::findOrFail($cesta_id);

        //Obtener el precio del producto que se va a añadir y
        $producto = Productos::findOrFail($producto_id);
        $precio_producto = $producto->precio;

        //Actualizamos el precio total de la cesta
        $cesta->precio_total += $precio_producto;
        $cesta->save();

        //Asignamos el ID de la cesta al producto
        $producto->cesta_id = $cesta_id;
        $producto->save();


        return response()->json(['message' => 'Producto añadido a la cesta correctamente'], 200);
    }

    public function añadirOpcionCesta(Request $request, $cesta_id, $opcion_id)
    {
        //Buscamos la cesta correspondiente
        $cesta = Cesta::findOrFail($cesta_id);

        //Obtenemos el precio de la opción que se va a añadir
        $opcion = Opciones::findOrFail($opcion_id);
        $precio_opcion = $opcion->precio;

        // Actualizar el precio total de la cesta
        $cesta->precio_total += $precio_opcion;
        $cesta->save();

        //Asignamos el ID de la cesta a la opcion
        $opcion->cesta_id = $cesta_id;
        $opcion->save();

        return response()->json(['message' => 'Opción añadida a la cesta correctamente'], 200);
    }
    //----------------------------------------------------------------------------------------

    //----------------------------AÑADIR PACKS Y OFERTAS A LA CESTA---------------------------
    public function añadirPackCesta(Request $request, $cesta_id, $pack_id)
    {
        //Buscamos la cesta correspondiente
        $cesta = Cesta::findOrFail($cesta_id);

        //el precio del pack que se va a añadir
        $pack = Packs::findOrFail($pack_id);
        $precio_pack = $pack->precio;

        //aQui tenemos el precio total de la cesta
        $cesta->precio_total += $precio_pack;
        $cesta->save();
        //guramos el id de la cesta en el pack
        $pack->cesta_id = $cesta_id;
        $pack->save();

        //Retornar una respuesta indicando que el pack ha sido añadido a la cesta
        return response()->json(['message' => 'Pack añadido a la cesta correctamente'], 200);
    }
    //----------------------------------------------------------------------------------------

    //------------------------------BORRAMOS LOS PRODUCTOS Y OPCIONES DE LA CESTA-----------------------------   
    public function borrarProductoCesta(Request $request, $cesta_id, $producto_id)
    {
        //Buscamos la cesta correspondiente
        $cesta = Cesta::findOrFail($cesta_id);

        //Buscamos el producto que se va a borrar de la cesta
        $producto = Productos::findOrFail($producto_id);

        //Guaramos el precio el precio del producto
        $precio_producto = $producto->precio;

        // Restar el precio del producto del precio total de la cesta
        $cesta->precio_total -= $precio_producto;
        $cesta->save();

        //Quitamos la relación del producto con la cesta
        $producto->cesta_id = null;
        $producto->save();

        //Retornamos una respuesta indicando que el producto ha sido borrado de la cesta
        return response()->json(['message' => 'Producto borrado de la cesta correctamente'], 200);
    }

    public function borrarOpcionCesta(Request $request, $cesta_id, $opcion_id)
    {
        // Buscamos la cesta correspondiente
        $cesta = Cesta::findOrFail($cesta_id);

        // Buscamos la opción que se va a borrar de la cesta
        $opcion = Opciones::findOrFail($opcion_id);

        // Obetenemos el precio de la opcion
        $precio_opcion = $opcion->precio;

        // Restar el precio de la opción del precio total de la cesta
        $cesta->precio_total -= $precio_opcion;
        $cesta->save();

        // Quitar la relación de la opción con la cesta
        $opcion->cesta_id = null;
        $opcion->save();

        // Retornar una respuesta indicando que la opción ha sido borrada de la cesta
        return response()->json(['message' => 'Opción borrada de la cesta correctamente'], 200);
    }

//----------------------------------------------------------------------------------------------------

//---------------------------------COMPRAMOS LOS PRODUCTOS Y OPCIONES CESTA--------------------------
/*
Esto es para comprar los productos y opciones, se crea un nuevo pedido y ese pedido, se crea la Informacion pedido para el usuario
Es decir, comprar hace lo siguiente.
La cesta la deja vacia y sus productos asociados a la cesta  se asocian un pedido
tambien se crea una inforamcion del pedido con el pedido
y tambien se asocia al usuario
*/
    public function comprar(Request $request, $cesta_id)
    {
        // Buscamos la cesta correspondiente con el metodo find
        $cesta = Cesta::findOrFail($cesta_id);

        // Crear un nuevo pedido nuevo
        $pedido = new Pedidos();
        $pedido->precio_total = $cesta->precio_total;
        // guardamos
        $pedido->save();

        // guardamos en la variable todos los productos asociados a la cesta
        $cestaProductos = $cesta->productos;

        // aqui lo que hacemos es asociar cada producto al nuevo pedido
        foreach ($cestaProductos as $producto) {
            $producto->pedido_id = $pedido->UUIDpedido;
            $producto->cesta_id = null;
            $producto->save();
        }
        // guardamos en la variable opciones todas las opciones asociadas a la cesta
        $opciones = $cesta->opciones;

        //Associamos cada opción al nuevo pedido
        foreach ($opciones as $opcion) {
            $opcion->pedido_id = $pedido->UUIDpedido;
            $opcion->cesta_id = null;
            $opcion->save();
        }
        //colocamos la cesta a cero y guardamos
        $cesta->precio_total = 0;
        $cesta->save();

        //Obtener todos los packs asociados a la cesta
        $cestaPacks = $cesta->packs;

        //Asociamos cada pack al nuevo pedido
        foreach ($cestaPacks as $pack) {
            // Aqui le decimos que pack al nuevo pedido
            $pack->pedido_id = $pedido->UUIDpedido;
            $pack->cesta_id = null;
            $pack->save();
        }

        //Creamos una nueva instancia de InformacionPedido
        $informacionPedido = new InformacionPedido();
        $informacionPedido->descripcion = $request->input('descripcion');
        $informacionPedido->estado = $request->input('estado');

        //Asiganamos el ID del pedido a la información del pedido
        $informacionPedido->pedido_id = $pedido->UUIDpedido;

        //Asociar el ID del usuario a la información del pedido y guardamos
        $informacionPedido->user_id = $cesta->user_id;
        $informacionPedido->save();
        //Retornamos una respuesta indicando que se ha realizado la compra y se ha creado el pedido
        return response()->json(['message' => 'Compra realizada con éxito. Pedido creado.'], 200);
    }
//----------------------------------------------------------------------------------------

    public function create()
    {
    }
    public function store(StoreCestaRequest $request)
    {
    }
    public function show(Cesta $cesta)
    {
    }
    public function edit(Cesta $cesta)
    {
    }
    public function update(UpdateCestaRequest $request, Cesta $cesta)
    {
    }
    public function destroy(Cesta $cesta)
    {
    }
    public function calculasporcentaje()
    {
//-----------------------------------esto es para hacer una busqueda del porcentaje----------------------------
        /*    
           $ofertas_activas = $producto->ofertas()->where('estado', 'activo')->get();
           //comprobamos si el producto tiene ofertas asociadas a el o no.
           if ($producto->ofertas->count() > 0) {
               //recorremos un bucle solo de las ofertas que esten activas de ese producto
               foreach ($ofertas_activas as $oferta) {
                  
                  $fecha_fin_oferta = Carbon::parse($oferta->fecha_fin);
                  //comprobamos si la oferta ha caducado o no
                   if (!$fecha_fin_oferta->isPast()) {
                       ///comprobamos si la oferta es de tipo porcentaje o de tipo fijo
                       if ($oferta->precio_oferta === 0 || $oferta->precio_oferta === null) {
                           // Si la oferta es del tipo que tiene un precio de oferta fijo
    
                           $precio_producto = $ofertas_activas->precio_oferta;
                           // Actualizar el precio total de la cesta
                           $cesta->precio_total += $precio_producto;
                           $cesta->save();
                  
                           // Asignar el ID de la cesta al producto
                           $producto->cesta_id = $cesta_id;
                           $producto->save();
    
                           return "El producto tiene una oferta de precio  y ha sido aplicada";
       
                       } else {
                           // Si la oferta es del tipo que tiene precio_oferta igual a cero o null
    
                           // Si la oferta es del tipo que tiene precio_oferta igual a cero o null
                           $porcentajeDescuento = $oferta->porcentaje_descuento;
                           $precio_producto = $producto->precio;
                           // Calcular el descuento
                           $descuento = ($precio_producto * $porcentajeDescuento) / 100;
                           // Calcular el nuevo precio con descuento
                           $precio_con_descuento = $precio_producto - $descuento;
                           // Actualizar el precio total de la cesta
                           $cesta->precio_total += $precio_con_descuento;
                           $cesta->save();
    
                           // Asignar el ID de la cesta al producto
                           $producto->cesta_id = $cesta_id;
                           $producto->save();
                           
                           return "El producto tiene una oferta de porcentaje de descuento y ha sido aplicada";
       
                       }
    
                   }
               }
               
            } 
            */
    }
}
