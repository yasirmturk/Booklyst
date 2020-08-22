<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateImagesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('images', function (Blueprint $table) {
            $table->bigIncrements('id');
            // $table->morphs('imageable');
            $table->string('filename');
            $table->string('url');
            $table->timestamps();
        });

        Schema::create('imageables', function (Blueprint $table) {
            $table->foreignId('image_id')->constrained();
            $table->morphs('imageable');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('imageables');
        Schema::dropIfExists('images');
    }
}
