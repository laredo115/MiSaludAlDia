<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('citas', function (Blueprint $table) {
            $table->foreignId('user_id')
                ->constrained('users')
                ->cascadeOnDelete();

            $table->string('especialidad', 150);
            $table->dateTime('fecha_hora');
            $table->string('lugar', 255)->nullable();
            $table->text('preguntas')->nullable();

            $table->index(['user_id', 'fecha_hora']);
        });
    }

    public function down(): void
    {
        Schema::table('citas', function (Blueprint $table) {
            $table->dropForeign(['user_id']);
            $table->dropIndex(['user_id', 'fecha_hora']);

            $table->dropColumn([
                'user_id',
                'especialidad',
                'fecha_hora',
                'lugar',
                'preguntas',
            ]);
        });
    }
};