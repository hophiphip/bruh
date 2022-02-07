<?php

use App\Models\Insurer;
use App\Models\Offer;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateOffersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create(app(Offer::class)->getTable(), function (Blueprint $table) {
            $table->bigIncrements('id');

            // NOTE: `case_id` is not referencing any table
            $table->integer('case_id');

            $table->bigInteger('insurer_id')->unsigned()->index();
            $table->text('description');
            $table->timestamps();
        });

        Schema::table(app(Offer::class)->getTable(), function (Blueprint $table) {
            $table->foreign('insurer_id')
                  ->references('id')
                  ->on(app(Insurer::class)->getTable())
                  ->onDelete('cascade');;
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists(app(Offer::class)->getTable());
    }
}
