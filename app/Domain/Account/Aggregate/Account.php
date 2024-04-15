<?php

declare(strict_types=1);

namespace App\Domain\Account\Aggregate;

use App\Domain\Account\ValueObject\AccountTypeInterface;
use App\Domain\Account\ValueObject\Balance;
use App\Domain\Account\ValueObject\Id;
use App\Domain\Shared\ValueObject\DateTimeValueObject;

final class Account
{
    private function __construct(
        private readonly Id $id,
        private Balance $balance,
        private readonly AccountTypeInterface $accountType,
        private readonly DateTimeValueObject $createdAt,
        private readonly ?DateTimeValueObject $updatedAt,
    ) {}

    public static function create(
        Id $id,
        Balance $balance,
        AccountTypeInterface $accountType,
        DateTimeValueObject $createdAt,
        ?DateTimeValueObject $updatedAt = null,
    ): self {
        return new self(
            $id,
            $balance,
            $accountType,
            $createdAt,
            $updatedAt,
        );
    }

    public function id(): Id
    {
        return $this->id;
    }

    public function balance(): Balance
    {
        return $this->balance;
    }

    public function accountType(): AccountTypeInterface
    {
        return $this->accountType;
    }

    public function updateBalance(Balance $balance): void
    {
        $this->balance = $balance;
    }

    public function createdAt(): DateTimeValueObject
    {
        return $this->createdAt;
    }

    public function updatedAt(): ?DateTimeValueObject
    {
        return $this->updatedAt;
    }

    public function asArray(): array
    {
        return [
            'id' => $this->id()->value(),
            'type' => $this->accountType()->value(),
            'balance' => $this->balance()->value(),
            'created_at' => $this->createdAt()->value(),
            'updated_at' => $this->updatedAt()?->value(),
        ];
    }
}
