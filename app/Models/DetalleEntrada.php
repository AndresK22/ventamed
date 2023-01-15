<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class DetalleEntrada extends Model
{
    use HasFactory, SoftDeletes;
    protected $fillable = [
        'entrada_id',
        'medicamento_id',
        'cantidadEntrada',
        'precioEntrada',
        'subEntrada'
    ];

    public function medicamentos()
    {
        return $this->belongsTo(Medicamento::class);
    }
    public function entradaMedicamentos()
    {
        return $this->belongsTo(EntradaMedicamento::class);
    }
}
