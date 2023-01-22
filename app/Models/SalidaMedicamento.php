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
        'horaSalida',
        'montoSalida'
    ];

    public function detalleSalida()
    {
        return $this->hasMany(DetalleSalida::class);
    }

    //Scope Query
    public function scopeFechaSalida1($query, $fechaSalida){
        if($fechaSalida){
            return $query->where('fechaSalida', '=', "$fechaSalida");
        }
    }
    public function scopeFechaSalida2($query, $fechaSalida1, $fechaSalida2){
        if($fechaSalida1){
            if($fechaSalida2){
                return $query->whereBetween('fechaSalida', [$fechaSalida1, $fechaSalida2]);
                dd($query);
            }
        }
    }
}
