<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class StoreCestaRequest extends FormRequest
{
//tenemos que colocar la authiuzacion a true porque si no no falla, de todas maneras , aqui
//lo que se puede hacer es cuando agregamos otorgar unas reglas de validacion y no es necesario hacerlo
//en el propio controller....
    public function authorize(): bool
    {
        return true;
    }
 //aqui colocamos las reglas de validacion
    public function rules(): array
    {
        return [
            //
        ];
    }
}
