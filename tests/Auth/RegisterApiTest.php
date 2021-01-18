<?php

namespace Akkurate\LaravelCore\Tests\Auth;

use Akkurate\LaravelCore\Tests\TestCase;
use Akkurate\LaravelAccountSubmodule\Models\User;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Support\Facades\Config;

class RegisterApiTest extends TestCase
{
    use WithFaker;

    /** @test **/
    public function it_should_register_a_user_with_password()
    {
        $this->withoutNotifications();

        Config::set('laravel-auth.allow_register', true);

        $password = $this->faker->password(8, 20);
        $email = $this->faker->safeEmail;

        $response = $this->post(route('api.auth.register', [
            'account_id' => $this->user->account->id,
            'firstname' => $this->faker->firstName,
            'lastname' => $this->faker->lastName,
            'email' => $email,
            'password' => $password,
            'password_confirmation' => $password,
        ]));
        $response->assertStatus(201);

        $user = User::where('email', $email)->first();
        $this->assertDatabaseHas('users', ['id' => $user->id]);
    }

    /** @test **/
    public function it_should_register_a_user_without_password()
    {
        $this->withoutNotifications();

        $email = $this->faker->safeEmail;

        $response = $this->post(route('api.auth.register', [
            'account_id' => $this->user->account->id,
            'firstname' => $this->faker->firstName,
            'lastname' => $this->faker->lastName,
            'email' => $email,
        ]));
        $response->assertStatus(201);

        $user = User::where('email', $email)->first();
        $this->assertDatabaseHas('users', ['id' => $user->id]);
    }
}
