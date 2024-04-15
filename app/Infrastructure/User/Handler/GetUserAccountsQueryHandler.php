<?php

declare(strict_types=1);

namespace App\Infrastructure\User\Handler;

use App\Domain\User\Exception\UserNotFoundException;
use App\Domain\User\UserRepository;
use App\Domain\User\ValueObject\Id;
use App\Infrastructure\User\Query\GetUserAccountsQuery;

final readonly class GetUserAccountsQueryHandler
{
    public function __construct(private UserRepository $userRepository) {}

    /**
     * @throws UserNotFoundException
     */
    public function __invoke(GetUserAccountsQuery $query): array
    {
        return $this->userRepository->getById(Id::fromPrimitives($query->id))->accounts();
    }
}
