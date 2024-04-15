<?php

declare(strict_types=1);

namespace App\Infrastructure\User\Command;

use App\Domain\Shared\Bus\Command;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

final readonly class CreateUserCommand implements Command
{
    private function __construct(
        public string $email,
        public string $name,
        public string $password,
    )
    {
    }

    public static function createFromRequest(FormRequest $request): self
    {
        $data = $request->safe(['name', 'email', 'password']);

        return new self(
            $data['email'],
            $data['name'],
            Hash::make($data['password']),
        );
    }
}
