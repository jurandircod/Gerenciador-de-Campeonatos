<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('patrocinadores', function (Blueprint $table) {
            $table->id();
            $table->string('nome');
            $table->string('contato_nome')->nullable();
            $table->string('contato_email')->nullable();
            $table->string('contato_telefone')->nullable();
            $table->decimal('valor_patrocinio', 10, 2)->nullable();
            $table->enum('status', ['Proposta Enviada', 'Em Negociação', 'Confirmado', 'Recusado'])->default('Proposta Enviada');
            $table->text('observacoes')->nullable();
            $table->timestamps();
            $table->softDeletes(); // ← ADICIONE ESTA LINHA

        });
    }

    public function down(): void
    {
        Schema::dropIfExists('patrocinadores');
    }
};
