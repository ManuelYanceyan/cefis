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
    use HasApiTokens, HasFactory, HasRolesAndAbilities, Notifiable;

    public $timestamps = true;

    protected $fillable = [
        'paternal_surname',
        'maternal_surname',
        'name',
        'email',
        'password',
        'dni',
    ];

    protected $hidden = [
        'password',
        'remember_token',
    ];

    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password' => 'hashed',
        ];
    }

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

    public function eventos(): BelongsToMany
    {
        return $this->belongsToMany(Evento::class, 'participantes', 'user_id', 'evento_id')
            ->withPivot('tipo_id', 'ponencia');
    }
}
