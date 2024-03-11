<?php

use App\Models\User;
use App\Models\Usuarios;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/


Route::get('/', function () {
    return view('welcome');
});


//vamos a proteger nuestras rutas con authorizcion y verificacion
Route::get('/setup', function(){
    $credentials = [
        'email' => "admin@admin.com",
        'password' => "password"
    ];
        // Autenticar con las credenciales
        if(Auth::attempt($credentials)){
            // Si las credenciales son correctas, crear un nuevo usuario Admin
            $usuario = new User();
            $usuario->name = 'Admin';
            $usuario->email = $credentials['email'];
            $usuario->password = Hash::make($credentials['password']);
            $usuario->save();
            
            // Generar tokens para el usuario Admin
            $adminToken = $usuario->createToken('admin-token',['create','update','delete']);
            $updateToken = $usuario->createToken('update-token',['create','update']);    
            $basicToken = $usuario->createToken('basic-token');
            
            // Devolver los tokens como respuesta
            return [
                'admin' => $adminToken->plainTextToken,
                'update' => $updateToken->plainTextToken,
                'basic' => $basicToken->plainTextToken
            ];
        } else {
            // Si las credenciales no coinciden, devolver un mensaje de error
            return response()->json(['error' => 'Las credenciales proporcionadas son incorrectas'], 401);
        }

});
