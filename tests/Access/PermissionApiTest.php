<?php

namespace Akkurate\LaravelCore\Tests\Access;

use Akkurate\LaravelCore\Tests\TestCase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\WithoutMiddleware;
use Spatie\Permission\Models\Permission;

class PermissionApiTest extends TestCase
{
    use WithFaker;
    use WithoutMiddleware;

    /** @test * */
    public function it_should_return_all_permissions()
    {
        $response = $this->get(route('api.access.permissions.index', [
            'uuid' => $this->user->account->uuid
        ]));
        $response->assertStatus(200);
    }

    /** @test * */
    public function it_should_read_a_permission()
    {
        $response = $this->get(route('api.access.permissions.show', [
            'uuid' => $this->user->account->uuid,
            'permission' => Permission::first()->id
        ]));
        $response->assertStatus(200);
    }

    /** @test * */
    public function it_should_create_a_permission()
    {
        $response = $this->post(route('api.access.permissions.store', [
            'uuid' => $this->user->account->uuid,
            'name' => $this->faker->lastName,
            'guard_name' => 'web',
        ]));
        $response->assertStatus(201);
    }

    /** @test * */
    public function it_should_update_a_permission()
    {
        $response = $this->put(route('api.access.permissions.update', [
            'uuid' => $this->user->account->uuid,
            'permission' => Permission::first(),
            'name' => $this->faker->lastName,
            'guard_name' => 'web',
        ]));
        $response->assertStatus(200);
    }

    /** @test * */
    public function it_should_delete_a_permission()
    {
        $response = $this->delete(route('api.access.permissions.destroy', [
            'uuid' => $this->user->account->uuid,
            'permission' => Permission::first(),
        ]));
        $response->assertStatus(204);
    }
}
