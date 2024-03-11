<?php

namespace App\Filters;

use Illuminate\Http\Request;
use App\Filters\ApiFilter;

class UserFilter extends ApiFilter
{
//esta clase es para filtrar, es muy sencillo
//Aqui tenemos las condiciones que debe seguir los filtros de la clase user
    protected $safeParams = [
        'name' => ['eq'],
        'email' => ['eq'],
        'rol' => ['eq'],
        'telefono' => ['eq'],
        'direccion' => ['eq'],
        'fecha_registro' => ['eq'],
        // Podemos añadir mas campos si queremos
    ];

    //Aqui se puiede mapear los nombres de las columnas si son diferentes en la base de datos
    //sirve para quitar el _ y que en la url puedas poner fecharegistro sin necesidad de meter _
    protected $columnMap = [
        'fecha_registro' => 'fecharegistro',
    ];

    //Aqui se mapean los operadores a los operadores de comparacion de SQL correspondientes
    protected $operatorMap = [
        'eq' => '=',    //es igual
        'lt' => '<',    //menor
        'gt' => '>',    //mayor
        'gte' => '>=',    //mayor que
     //podemos agregar mas campos si queremos
    ];
}
