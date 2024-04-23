<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class UsersResources extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            'id' => $this->id,
            'Nombre' => $this->Nombre,
            'Apellido' => $this->Apellido,
            'Usuario' => $this->Usuario,
            'email' => $this->email,
            'role_id' => $this->role_id,
            'password' => $this->password,
            'enabled' => $this->enabled,
            'created_at' => Carbon::parse($this->created_at)->format('d/m/Y h:i A'),
            'updated_at' => Carbon::parse($this->updated_at)->format('d/m/Y h:i A'),
        ];
    }
}
