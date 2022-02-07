<?php

namespace Database\Seeders;

use App\Models\Insurer;
use App\Models\Offer;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        DB::table(app(Offer::class)->getTable())->truncate();
        DB::table(app(Insurer::class)->getTable())->truncate();

        Insurer::factory()->count(20)->create()->each(function ($insurer) {
            $offers = Offer::factory()->count(5)->make();
            $insurer->getOffers()->saveMany($offers);
        });
    }
}
