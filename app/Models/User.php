<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;

class User extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'Nombre',
        'Apellido',
        'Usuario',
        'email',
        'role_id',
        'password',
        'enabled'
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
        'enabled' => 'boolean',
    ];


    public function rols ()
    {
        return $this->belongsToMany(Rol::class, 'user');
    }


    public function isAuthorized($object, $operation)
    {
        return Db::table('rol-permisos')
            ->where('object', $object)
            ->where('operation', $operation)
            ->join('user', 'id.role_id', '=', 'rol-permisos.role_id')
            ->where('id.user', $this->id)
            ->exists();
    }
}
