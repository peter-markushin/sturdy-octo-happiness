<?php

declare(strict_types=1);

namespace App\UI\Http\Auth;

use App\Infrastructure\Laravel\Controller;
use App\Infrastructure\Laravel\Requests\Auth\LoginRequest;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Auth;

final class LoginController extends Controller
{
    public function __invoke(LoginRequest $request): JsonResponse
    {
        $credentials = $request->only('email', 'password');
        $token = Auth::attempt($credentials);

        if ($token === false) {
            return new JsonResponse([
                'status' => 'error',
                'message' => 'Unauthorized',
            ], 401);
        }

        return new JsonResponse([
            'status' => 'success',
            'authorization' => [
                'token' => $token,
                'type' => 'bearer',
            ]
        ]);
    }
}
