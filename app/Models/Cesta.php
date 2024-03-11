<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Cesta extends Model
{
    use HasFactory;

    protected $fillable = [

    ];
    protected $primaryKey = 'UUIDcesta';

//----------declaramos las relacions de la tabla cesta con otras trablas---------------
//relacion con usuario de 1 a 1, una cesta pertenece a un unico usuario
    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    //1 cesta tiene muchos productos, una cesta puede tener muchos productos
    public function productos()
    {
        return $this->hasMany(Productos::class, 'cesta_id');
    }
        
    //1 cesta tiene muchos opciones, una cesta puede tener muchas opciones
    public function opciones()
    {
        return $this->hasMany(Opciones::class, 'cesta_id');
    }

    //1 cesta tiene muchos packs, una cesta puede tener muchos packs
    public function packs()
    {
        return $this->hasMany(Packs::class, 'cesta_id');
    }

    //1 cesta tiene muchas ofertas, una cesta puede tener muchas ofertas
    public function ofertas()
    {
        return $this->hasMany(Ofertas::class, 'cesta_id');
    }
}
