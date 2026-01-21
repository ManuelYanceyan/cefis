<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Model;

class Certificado extends Model
{
    use HasUuids;
    protected $table = 'certificados';
    public $incrementing = false;

    protected $fillable = [
            'tipo_id',
            'user_id',
            'evento_id',
                ];


        protected $hidden = [];

}
