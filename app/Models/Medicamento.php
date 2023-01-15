<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Medicamento extends Model
{
    use HasFactory, SoftDeletes;
    protected $fillable = [
        'codBarras',
        'nombreMedicamento',
        'cantidaMedicamento',
        'precioUnitario'
    ];

    public function detalleEntradas()
    {
        return $this->hasMany(DetalleEntrada::class);
    }
    public function detalleSalidas()
    {
        return $this->hasMany(DetalleSalida::class);
    }

    //Scope Query
    public function scopeNombreMedicamento($query, $nombreMedicamento){
        if($nombreMedicamento){
            return $query->where('nombreMedicamento', 'like', "%$nombreMedicamento%");
        }
    }
}
