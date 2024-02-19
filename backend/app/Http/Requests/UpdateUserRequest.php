<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UpdateUserRequest extends FormRequest
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
            "email" => ['email', 'unique:users,email'],
            "password" => ['string', 'min:8'],
            "current_password" => ['required_with:password']
        ];
    }

    public function attributes()
    {
        return [
            "password" => "nova senha",
            "current_password" => "senha atual"
        ];
    }
}
