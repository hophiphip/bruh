<?php

namespace Database\Seeders;

use App\Models\Insurer;
use App\Models\Offer;
use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed count.
     *
     * @var integer
     */
    public const SEED_COUNT = 20;

    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        DB::table(app(Offer::class)->getTable())->truncate();
        DB::table(app(Insurer::class)->getTable())->truncate();

        User::factory()->count(self::SEED_COUNT)->create()->each(function ($user) {
            Insurer::factory()->count(1)->create()->each(function ($insurer) use ($user) {
                $offers = Offer::factory()->count(5)->make();
                /* TODO: User::find(1)->insurers() returns nothing ? */
                $insurer->getOffers()->saveMany($offers);
                $user->insurer()->save($insurer);
            });
        });
    }
}
