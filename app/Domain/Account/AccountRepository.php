<?php

declare(strict_types=1);

namespace App\Domain\Account;

use App\Domain\Account\Aggregate\Account;
use App\Domain\Account\Exception\AccountNotFoundException;
use App\Domain\Account\ValueObject\Id;

interface AccountRepository
{
    public function create(Account $account, ?string $userId = null): void;

    public function update(Account $account): void;

    /**
     * @throws AccountNotFoundException
     */
    public function getById(Id $accountId): Account;

    public function findById(Id $accountId): ?Account;
}
