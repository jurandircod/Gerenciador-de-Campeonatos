<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('tarefas', function (Blueprint $table) {
            $table->id();
            $table->foreignId('responsavel_id')->constrained('responsaveis')->onDelete('cascade');
            $table->foreignId('area_id')->constrained('areas')->onDelete('cascade');
            $table->string('titulo');
            $table->text('descricao')->nullable();
            $table->date('prazo');
            $table->enum('status', ['Pendente', 'Em Andamento', 'Concluída'])->default('Pendente');
            $table->enum('prioridade', ['Alta', 'Média', 'Baixa'])->default('Média');
            $table->timestamps();
            $table->softDeletes(); // ← ADICIONE ESTA LINHA

        });
    }

    public function down(): void
    {
        Schema::dropIfExists('tarefas');
    }
};
