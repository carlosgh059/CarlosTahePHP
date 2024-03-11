<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class PacksResource extends JsonResource
{
//es json
    public function toArray(Request $request): array
    {
        return parent::toArray($request);
    }
}
