<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('medicamentos', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')
                ->constrained('users')
                ->cascadeOnDelete();

            $table->string('nombre', 150);
            $table->string('dosis', 150);
            $table->time('hora');
            $table->text('notas')->nullable();
            $table->timestamps();

            $table->index(['user_id', 'hora']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('medicamentos');
    }
};