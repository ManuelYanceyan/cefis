<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Tipo extends Model
{
    
protected $table = 'tipos';
public $timetapms = false;
protected $fillable = ['tipo'];

 
    protected $hidden = [
        'id',
    ];
}
