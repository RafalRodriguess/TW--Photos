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
        Schema::table('transactions', function (Blueprint $table) {
            $table->string('proof')->nullable()->after('amount'); // Adiciona a coluna `proof` após `amount`
        });
    }
    
    public function down()
    {
        Schema::table('transactions', function (Blueprint $table) {
            $table->dropColumn('proof');
        });
    }
    
};