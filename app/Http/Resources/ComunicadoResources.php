<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class ComunicadoResources extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            'nombre_comunicado' => $this->nombre_comunicado,
            'comunicado' => $this->comunicado,
            'created_at' => Carbon::parse($this->created_at)->format('d/m/Y h:i A'),
            'updated_at' => Carbon::parse($this->updated_at)->format('d/m/Y h:i A'),
        ];
    }
}
