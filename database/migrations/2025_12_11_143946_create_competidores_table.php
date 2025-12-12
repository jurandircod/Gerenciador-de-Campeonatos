<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('competidores', function (Blueprint $table) {
            $table->id();
            $table->string('nome');
            $table->string('email')->unique();
            $table->string('telefone')->nullable();
            $table->date('data_nascimento');
            $table->enum('categoria', ['Iniciante', 'Amador', 'Profissional'])->default('Amador');
            $table->string('cidade')->nullable();
            $table->string('estado')->nullable();
            $table->enum('status_inscricao', ['Pendente', 'Confirmada', 'Cancelada'])->default('Pendente');
            $table->timestamps();
            $table->softDeletes();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('competidores');
    }
};
