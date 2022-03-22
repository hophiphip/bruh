<?php

namespace Database\Seeders;

use App\Models\Insurer;
use App\Models\LoginToken;
use App\Models\ClientLocation;
use App\Models\Offer;
use App\Models\OfferRequest;
use App\Models\Role;
use App\Models\User;
use App\Providers\DatabaseTableNamesProvider;
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
        DB::connection(DatabaseTableNamesProvider::CLIENT_LOCATION_COLLECTION_CONNECTION)
            ->table(DatabaseTableNamesProvider::CLIENT_LOCATION_COLLECTION)
            ->truncate();

        DB::table(DatabaseTableNamesProvider::ROLE_TABLE)->truncate();
        DB::table(DatabaseTableNamesProvider::OFFER_REQUEST_TABLE)->truncate();
        DB::table(DatabaseTableNamesProvider::OFFER_TABLE)->truncate();
        DB::table(DatabaseTableNamesProvider::INSURER_TABLE)->truncate();
        DB::table(DatabaseTableNamesProvider::LOGIN_TOKEN_TABLE)->truncate();
        DB::table(DatabaseTableNamesProvider::USER_TABLE)->truncate();
    }

    /**
     * Seed the DB with new data.
     *
     * @return void
     */
    public function seed()
    {
        // TODO: Move to separate seeder and call it separately (mb. from migration) - it is initial constant data
        // Add the default user roles
        $this->call([
            RoleSeeder::class,
        ]);

        $this->command->getOutput()->info('Seeding database...');
        $this->command->getOutput()->progressStart(self::USER_SEED_COUNT);

        // TODO: Mode everything to seeders
        User::factory()->count(self::USER_SEED_COUNT)->create()->each(function ($user) {
            Insurer::factory()->count(1)->create()->each(function ($insurer) use ($user) {
                Offer::factory()->count(self::OFFER_SEED_COUNT)->create()->each(function ($offer) use ($insurer, $user) {
                    $offerRequests = OfferRequest::factory()->count(self::OFFER_REQUEST_SEED_COUNT)->make();

                    $offer->requests()->saveMany($offerRequests);
                    $insurer->offers()->save($offer);
                    $user->insurer()->save($insurer);
                    $user->roles()->sync([ Role::insurerRoleId() ]);
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
