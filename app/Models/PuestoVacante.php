<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class PuestoVacante extends Model
{
    protected $table = 'puestos_vacantes';
    protected $guarded = [];
    protected $casts = ['estado' => 'boolean'];
}
