<?php

declare(strict_types=1);

namespace App\Infrastructure\User\Handler;

use App\Domain\Shared\ValueObject\DateTimeValueObject;
use App\Domain\User\Aggregate\User;
use App\Domain\User\UserRepository;
use App\Domain\User\ValueObject\Email;
use App\Domain\User\ValueObject\Id;
use App\Domain\User\ValueObject\Name;
use App\Infrastructure\User\Command\CreateUserCommand;

final readonly class CreateUserCommandHandler
{
    public function __construct(private UserRepository $userRepository)
    {
    }

    public function __invoke(CreateUserCommand $command): User
    {
        $user = User::create(
            Id::random(),
            Email::fromString($command->email),
            Name::fromString($command->name),
            DateTimeValueObject::now(),
        );

        $this->userRepository->create($user, $command->password);

        return $user;
    }
}
