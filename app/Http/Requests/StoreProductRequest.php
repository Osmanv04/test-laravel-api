<?php

namespace App\Http\Requests;

use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Foundation\Http\FormRequest;

class StoreProductRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'name' => 'required|string|max:255',
            'price' => 'required|numeric|min:0',
            'tax_cost' => 'required|numeric|min:0',
            'manufacturing_cost' => 'required|numeric|min:0',
            'description' => 'required|string',
            'currency_id' => 'required|exists:currencies,id',
        ];
    }

    public function messages(): array
    {
        return [
            'name.required' => 'El nombre del producto es obligatorio.',
            'name.string' => 'El nombre debe ser un texto.',
            'name.max' => 'El nombre no puede tener más de 255 caracteres.',
            'description.required' => 'La descripción del producto es obligatoria.',
            'description.string' => 'La descripción debe ser un texto.',
            'price.required' => 'El precio del producto es obligatorio.',
            'price.numeric' => 'El precio debe ser un número.',
            'price.min' => 'El precio debe ser mayor o igual a 0.',
            'currency_id.required' => 'La divisa es obligatoria.',
            'currency_id.exists' => 'La divisa seleccionada no existe.',
            'tax_cost.required' => 'El costo de impuestos es obligatorio.',
            'tax_cost.numeric' => 'El costo de impuestos debe ser un número.',
            'tax_cost.min' => 'El costo de impuestos debe ser mayor o igual a 0.',
            'manufacturing_cost.required' => 'El costo de fabricación es obligatorio.',
            'manufacturing_cost.numeric' => 'El costo de fabricación debe ser un número.',
            'manufacturing_cost.min' => 'El costo de fabricación debe ser mayor o igual a 0.',
        ];
    }
}
