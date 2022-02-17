<?php

namespace Database\Seeders;

use App\Models\Insurer;
use App\Models\LoginToken;
use App\Models\Offer;
use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed count for users.
     *
     * @var integer
     */
    public const USER_SEED_COUNT = 20;

    /**
     * Seed count for offers.
     *
     * @var integer
     */
    public const OFFER_SEED_COUNT = 5;

    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        DB::table(app(Offer::class)->getTable())->truncate();
        DB::table(app(Insurer::class)->getTable())->truncate();
        DB::table(app(LoginToken::class)->getTable())->truncate();
        DB::table(app(User::class)->getTable())->truncate();

        User::factory()->count(self::USER_SEED_COUNT)->create()->each(function ($user) {
            Insurer::factory()->count(1)->create()->each(function ($insurer) use ($user) {
                $offers = Offer::factory()->count(self::OFFER_SEED_COUNT)->make();

                /* TODO: User::find(1)->insurers() returns nothing ? */
                $insurer->getOffers()->saveMany($offers);
                $user->insurer()->save($insurer);
            });
        });
    }
}
