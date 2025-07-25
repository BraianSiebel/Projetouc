<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('clientes_pagantes', function (Blueprint $table) {
            $table->id();
            $table->string('nome');
            $table->decimal('valor_contrato', 19, 4);
            $table->timestamps();
            $table->boolean('UC_existente')->default(true);

            // --- LINHAS ADICIONADAS ---
            $table->unsignedBigInteger('user_id')->nullable();
            $table->foreign('user_id')
                ->references('id')
                ->on('users')
                ->onDelete('set null');
            // --------------------------

        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('clientes_pagantes');
    }

};
