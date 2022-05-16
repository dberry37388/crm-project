<?php

namespace App\Http\Requests\Contact;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\Rule;

class StoreContactRequest extends FormRequest
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
            'first_name' => ['required', 'max:255'],
            'last_name' => ['required', 'max:255'],
            'email' => ['sometimes', 'max:255'],
            'job_title' => ['sometimes', 'max:255'],
            'phone_number' => ['sometimes', 'max:255'],
            'mobile_number' => ['sometimes', 'max:255'],
            'description' => ['sometimes', 'max:255'],
            'assigned_to_id' => ['sometimes', Rule::exists('users', 'id')],
        ];
    }

    protected function prepareForValidation()
    {
        $data = [];

        if (!empty($this->assigned_to)) {
            $data['assigned_to_id'] = $this->assigned_to['id'];
        }

        $this->merge($data);
    }
}
