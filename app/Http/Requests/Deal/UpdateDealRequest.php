<?php

namespace App\Http\Requests\Deal;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class UpdateDealRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return false;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, mixed>
     */
    public function rules()
    {
        return [
            'name' => ['required', 'max:1000'],
            'amount' => ['sometimes', 'numeric'],
            'owner_id' => ['sometimes', Rule::exists('users', 'id')],
            'type' => ['sometimes', Rule::in(config('defaults.deals.types'))],
            'stage' => ['sometimes', Rule::in(config('defaults.deals.stages'))],
            'priority' => ['sometimes', Rule::in(config('defaults.priorities'))]
        ];
    }
}
