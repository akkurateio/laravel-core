<?php

namespace Akkurate\LaravelCore\Database\Factories\Admin;

use Akkurate\LaravelCore\Models\Account;
use Akkurate\LaravelCore\Models\Language;
use Illuminate\Database\Eloquent\Factories\Factory;

class LanguageFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = Language::class;

    public function definition()
    {
        return [
            'uuid' => $this->faker->uuid,
            'label' => $this->faker->name,
            'locale' => $this->faker->languageCode,
            'locale_php' => $this->faker->languageCode,
            'priority' => $this->faker->randomNumber(1),
            'is_active' => $this->faker->boolean,
            'is_default' => $this->faker->boolean
        ];
    }
}
