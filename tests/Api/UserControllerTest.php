<?php

namespace Tests\Api;

use App\Infrastructure\Laravel\Models\UserModel;
use Tests\ApiTestCase;

class UserControllerTest extends ApiTestCase
{
    public function testGetAll()
    {
        $jsonResponse = $this->actingAsAdmin()->json('GET', '/users');

        // Check status and structure
        $jsonResponse
            ->assertStatus(200)
            ->assertJsonStructure(
                [
                    'data' => [
                        [
                            'id',
                            'name',
                            'email',
                        ],
                    ],
                ]
            );
    }

    public function testPost()
    {
        $testUser = UserModel::factory()->make()->getAttributes();

        $jsonResponse = $this->actingAsAdmin()->json('POST', '/users', $testUser);

        unset($testUser['password']);

        // Check status, structure and data
        $jsonResponse
            ->assertStatus(201)
            ->assertJsonStructure(
                [
                    'data' =>
                        [
                            'name',
                            'email',
                            'id',
                        ]
                ]
            );

        // Check password is hidden
        $response = $jsonResponse->decodeResponseJson();
        $this->assertNotContains('password', $response['data']);
    }
}
