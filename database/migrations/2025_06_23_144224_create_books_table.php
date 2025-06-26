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
        Schema::create('books', function (Blueprint $table) {
            $table->id();
            $table->string('isbn')->unique();
            $table->string('title');
            $table->string('author');
            $table->string('publisher')->nullable();
            $table->unsignedSmallInteger('publication_year')->nullable(); // Ano de publicação
            $table->string('edition')->nullable();
            $table->string('genre')->nullable();
            $table->string('language')->default('Português');
            $table->unsignedSmallInteger('pages')->nullable();
            $table->unsignedInteger('total_copies')->default(0); // Total de exemplares físicos
            $table->unsignedInteger('available_copies')->default(0); // Exemplares disponíveis para empréstimo
            $table->boolean('is_active')->default(true); // Livro ativo no acervo
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('books');
    }
};