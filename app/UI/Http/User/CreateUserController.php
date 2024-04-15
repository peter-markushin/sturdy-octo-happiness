<?php

declare(strict_types=1);

namespace App\UI\Http\User;

use App\Infrastructure\Laravel\Controller;
use App\Infrastructure\Laravel\Requests\User\CreateUserRequest;
use App\Infrastructure\User\Command\CreateUserCommand;
use App\Infrastructure\User\Handler\CreateUserCommandHandler;
use Illuminate\Http\JsonResponse;
use Symfony\Component\HttpFoundation\Response;

final class CreateUserController extends Controller
{
    public function __invoke(CreateUserRequest $request, CreateUserCommandHandler $handler): JsonResponse
    {
        $command = CreateUserCommand::createFromRequest($request);

        $user = $handler($command);

        return new JsonResponse(
            $user->asArray(),
            Response::HTTP_CREATED,
        );
    }
}
