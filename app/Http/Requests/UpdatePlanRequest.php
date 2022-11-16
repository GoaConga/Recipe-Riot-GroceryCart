<?php

namespace App\Http\Requests;

use App\Models\Plan;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Response;

class UpdatePlanRequest extends FormRequest
{
    public function authorize()
    {
        return true;
    }

    public function rules()
    {
        return [
            'week'          => [
                'string',
                'required',
            ],
            'name'=> [
                'string',
                'required',
            ],
            'description'=> [
                'string',
                'required',
            ],
            'date' => ['required'],
            'recipes'   => [
                'required',
                'array',
            ],
        ];
    }
}
