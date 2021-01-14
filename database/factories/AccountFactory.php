<?php

namespace Akkurate\LaravelCore\Database\Factories;

use Akkurate\LaravelCore\Models\Account;
use Illuminate\Database\Eloquent\Factories\Factory;

class AccountFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = Account::class;

    public function definition()
    {
        return [
            'name' => $this->faker->name,
            'email' => $this->faker->email,
            'website' => $this->faker->url,
            'is_active' => $this->faker->boolean
        ];
    }
}
