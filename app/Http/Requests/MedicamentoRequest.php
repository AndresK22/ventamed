<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class MedicamentoRequest extends FormRequest
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
            'codBarras' => 'required|string|max:25|unique:medicamentos,codBarras',
            'nombreMedicamento' => 'required|string|max:255',
            'cantidadMedicamento' => 'nullable|integer|min:0',
            'precioUnitario' => 'required|numeric|between:0.01,999.99',
        ];
    }
}