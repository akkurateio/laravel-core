<?php

namespace Akkurate\LaravelCore\Database\Factories\Admin;

use Akkurate\LaravelCore\Models\Country;
use Illuminate\Database\Eloquent\Factories\Factory;

class CountryFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = Country::class;

    public function definition()
    {
        return [
            'name' => $this->faker->name,
            'code' => $this->faker->name,
            'priority' => $this->faker->randomNumber(1),
            'is_active' => $this->faker->boolean
        ];
    }
}
