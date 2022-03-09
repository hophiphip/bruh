<?php

use App\Models\Offer;
use App\Models\OfferRequest;
use App\Providers\DatabaseTableNamesProvider;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateOfferRequestTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create(DatabaseTableNamesProvider::OFFER_REQUEST_TABLE, function (Blueprint $table) {
           $table->bigIncrements('id');

            $table->unsignedBigInteger('offer_id');
            $table->foreign('offer_id')->references('id')->on(app(Offer::class)->getTable())->cascadeOnDelete();

            $table->string('email');
            $table->timestamp('email_verified_at')->nullable();

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists(DatabaseTableNamesProvider::OFFER_REQUEST_TABLE);
    }
}
