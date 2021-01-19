<?php

namespace Akkurate\LaravelCore\Tests\Admin;

use Akkurate\LaravelCore\Tests\TestCase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\WithoutMiddleware;

class UserControllerTest extends TestCase
{
    use WithFaker;
    use WithoutMiddleware;

    /** @test * */
    public function it_should_return_the_users_view()
    {
        $response = $this->get(route('brain.admin.users.index', [
            'uuid' => $this->user->account->slug
        ]));
        $response->assertStatus(200);
    }

    /** @test * */
    public function it_should_return_a_user_show_view()
    {
        $user = user()->factory()->create();
        $user->preference()->create();
        $response = $this->get(route('brain.admin.users.show', [
            'uuid' => $this->user->account->slug,
            'user' => $user->id
        ]));
        $response->assertStatus(200);
    }

    /** @test * */
    public function it_should_return_to_a_user_edit_view()
    {
        $user = user()->factory()->create();
        $user->preference()->create();
        $response = $this->get(route('brain.admin.users.edit', [
            'uuid' => $this->user->account->slug,
            'user' => $user->id
        ]));
        $response->assertStatus(200);
    }

    /** @test * */
    public function it_should_update_a_user()
    {
        $user = user()->factory()->create();

        $response = $this->put(route('brain.admin.users.update', [
            'uuid' => $this->user->account->slug,
            'user' => $user,
            'firstname' => $this->faker->firstName,
            'lastname' => $this->faker->lastName,
            'email' => $this->faker->safeEmail,
            'account_id' => account()->factory()->create()->id,
        ]));

        $response->assertStatus(302);

        $this->assertDatabaseHas('users', ['id' => $user->id]);
    }

    /** @test * */
    public function it_should_delete_a_user_and_redirect()
    {
        $user = user()->factory()->create();

        $response = $this->delete(route('brain.admin.users.destroy', [
            'uuid' => $this->user->account->slug,
            'user' => $user->id
        ]));

        $response->assertRedirect();

        $this->assertSoftDeleted('users', ['id' => $user->id]);
    }
}
