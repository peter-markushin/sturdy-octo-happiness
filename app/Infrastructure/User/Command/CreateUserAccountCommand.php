<?php

declare(strict_types=1);

namespace App\Infrastructure\User\Command;

use App\Domain\Shared\Bus\Command;

final readonly class CreateUserAccountCommand implements Command
{
    public function __construct(
        public string $userId,
        public int $balance,
    ) {}
}
