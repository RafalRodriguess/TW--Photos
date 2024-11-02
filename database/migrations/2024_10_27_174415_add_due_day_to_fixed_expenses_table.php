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
        Schema::table('fixed_expenses', function (Blueprint $table) {
            $table->integer('due_day')->after('amount');
        });
    }
    
    public function down()
    {
        Schema::table('fixed_expenses', function (Blueprint $table) {
            $table->dropColumn('due_day');
        });
    }
    
};
