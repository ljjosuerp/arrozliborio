<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Aplicacion extends Model
{
    protected $table = 'aplicaciones';
    protected $guarded = [];

    public function aspirante(): BelongsTo
    {
        return $this->belongsTo(Aspirante::class);
    }

    public function puesto(): BelongsTo
    {
        return $this->belongsTo(PuestoVacante::class, 'puesto_vacante_id');
    }
}
