<?php

declare(strict_types=1);

namespace App\Groups\Auth;

use Illuminate\Foundation\Http\FormRequest;

/**
 * @property string|null $email
 */
class ForgotPasswordRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'email' => [
                'required',
                'string',
                'email',
            ],
        ];
    }
}
