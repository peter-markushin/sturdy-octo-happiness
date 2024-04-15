<?php

declare(strict_types=1);

namespace App\UI\Http\User;

use App\Domain\Account\Aggregate\Account;
use App\Domain\User\Exception\UserNotFoundException;
use App\Infrastructure\Laravel\Controller;
use App\Infrastructure\User\Handler\GetUserAccountsQueryHandler;
use App\Infrastructure\User\Query\GetUserAccountsQuery;
use Illuminate\Http\JsonResponse;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;

final class GetUserAccountsController extends Controller
{
    public function __invoke(GetUserAccountsQueryHandler $handler, string $id): JsonResponse
    {
        try {
            $accounts = $handler(new GetUserAccountsQuery($id));
        } catch (UserNotFoundException) {
            throw new NotFoundHttpException();
        }

        return new JsonResponse(
            array_map(static fn(Account $account) => $account->asArray(), $accounts)
        );
    }
}
