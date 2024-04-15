<?php

declare(strict_types=1);

namespace App\Domain\User;

use Hibit\Criteria;
use Hibit\CriteriaPagination;

final class UserSearchCriteria extends Criteria
{
    public const int PAGINATION_SIZE = 100;

    private ?string $email = null;

    public static function create(?int $offset = null, string $email = null): UserSearchCriteria
    {
        $criteria = new self(
            CriteriaPagination::create(self::PAGINATION_SIZE, $offset)
        );

        if (!empty($email)) {
            $criteria->email = $email;
        }

        return $criteria;
    }

    public function email(): ?string
    {
        return $this->email;
    }
}
