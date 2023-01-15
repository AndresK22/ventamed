<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class SalidaMedicamento extends Model
{
    use HasFactory, SoftDeletes;
    protected $fillable = [
        'fechaSalida',
        'montoSalida'
    ];

    public function detalleSalidas()
    {
        return $this->hasMany(DetalleSalida::class);
    }
}
