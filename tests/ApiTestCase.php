<?php

namespace Tests;

use App\Infrastructure\Laravel\Models\UserModel;
use Database\Seeders\UserStorySeeder;
use Illuminate\Contracts\Auth\Authenticatable as UserContract;
use Illuminate\Support\Arr;
use JWTAuth;

abstract class ApiTestCase extends TestCase
{
    /**
     * Set the currently logged in user for the application and Authorization headers for API request
     *
     * @param  \Illuminate\Contracts\Auth\Authenticatable
     * @param  string|null  $guard
     *
     * @return $this
     */
    public function actingAs(UserContract $user, $guard = null): static
    {
        parent::actingAs($user, $guard);

        return $this->withHeader('Authorization', 'Bearer ' . JWTAuth::fromUser($user));
    }

    /**
     * API Test case helper function for setting up
     * the request auth header as supplied user
     *
     * @param array $credentials
     *
     * @return $this
     */
    public function actingAsUser(array $credentials): static
    {
        if (!$token = JWTAuth::attempt($credentials)) {
            return $this;
        }

        $user = ($apiKey = Arr::get($credentials, 'api_key'))
            ? UserModel::whereApiKey($apiKey)->firstOrFail()
            : UserModel::whereEmail(Arr::get($credentials, 'email'))->firstOrFail();

        return $this->actingAs($user);
    }

    /**
     * API Test case helper function for setting up the request as a logged in admin user
     *
     * @return $this
     */
    public function actingAsAdmin(): static
    {
        $user = UserModel::where('email', UserStorySeeder::ADMIN_CREDENTIALS['email'])->firstOrFail();

        return $this->actingAs($user);
    }
}
