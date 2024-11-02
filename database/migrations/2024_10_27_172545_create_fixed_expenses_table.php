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
        Schema::create('fixed_expenses', function (Blueprint $table) {
            $table->id();
            $table->string('description');
            $table->decimal('amount', 10, 2);
            $table->integer('due_day'); // Dia do vencimento
            $table->enum('status', ['pendente', 'pago'])->default('pendente');
            $table->timestamps();
        });
        
    }
    
    public function down()
    {
        Schema::dropIfExists('fixed_expenses');
    }
    
};
