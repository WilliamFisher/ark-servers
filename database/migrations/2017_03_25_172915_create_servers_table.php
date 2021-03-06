<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateServersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('servers', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('user_id');
            $table->string('platform');
            $table->string('name', 16);
            $table->string('map');
            $table->text('description');
            $table->string('rules');
            $table->boolean('is_pvp');
            $table->boolean('is_pve');
            $table->float('xp_rate');
            $table->float('gather_rate');
            $table->float('tame_rate');
            $table->float('breeding_rate');
            $table->date('last_wipe');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('servers');
    }
}
