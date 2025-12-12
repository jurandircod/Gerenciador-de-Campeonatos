<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('responsaveis', function (Blueprint $table) {
            $table->id();
            $table->string('nome');
            $table->string('email')->unique();
            $table->string('telefone')->nullable();
            $table->string('area_responsabilidade');
            $table->timestamps();
            $table->softDeletes(); // ← ADICIONE ESTA LINHA

        });
    }

    public function down(): void
    {
        Schema::dropIfExists('responsaveis');
    }
};