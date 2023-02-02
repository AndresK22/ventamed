<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use App\Models\EntradaMedicamento;
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
        Schema::create('detalle_entradas', function (Blueprint $table) {
            $table->id();
            //$table->foreignId('entrada_medicamento_id')->constrained();
            $table->foreignIdFor(EntradaMedicamento::class)->references('id')->on('entrada_medicamentos')->onDelete('cascade');
            //$table->foreignId('medicamento_id')->constrained();
            $table->foreignIdFor(Medicamento::class)->references('id')->on('medicamentos');
            $table->integer('cantidadEntrada');
            $table->decimal('precioEntrada', 5, 2);
            $table->decimal('subEntrada', 5, 2)->nullable();
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
        Schema::dropIfExists('detalle_entradas');
    }
};
