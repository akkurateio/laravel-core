<?php

namespace Akkurate\LaravelCore\Tests\Access;

use Akkurate\LaravelCore\Tests\TestCase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\WithoutMiddleware;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;

;

class RoleControllerTest extends TestCase
{
    use WithFaker;
    use WithoutMiddleware;

    /** @test **/
    public function it_should_return_the_roles_index()
    {
        $response = $this->get(route('brain.access.roles.index', [
            'uuid' => $this->user->account->slug,
        ]));
        $response->assertStatus(200);
    }

    /** @test **/
    public function it_should_redirect_to_a_role_edit_view()
    {
        $role = Role::first();

        $response = $this->get(route('brain.access.roles.show', [
            'uuid' => $this->user->account->slug,
            'role' => $role->id,
        ]));
        $response->assertRedirect('brain/'. $this->user->account->slug .'/access/roles/'. $role->id . '/edit');
    }

    /** @test **/
    public function it_should_return_an_create_role_view()
    {
        $response = $this->get(route('brain.access.roles.create', [
            'uuid' => $this->user->account->slug,
        ]));
        $response->assertStatus(200);
    }

    /** @test **/
    public function it_should_create_a_role()
    {
        $response = $this->post(route('brain.access.roles.store', [
            'uuid' => $this->user->account->slug,
            'name' => 'test',
        ]));

        $response->assertRedirect('brain/'. $this->user->account->slug .'/access/roles/');

        $role = Role::where('name', 'test')->first();
        $this->assertDatabaseHas('roles', ['id' => $role->id]);
    }

    /** @test **/
    public function it_should_return_an_edit_role_view()
    {
        $role = Role::first();
        $response = $this->get(route('brain.access.roles.edit', [
            'uuid' => $this->user->account->slug,
            'role' => $role->id,
        ]));
        $response->assertStatus(200);
    }

    /** @test * */
    public function it_should_update_a_role_and_redirect_to_index()
    {
        $response = $this->put(route('brain.access.roles.update', [
            'uuid' => $this->user->account->slug,
            'role' => Role::first()->id,
            'name' => 'test',
        ]));
        $response->assertRedirect('brain/' . $this->user->account->slug . '/access/roles/');

        $role = Role::where('name', 'test')->first();
        $this->assertDatabaseHas('roles', ['id' => $role->id]);
    }

    /** @test **/
    public function it_should_delete_a_role_and_redirect_back()
    {
        $role = Role::first();

        $response = $this->delete(route('brain.access.roles.destroy', [
            'uuid' => $this->user->account->slug,
            'role' => $role->id,
        ]));
        $response->assertRedirect();

        $this->assertDatabaseMissing('roles', ['id' => $role->id]);
    }

    /** @test **/
    public function it_should_give_a_role_to_a_user_and_redirect_back()
    {
        $response = $this->post(route('brain.access.roles.permission.give', [
            'uuid' => $this->user->account->slug,
            'permission' => Permission::first()->name,
            'role' => Role::first()->name,
        ]));
        $response->assertRedirect();
    }

    /** @test **/
    public function it_should_revoke_a_role_to_a_user_and_redirect_back()
    {
        $response = $this->post(route('brain.access.roles.permission.revoke', [
            'uuid' => $this->user->account->slug,
            'permission' => Permission::first()->name,
            'role' => Role::first()->id,
        ]));
        $response->assertRedirect();
    }
}
