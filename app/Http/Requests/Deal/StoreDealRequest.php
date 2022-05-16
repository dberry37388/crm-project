<?php

namespace App\Http\Requests\Deal;

use Carbon\Carbon;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Arr;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\Rule;

class StoreDealRequest extends FormRequest
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
            'name' => ['required', 'max:1000'],
            'amount' => ['sometimes', 'numeric'],
            'owned_by_id' => ['sometimes', Rule::exists('users', 'id')],
            'type' => ['required', Rule::in(config('defaults.deals.types'))],
            'stage' => ['required', Rule::in(config('defaults.deals.stages'))],
            'priority' => ['sometimes', Rule::in(config('defaults.priorities'))],
            'close_date' => ['sometimes'],
        ];
    }

    protected function prepareForValidation()
    {
        $data = [];

        $data['owned_by_id'] = Arr::get($this->owner, 'id', Auth::id());

        if (empty($this->type)) {
            $data['type'] = config('defaults.deals.types')[0];
        }

        if (empty($this->stage)) {
            $data['stage'] = config('defaults.stages')[0];
        }

        if (empty($this->priority)) {
            $data['priority'] = config('defaults.priorities')[0];
        }

        if (!empty($this->close_date)) {
            dd($this->close_date);
            $data['close_date'] = Carbon::now()->toDateString();
        }

        $this->merge(array_filter($data));
    }
}
