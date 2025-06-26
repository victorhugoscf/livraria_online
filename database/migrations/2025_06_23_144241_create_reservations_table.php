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
        Schema::create('reservations', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained()->onDelete('cascade');
            $table->foreignId('book_id')->constrained()->onDelete('cascade'); // Livro que está sendo reservado
            $table->dateTime('reservation_date')->useCurrent();
            $table->dateTime('expiration_date')->nullable(); // Data até quando a reserva é válida para retirada
            $table->enum('status', ['pending', 'available_for_pickup', 'cancelled', 'completed'])->default('pending');
            $table->timestamps();

            // Adicionar índices para otimização
            $table->index('user_id');
            $table->index('book_id');
            $table->index('status');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('reservations');
    }
};