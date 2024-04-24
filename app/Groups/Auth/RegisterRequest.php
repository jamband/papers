<?php

declare(strict_types=1);

namespace App\Groups\Auth;

use Illuminate\Config\Repository;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rules;

/**
 * @property string|null $name
 * @property string|null $email
 * @property string|null $password
 */
class RegisterRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(
        Repository $config,
    ): array {
        return [
            'name' => [
                'required',
                'string',
                'min:'.$config->get('auth.name_min_length'),
                'max:'.$config->get('auth.name_max_length'),
            ],
            'email' => [
                'required',
                'string',
                'email',
                'max:255',
                'unique:users',
            ],
            'password' => [
                'required',
                'string',
                'confirmed',
                'min:'.$config->get('auth.password_min_length'),
                'max:'.$config->get('auth.password_max_length'),
                Rules\Password::defaults(),
            ],
        ];
    }
}
