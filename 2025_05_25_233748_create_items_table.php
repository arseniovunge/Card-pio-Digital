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
    Schema::create('items', function (Blueprint $table) {
        $table->id();
        $table->string('nome');
        $table->text('descricao');
        $table->decimal('preco', 10, 2);
        $table->string('imagem_url')->nullable();
        $table->foreignId('categoria_id')->constrained()->onDelete('cascade');
        $table->foreignId('restaurante_id')->constrained()->onDelete('cascade');
        $table->timestamps();
    });
}

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('items');
    }
};
