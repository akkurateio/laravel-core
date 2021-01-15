<?php

namespace Akkurate\LaravelCore\Tests\Core;

use Akkurate\LaravelCore\Tests\TestCase;
use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Laravel\Passport\Passport;

class MiddlewareApiTest extends TestCase
{
    /** @test */
    public function it_should_return_an_invalid_user_response()
    {
        $user = User::forceCreate([
            'firstname' => 'User',
            'lastname' => 'Lastname',
            'email' => 'user@email.com',
            'password' => Hash::make('test'),
            'account_id' => 2,
        ]);

        Passport::actingAs($user);

        $response = $this->get(route('api.admin.accounts.index', ['uuid' => $this->user->account->slug]));

        $response->assertStatus(400)->assertJson(['error' => 'Invalid user']);
    }

    /** @test */
    public function it_should_return_an_invalid_account_response()
    {
        Passport::actingAs($this->user);

        $this->user->activate();

        $response = $this->get(route('api.admin.accounts.index', ['uuid' => 'mauvais-slug']));

        $response->assertStatus(400)->assertJson(['error' => 'Invalid account']);
    }

    /** @test */
    public function it_should_return_an_unauthorized_response()
    {
        Passport::actingAs($this->user);

        $this->user->activate();

        $response = $this->get(route('api.admin.accounts.index', ['uuid' => $this->user->account->slug]));

        $response->assertStatus(403);
    }

    /** @test */
    public function it_should_return_a_valide_response()
    {
        Passport::actingAs($this->user);

        $this->user->activate();
        $this->user->syncRoles('superadmin');

        $response = $this->get(route('api.admin.accounts.index', ['uuid' => $this->user->account->slug]));

        $response->assertStatus(200);
    }
}
