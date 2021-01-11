<?php

namespace Akkurate\LaravelCore\Tests\Admin;

use Akkurate\LaravelCore\Models\Language;
use Akkurate\LaravelCore\Tests\TestCase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\WithoutMiddleware;
use Laravel\Passport\Passport;

class LanguageControllerTest extends TestCase
{
    use WithFaker;
    use WithoutMiddleware;

   /** @test **/
    public function it_should_return_the_languages_view()
    {
        Passport::actingAs($this->user);
        $response = $this->get(route('brain.admin.languages.index', [
            'uuid' => $this->user->account->slug
        ]));
        $response->assertStatus(200);
    }

    /** @test **/
    public function it_should_redirect_to_a_language_edit_view()
    {
        Passport::actingAs($this->user);

        $language = Language::first();

        $response = $this->get(route('brain.admin.languages.show', [
            'uuid' => $this->user->account->slug,
            'language' => $language->id
        ]));
        $response->assertRedirect();
    }

    /** @test **/
    public function it_should_return_to_a_language_edit_view()
    {
        Passport::actingAs($this->user);

        $language = Language::first();

        $response = $this->get(route('brain.admin.languages.edit', [
            'uuid' => $this->user->account->slug,
            'language' => $language->id
        ]));
        $response->assertStatus(200);
    }

    /** @test **/
    public function it_should_create_a_language()
    {
        $response = $this->post(route('brain.admin.languages.store', [
            'uuid' => $this->user->account->slug,
            'locale' => $this->faker->locale,
            'locale_php' => $this->faker->locale,
            'priority' => $this->faker->numberBetween(1,100),
        ]));

        $response->assertStatus(302);

        $language = Language::first();
        $this->assertDatabaseHas('admin_languages', ['id' => $language->id]);
    }

    /** @test **/
    public function it_should_update_a_language()
    {
        $language = Language::first();

        $response = $this->put(route('brain.admin.languages.update', [
            'uuid' => $this->user->account->slug,
            'language' => $language,
            'locale' => $this->faker->locale,
            'locale_php' => $this->faker->locale,
            'priority' => $this->faker->numberBetween(1,100),
        ]));

        $response->assertStatus(302);

        $this->assertDatabaseHas('admin_languages', ['id' => $language->id]);
    }

    /** @test **/
    public function it_should_delete_a_language_and_redirect()
    {
        $language = Language::first();

        $response = $this->delete(route('brain.admin.languages.destroy', [
            'uuid' => $this->user->account->slug,
            'language' => $language->id
        ]));

        $response->assertRedirect();

        $this->assertDeleted('admin_languages', ['id' => $language->id]);
    }

}
