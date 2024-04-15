<?php

declare(strict_types=1);

namespace App\UI\Http\User;

use App\Domain\User\UserRepository;
use App\Domain\User\ValueObject\Id;
use App\Infrastructure\Laravel\Controller;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

final class GetUserController extends Controller
{
    public function __invoke(Request $request, UserRepository $userRepository, string $id): JsonResponse
    {
        $user = $userRepository->getById(Id::fromPrimitives($id));

        return new JsonResponse($user->asArray());
    }
}
