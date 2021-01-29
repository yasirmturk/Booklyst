<?php

use App\Models\Booking;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateBookingTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('orders', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained();
            $table->decimal('amount', 9, 3);
            $table->tinyInteger('is_paid')->default(0);
            $table->tinyInteger('is_cancelled')->default(0);
            $table->timestamps();
        });

        Schema::create('bookings', function (Blueprint $table) {
            $table->id();
            $table->foreignId('order_id')->constrained();
            $table->foreignId('service_id')->constrained();
            $table->timestamp('service_time');
            $table->decimal('amount', 9, 3);
            $table->string('status')->default(Booking::STATUS_BOOKED);
            $table->tinyInteger('is_paid')->default(0);
            $table->tinyInteger('is_cancelled')->default(0);
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
        Schema::dropIfExists('bookings');
        Schema::dropIfExists('orders');
    }
}
