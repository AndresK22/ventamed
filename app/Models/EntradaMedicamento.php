<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class EntradaMedicamento extends Model
{
    use HasFactory, SoftDeletes;
    protected $fillable = [
        'fechaEntrada',
        'montoEntrada'
    ];

    public function detalleEntradas()
    {
        return $this->hasMany(DetalleEntrada::class);
    }

    //Scope Query
    public function scopeFechaEntrada1($query, $fechaEntrada){
        if($fechaEntrada){
            return $query->where('fechaEntrada', '=', "%$fechaEntrada%");
        }
    }
    public function scopeFechaEntrada2($query, $fechasEntradas){
        if($fechasEntradas){
            return $query->where('fechaEntrada', 'between', "$fechasEntradas[0]", 'and', "$fechasEntradas[1]");
        }
    }
}
