<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class AddForeignKeysToWidgetDashboardTable extends Migration
{

    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('widget_dashboard', function (Blueprint $table) {
            $table->foreign('dashboard_id', 'fk_widget_dashboard_dashboards1')->references('id')->on('dashboards')->onUpdate('cascade')->onDelete('cascade');
            $table->foreign('widget_id', 'fk_widget_dashboard_widgets1')->references('id')->on('widgets')->onUpdate('cascade')->onDelete('cascade');
        });
    }


    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('widget_dashboard', function (Blueprint $table) {
            $table->dropForeign('fk_widget_dashboard_dashboards1');
            $table->dropForeign('fk_widget_dashboard_widgets1');
        });
    }

}
