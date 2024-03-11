<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Pedidos extends Model
{
    use HasFactory;
    protected $fillable = [
        'precio_total', 
        'descripcion',
        'estado'
    ];


    protected $primaryKey = 'UUIDpedido'; // Especifica el nombre de la clave primaria

//----------declaramos las relacions de la tabla pedidos con otras trablas---------------

    //1 pedido tiene muchos productos
    public function productos()
    {
        return $this->hasMany(Productos::class, 'pedido_id');
    }

    //1 pedido tiene muchos productos
    public function opciones()
    {
        return $this->hasMany(Opciones::class, 'pedido_id');
    }
    //1 pedido tiene muchos productos
    public function packs()   
    {
        return $this->hasMany(Packs::class, 'pedido_id');
    }
            //1 pedido tiene muchos productos
    public function ofertas()
    {
        return $this->hasMany(Ofertas::class, 'pedido_id');
    }
    
    public function informacionPedido()
    {
        return $this->hasOne(InformacionPedido::class, 'pedido_id');
    }
    

}
