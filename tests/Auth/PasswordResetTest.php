<?php

namespace Akkurate\LaravelCore\Tests\Auth;

use Akkurate\LaravelCore\Tests\TestCase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Support\Facades\Config;

class PasswordResetTest extends TestCase
{
    use WithFaker;

    /** @test * */
    public function it_should_return_null()
    {
        Config::set('back-components', null);

        $token = $this->user->getRememberToken();

        $this->assertNull($this->user->sendPasswordResetNotification($token));
    }
}
