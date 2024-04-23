<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Rol extends Model
{
    protected $fillable = [
        'name',
    ];

    public function Permisos()
    {
        return $this->hasMany(Permisos::class, 'name', 'id');
    }

    public function users()
    {
        return $this->belongsToMany(users::class, 'Nombre')->withTrashed();
    }
}
 