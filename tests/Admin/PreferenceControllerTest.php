<?php

namespace Akkurate\LaravelCore\Tests\Admin;

use Akkurate\LaravelCore\Tests\TestCase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\WithoutMiddleware;

class PreferenceControllerTest extends TestCase
{
    use WithFaker;
    use WithoutMiddleware;

    /** @test * */
    public function it_should_update_a_preference_then_redirect()
    {
        $preference = $this->user->account->preference()->create();

        $response = $this->put(route('brain.admin.preferences.update', [
            'uuid' => $this->user->account->slug,
            'preference' => $preference,
            'pagination' => $this->faker->numberBetween(1, 500),
        ]));

        $this->assertDatabaseHas('admin_preferences', ['id' => $preference->id]);

        $response->assertStatus(302);
    }
}
