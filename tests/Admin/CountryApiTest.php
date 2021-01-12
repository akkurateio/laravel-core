<?php

namespace Akkurate\LaravelCore\Tests\Admin;

use Akkurate\LaravelCore\Tests\TestCase;
use Laravel\Passport\Passport;
use Akkurate\LaravelCore\Models\Country;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\WithoutMiddleware;

class CountryApiTest extends TestCase
{

    use WithFaker;
    use WithoutMiddleware;

    /** @test **/
    public function it_should_return_all_countries()
    {
        Passport::actingAs($this->user);
        Country::factory()->count(2)->make();
        $response = $this->get(route('api.admin.countries.index', [
            'uuid' => $this->user->account->uuid
        ]));
        $response->assertStatus(200);
    }

    /** @test **/
    public function it_should_read_a_country()
    {
        Passport::actingAs($this->user);
        $response = $this->get(route('api.admin.countries.show', [
            'uuid' => $this->user->account->uuid,
            'country' => Country::factory()->create()
        ]));
        $response->assertStatus(200);
    }

    /** @test **/
    public function it_should_create_a_country()
    {
        Passport::actingAs($this->user);
        $response = $this->post(route('api.admin.countries.store', [
            'uuid' => $this->user->account->uuid,
            'name' => $this->faker->country,
            'code' => $this->faker->countryCode,
            'priority' => $this->faker->numberBetween(1,100),
        ]));
        $response->assertStatus(201);
    }

    /** @test **/
    public function it_should_update_a_country()
    {
        Passport::actingAs($this->user);
        $response = $this->put(route('api.admin.countries.update', [
            'uuid' => $this->user->account->uuid,
            'country' => Country::factory()->create(),
            'name' => $this->faker->country,
            'code' => $this->faker->unique()->countryCode,
            'priority' => $this->faker->numberBetween(1,100),
        ]));
        $response->assertStatus(200);
    }

    /** @test **/
    public function it_should_delete_a_country()
    {
        Passport::actingAs($this->user);
        $response = $this->delete(route('api.admin.countries.destroy', [
            'uuid' => $this->user->account->uuid,
            'country' => Country::factory()->create()
        ]));
        $response->assertStatus(204);
    }

}
