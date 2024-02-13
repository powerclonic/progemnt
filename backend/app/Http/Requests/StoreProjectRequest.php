<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreProjectRequest extends FormRequest
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
            'title'         => ['required', 'string', 'max:128'],
            'description'   => ['required', 'string', 'max:4096'],
            'visibility'    => ['required', 'in:1,2,3'],
            'deadline'      => ['required', 'date', 'after:today']
        ];
    }

    public function attributes()
    {
        return [
            'deadline'      => 'prazo',
            'visibility'    => 'visibilidade'
        ];
    }
}
