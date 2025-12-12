<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('orcamento', function (Blueprint $table) {
            $table->id();
            $table->string('categoria'); // Patrocínios, Pista, Som, Alimentação, etc
            $table->string('descricao');
            $table->decimal('valor_previsto', 10, 2)->default(0);
            $table->decimal('valor_realizado', 10, 2)->default(0);
            $table->enum('tipo', ['Receita', 'Despesa']);
            $table->timestamps();
            $table->softDeletes(); // ← ADICIONE ESTA LINHA

        });
    }

    public function down(): void
    {
        Schema::dropIfExists('orcamento');
    }
};
