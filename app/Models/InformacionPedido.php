<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class InformacionPedido extends Model
{
    use HasFactory;
    protected $fillable = [

    ];
    
    protected $primaryKey = 'UUIDinformacionpedido';

//----------declaramos las relacions de la tabla inforamcion del pedido con otras trablas---------------
//delcaracion de 1 a 1 con pedido
    public function pedido()
    {
        return $this->belongsTo(Pedidos::class, 'pedido_id');
    }
    //relacion 1 a 1 con usuario.
    public function usuario()
    {
        return $this->belongsTo(Usuarios::class, 'usuario_id');
    }

    //relacion 1 a 1 con usuario.
    public function user()
    {
       return $this->belongsTo(User::class, 'user_id');
    }
}
