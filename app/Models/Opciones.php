<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Opciones extends Model
{
    use HasFactory;
    protected $fillable = [  
    'nombre',
    'descripcion',
    'imagen',
    'precio',
    'estado',
    'asociadoProducto']; 

    protected $primaryKey = 'UUIDopciones'; 

//----------declaramos las relacions de la tabla opciones con otras trablas---------------
    //1 opcion de 1 producto
    public function producto()
    {
        return $this->belongsTo(Productos::class);
    }

    //1 producto esta asociado a un pedido
    public function pedidos()
    {
        return $this->belongsTo(Pedidos::class, 'UUIDpedido');
    }

    // relacion de un producto pertenece a muchos packs
    public function packs()
    {
        return $this->belongsTo(Packs::class, 'pack_id');
    }
    
    //1 oferta puede tener muchas ofertas muchos a muchos
    public function ofertas()
    {
        return $this->belongsToMany(Ofertas::class, 'oferta_producto', 'opcion_id', 'oferta_id');
    }

    //es una relacion muchos a muchos
    public function categorias()
    {
         return $this->belongsToMany(Categoria::class, 'categoria_producto', 'UUIDopciones', 'UUIDcategoria');
    }

    //1 cesta  esta asociado a una opcion
    public function cesta()
    {
        return $this->belongsTo(Cesta::class, 'UUIDpedido');
    }
}
