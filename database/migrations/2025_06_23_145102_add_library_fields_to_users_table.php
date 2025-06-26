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
        Schema::table('users', function (Blueprint $table) {
            $table->string('cpf')->unique()->nullable()->after('email'); 
            $table->string('matricula')->unique()->nullable()->after('cpf'); 
            $table->string('phone')->nullable()->after('matricula');
            $table->text('address')->nullable()->after('phone');
            $table->enum('user_type', ['member', 'librarian', 'admin'])->default('member')->after('password');
            $table->boolean('is_active')->default(true)->after('user_type');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('users', function (Blueprint $table) {
            $table->dropColumn(['cpf', 'matricula', 'phone', 'address', 'user_type', 'is_active']);
        });
    }
};