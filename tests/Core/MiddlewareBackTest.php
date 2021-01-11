<?php

namespace Akkurate\LaravelCore\Tests\Core;

use Akkurate\LaravelCore\Models\User;
use Akkurate\LaravelCore\Tests\TestCase;
use Illuminate\Support\Facades\Hash;

class MiddlewareBackTest extends TestCase
{
    /** @test */
    public function it_should_redirect_the_user_to_login()
    {
        $user = User::forceCreate([
            'firstname' => 'User',
            'lastname' => 'Lastname',
            'email' => 'user@email.com',
            'password' => Hash::make('test'),
            'account_id' => 2,
        ]);

        $response = $this->get(route('brain.admin.accounts.index', ['uuid' => $user->account->slug]));

        $response->assertRedirect('/login');
    }

    /** @test */
    public function it_should_redirect_to_the_dashboard()
    {
        $this->user->activate();

        $response = $this->get(route('brain.admin.accounts.index', ['uuid' => 'mauvais-slug']));

        $response->assertRedirect(config('laravel-core.admin.route') . '/' .$this->user->account->slug);
    }

    /** @test */
    public function it_should_return_an_unauthorized_response()
    {
        $this->user->activate();

        $response = $this->get(route('brain.admin.accounts.index', ['uuid' => $this->user->account->slug]));

        $response->assertStatus(403);
    }

    /** @test */
    public function it_should_return_a_valide_response()
    {
        $this->user->activate();
        $this->user->syncRoles('superadmin');

        $response = $this->get(route('brain.admin.accounts.index', ['uuid' => $this->user->account->slug]));

        $response->assertStatus(200);
    }
}
