<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Passport\Contracts\OAuthenticatable;
use Laravel\Passport\HasApiTokens;
use Silber\Bouncer\Database\HasRolesAndAbilities;

class User extends Authenticatable implements OAuthenticatable
{
    /** @use HasFactory<\Database\Factories\UserFactory> */
    use HasApiTokens, HasFactory, HasRolesAndAbilities, Notifiable;

    /**
     * @var bool
     */
    public $timestamps = true;

    /**
     * The attributes that are mass assignable.
     *
     * @var list<string>
     */
    protected $fillable = [
        'paternal_surname',
        'maternal_surname',
        'name',
        'email',
        'password',
        'dni',
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
        ];
    }

    // Relaciones con Evento a través de la tabla pivote participantes
    public function eventosComoPreRegistrado(): BelongsToMany
    {
        return $this->belongsToMany(Evento::class, 'participantes', 'user_id', 'evento_id')
            ->withPivot('tipo_id')
            ->wherePivot('tipo_id', 1);
    }

    public function eventosComoAsistente(): BelongsToMany
    {
        return $this->belongsToMany(Evento::class, 'participantes', 'user_id', 'evento_id')
            ->withPivot('tipo_id')
            ->wherePivot('tipo_id', 2);
    }

    public function eventosComoPonente(): BelongsToMany
    {
        return $this->belongsToMany(Evento::class, 'participantes', 'user_id', 'evento_id')
            ->withPivot('tipo_id', 'ponencia')
            ->wherePivot('tipo_id', 3);
    }

    public function eventosComoOrganizador(): BelongsToMany
    {
        return $this->belongsToMany(Evento::class, 'participantes', 'user_id', 'evento_id')
            ->withPivot('tipo_id')
            ->wherePivot('tipo_id', 4);
    }

    // Relación para obtener todos los eventos del usuario sin importar el tipo
    public function eventos(): BelongsToMany
    {
        return $this->belongsToMany(Evento::class, 'participantes', 'user_id', 'evento_id')
            ->withPivot('tipo_id', 'ponencia');
    }
}
