<?php

namespace Akkurate\LaravelCore\Tests\Admin;

use Akkurate\LaravelCore\Models\Account;
use Akkurate\LaravelCore\Tests\TestCase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\WithoutMiddleware;

class AccountControllerTest extends TestCase
{
    use WithFaker;
    use WithoutMiddleware;


    /** @test * */
    public function it_should_return_the_accounts_view()
    {
        $response = $this->get(route('brain.admin.accounts.index', [
            'uuid' => $this->user->account->slug,
        ]));
        $response->assertStatus(200);
    }

    /** @test * */
    public function it_should_redirect_to_a_account_edit_view()
    {
        $account = Account::first();
        $response = $this->get(route('brain.admin.accounts.show', [
            'uuid' => $this->user->account->slug,
            'account' => $account->id,
        ]));
        $response->assertRedirect();
    }

    /** @test * */
    public function it_should_return_to_a_account_edit_view()
    {
        $account = Account::first();
        $response = $this->get(route('brain.admin.accounts.edit', [
            'uuid' => $this->user->account->slug,
            'account' => $account->id,
        ]));
        $response->assertStatus(200);
    }

    /** @test * */
    public function it_should_store_an_account_and_redirect()
    {
        $response = $this->post(route('brain.admin.accounts.store', [
            'uuid' => $this->user->account->slug,
            'name' => 'Test Company',
            'number' => $this->faker->phoneNumber,
            'email' => $this->faker->companyEmail,
        ]));

        $account = Account::where('slug', 'test-company')->first();

        $this->assertDatabaseHas('admin_accounts', ['id' => $account->id]);
        $response->assertStatus(302);
    }

    /** @test * */
    public function it_should_update_a_account_and_redirect()
    {
        $response = ($this->put(route('brain.admin.accounts.update', [
            'uuid' => $this->user->account->slug,
            'account' => Account::first()->id,
            'name' => 'Test Company',
        ])));

        $account = Account::where('name', 'Test Company')->first();

        $this->assertDatabaseHas('admin_accounts', ['id' => $account->id]);
        $response->assertStatus(302);
    }

    /** @test * */
    public function it_should_delete_a_account_and_redirect()
    {
        $account = Account::first();

        $response = $this->delete(route('brain.admin.accounts.destroy', [
            'uuid' => $this->user->account->slug,
            'account' => $account->id,
        ]));

        $response->assertRedirect();

        $this->assertSoftDeleted('admin_accounts', ['id' => $account->id]);
    }
}
