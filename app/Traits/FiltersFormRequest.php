<?php

namespace App\Traits;

trait FiltersFormRequest
{
    protected function filterEmptyRules(array $rules): array
    {
        $sentWithRequest = $this->request->all();

        foreach ($rules as $field => $rule) {
            if (! $this->request->has($field) || empty($this->$field)) {
                unset($rules[$field]);
            }
        }

        return $rules;
    }
}
