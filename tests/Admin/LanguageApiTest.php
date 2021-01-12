<?php

namespace Akkurate\LaravelCore\Tests\Admin;

use Akkurate\LaravelCore\Tests\TestCase;
use Laravel\Passport\Passport;
use Akkurate\LaravelCore\Models\Language;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\WithoutMiddleware;

class LanguageApiTest extends TestCase
{

    use WithFaker;
    use WithoutMiddleware;

    /** @test **/
    public function it_should_return_all_languages()
    {
        Passport::actingAs($this->user);
        Language::factory()->count(3)->create();
        $response = $this->get(route('api.admin.languages.index', [
            'uuid' => $this->user->account->uuid
        ]));
        $response->assertStatus(200);
    }

    /** @test **/
    public function it_should_read_a_language()
    {
        Passport::actingAs($this->user);
        $response = $this->get(route('api.admin.languages.show', [
            'uuid' => $this->user->account->uuid,
            'language' => Language::factory()->create()
        ]));
        $response->assertStatus(200);
    }

    /** @test **/
    public function it_should_create_a_language()
    {
        Passport::actingAs($this->user);
        $response = $this->post(route('api.admin.languages.store', [
            'uuid' => $this->user->account->uuid,
            'locale' => $this->faker->locale,
            'locale_php' => $this->faker->locale,
            'priority' => $this->faker->numberBetween(1,100),
        ]));
        $response->assertStatus(201);
    }

    /** @test **/
    public function it_should_update_a_language()
    {
        Passport::actingAs($this->user);
        $response = $this->put(route('api.admin.languages.update', [
            'uuid' => $this->user->account->uuid,
            'language' => Language::factory()->create(),
            'locale' => $this->faker->locale,
            'locale_php' => $this->faker->locale,
            'priority' => $this->faker->numberBetween(1,100),
        ]));
        $response->assertStatus(200);
    }

    /** @test **/
    public function it_should_delete_a_language()
    {
        Passport::actingAs($this->user);
        $response = $this->delete(route('api.admin.languages.destroy', [
            'uuid' => $this->user->account->uuid,
            'language' => Language::factory()->create()
        ]));
        $response->assertStatus(204);
    }

}
