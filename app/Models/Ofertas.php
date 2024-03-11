<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Ofertas extends Model
{
    use HasFactory;
    protected $fillable = [
        'precio_oferta',
        'porcentaje_descuento',
        'fecha_inicio',
        'fecha_fin',
        'descripcion',
        'estado',
        'producto_id',
    ];
    protected $primaryKey = 'UUIDoferta';
//----------declaramos las relacions de la tabla oferta con otras trablas---------------

    //la relacion 1 una oferta pertenece a muchos producto muchos a muchos
    public function productos()
    {
        return $this->belongsToMany(Productos::class, 'oferta_producto', 'oferta_id', 'producto_id');
    }

    // 1 oferta puede pertenecer a muchas opciones (productos)
    public function opciones()
    {
        return $this->belongsToMany(Opciones::class, 'oferta_producto', 'oferta_id', 'opcion_id');
    }

    //1 producto esta asociado a un pedido
    public function cesta()
    {
        return $this->belongsTo(Cesta::class, 'pack_id');
    }
    //1 producto esta asociado a un pedido
    public function pedidos()
    {
        return $this->belongsTo(Pedidos::class, 'UUIDpedido');
    }
}
