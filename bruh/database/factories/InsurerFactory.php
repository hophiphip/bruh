<?php

namespace Database\Factories;

use App\Models\Insurer;
use Illuminate\Database\Eloquent\Factories\Factory;
use JetBrains\PhpStorm\ArrayShape;

class InsurerFactory extends Factory
{
    /**
     * @var string factory model
     */
    protected $model = Insurer::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    #[ArrayShape(['user_id' => 'integer', 'first_name' => "string", 'last_name' => "string", 'company_name' => "string"])]
    public function definition(): array
    {
        return [
            /* TODO: Default value needs to be overwritten */
            'user_id' => 1,

            'first_name' => $this->faker->firstName(),
            'last_name' => $this->faker->lastName(),
            'company_name' => $this->faker->company(),
        ];
    }
}
