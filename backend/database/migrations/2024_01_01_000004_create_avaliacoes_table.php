<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('avaliacoes', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained('users');
            $table->foreignId('optativa_id')->constrained('optativas');
            $table->tinyInteger('nota_geral')->unsigned()->comment('1-5');
            $table->tinyInteger('nota_didatica')->unsigned()->comment('1-5');
            $table->tinyInteger('nota_conteudo')->unsigned()->comment('1-5');
            $table->tinyInteger('nota_dificuldade')->unsigned()->comment('1-5');
            $table->text('comentario');
            $table->json('tags')->nullable();
            $table->boolean('anonima')->default(false);
            $table->timestamps();

            $table->unique(['user_id', 'optativa_id']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('avaliacoes');
    }
};
