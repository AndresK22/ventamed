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
        Schema::create('entrada_medicamentos', function (Blueprint $table) {
            $table->id();
            $table->date('fechaEntrada')->nullable();
            $table->string('proveedorEntrada', 255)->nullable();
            $table->decimal('montoEntrada', 5, 2)->nullable();
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
        Schema::dropIfExists('entrada_medicamentos');
    }
};
