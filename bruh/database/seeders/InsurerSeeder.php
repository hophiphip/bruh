<?php

namespace Database\Seeders;

use App\Models\Insurer;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class InsurerSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        // TODO: User service for table names
        DB::table(app(Insurer::class)->getTable())->truncate();
        Insurer::factory()->count(50)->create();
    }
}
