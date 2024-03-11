<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Productos extends Model
{
    use HasFactory;
    protected $fillable = ['nombre', 'descripcion', 'precio', 'pedido_id']; 

   
    protected $primaryKey = 'UUIDproducto'; // Es la clave primaria o da error

//----------declaramos las relacions de la tabla productos con otras trablas---------------
    //1 producto puede tener muchas opciones
    public function opciones()
    {
        return $this->hasMany(Opciones::class, 'productos_id');
    }

    //es una relacion muchos a muchos
    public function categorias()
    {
        return $this->belongsToMany(Categoria::class, 'categoria_producto', 'UUIDproducto', 'UUIDcategoria');
    }
    //1 producto esta asociado a un pedido
    public function pedidos()
    {
        return $this->belongsTo(Pedidos::class, 'UUIDpedido');
    }

    // Relación de un producto pertenece a 1 pack
    public function packs()
    {
        return $this->belongsTo(Packs::class, 'pack_id');
    }

    //1 producto puede tener muchas ofertas muchos a muchos
    public function ofertas()
    {
        return $this->belongsToMany(Ofertas::class, 'oferta_producto', 'producto_id', 'oferta_id');
    }
 
    //1 producto esta asociado a un pedido
    public function cesta()
     {
           return $this->belongsTo(Cesta::class, 'UUIDpedido');
      }
}
