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
        'proveedorEntrada',
        'montoEntrada'
    ];

    public function detalleEntrada()
    {
        return $this->hasMany(DetalleEntrada::class);
    }

    //Scope Query
    public function scopeProveedorEntrada($query, $proveedor){
        if($proveedor){
            return $query->where('proveedorEntrada', 'LIKE', "%$proveedor%");
        }
    }
    public function scopeFechaEntrada1($query, $fechaEntrada){
        if($fechaEntrada){
            return $query->where('fechaEntrada', '=', "$fechaEntrada");
        }
    }
    public function scopeFechaEntrada2($query, $fechasEntrada1, $fechasEntrada2){
        if($fechasEntrada1){
            if($fechasEntrada2){
                return $query->whereBetween('fechaEntrada', [$fechasEntrada1, $fechasEntrada2]);
                dd($query);
            }
        }
    }
}
