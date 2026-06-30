<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Provincia extends Model
{
    protected $table = 'provincias';
    protected $guarded = [];

    public function ubicaciones(): HasMany
    {
        return $this->hasMany(Ubicacion::class)->orderBy('orden');
    }
}
