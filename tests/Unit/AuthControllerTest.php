<?php

namespace Tests\Unit;

use App\Models\User;
use Tests\TestCase;

class AuthControllerTest extends TestCase
{
    public function test_user_registration_happy_path()
    {
        $response = $this->postJson('/register', [
            'email' => 'demo@example.test',
            'phone_number' => '1234567890',
            'password' => 'demo_password',
        ]);

        $this->assertDatabaseCount('users', 1);
        $this->assertDatabaseHas('users', [
            'email' => 'demo@example.test',
            'phone_number' => '1234567890',
        ]);

        $user = User::query()->first();
        $this->assertNotSoftDeleted($user);

        $response
            ->assertStatus(201)
            ->assertJson([
                'message' => 'User created',
            ]);
    }

    public function test_user_registration_validation()
    {
        $this->postJson('/register', [
            'email' => 'demo@example.test',
            'phone_number' => '1234567890',
            'password' => 'demo_password',
        ]);

        $response = $this->postJson('/register', [
            'email' => 'demo@example.test',
            'phone_number' => '1234567890',
            'password' => 'demo_password',
        ]);

        $response
            ->assertStatus(422)
            ->assertJson([
                "errors" => [
                    "email" => [
                        "The email has already been taken.",
                    ],
                    "phone_number" => [
                        "The phone number has already been taken.",
                    ],
                ],
            ]);
    }

    public function test_user_login_happy_path()
    {
        $user = User::factory()->create([
            'email' => 'demo@example.test',
            'phone_number' => '1234567890',
            'password' => bcrypt('demo_password'),
        ]);

        $response = $this->postJson('/login', [
            'username' => '1234567890',
            'password' => 'demo_password',
        ]);

        $response
            ->assertStatus(200)
            ->assertJson([
                'token_type' => 'bearer',
                'expires_in' => 21600
            ]);
    }

    public function test_user_profile_happy_path()
    {
        $user = User::factory()->create([
            'email' => 'demo@example.test',
            'phone_number' => '1234567890',
            'password' => 'demo_password',
        ]);

        $token = auth()->login($user);

        $response = $this->withHeaders([
            'Authorization' => 'Bearer ' . $token,
        ])->getJson('/me');

        $response
            ->assertStatus(200)
            ->assertJson($this->parseModel($user));
    }

    private function parseModel($model)
    {
        return json_decode($model->toJson(), true);
    }
}
