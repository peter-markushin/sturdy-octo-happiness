<?php

declare(strict_types=1);

namespace App\UI\Http\User;

use App\Infrastructure\Laravel\Controller;
use App\Infrastructure\Laravel\Requests\User\UpdateUserRequest;
use App\Infrastructure\User\Command\UpdateUserCommand;
use App\Infrastructure\User\Handler\UpdateUserCommandHandler;
use Illuminate\Http\JsonResponse;

final class UpdateUserController extends Controller
{
    public function __invoke(UpdateUserRequest $request, UpdateUserCommandHandler $handler, string $id): JsonResponse
    {
        $command = UpdateUserCommand::createFromRequest($id, $request);

        $user = $handler($command);

        return new JsonResponse($user->asArray());
    }
}
