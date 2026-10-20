<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Medicamento extends Model
{
    protected $table = 'medicamentos';

    protected $fillable = [
        'nombre',
        'dosis',
        'hora',
        'notas',
    ];

    public function usuario(): BelongsTo
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    public function tomas(): HasMany
    {
        return $this->hasMany(Toma::class, 'medicamento_id');
    }
}