<?php

namespace Tests\Feature\Api\V1\User;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class UserRegisterTest extends TestCase
{
    use RefreshDatabase;

    protected static $user = [
        "login" => "nurba",
        "email" => "mura@gmail.com",
        "password" => "password"
    ];
    /**
     * A basic feature test example.
     */
    public function test_user_register(): void
    {
        $response = $this->post('/api/v1/register', [
            "login" => self::$user["login"],
            "email" => self::$user["email"],
            "password" => self::$user["password"]
        ]);
        $response->assertJsonStructure([
            "message",
            "token"
        ]);
        $response->assertOk();
    }
}
