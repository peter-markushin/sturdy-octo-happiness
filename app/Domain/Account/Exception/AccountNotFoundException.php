<?php

declare(strict_types=1);

namespace App\Domain\Account\Exception;

use App\Domain\Shared\Exception\NotFoundException;

final class AccountNotFoundException extends NotFoundException {}
