<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Categoria extends Model
{
    use HasFactory;
    protected $fillable = [
      'categoria',
      'descripcion',
    ];
    protected $primaryKey = 'UUIDcategoria';

//----------declaramos las relacions de la tabla cesta con otras trablas---------------
//relacion con productos de muchos a muchos, una categoria puede tener muchos productos
    public function productos()
    {
      return $this->belongsToMany(Productos::class, 'categoria_producto', 'UUIDcategoria', 'UUIDproducto');
    }

//relacion que tiene con opciones  de muchos a muchos con opciones
    public function opciones()
    {
      return $this->belongsToMany(Opciones::class, 'categoria_producto', 'UUIDopciones', 'UUIDproducto');
    }
//------------------------------------------------------------------------
}
