<?php

namespace App\Http\Requests\Deal;

use App\Traits\FiltersFormRequest;
use Carbon\Carbon;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\Rule;

class UpdateDealRequest extends FormRequest
{
    use FiltersFormRequest;

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
        $rules = [
            'name' => ['required', 'max:1000'],
            'amount' => ['sometimes', 'numeric'],
            'owned_by_id' => ['sometimes', Rule::exists('users', 'id')],
            'type' => ['sometimes', Rule::in(config('defaults.deals.types'))],
            'stage' => ['sometimes', Rule::in(config('defaults.deals.stages'))],
            'priority' => ['sometimes', Rule::in(config('defaults.priorities'))],
            'close_date' => ['sometimes', 'date'],
        ];

         return $this->filterEmptyRules($rules);
    }

    protected function prepareForValidation()
    {
        $data = [];

        if (!empty($this->close_date)) {
            $data['close_date'] = Carbon::now()->toDateString();
        }

        if (!empty($this->owned_by_id)) {
            $data['owned_by_id'] = $this->owned_by_id['id'];
        }

//        foreach ($this->keys() as $key) {
//            if (empty($this->get($key))) {
//                $this->request->remove($key);
//            }
//        }

        $this->merge(array_filter($data));
    }
}
