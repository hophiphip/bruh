<?php

namespace Database\Seeders;

use App\Models\Offer;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class OfferSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        // TODO: Table/collection names as protected prop. in a model
        // TODO: Db connection as a protected prop. in a model

        DB::table('offers')->truncate();

        Offer::factory()->count(50)->create();
    }
}
