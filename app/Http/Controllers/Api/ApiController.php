<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Cesta;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Tymon\JWTAuth\Facades\JWTAuth;

class ApiController extends Controller
{
    //
    public function register(Request $request){
       
        $validatedData = $request->validate([
            "name" => "required",
            "email" => "required|email|unique:users",
            "password" => "required|confirmed"
        ]);
      
        // Creamos el usuario y obtenemos la instancia
        $user = User::create([
            "name"=>$request->name,
            "email"=>$request->email,
            "password"=>Hash::make($request->password),
            "rol"=>$request->rol,
            "telefono"=>$request->telefono,
            "fecha_registro"=>now(), 
            "direccion"=>$request->direccion,
            "imagen_perfil"=>$request->imagen_perfil
        ]);

        // Creamos una cesta asociada al usuario recién creado
        $cesta = new Cesta();
        $cesta->precio_total = 0; // Puedes establecer un valor predeterminado para el precio total
        $cesta->user_id = $user->id; // Asignamos el ID del usuario recién creado
        $cesta->save();

        return response()->json("creado correctamente");
    }

    
    public function login(Request $request){
        $request->validate([
            "email" => "required|email",
            "password" => "required"
        ]);
        //jwtauth and aatempt
        $token = JWTAuth::attempt([
            "email" => $request->email,
            "password" =>$request->password
        ]);

        if (!empty($token)) {
            return response()->json([
                "status" => true,
                "message" => "Usuario correcto, bienvenido",
                "token" => $token
            ]);
        }

        return("login malo, ok");
    }
    public function profile(Request $request){
        
        $userData = auth()->user();

        return response()->json([
            "status" => true,
            "message" => "profile data",
            "user" => $userData
        ]);
    }
    public function refreshToken(Request $request){
        $newToken = auth()->refresh();
        return response()->json([
            "status" => true,
            "message" => "Nuevo token creado",
            "user" => $newToken
        ]);
    }
    public function logout(){
       auth()->logout();
       return response()->json([
        "status" => true,
        "message" => "Sesion cerrada"
    ]);
    }
}
