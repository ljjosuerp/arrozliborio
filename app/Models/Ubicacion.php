<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Ubicacion extends Model
{
    protected $table = 'ubicaciones';
    protected $guarded = [];

    public function provincia(): BelongsTo
    {
        return $this->belongsTo(Provincia::class);
    }
}
