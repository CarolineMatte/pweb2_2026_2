<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('passaportes', function (Blueprint $table) {
            $table->id();
            $table->string('numero_documento', 30);
            $table->string('pais_emissor', 100);
            $table->date('data_validade');
            $table->foreignId('cliente_id')->unique()->constrained('clientes')->onDelete('cascade');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('passaportes');
    }
};
