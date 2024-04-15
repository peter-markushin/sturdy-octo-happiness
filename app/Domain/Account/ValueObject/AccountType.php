<?php

declare(strict_types=1);

namespace App\Domain\Account\ValueObject;

enum AccountType: string implements AccountTypeInterface
{
    case U = AccountTypeInterface::USER;
    case S = AccountTypeInterface::SYSTEM;

    public function value(): string
    {
        return $this->value;
    }

    public static function fromPrimitives(string $type): static
    {
        return self::from($type);
    }
}
