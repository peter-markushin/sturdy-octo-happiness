<?php

namespace App\Infrastructure\Laravel\Requests\User;

use Illuminate\Foundation\Http\FormRequest;

final class UpdateUserRequest extends FormRequest
{
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'name' => ['min:1'],
            'email' => ['email', 'unique:users,email'],
            'password' => ['min:6'],
        ];
    }
}
