<?php

declare(strict_types=1);

namespace App\Infrastructure\User\Handler;

use App\Domain\Shared\Bus\Command;
use App\Domain\User\Aggregate\User;
use App\Domain\User\UserRepository;
use App\Domain\User\ValueObject\Id;
use App\Infrastructure\User\Command\UpdateUserCommand;

final class UpdateUserCommandHandler implements Command
{
    public function __construct(private UserRepository $userRepository) {}

    public function __invoke(UpdateUserCommand $command): User
    {
        $user = $this->userRepository->getById(Id::fromPrimitives($command->id));

        if (isset($command->email)) {
            $user->updateEmail($command->email);
        }

        if (isset($command->name)) {
            $user->updateName($command->name);
        }

        $this->userRepository->update($user, $command->password);

        return $user;
    }
}
