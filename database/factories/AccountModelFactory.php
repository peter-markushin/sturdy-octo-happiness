<?php

declare(strict_types=1);

namespace Database\Factories;

use App\Infrastructure\Laravel\Models\AccountModel;
use Illuminate\Database\Eloquent\Factories\Factory;

class AccountModelFactory extends Factory
{
    protected $model = AccountModel::class;

    public function definition(): array
    {
        return [
            'type' => 'user',
            'balance' => random_int(1999, 20000),
        ];
    }
}
