<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('clientes', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained()->onDelete('cascade');
            $table->string('nome');
            $table->string('telefone', 20);
            $table->string('cpf', 14)->nullable();
            $table->timestamps();
            $table->softDeletes();

            $table->index(['user_id', 'nome']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('clientes');
    }
};
