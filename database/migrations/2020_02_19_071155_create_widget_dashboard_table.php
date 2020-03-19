<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateWidgetDashboardTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('widget_dashboard', function(Blueprint $table)
		{
			$table->bigInteger('widget_id')->unsigned()->index('fk_widget_dashboard_widgets1_idx');
			$table->bigInteger('dashboard_id')->unsigned()->index('fk_widget_dashboard_dashboards1_idx');
		});
	}


	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::drop('widget_dashboard');
	}

}
