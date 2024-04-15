<?php

declare(strict_types=1);

namespace App\Infrastructure\User\Handler;

use App\Domain\Account\AccountRepository;
use App\Domain\Account\Aggregate\Account;
use App\Domain\Account\ValueObject\AccountType;
use App\Domain\Account\ValueObject\AccountTypeInterface;
use App\Domain\Account\ValueObject\Balance;
use App\Domain\Account\ValueObject\Id;
use App\Domain\Shared\ValueObject\DateTimeValueObject;
use App\Infrastructure\User\Command\CreateUserAccountCommand;

final readonly class CreateUserAccountCommandHandler
{
    public function __construct(private AccountRepository $repository) {}

    public function __invoke(CreateUserAccountCommand $command): Account
    {
        $account = Account::create(
            Id::random(),
            Balance::fromInteger($command->balance),
            AccountType::from(AccountTypeInterface::USER),
            DateTimeValueObject::now()
        );

        $this->repository->create($account, $command->userId);

        return $account;
    }
}
