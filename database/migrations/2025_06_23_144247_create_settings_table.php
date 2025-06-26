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
        Schema::create('settings', function (Blueprint $table) {
            $table->id();
            $table->string('key')->unique(); // Chave da configuração (ex: 'loan_limit', 'loan_period_days')
            $table->string('value'); // Valor da configuração
            $table->string('description')->nullable(); // Descrição do que a configuração faz
            $table->timestamps();
        });

        // Adicionar algumas configurações iniciais (pode ser feito em um Seeder também)
        // Você pode adicionar isso aqui ou usar um Seeder para popular os dados iniciais.
        // Se for fazer aqui, use DB::table('settings')->insert([...]);
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('settings');
    }
};