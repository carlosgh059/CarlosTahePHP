<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\ResourceCollection;

class ProductosCollection extends ResourceCollection
{
    //--------------collecciones-----------------
    /*
    Es como una clase que se encarga de transformar los datos en json
    Ademas se pueden mapear lo cual tambien nos ayuda a si queremos mostrar algunos datos y no todos.
    */
    public function toArray(Request $request): array
    {
        return parent::toArray($request);
    }
}
