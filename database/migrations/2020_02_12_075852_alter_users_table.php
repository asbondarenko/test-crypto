<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AlterUsersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        if (Schema::hasTable('users')) {
            Schema::table('users', function (Blueprint $table) {
                $table->tinyInteger('active')->default(\App\Models\User::STATUS_ACTIVE);
                $table->tinyInteger('web_notifications')->default(\App\Models\User::WEB_NOTIFICATIONS_DISABLED);
                $table->tinyInteger('terms_and_conditions')->default(\App\Models\User::TERMS_AND_CONDITIONS_NOT_ACCEPTED);
                $table->string('hear_about_us')->nullable();
                $table->string('motto')->nullable();
                $table->text('about_me')->nullable();
                $table->string('email_alerts')->nullable();
                $table->string('sms_alerts')->nullable();
            });
        }
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        if (Schema::hasTable('users')) {
            Schema::table('users', function (Blueprint $table) {
                if (Schema::hasColumn('users', 'active')) {
                    $table->dropColumn('active');
                    $table->dropColumn('web_notifications');
                    $table->dropColumn('terms_and_conditions');
                    $table->dropColumn('hear_about_us');
                    $table->dropColumn('motto');
                    $table->dropColumn('about_me');
                    $table->dropColumn('email_alerts');
                    $table->dropColumn('sms_alerts');
                }
            });
        }
    }
}
