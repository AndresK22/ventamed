<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class DetalleSalida extends Model
{
    use HasFactory, SoftDeletes;
    protected $fillable = [
        'cantidadSalida',
        'precioSalida',
        'subSalida'
    ];

    public function salidaMedicamento()
    {
        return $this->belongsTo(SalidaMedicamento::class);
    }

    public function medicamento()
    {
        return $this->belongsTo(Medicamento::class);
    }
    
}
