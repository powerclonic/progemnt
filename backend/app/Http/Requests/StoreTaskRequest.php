<?php

namespace App\Http\Requests;

use App\Models\Project;
use Illuminate\Foundation\Http\FormRequest;

class StoreTaskRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        $project = Project::find($this->project_id);
        return $this->user()->can('update', $project);
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'project_id'  => ['required', 'exists:projects,id'],
            'title'       => ['required', 'string', 'max:128'],
            'description' => ['nullable', 'string', 'max:4096'],
            'responsible' => ['nullable', 'exists:users,id'],
            'deadline'    => ['nullable', 'date', 'after_or_equal:today']
        ];
    }
}
