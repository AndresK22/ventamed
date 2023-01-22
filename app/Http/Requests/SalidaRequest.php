<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class SalidaRequest extends FormRequest
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
            'salida_id' => 'integer',
            'fechaSalida' => 'date',
            'precioSalida' => 'numeric|between:0.01,999.99',
            'subSalida' => 'numeric|between:0.01,999.99',
            'montoSalida' => 'numeric|between:0.01,999.99'
        ];
    }
}