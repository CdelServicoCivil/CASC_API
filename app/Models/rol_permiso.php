<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class rol_permiso extends Model
{
    use HasFactory;
    protected $fillable = [
        'role_id', 
        'permiso_id',
    ];

    public function roles()
    {
        return $this->hasMany(roles::class, 'id');
    }
    public function permisos()
    {
        return $this->hasMany(permisos::class, 'id', 'name');
    }
}
