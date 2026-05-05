<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('optativas', function (Blueprint $table) {
            $table->id();
            $table->string('nome');
            $table->string('codigo')->unique();
            $table->foreignId('curso_id')->constrained('cursos');
            $table->foreignId('professor_id')->constrained('professores');
            $table->string('semestre');
            $table->text('descricao')->nullable();
            $table->integer('creditos');
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('optativas');
    }
};
