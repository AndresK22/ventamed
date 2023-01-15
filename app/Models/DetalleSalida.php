<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class DetalleSalida extends Model
{
    use HasFactory, SoftDeletes;
    protected $fillable = [
        'salida_id',
        'medicamento_id',
        'cantidadSalida',
        'subSalida'
    ];

    public function medicamentos()
    {
        return $this->belongsTo(Medicamento::class);
    }
    public function salidaMedicamentos()
    {
        return $this->belongsTo(SalidaMedicamento::class);
    }
}
