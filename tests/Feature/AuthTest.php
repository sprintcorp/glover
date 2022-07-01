<?php

namespace Tests\Feature;

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class AuthTest extends TestCase
{
    use RefreshDatabase;

    public function test_login_route_api()
    {
        $user = $this->createUser();
        $response = $this->postJson('/api/login',[
            'email' => $user->email,
            'password' => 'password'
        ])->assertOk();
        $this->assertArrayHasKey('access_token',$response->json());
    }

    public function test_if_user_email_is_not_available_then_it_return_error()
    {
        $this->postJson('/api/login',[
            'email' => 'fred@me.com',
            'password' => 'password'
        ])->assertUnauthorized();
    }

    public function test_it_raise_error_if_password_is_incorrect()
    {
        $user = $this->createUser();
        $this->postJson('/api/login',[
            'email' => $user->email,
            'password' => 'random'
        ])->assertUnauthorized();
    }

    public function test_a_user_can_register()
    {
        $this->postJson('/api/register',[
            'firstname' => "Frederick",
            'lastname' => "Adebayo",
            'email' => "sprintcorp7+03@gmail.com",
            'password' => 'secret123',
        ])->assertCreated();

        $this->assertDatabaseHas('users',['firstname' => 'Frederick']);
    }

    public function test_user_validation_for_registration()
    {
        $this->postJson('/api/register',[
            'lastname' => "Adebayo",
            'password' => 'secret',
        ])->assertStatus(422);

    }

}
