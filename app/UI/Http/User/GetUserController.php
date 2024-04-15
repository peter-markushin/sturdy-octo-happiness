<?php

declare(strict_types=1);

namespace App\UI\Http\User;

use App\Infrastructure\Laravel\Controller;
use App\Infrastructure\User\Handler\GetUserQueryHandler;
use App\Infrastructure\User\Query\GetUserQuery;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;

final class GetUserController extends Controller
{
    public function __invoke(Request $request, GetUserQueryHandler $handler, string $id): JsonResponse
    {
        $user = $handler(new GetUserQuery($id));

        if ($user === null) {
            throw new NotFoundHttpException();
        }

        return new JsonResponse($user->asArray());
    }
}
