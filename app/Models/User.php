<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;
use Tymon\JWTAuth\Contracts\JWTSubject;

class User extends Authenticatable implements JWTSubject
{
    use HasApiTokens, HasFactory, Notifiable;
//------------------esto es para el token y la parte de la seguridad---------------
    protected $fillable = [
        'name',
        'email',
        'password',
    ];
    protected $hidden = [
        'password',
        'remember_token',
    ];
    protected $casts = [
        'email_verified_at' => 'datetime',
        'password' => 'hashed',
    ];
  //--------------------------------------------------
  
//----------declaramos las relaciones del JWT token--------------
  //relacion la clase jwt token
    public function getJWTIdentifier()
    {
      return $this->getKey();
    }
  //relacion la clase jwt token
    public function getJWTCustomClaims()
    {
      return [];
    }
    
//----------declaramos las relacions de la tabla User con otras trablas---------------
    //relacion 1 a muchos con informacion del pedido
    public function informacionesPedido()
    {
        return $this->hasMany(InformacionPedido::class, 'user_id');
    }

    //relacion 1 a 1 con informacion cesta
    public function cesta()
    {
        return $this->hasMany(Cesta::class, 'user_id');
    }
}
