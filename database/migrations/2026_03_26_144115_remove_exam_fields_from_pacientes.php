<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up()
    {
        Schema::table('pacientes', function (Blueprint $table) {
            // 1. Removemos as "regras" (constraints) primeiro
            // O padrão do Laravel é: nome_da_tabela_nome_da_coluna_foreign
            $table->dropForeign(['medico_id']);
            $table->dropForeign(['user_agendamento_id']);
            $table->dropForeign(['user_cancelamento_id']);

            // 2. Agora sim, podemos apagar as colunas com segurança
            $table->dropColumn([
                'data_exame', 
                'medico_id', 
                'justificativa_cancelamento', 
                'data_cancelamento', 
                'user_agendamento_id', 
                'user_cancelamento_id'
            ]);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('pacientes', function (Blueprint $table) {
            // 1. Recriamos as colunas
            $table->dateTime('data_exame')->nullable();
            $table->foreignId('medico_id')->nullable()->constrained()->onDelete('set null');
            $table->text('justificativa_cancelamento')->nullable();
            $table->dateTime('data_cancelamento')->nullable();
            $table->foreignId('user_agendamento_id')->nullable()->constrained('users')->onDelete('set null');
            $table->foreignId('user_cancelamento_id')->nullable()->constrained('users')->onDelete('set null');
        });
    }
};
