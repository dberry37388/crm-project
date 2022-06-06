<?php

namespace App\Http\Controllers\Api\V1;

use App\Http\Controllers\Controller;
use App\Models\Company;
use App\Models\Task;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Auth;

class BaseApiController extends Controller
{
    /**
     * @param Model $model
     * @return string
     */
    public function getNoteableType(Model $model): string
    {
        return class_basename($model);
    }
}
