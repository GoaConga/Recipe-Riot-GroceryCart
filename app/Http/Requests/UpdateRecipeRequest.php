<?php

namespace App\Http\Requests;

use App\Models\Recipe;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Response;

class UpdateRecipeRequest extends FormRequest
{
    public function authorize()
    {
        return true;
    }

    public function rules()
    {
        return [
            'name'          => [
                'string',
                'required',
            ],
            'category'          => [
                'string',
                'required',
            ],
            'serve'          => [
                'string',
                'required',
            ],
            'fave'          => [
                'string',
                'required',
            ],
            'rating'          => [
                'string',
                'required',
            ],
            'procedure'          => [
                'string',
                'required',
            ],
            'ingredients.*' => [
                'integer',
            ],
            'ingredients'   => [
                'required',
                'array',
            ],
        ];
    }
}
