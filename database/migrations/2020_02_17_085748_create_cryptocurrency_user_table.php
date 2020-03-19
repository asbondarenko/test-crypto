<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateCryptocurrencyUserTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('cryptocurrency_user', function(Blueprint $table)
		{
			$table->bigInteger('user_id')->unsigned()->index('fk_cryptocurrency_user_users_idx');
			$table->integer('cryptocurrency_id')->unsigned()->index('fk_cryptocurrency_user_cryptocurrencies1_idx');
		});
	}


	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::dropIfExists('cryptocurrency_user');
	}

}
