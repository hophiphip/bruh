<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use JetBrains\PhpStorm\ArrayShape;

class OfferRequestFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array
     */
    #[ArrayShape(['email' => "string", 'email_verified_at' => "null"])]
    public function definition(): array
    {
        return [
            'email' => $this->faker->unique()->safeEmail(),
            'email_verified_at' => null,
        ];
    }
}
