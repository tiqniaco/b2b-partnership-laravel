<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Country>
 */

class CountryFactory extends Factory
{
    protected $model = \App\Models\Country::class;

    public function definition()
    {
        return [
            'name_en' => $this->faker->country,
            'name_ar' => $this->faker->country,
        ];
    }
}