<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateAssetCryptocurrencyTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('asset_cryptocurrency', function(Blueprint $table)
		{
			$table->integer('asset_id')->unsigned()->index('fk_asset_cryptocurrency_assets1_idx');
			$table->integer('cryptocurrency_id')->unsigned()->index('fk_asset_cryptocurrency_cryptocurrencies1_idx');
		});
	}


	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::drop('asset_cryptocurrency');
	}

}
