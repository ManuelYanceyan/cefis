<?php

namespace App\Http\Requests\Admin;

use Illuminate\Foundation\Http\FormRequest;

class AddOrganizadorRequest extends FormRequest
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
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'organizador' => 'required|exists:users,id'
        ];
    }
        public function messages(): array
    {
        return [
            "organizador.required" => "Debe seleccionar un organizador",
            "organizador.exists" => "El organizador  no existe",
        ];
    }
}
