<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Carrusel extends Model
{
    protected $table = 'carruseles';
    protected $guarded = [];
    protected $casts = ['estado' => 'boolean'];
}
