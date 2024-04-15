<?php

declare(strict_types=1);

namespace App\Infrastructure\User\Handler;

use App\Domain\User\Aggregate\User;
use App\Domain\User\UserRepository;
use App\Domain\User\ValueObject\Id;
use App\Infrastructure\User\Query\GetUserQuery;

final readonly class GetUserQueryHandler
{
    public function __construct(private UserRepository $userRepository) {}

    public function __invoke(GetUserQuery $query): ?User
    {
        return $this->userRepository->findById(Id::fromPrimitives($query->id));
    }
}
