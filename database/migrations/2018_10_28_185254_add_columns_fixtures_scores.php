<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddColumnsFixturesScores extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('fixtures', function($table) {
            $table->tinyInteger('score_home');
            $table->tinyInteger('score_away');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('fixtures', function($table) {
            $table->dropColumn('score_home');
            $table->dropColumn('score_away');
        });
    }
}
