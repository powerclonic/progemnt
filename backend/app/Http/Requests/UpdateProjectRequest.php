<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UpdateProjectRequest extends FormRequest
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
            'title'         => ['string', 'max:128'],
            'description'   => ['string', 'max:4096'],
            'visibility'    => ['in:1,2,3'],
            'deadline'      => ['date', 'after:today']
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
