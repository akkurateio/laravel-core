<?php

namespace Akkurate\LaravelCore\Tests\Admin;

use Akkurate\LaravelCore\Models\Country;
use Akkurate\LaravelCore\Tests\TestCase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\WithoutMiddleware;
use Laravel\Passport\Passport;

class CountryControllerTest extends TestCase
{
    use WithFaker;
    use WithoutMiddleware;

    /** @test **/
    public function it_should_return_the_countries_view()
    {
        Passport::actingAs($this->user);
        Country::factory()->count(2)->make();
        $response = $this->get(route('brain.admin.countries.index', [
            'uuid' => $this->user->account->slug
        ]));
        $response->assertStatus(200);
    }

    /** @test **/
    public function it_should_redirect_to_a_country_edit_view()
    {
        Passport::actingAs($this->user);

        $country = Country::first();

        $response = $this->get(route('brain.admin.countries.show', [
            'uuid' => $this->user->account->slug,
            'country' => $country->id
        ]));
        $response->assertRedirect();
    }

    /** @test **/
    public function it_should_return_to_a_country_edit_view()
    {
        Passport::actingAs($this->user);

        $country = Country::first();

        $response = $this->get(route('brain.admin.countries.edit', [
            'uuid' => $this->user->account->slug,
            'country' => $country->id
        ]));
        $response->assertStatus(200);
    }

    /** @test **/
    public function it_should_create_a_country()
    {
        Passport::actingAs($this->user);
        $response = $this->post(route('brain.admin.countries.store', [
            'uuid' => $this->user->account->slug,
            'name' => $this->faker->country,
            'code' => $this->faker->countryCode,
            'priority' => $this->faker->numberBetween(1, 100),
        ]));

        $response->assertStatus(302);

        $country = Country::first();
        $this->assertDatabaseHas('admin_countries', ['id' => $country->id]);
    }

    /** @test **/
    public function it_should_update_a_country()
    {
        $country = Country::first();

        $response = $this->put(route('brain.admin.countries.update', [
            'uuid' => $this->user->account->slug,
            'country' => $country,
            'name' => $this->faker->country,
            'code' => $this->faker->countryCode,
            'priority' => $this->faker->numberBetween(1, 100),
        ]));

        $response->assertStatus(302);

        $this->assertDatabaseHas('admin_countries', ['id' => $country->id]);
    }

    /** @test **/
    public function it_should_delete_a_country_and_redirect()
    {
        $country = Country::first();

        $response = $this->delete(route('brain.admin.countries.destroy', [
            'uuid' => $this->user->account->slug,
            'country' => $country->id
        ]));

        $response->assertRedirect();

        $this->assertDeleted('admin_countries', ['id' => $country->id]);
    }
}
