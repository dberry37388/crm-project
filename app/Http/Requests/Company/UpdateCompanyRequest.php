<?php

namespace App\Http\Requests\Company;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\Rule;

class UpdateCompanyRequest extends FormRequest
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
            'name' => ['required', 'max:255'],
            'description' => ['sometimes', 'max:255'],
            'city' => ['sometimes', 'max:255'],
            'state' => ['sometimes', 'max:255'],
            'postal_code' => ['sometimes', 'max:255'],
            'number_of_employees' => ['sometimes', 'max:255'],
            'timezone' => ['sometimes', 'max:255'],
            'industry_id' => ['sometimes', Rule::exists('industries')],
        ];
    }
}
