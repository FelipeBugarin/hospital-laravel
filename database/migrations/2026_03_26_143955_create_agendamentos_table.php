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
        Schema::create('agendamentos', function (Blueprint $table) {
            $table->id();
            // Chaves Estrangeiras (Relacionamentos)
            $table->foreignId('paciente_id')->constrained()->onDelete('cascade');
            $table->foreignId('medico_id')->constrained()->onDelete('cascade');
            $table->foreignId('exame_id')->constrained()->onDelete('cascade');
            $table->foreignId('user_id')->constrained(); // Quem criou o agendamento
            
            // Dados do Exame
            $table->dateTime('data_prevista');
            $table->string('status')->default('Agendado'); // Agendado, Realizado, Cancelado
            
            // Dados do Cancelamento
            $table->text('justificativa_cancelamento')->nullable();
            $table->dateTime('data_cancelamento')->nullable();
            $table->foreignId('user_cancelamento_id')->nullable()->constrained('users');
            
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('agendamentos');
    }
};
