<?php

namespace App\Http\Requests\Task;

use Carbon\Carbon;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Arr;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\Rule;

class StoreTaskRequest extends FormRequest
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
    public function rules(): array
    {
        return [
            'task' => ['required', 'max:3000'],
            'notes' => ['sometimes', 'max:4294967295'],
            'due_date' => ['sometimes', 'date'],
            'completed_at' => ['sometimes'],
            'priority' => ['sometimes', Rule::in(['Low', 'Medium', 'High'])],
            'assigned_to_id' => ['sometimes', Rule::exists('users', 'id')]
        ];
    }

    protected function prepareForValidation()
    {
        $data = [];

        if (empty($this->due_date)) {
            $data['due_date'] = Carbon::now()->toDateString();
        }

        $data['assigned_to_id'] = Arr::get($this->assigned_to, 'id', Auth::id());

        $this->merge(array_filter($data));
    }
}
