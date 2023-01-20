<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class EntradaRequest extends FormRequest
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
            'entrada_id' => 'integer',
            'fechaEntrada' => 'date',
            'proveedorEntrada' => 'string|max:255',
            'montoEntrada' => 'numeric|between:0.01,999.99'
        ];
    }
}