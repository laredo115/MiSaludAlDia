<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('tomas', function (Blueprint $table) {
            $table->id();

            $table->foreignId('medicamento_id')
                ->constrained('medicamentos')
                ->cascadeOnDelete();

            $table->date('fecha');
            $table->dateTime('registrada_en');
            $table->timestamps();

            $table->unique(['medicamento_id', 'fecha']);
            $table->index('fecha');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('tomas');
    }
};