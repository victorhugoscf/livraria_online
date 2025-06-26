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
        Schema::create('copies', function (Blueprint $table) {
            $table->id();
            $table->foreignId('book_id')->constrained()->onDelete('cascade'); // Chave estrangeira para books
            $table->string('patrimony_code')->unique(); // Código de patrimônio/identificação do exemplar
            $table->enum('status', ['available', 'loaned', 'reserved', 'damaged', 'lost', 'in_maintenance'])->default('available');
            $table->boolean('is_active')->default(true); // Exemplar ativo no acervo
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('copies');
    }
};