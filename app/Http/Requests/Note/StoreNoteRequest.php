<?php

namespace App\Http\Requests\Note;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Auth;

class StoreNoteRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize(): bool
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
            'note' => ['required']
        ];
    }

    protected function prepareForValidation()
    {
        $data = [];

        if (empty($this->assigned_to)) {
            $data['assigned_to_id'] = Auth::user()->id;
        }

        $this->merge(array_filter($data));
    }
}
