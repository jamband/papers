<?php

declare(strict_types=1);

namespace App\Http\Requests\Paper;

use Illuminate\Foundation\Http\FormRequest;

class UpdateRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'title' => [
                'required',
                'string',
                'max:100',
            ],
            'body' => [
                'required',
                'string',
            ],
        ];
    }
}
