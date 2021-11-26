<?php

declare(strict_types=1);

namespace App\Http\Requests\Paper;

use Illuminate\Foundation\Http\FormRequest;
use JetBrains\PhpStorm\ArrayShape;

class CreateRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    #[ArrayShape([
        'title' => "string[]",
        'body' => "string[]"
    ])] public function rules(): array
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
