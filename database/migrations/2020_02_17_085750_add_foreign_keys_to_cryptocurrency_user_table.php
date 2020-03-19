<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class AddForeignKeysToCryptocurrencyUserTable extends Migration
{

    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('cryptocurrency_user', function (Blueprint $table) {
            $table->foreign('cryptocurrency_id', 'fk_cryptocurrency_user_cryptocurrencies1')->references('id')->on('cryptocurrencies')->onUpdate('CASCADE')->onDelete('CASCADE');
            $table->foreign('user_id', 'fk_cryptocurrency_user_users')->references('id')->on('users')->onUpdate('CASCADE')->onDelete('CASCADE');
        });
    }


    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('cryptocurrency_user', function (Blueprint $table) {
            $table->dropForeign('fk_cryptocurrency_user_cryptocurrencies1');
            $table->dropForeign('fk_cryptocurrency_user_users');
        });
    }

}
