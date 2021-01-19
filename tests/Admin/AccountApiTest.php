<?php

namespace Akkurate\LaravelCore\Tests\Admin;

use Akkurate\LaravelCore\Tests\TestCase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\WithoutMiddleware;

class AccountApiTest extends TestCase
{
    use WithFaker;
    use WithoutMiddleware;

    /** @test * */
    public function it_should_return_all_accounts()
    {
        account()->factory()->count(2)->make();
        $response = $this->get(route('api.admin.accounts.index', [
            'uuid' => $this->user->account->uuid
        ]));
        $response->assertStatus(200);
    }

    /** @test * */
    public function it_should_read_a_account()
    {
        $response = $this->get(route('api.admin.accounts.show', [
            'uuid' => $this->user->account->uuid,
            'account' => account()->factory()->create()
        ]));
        $response->assertStatus(200);
    }

    /** @test * */
    public function it_should_store_an_account()
    {
        $response = $this->post(route('api.admin.accounts.store', [
            'uuid' => $this->user->account->uuid,
            'name' => 'Test Company'
        ]));
        $response->assertStatus(201);
    }

    /** @test * */
    public function it_should_update_an_account()
    {
        $response = $this->put(route('api.admin.accounts.update', [
            'uuid' => $this->user->account->uuid,
            'account' => account()->factory()->create(),
            'name' => 'Test',
            'email' => 'test@subvitamine.com',
        ]));
        $response->assertStatus(200);
    }

    /** @test * */
    public function it_should_delete_an_account()
    {
        $response = $this->delete(route('api.admin.accounts.destroy', [
            'uuid' => $this->user->account->uuid,
            'account' => account()->factory()->create()
        ]));
        $response->assertStatus(204);
    }

    /** @test * */
    public function it_should_return_all_users_for_an_account()
    {
        $response = $this->get(route('api.admin.find.users', [
            'uuid' => $this->user->account->uuid,
            'account' => $this->user->account
        ]));
        $response->assertStatus(200);
    }
}
