<?php

declare(strict_types=1);

namespace App\UI\Http\User;

use App\Infrastructure\Laravel\Controller;
use App\Infrastructure\Laravel\Requests\User\CreateUserAccountRequest;
use App\Infrastructure\User\Command\CreateUserAccountCommand;
use App\Infrastructure\User\Handler\CreateUserAccountCommandHandler;
use Illuminate\Http\JsonResponse;

final class CreateUserAccountController extends Controller
{
    public function __invoke(CreateUserAccountRequest $request, CreateUserAccountCommandHandler $handler, string $id): JsonResponse
    {
        $account = $handler(new CreateUserAccountCommand($id, $request->integer('balance')));

        return new JsonResponse($account->asArray(), JsonResponse::HTTP_CREATED);
    }
}
