<?php

namespace Database\Factories;

use App\Models\Offer;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Facades\App;
use App\Faker\OfferProvider;

class OfferFactory extends Factory
{
    /**
     * @var string factory model
     */
    protected $model = Offer::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition(): array
    {
        $this->faker->addProvider(new OfferProvider($this->faker));

        $issueCase = $this->faker->issueCase();

        return [
            'case_id' => $issueCase,
            'description' => $this->faker->issueDescription($issueCase),

            /* TODO: FK, needs to be overwritten
             *  like that: Offer::factory()->make([ 'insurer_id' => 42 ]);
             */
            'insurer_id' => 1,
        ];
    }
}
