<?php

declare(strict_types=1);

namespace App\Http\Requests\Auth;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rules;
use JetBrains\PhpStorm\ArrayShape;

/**
 * @property string|null $token
 * @property string|null $email
 * @property string|null $password
 */
class ResetPasswordRequest extends FormRequest
{
    /**
     * @return bool
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * @return array
     */
    #[ArrayShape([
        'token' => "string[]",
        'email' => "string[]",
        'password' => "array"
    ])] public function rules(): array
    {
        return [
            'token' => [
                'required',
                'string',
            ],
            'email' => [
                'required',
                'string',
                'email',
            ],
            'password' => [
                'required',
                'string',
                'confirmed',
                Rules\Password::defaults(),
            ],
        ];
    }
}
