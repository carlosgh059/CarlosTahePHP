<?php

namespace App\Http\Controllers;

use App\Filters\UserFilter;
use App\Models\Usuarios;
use App\Http\Requests\StoreUsuariosRequest;
use App\Http\Requests\UpdateUsuariosRequest;
use App\Http\Resources\UserCollection;
use App\Models\User;
use Illuminate\Http\Request;
use Tymon\JWTAuth\Facades\JWTAuth;

class UserController extends Controller
{
//------------------------Listamos todos los usuario----------------------
//esto es para listar todos los usuarios, este metodo se encarga de hacer eso.
//Podemos usar filtros si queremos, se puede filtrar por nombre o lo que queramos.
    public function index(Request $request)
    {
        //Utilizamos los filtros para si queremos ver los usuarios, dejo aqui una ruta de ejemplo
        //http://127.0.0.1:8000/api/v2/usuarios?nombre[eq]=paco
        //Esto de UserFilter es para filtrar, es decir, enviamos a traves de la request, enviamos
        //lo que es la consulta, no es necesario usar where, es a traves del metodo transform que he creado

        $filter = new UserFilter;
        $queryItems = $filter->transform($request);

        //Ahora lo que hacemos es obtener todos los usuarios con relaciones cargadas y aplicar los filtros
        $usuarios = User::with(['informacionesPedido.pedido.productos','informacionesPedido.pedido.opciones','cesta'])
        ->where($queryItems);

        // Retornar la colección de usuarios
        return new UserCollection($usuarios->paginate()->appends($request->query()));
    }
//----------------------------------------------------------------------

    public function store(StoreUsuariosRequest $request){}
    public function create(){}
    public function show(Usuarios $usuarios){}
    public function edit(Usuarios $usuarios){}
    public function update(UpdateUsuariosRequest $request, Usuarios $usuarios){}
    public function destroy(Usuarios $usuarios){}
}
