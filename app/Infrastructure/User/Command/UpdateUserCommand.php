<?php

declare(strict_types=1);

namespace App\Infrastructure\User\Command;

use App\Domain\Shared\Bus\Command;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Hash;

final readonly class UpdateUserCommand implements Command
{
    private function __construct(
        public string $id,
        public ?string $email,
        public ?string $name,
        public ?string $password,
    ) {}

    public static function createFromRequest(string $id, FormRequest $request): self
    {
        $data = $request->safe(['name', 'email', 'password']);

        return new self(
            $id,
            $data['email'],
            $data['name'],
            isset($data['password']) ? Hash::make($data['password']) : null,
        );
    }
}
