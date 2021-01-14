<?php

namespace Akkurate\LaravelCore\Tests\Core;

use Akkurate\LaravelCore\Models\User;
use Akkurate\LaravelCore\Tests\TestCase;

class InstallerTest extends TestCase
{
    /** @test */
    public function it_should_have_an_akkurate_user_as_default_auth_user()
    {
        $this->artisan('core:install');
        $this->assertEquals(get_class($this->user), config('auth.providers.users.model'));
    }

    /** @test */
    public function it_should_change_the_api_guard_driver()
    {
        $this->artisan('core:install');
        $this->assertEquals('passport', config('auth.guards.api.driver'));
    }

    /** @test */
    public function it_should_have_a_data_in_database()
    {
        $this->artisan('core:install');

        $user = User::where('email', 'superadmin@test.com')->first();

        $this->assertDatabaseHas('users', ['id' => $user->id]);
    }
}
