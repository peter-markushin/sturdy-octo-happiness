<?php

declare(strict_types=1);

namespace App\Infrastructure\Account;

use App\Domain\Account\Aggregate\Account;
use App\Domain\Account\Exception\AccountNotFoundException;
use App\Domain\Account\ValueObject\AccountType;
use App\Domain\Account\ValueObject\Balance;
use App\Domain\Account\ValueObject\Id;
use App\Domain\Shared\ValueObject\DateTimeInterface;
use App\Domain\Shared\ValueObject\DateTimeValueObject;
use App\Infrastructure\Laravel\Models\AccountModel;
use Illuminate\Database\Eloquent\ModelNotFoundException;

final class AccountRepository implements \App\Domain\Account\AccountRepository
{
    public function create(Account $account, ?string $userId = null): void
    {
        $accountModel = new AccountModel();

        $accountModel->id = $account->id()->value();
        $accountModel->type = $account->accountType()->value();
        $accountModel->balance = $account->balance()->value();
        $accountModel->created_at = DateTimeValueObject::now()->value();
        $accountModel->user()->associate($userId);

        $accountModel->save();
    }

    public function update(Account $account): void
    {
        $accountModel = AccountModel::findOrFail($account->id()->value());

        $accountModel->balance = $account->balance()->value();

        $accountModel->save();
    }

    /**
     * @inheritDoc
     */
    public function getById(Id $accountId): Account
    {
        try {
            $accountModel = AccountModel::findOrFail($accountId->value());
        } catch (ModelNotFoundException $e) {
            throw new AccountNotFoundException(previous: $e);
        }

        return self::map($accountModel);
    }

    public function findById(Id $accountId): ?Account
    {
        try {
            return $this->getById($accountId);
        } catch (AccountNotFoundException) {
            return null;
        }
    }

    public static function map(AccountModel $accountModel): Account
    {
        return Account::create(
            Id::fromPrimitives($accountModel->id),
            Balance::fromInteger($accountModel->balance),
            AccountType::fromPrimitives($accountModel->type),
            DateTimeValueObject::fromPrimitives($accountModel->created_at->format(DateTimeInterface::DATETIME_FORMAT)),
            $accountModel->updated_at ? DateTimeValueObject::fromPrimitives($accountModel->updated_at->format(DateTimeInterface::DATETIME_FORMAT)) : null,
        );
    }
}
