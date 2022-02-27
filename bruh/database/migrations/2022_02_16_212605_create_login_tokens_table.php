<?php

use App\Models\LoginToken;
use App\Models\User;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateLoginTokensTable extends Migration
{
    /**
     * Migration table name.
     *
     * @var string
     */
    protected string $tableName = '';

    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        $this->tableName = app(LoginToken::class)->getTable();

        Schema::create($this->tableName, function (Blueprint $table) {
            $table->id();

            $table->unsignedBigInteger('user_id');
            $table->foreign('user_id')->references('id')->on(app(User::class)->getTable())->cascadeOnDelete();

            $table->string('token')->unique();
            $table->timestamp('consumed_at')->nullable();
            $table->timestamp('expires_at');
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
        Schema::dropIfExists($this->tableName);
    }
}
