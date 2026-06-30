<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Evento extends Model
{
    protected $table = 'eventos';
    protected $guarded = [];
    protected $casts = ['estado' => 'boolean', 'fecha' => 'date'];
}
