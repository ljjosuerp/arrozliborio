<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Catalogo extends Model
{
    protected $table = 'catalogos';
    protected $guarded = [];
    protected $casts = ['estado' => 'boolean'];
}
