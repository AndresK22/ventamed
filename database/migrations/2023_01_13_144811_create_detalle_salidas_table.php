<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use App\Models\SalidaMedicamento;
use App\Models\Medicamento;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('detalle_salidas', function (Blueprint $table) {
            $table->id();
            //$table->foreignId('salida_medicamento_id')->constrained();
            $table->foreignIdFor(SalidaMedicamento::class)->references('id')->on('salida_medicamentos')->onDelete('cascade');
            //$table->foreignId('medicamento_id')->constrained();
            $table->foreignIdFor(Medicamento::class)->references('id')->on('medicamentos');
            $table->integer('cantidadSalida');
            $table->decimal('precioSalida', 5, 2);
            $table->decimal('subSalida', 5, 2)->nullable();
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
        Schema::dropIfExists('detalle_salidas');
    }
};
