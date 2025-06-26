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
        Schema::create('loans', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained()->onDelete('cascade'); // Usuário que pegou o livro
            $table->foreignId('copy_id')->constrained()->onDelete('cascade'); // Exemplar emprestado
            $table->dateTime('loan_date')->useCurrent(); // Data e hora do empréstimo
            $table->dateTime('due_date'); // Data prevista de devolução
            $table->dateTime('return_date')->nullable(); // Data real da devolução
            $table->enum('status', ['in_progress', 'returned', 'overdue', 'cancelled'])->default('in_progress');
            $table->decimal('fine_amount', 8, 2)->default(0.00); // Valor da multa, se houver
            $table->timestamps();

            // Adicionar índices para otimização de consultas
            $table->index('user_id');
            $table->index('copy_id');
            $table->index('status');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('loans');
    }
};