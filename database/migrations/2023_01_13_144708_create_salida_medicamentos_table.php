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
        Schema::create('salida_medicamentos', function (Blueprint $table) {
            $table->id();
            $table->date('fechaSalida')->nullable();
            $table->time('horaSalida')->nullable();
            $table->decimal('montoSalida', 5, 2)->nullable();
            $table->timestamps();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('salida_medicamentos');
    }
};
