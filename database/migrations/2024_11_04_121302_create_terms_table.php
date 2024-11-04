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
        Schema::create('terms', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('client_id'); // ID do cliente relacionado
            $table->date('term_date'); // Data do termo
            $table->text('description'); // Descrição interna do termo
            $table->string('purpose'); // Finalidade do termo (ex: Marketing, Instagram)
            $table->timestamps();
    
            $table->foreign('client_id')->references('id')->on('clients')->onDelete('cascade');
        });
    }
    

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('terms');
    }
};
