<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Responsabilidad extends Model
{
    protected $table = 'responsabilidades';
    protected $guarded = [];
    protected $casts = ['estado' => 'boolean'];
}
