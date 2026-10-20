<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Toma extends Model
{
    protected $table = 'tomas';

    protected $fillable = [
        'fecha',
        'registrada_en',
    ];

    protected function casts(): array
    {
        return [
            'fecha' => 'date',
            'registrada_en' => 'datetime',
        ];
    }

    public function medicamento(): BelongsTo
    {
        return $this->belongsTo(
            Medicamento::class,
            'medicamento_id'
        );
    }
}