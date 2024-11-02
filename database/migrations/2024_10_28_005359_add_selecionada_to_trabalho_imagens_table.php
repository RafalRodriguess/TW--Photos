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
        Schema::table('trabalho_imagens', function (Blueprint $table) {
            $table->boolean('status')->default(0); // 0 = não selecionada, 1 = selecionada
        });
    }
    


    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('trabalho_imagens', function (Blueprint $table) {
            //
        });
    }
};
