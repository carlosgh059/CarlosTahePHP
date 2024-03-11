<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Packs extends Model
{
    use HasFactory;

    protected $fillable = [
        'titulo',
        'descripcion',
        'precio',
        'imagen',
        'estado',
    ];
    protected $primaryKey = 'UUIDpack'; // Especifica el nombre de la clave primaria

   //----------declaramos las relacions de la tabla packs con otras trablas--------------- 
    public function productos()
    {
        return $this->hasMany(Productos::class, 'pack_id');
    }
    public function opciones()
    {
        return $this->hasMany(Opciones::class, 'pack_id');
    }
    //1 producto esta asociado a un pedido
    public function cesta()
    {
        return $this->belongsTo(Cesta::class, 'UUIDpedido');
    }
   //1 producto esta asociado a un pedido
   public function pedidos()
   {
       return $this->belongsTo(Pedidos::class, 'UUIDpedido');
   }


}
