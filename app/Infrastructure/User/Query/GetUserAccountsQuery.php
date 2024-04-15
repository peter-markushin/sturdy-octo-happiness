<?php

declare(strict_types=1);

namespace App\Infrastructure\User\Query;

final readonly class GetUserAccountsQuery
{
    public function __construct(
        public string $id
    ) {}
}
