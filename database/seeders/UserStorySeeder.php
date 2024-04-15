<?php

namespace Database\Seeders;

use App\Models\Role;

class UserStorySeeder extends BaseSeeder
{
    /**
     * Credentials
     */
    public const ADMIN_CREDENTIALS = [
        'email' => 'admin@admin.com',
    ];

    public function runFake()
    {
        // Create an admin user
        \App\Infrastructure\Laravel\Models\UserModel::factory()->create([
            'name'         => 'Admin',
            'email'        => static::ADMIN_CREDENTIALS['email'],
        ]);

        // Create regular user
        \App\Infrastructure\Laravel\Models\UserModel::factory()->create([
            'name'         => 'Bob',
            'email'        => 'bob@bob.com',
        ]);
    }
}
