<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class DetalleEntrada extends Model
{
    use HasFactory, SoftDeletes;
    protected $fillable = [
        'cantidadEntrada',
        'precioEntrada',
        'subEntrada'
    ];

    public function entradaMedicamento()
    {
        return $this->belongsTo(EntradaMedicamento::class);
    }

    public function medicamento()
    {
        return $this->belongsTo(Medicamento::class);
    }
}
