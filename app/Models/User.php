<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable
{
    /** @use HasFactory<\Database\Factories\UserFactory> */
    use HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var list<string>
     */
    protected $fillable = [
        'name',
        'apellidos',
        'email',
        'telefono',
        'cargo',
        'rol',
        'activo',
        'password',
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var list<string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password' => 'hashed',
            'activo' => 'boolean',
            'ultimo_acceso' => 'datetime',
        ];
    }

    /**
     * Accessor para nombre completo
     */
    public function getNombreCompletoAttribute()
    {
        return $this->name . ' ' . $this->apellidos;
    }

    /**
     * Scope para obtener solo usuarios activos
     */
    public function scopeActivos($query)
    {
        return $query->where('activo', true);
    }

    /**
     * Scope para obtener usuarios por rol
     */
    public function scopePorRol($query, $rol)
    {
        return $query->where('rol', $rol);
    }

    /**
     * Scope para buscar por nombre o email
     */
    public function scopeBuscar($query, $termino)
    {
        return $query->where('name', 'like', "%{$termino}%")
                    ->orWhere('apellidos', 'like', "%{$termino}%")
                    ->orWhere('email', 'like', "%{$termino}%");
    }

    /**
     * Verificar si el usuario es administrador
     */
    public function isAdmin()
    {
        return $this->rol === 'admin';
    }

    /**
     * Verificar si el usuario es gestor
     */
    public function isGestor()
    {
        return $this->rol === 'gestor';
    }

    /**
     * Verificar si el usuario es operador
     */
    public function isOperador()
    {
        return $this->rol === 'operador';
    }
}
