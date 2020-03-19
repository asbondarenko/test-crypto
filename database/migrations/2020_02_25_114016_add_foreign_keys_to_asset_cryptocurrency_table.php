<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class AddForeignKeysToAssetCryptocurrencyTable extends Migration
{

    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('asset_cryptocurrency', function (Blueprint $table) {
            $table->foreign('asset_id', 'fk_asset_cryptocurrency_assets1')->references('id')->on('assets')->onUpdate('NO ACTION')->onDelete('NO ACTION');
            $table->foreign('cryptocurrency_id', 'fk_asset_cryptocurrency_cryptocurrencies1')->references('id')->on('cryptocurrencies')->onUpdate('NO ACTION')->onDelete('NO ACTION');
        });
    }


    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('asset_cryptocurrency', function (Blueprint $table) {
            $table->dropForeign('fk_asset_cryptocurrency_assets1');
            $table->dropForeign('fk_asset_cryptocurrency_cryptocurrencies1');
        });
    }

}
