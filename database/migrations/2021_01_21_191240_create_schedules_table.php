<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateSchedulesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('schedules', function (Blueprint $table) {
            $table->id();
            $table->morphs('scheduleable');
            $table->tinyInteger('mon')->default(1);
            $table->time('mon_start')->default('00:00');
            $table->time('mon_stop')->default('00:00');
            $table->tinyInteger('tue')->default(1);
            $table->time('tue_start')->default('00:00');
            $table->time('tue_stop')->default('00:00');
            $table->tinyInteger('wed')->default(1);
            $table->time('wed_start')->default('00:00');
            $table->time('wed_stop')->default('00:00');
            $table->tinyInteger('thu')->default(1);
            $table->time('thu_start')->default('00:00');
            $table->time('thu_stop')->default('00:00');
            $table->tinyInteger('fri')->default(1);
            $table->time('fri_start')->default('00:00');
            $table->time('fri_stop')->default('00:00');
            $table->tinyInteger('sat')->default(1);
            $table->time('sat_start')->default('00:00');
            $table->time('sat_stop')->default('00:00');
            $table->tinyInteger('sun')->default(1);
            $table->time('sun_start')->default('00:00');
            $table->time('sun_stop')->default('00:00');
            $table->softDeletes();
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
        Schema::dropIfExists('schedules');
    }
}
