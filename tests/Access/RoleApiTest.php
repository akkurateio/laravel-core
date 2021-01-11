<?php

namespace Akkurate\LaravelCore\Tests\Access;

use Akkurate\LaravelCore\Tests\TestCase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\WithoutMiddleware;
use Spatie\Permission\Models\Role;

class RoleApiTest extends TestCase
{
    use WithFaker;
    use WithoutMiddleware;

    /** @test **/
    public function it_should_return_all_roles()
    {
        $response = $this->get(route('api.access.roles.index', [
            'uuid' => $this->user->account->uuid
        ]));
        $response->assertStatus(200);
    }

    /** @test **/
    public function it_should_read_a_role()
    {
        $response = $this->get(route('api.access.roles.show', [
            'uuid' => $this->user->account->uuid,
            'role' => Role::first()->id
        ]));
        $response->assertStatus(200);
    }

    /** @test **/
    public function it_should_create_a_role()
    {
        $response = $this->post(route('api.access.roles.store', [
            'uuid' => $this->user->account->uuid,
            'name' => $this->faker->lastName,
            'guard_name' => 'web',
        ]));
        $response->assertStatus(201);
    }

    /** @test **/
    public function it_should_update_a_role()
    {
        $response = $this->put(route('api.access.roles.update', [
            'uuid' => $this->user->account->uuid,
            'role' => Role::first(),
            'name' => $this->faker->lastName,
            'guard_name' => 'web',
        ]));
        $response->assertStatus(200);
    }

    /** @test **/
    public function it_should_delete_a_role()
    {
        $response = $this->delete(route('api.access.roles.destroy', [
            'uuid' => $this->user->account->uuid,
            'role' => Role::first(),
        ]));
        $response->assertStatus(204);
    }

}
