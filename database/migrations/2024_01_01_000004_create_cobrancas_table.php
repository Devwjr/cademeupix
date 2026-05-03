<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('cobrancas', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained()->onDelete('cascade');
            $table->foreignId('divida_id')->constrained()->onDelete('cascade');
            $table->string('chave_pix')->unique();
            $table->decimal('valor', 10, 2);
            $table->enum('status', ['pendente', 'pago', 'vencido'])->default('pendente');
            $table->string('link_pagamento')->nullable();
            $table->timestamps();

            $table->index(['user_id', 'status']);
            $table->index(['divida_id']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('cobrancas');
    }
};
