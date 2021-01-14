<?php

namespace Akkurate\LaravelCore\Tests\Auth;

use Akkurate\LaravelCore\Models\User;
use Akkurate\LaravelCore\Tests\TestCase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Support\Facades\Config;

class RegisterControllerTest extends TestCase
{
    use WithFaker;

    /** @test **/
    public function it_should_register_a_user_with_password()
    {
        Config::set('laravel-auth.allow_register', true);

        $password = $this->faker->password(8, 20);
        $email = $this->faker->safeEmail;

        $response = $this->post(route('register', [
            'account_id' => $this->user->account->id,
            'firstname' => $this->faker->firstName,
            'lastname' => $this->faker->lastName,
            'email' => $email,
            'password' => $password,
            'password_confirmation' => $password,
        ]));
        $response->assertRedirect(config('laravel-core.admin.route'));

        $user = User::where('email', $email)->first();
        $this->assertDatabaseHas('users', ['id' => $user->id]);
    }

    /** @test **/
    public function it_should_register_a_user_without_password()
    {
        $email = $this->faker->safeEmail;

        $response = $this->post(route('register', [
            'account_id' => $this->user->account->id,
            'firstname' => $this->faker->firstName,
            'lastname' => $this->faker->lastName,
            'email' => $email,
        ]));
        $response->assertRedirect(config('laravel-core.admin.route'));

        $user = User::where('email', $email)->first();
        $this->assertDatabaseHas('users', ['id' => $user->id]);
    }

    /** @test **/
    public function it_should_register_a_user_without_password_and_account_id()
    {
        $email = $this->faker->safeEmail;

        $response = $this->post(route('register', [
            'firstname' => $this->faker->firstName,
            'lastname' => $this->faker->lastName,
            'email' => $email,
        ]));
        $response->assertRedirect(config('laravel-core.admin.route'));

        $user = User::where('email', $email)->first();
        $this->assertDatabaseHas('users', ['id' => $user->id]);
    }
}
