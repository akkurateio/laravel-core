<?php

namespace Akkurate\LaravelCore\Tests\Access;

use Akkurate\LaravelCore\Tests\TestCase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\WithoutMiddleware;
use Spatie\Permission\Models\Permission;

class PermissionControllerTest extends TestCase
{
    use WithFaker;
    use WithoutMiddleware;

    /** @test * */
    public function it_should_return_the_permissions_index()
    {
        $response = $this->get(route('brain.access.permissions.index', [
            'uuid' => $this->user->account->slug
        ]));
        $response->assertStatus(200);
    }

    /** @test * */
    public function it_should_redirect_to_a_permission_edit_view()
    {
        $permission = Permission::first();

        $response = $this->get(route('brain.access.permissions.show', [
            'uuid' => $this->user->account->slug,
            'permission' => $permission->id
        ]));
        $response->assertRedirect('brain/' . $this->user->account->slug . '/access/permissions/' . $permission->id . '/edit');
    }

    /** @test * */
    public function it_should_return_an_create_permission_view()
    {
        $response = $this->get(route('brain.access.permissions.create', [
            'uuid' => $this->user->account->slug
        ]));
        $response->assertStatus(200);
    }

    /** @test * */
    public function it_should_create_a_permission()
    {
        $response = $this->post(route('brain.access.permissions.store', [
            'uuid' => $this->user->account->slug,
            'name' => 'test',
        ]));

        $response->assertRedirect('brain/' . $this->user->account->slug . '/access/permissions/');

        $permission = Permission::where('name', 'test')->first();
        $this->assertDatabaseHas('permissions', ['id' => $permission->id]);
    }

    /** @test * */
    public function it_should_return_an_edit_permission_view()
    {
        $permission = Permission::first();
        $response = $this->get(route('brain.access.permissions.edit', [
            'uuid' => $this->user->account->slug,
            'permission' => $permission->id
        ]));
        $response->assertStatus(200);
    }

    /** @test * */
    public function it_should_update_a_permission_and_redirect_to_index()
    {
        $response = $this->put(route('brain.access.permissions.update', [
            'uuid' => $this->user->account->slug,
            'permission' => Permission::first()->id,
            'name' => 'test'
        ]));
        $response->assertRedirect('brain/' . $this->user->account->slug . '/access/permissions/');

        $permission = Permission::where('name', 'test')->first();
        $this->assertDatabaseHas('permissions', ['id' => $permission->id]);
    }

    /** @test * */
    public function it_should_delete_a_permission_and_redirect_back()
    {
        $permission = Permission::first();

        $response = $this->delete(route('brain.access.permissions.destroy', [
            'uuid' => $this->user->account->slug,
            'permission' => $permission->id,
        ]));
        $response->assertRedirect();

        $this->assertDatabaseMissing('permissions', ['id' => $permission->id]);
    }

    /** @test * */
    public function it_should_give_a_permission_to_a_user_and_redirect_back()
    {
        $response = $this->post(route('brain.access.permission.give', [
            'uuid' => $this->user->account->slug,
            'modelUuid' => $this->user->uuid,
            'permission' => Permission::first()->name,
        ]));
        $response->assertRedirect();
    }

    /** @test * */
    public function it_should_revoke_a_permission_to_a_user_and_redirect_back()
    {
        $response = $this->post(route('brain.access.permission.revoke', [
            'uuid' => $this->user->account->slug,
            'modelUuid' => $this->user->uuid,
            'permission' => Permission::first()->name,
        ]));
        $response->assertRedirect();
    }
}
