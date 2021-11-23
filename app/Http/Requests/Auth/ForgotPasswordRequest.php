<?php

declare(strict_types=1);

namespace App\Http\Requests\Auth;

use Illuminate\Foundation\Http\FormRequest;

/**
 * @property string|null $email
 */
class ForgotPasswordRequest extends FormRequest
{
    /**
     * @return bool
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * @return string[][]
     */
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
