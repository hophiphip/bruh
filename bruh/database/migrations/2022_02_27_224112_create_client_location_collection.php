<?php

use App\Models\ClientLocation;
use App\Providers\DatabaseTableNamesProvider;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateClientLocationCollection extends Migration
{
    /**
     * The name of the database connection to use.
     *
     * @var string
     */
    protected $connection = 'mongodb';

    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::connection(DatabaseTableNamesProvider::client_location_collection_connection())
            ->table(DatabaseTableNamesProvider::CLIENT_LOCATION_COLLECTION, function (Blueprint $collection) {
            $collection->string('email');

            // store location data as JSON
            $collection->json('location');

            $collection->timestamps();

            // Expire in 30 days
            $collection->expire('createdAt', 60 * 60 * 24 * 30);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::connection(DatabaseTableNamesProvider::client_location_collection_connection())
            ->table(DatabaseTableNamesProvider::CLIENT_LOCATION_COLLECTION, function (Blueprint $collection) {
            $collection->dropIfExists();
        });
    }
}
