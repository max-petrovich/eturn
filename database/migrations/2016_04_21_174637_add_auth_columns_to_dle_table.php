<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddAuthColumnsToDleTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('dle_users', function (Blueprint $table) {
            $table->string('email', 255)->change();
            $table->string('password', 255)->change();
            $table->string('name', 255)->change();
            $table->rememberToken();
            $table->timestamps();
        });
        DB::statement('ALTER TABLE dle_users ENGINE = InnoDB');
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('dle_users', function (Blueprint $table) {
            $table->string('email', 50)->change();
            $table->string('password', 32)->change();
            $table->string('name', 40)->change();
            $table->dropRememberToken();
            $table->dropTimestamps();
        });
        DB::statement('ALTER TABLE dle_users ENGINE = MyISAM');
    }
}