<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('fornecedores', function (Blueprint $table) {
            $table->id();
            $table->string('nome');
            $table->enum('tipo', ['Som', 'Alimentação', 'Estrutura', 'Pista', 'Outros']);
            $table->string('contato_nome')->nullable();
            $table->string('contato_telefone')->nullable();
            $table->string('contato_email')->nullable();
            $table->decimal('valor_orcamento', 10, 2)->nullable();
            $table->enum('status', ['Orçamento', 'Contratado', 'Cancelado'])->default('Orçamento');
            $table->text('observacoes')->nullable();
            $table->timestamps();
            $table->softDeletes(); // ← ADICIONE ESTA LINHA

        });
    }

    public function down(): void
    {
        Schema::dropIfExists('fornecedores');
    }
};
