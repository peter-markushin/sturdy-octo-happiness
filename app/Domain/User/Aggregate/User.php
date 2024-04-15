<?php

declare(strict_types=1);

namespace App\Domain\User\Aggregate;

use App\Domain\Account\Aggregate\Account;
use App\Domain\Shared\ValueObject\DateTimeValueObject;
use App\Domain\User\ValueObject\Email;
use App\Domain\User\ValueObject\Id;
use App\Domain\User\ValueObject\Name;

final class User
{
    private function __construct(
        private readonly Id $id,
        private Email $email,
        private Name $name,
        private array $accounts,
        private DateTimeValueObject $createdAt,
        private ?DateTimeValueObject $updatedAt,
    ) {}

    public static function create(
        Id $id,
        Email $email,
        Name $name,
        array $accounts,
        DateTimeValueObject $createdAt,
        ?DateTimeValueObject $updatedAt = null,
    ): self {
        return new self(
            $id,
            $email,
            $name,
            $accounts,
            $createdAt,
            $updatedAt,
        );
    }

    public function id(): Id
    {
        return $this->id;
    }

    public function email(): Email
    {
        return $this->email;
    }

    public function name(): Name
    {
        return $this->name;
    }

    /**
     * @return Account[]
     */
    public function accounts(): array
    {
        return $this->accounts;
    }

    public function createdAt(): DateTimeValueObject
    {
        return $this->createdAt;
    }

    public function updatedAt(): ?DateTimeValueObject
    {
        return $this->updatedAt;
    }

    public function updateEmail(string $email): void
    {
        $this->email = Email::fromString($email);
    }

    public function updateName(string $name): void
    {
        $this->name = Name::fromString($name);
    }

    public function asArray(): array
    {
        return [
            'id' => $this->id()->value(),
            'email' => $this->email()->value(),
            'name' => $this->name()->value(),
            'created_at' => $this->createdAt()->value(),
            'updated_at' => $this->updatedAt()?->value(),
        ];
    }
}
