<?php

declare(strict_types=1);

namespace App\UI\Http\Auth;

use App\Infrastructure\Laravel\Controller;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Auth;

final class RefreshTokenController extends Controller
{
    public function __invoke(): JsonResponse
    {
        return new JsonResponse([
            'status' => 'success',
            'authorization' => [
                'token' => Auth::refresh(),
                'type' => 'bearer',
            ]
        ]);
    }
}
