<?php

declare(strict_types=1);

namespace App\Domain\User;

use App\Domain\User\Aggregate\User;
use App\Domain\User\Exception\UserNotFoundException;
use App\Domain\User\ValueObject\Id;

interface UserRepository
{
    public function create(User $user, string $password): void;

    public function update(User $user, string $password): void;

    /**
     * @throws UserNotFoundException
     */
    public function getById(Id $userId): User;

    public function findById(Id $userId): ?User;

    /**
     * @param UserSearchCriteria $criteria
     *
     * @return array<array-key, User>
     */
    public function findByCriteria(UserSearchCriteria $criteria): array;
}
