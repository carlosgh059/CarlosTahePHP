<?php

use App\Http\Controllers\CategoriaController;
use App\Http\Controllers\CestaController;
use App\Http\Controllers\InformacionPedidoController;
use App\Http\Controllers\OfertasController;
use App\Http\Controllers\OpcionesController;
use App\Http\Controllers\PacksController;
use App\Http\Controllers\PedidosController;
use App\Http\Controllers\ProductosController;
use App\Http\Controllers\UsuariosController;
use App\Http\Resources\OpcionesCollection;
use App\Http\Resources\ProductosCollection;
use App\Models\InformacionPedido;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\ApiController;
use App\Http\Controllers\UserController;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "api" middleware group. Make something great!
|
*/

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});

//*******Aqui declaramos las rutas que vamos a usar********
Route::group(['prefix' => 'v2', 'namespace' => 'App\Http\Controllers'], function(){
   //----------------rutas generales-----------
    Route::apiResource('productos',ProductosController::class);
    Route::apiResource('opciones',OpcionesController::class);
    Route::apiResource('categorias', CategoriaController::class);
    Route::apiResource('pedidos', PedidosController::class);
    Route::apiResource('informacionpedido', InformacionPedidoController::class);
    Route::apiResource('usuarios', UsuariosController::class);
    Route::apiResource('user', UserController::class);
    Route::apiResource('packs', PacksController::class);
    Route::apiResource('ofertas', OfertasController::class);
    Route::apiResource('cesta', CestaController::class);
    //---------------rutas propias------------------
    //categoria
    Route::put('/categorias/{categoria_id}/productos/{producto_id}', 'CategoriaController@asociarCategoriaProducto');
    Route::put('/categorias/{categoria_id}/opciones/{opcion_id}', 'CategoriaController@asociarCategoriaOpcion');
    //packs
    Route::put('/packs/{pack_id}/productos/{producto_id}', 'PacksController@agregarProductoPack');
    Route::put('/packs/{pack_id}/opciones/{opcion_id}', 'PacksController@agregarOpcionPack');
    // ofertas
    Route::put('/ofertas/{oferta_id}/productos/{producto_id}', [OfertasController::class, 'asociarProductoOferta']);
    Route::put('/ofertas/{oferta_id}/opciones/{opcion_id}', [OfertasController::class, 'asociarOpcionOferta']);
    Route::put('/opciones/{opcion_id}/productos/{producto_id}', [OpcionesController::class, 'agregarOpcionAProducto']);
    //Cesta
    Route::put('/cesta/{cesta_id}/producto/{producto_id}', 'CestaController@añadirProductoCesta');
    Route::put('/cesta/{cesta_id}/opcion/{opcion_id}', 'CestaController@añadirOpcionCesta');
    Route::put('/cesta/{cesta_id}/pack/{pack_id}', [CestaController::class, 'añadirPackCesta']);
    Route::delete('/cesta/{cesta_id}/producto/{producto_id}', 'CestaController@borrarProductoCesta');
    Route::delete('/cesta/{cesta_id}/opcion/{opcion_id}', 'CestaController@borrarOpcionCesta');
    Route::post('/cesta/{cesta_id}/comprar', 'CestaController@comprar');
    //usuarios
    Route::get ("vertodosusuarios", [UserController:: class, "verTodosUsuarios" ]);
});
//-----------------------ESTO ES PARA EL JWT TOKENS-------------
/*
Aqui tienes las rutas del jwt tokens que vamos a necesitar.
*/
Route::post("register", [ApiController::class, "register"]);
Route::post("login", [ApiController::class, "login"]);

Route::group([
    "middleware" => ["auth:api"]
], function(){
    Route::get ("profile", [ApiController::class, "profile"]);
    Route::get ("refresh", [ApiController::class, "refreshToken"]);
    Route::get ("logout", [ApiController:: class, "logout" ]);
});