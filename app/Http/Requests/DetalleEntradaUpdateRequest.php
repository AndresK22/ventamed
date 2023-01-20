<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class DetalleEntradaUpdateRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, mixed>
     */
    public function rules()
    {
        return [
            'idDet' => 'required|integer',
            'cantidadEntradaEdit' => 'required|integer',
            'precioEntradaEdit' => 'required|numeric|between:0.01,999.99'
        ];
    }
}