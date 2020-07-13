<?php

use App\Models\Business;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateBusinessesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('categories', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->tinyInteger('is_service');
            $table->tinyInteger('is_product');
            $table->timestamps();
        });

        Schema::create('businesses', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->tinyInteger('is_service');
            $table->tinyInteger('is_product');
            // $table->string('categories')->default('[]');
            $table->enum('type', Business::$types);
            $table->text('description')->nullable();
            $table->string('phone');
            $table->integer('employee_count')->default(0);
            $table->timestamps();
        });

        Schema::create('business_category', function (Blueprint $table) {
            $table->id();
            $table->foreignId('category_id')->constrained();
            $table->foreignId('business_id')->constrained();
            $table->timestamps();
        });

        Schema::create('business_user', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained();
            $table->foreignId('business_id')->constrained();
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
        Schema::dropIfExists('business_user');
        Schema::dropIfExists('business_category');
        Schema::dropIfExists('businesses');
        Schema::dropIfExists('category');
    }
}
