<?php

namespace Database\Seeders;

use App\Models\Insurer;
use App\Models\LoginToken;
use App\Models\Mongo\ClientLocation;
use App\Models\Offer;
use App\Models\OfferRequest;
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
     * Seed count for offer requests.
     *
     * @var integer
     */
    public const OFFER_REQUEST_SEED_COUNT = 5;

    /**
     * Drop all DB tables.
     *
     * @return void
     */
    public function cleanup()
    {
        ClientLocation::truncate();

        DB::table(app(OfferRequest::class)->getTable())->truncate();
        DB::table(app(Offer::class)->getTable())->truncate();
        DB::table(app(Insurer::class)->getTable())->truncate();
        DB::table(app(LoginToken::class)->getTable())->truncate();
        DB::table(app(User::class)->getTable())->truncate();
    }

    /**
     * Seed the DB with new data.
     *
     * @return void
     */
    public function seed()
    {
        $this->command->getOutput()->info('Seeding database...');
        $this->command->getOutput()->progressStart(self::USER_SEED_COUNT);

        User::factory()->count(self::USER_SEED_COUNT)->create()->each(function ($user) {
            Insurer::factory()->count(1)->create()->each(function ($insurer) use ($user) {
                Offer::factory()->count(self::OFFER_SEED_COUNT)->create()->each(function ($offer) use ($insurer, $user) {
                    $offerRequests = OfferRequest::factory()->count(self::OFFER_REQUEST_SEED_COUNT)->make();

                    $offer->requests()->saveMany($offerRequests);
                    $insurer->offers()->save($offer);
                    $user->insurer()->save($insurer);
                });
            });

            $this->command->getOutput()->progressAdvance();
        });

        $this->command->getOutput()->progressFinish();
    }

    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        $this->cleanup();
        $this->seed();
    }
}
