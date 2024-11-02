<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
/*       Schema::create('imagens_selecionadas', function (Blueprint $table) {
    $table->id();
    $table->foreignId('trabalho_id')->constrained()->onDelete('cascade');
    $table->foreignId('trabalho_imagem_id')->constrained('trabalho_imagens')->onDelete('cascade'); // Nome correto da tabela
    $table->timestamps();
}); */
       
        
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('imagens_selecionadas');
    }
};
