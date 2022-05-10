<?php

namespace App\Http\Requests\Task;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\Rule;

class UpdateTaskRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return Auth::check();
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, mixed>
     */
    public function rules()
    {
        return [
            'task' => ['required', 'max:3000'],
            'notes' => ['sometimes', 'max:4294967295'],
            'due_date' => ['sometimes', 'date'],
            'completed_at' => ['sometimes', 'date', 'after_or_equal::due_date'],
            'priority' => ['sometimes', Rule::in(['Low', 'Medium', 'High'])],
            'assigned_to_id' => ['sometimes', Rule::exists('users', 'id')]
        ];
    }
}
