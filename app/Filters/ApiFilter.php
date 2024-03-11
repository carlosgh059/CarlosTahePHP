<?php

namespace App\Filters;

use Illuminate\Http\Request;

class ApiFilter
{   
    //Declaramos la variables que se van a usar para mapear los parametros de la request que nos llegue.
    protected $safeParams = [];
    protected $columnMap = [];
    protected $operatorMap = [];

    //este metodo Transform lo que hace es tranforma la request que recibimos en una busqueda
    //devolvemos un eloquerry con la consulta
    //en resumen lo que hacemos es filtrar las solicitudes que nos llegan por los paramoetros 
    public function transform(Request $request)
    {

        $eloQuery = [];

        foreach ($this->safeParams as $parm => $operators) {
            //aqui lo que hace es verificar si el $parm cumple con la solicutd [eq] y si no continua
            $query = $request->query($parm);
            if (!isset($query)) {
                continue;
            }
            //Obetenemos el nombre de columna correspondiente al parámetro
            $column = $this->columnMap[$parm] ?? $parm;
            foreach ($operators as $operator) { //Itineramos sobre los parametros de comparacion permitidos para el parametro
                if (isset($query[$operator])) { //verificamos si el operador esta presente
                    $eloQuery[] = [$column, $this->operatorMap[$operator], $query[$operator]];
                }
            }
        }
        //Devolvemos la consulta Eloquent resultante
        return $eloQuery;
    }
}
