<?php

namespace Akkurate\LaravelCore\Database\Factories\Admin;

use Akkurate\LaravelCore\Models\Account;
use Akkurate\LaravelCore\Models\Language;
use Akkurate\LaravelCore\Models\Preference;
use Akkurate\LaravelCore\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

class PreferenceFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = Preference::class;

    public function definition()
    {
        return [
            'preferenceable_type' => 'Akkurate\LaravelCore\Models\Account',
            'preferenceable_id' => 1,
            'target' => $this->faker->randomElement(['both', 'b2c', 'b2b']),
            'pagination' => $this->faker->numberBetween(1, 500),
            'language_id' => Language::factory()->create()->id
        ];
    }
}
