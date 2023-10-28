<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddNumRoundInTournamentsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('tournaments', function (Blueprint $table) {
            $table->integer('num_round')->default(0);
        });
        Schema::table('games', function (Blueprint $table) {
            $table->integer('num_round')->default(0);
        });
        Schema::table('tournaments', function (Blueprint $table) {
            $table->boolean('is_generated_playoff')->default(false);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('tournaments', function (Blueprint $table) {
            $table->dropColumn('num_round');
            $table->dropColumn('is_generated_playoff');
        });
        Schema::table('games', function (Blueprint $table) {
            $table->dropColumn('num_round');
        });
    }
}
