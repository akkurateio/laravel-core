<?php

namespace Akkurate\LaravelCore\Tests\Admin;

use Akkurate\LaravelCore\Tests\TestCase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\WithoutMiddleware;

class UserApiTest extends TestCase
{
    use WithFaker;
    use WithoutMiddleware;

    /** @test **/
    public function it_should_return_all_users()
    {
        user()->factory()->count(2)->make();

        $response = $this->get(route('api.admin.users.index', [
            'uuid' => $this->user->account->uuid
        ]));
        $response->assertStatus(200);
    }

    /** @test **/
    public function it_should_read_a_user()
    {
        $response = $this->get(route('api.admin.users.show', [
            'uuid' => $this->user->account->uuid,
            'user' => user()->factory()->create()
        ]));
        $response->assertStatus(200);
    }

    /** @test **/
    public function it_should_update_an_user()
    {
        $response = $this->put(route('api.admin.users.update', [
            'uuid' => $this->user->account->uuid,
            'user' => user()->factory()->create(),
            'firstname' => 'Test',
            'lastname' => 'Test',
            'email' => 'test@subvitamine.com',
        ]));
        $response->assertStatus(200);
    }

    /** @test **/
    public function it_should_return_an_403()
    {
        $response = $this->delete(route('api.admin.users.destroy', [
            'uuid' => $this->user->account->uuid,
            'user' => user()->factory()->create()
        ]));
        $response->assertStatus(403);
    }

    /** @test **/
    public function it_should_delete_an_user()
    {
        $user = user()->factory()->create();

        $user->update([
           'account_id' => $this->user->account->id
        ]);

        $response = $this->delete(route('api.admin.users.destroy', [
            'uuid' => $this->user->account->uuid,
            'user' => $user
        ]));
        $response->assertStatus(204);
    }
}
