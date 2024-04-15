<?php

declare(strict_types=1);

namespace App\Domain\Account\ValueObject;

interface AccountTypeInterface
{
    public const string USER = 'user';
    public const string SYSTEM = 'system';

    public function value(): string;
    public static function fromPrimitives(string $type): static;
}
