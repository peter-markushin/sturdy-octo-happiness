<?php

declare(strict_types=1);

namespace App\Infrastructure\Laravel\Requests\User;

use Illuminate\Foundation\Http\FormRequest;

final class CreateUserAccountRequest extends FormRequest
{
    public function rules(): array
    {
        return [
            'balance' => ['required', 'integer', 'min:0'],
        ];
    }
}
