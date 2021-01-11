<?php

namespace Akkurate\LaravelCore\Tests\Core;

use Akkurate\LaravelCore\Tests\TestCase;

class AdminControllerTest extends TestCase
{
    /** @test */
    public function it_should_redirect_to_login()
    {
        auth()->logout();

        $response = $this->get('/admin');

        $response->assertRedirect('/login');
    }

    /** @test */
    public function it_should_redirect_to_dashboard()
    {
        $response = $this->get('/admin');

        $response->assertRedirect('/brain');
    }
}
