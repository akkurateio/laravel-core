<?php

namespace Akkurate\LaravelCore\Database\Factories\Admin;

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
            'params' => $this->faker->sentence,
            'internal_reference' => $this->faker->unique()->name,
            'website' => $this->faker->url,
            'parent_id' => 1,
            'country_id' => 1,
            'address_id' => 1 ,
            'phone_id' => 1,
            'email_id' => 1,
            'is_active' => $this->faker->boolean
        ];
    }
}
