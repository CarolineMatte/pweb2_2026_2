<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('atracoes', function (Blueprint $table) {
            $table->id();
            $table->string('nome');
            $table->text('descricao');
            $table->string('imagem')->nullable(); // nome do arquivo salvo no disco public
            $table->foreignId('destino_id')
                  ->constrained('destinos')
                  ->onDelete('cascade'); // ao excluir destino, exclui suas atrações
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('atracoes');
    }
};
