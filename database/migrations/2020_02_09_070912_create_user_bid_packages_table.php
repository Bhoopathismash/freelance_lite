<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateUserBidPackagesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('user_bid_packages', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('user_id');
            $table->integer('package_id');
            $table->integer('total_bids');
            $table->integer('used_bids');
            $table->integer('balance_bids');
            $table->string('payment_id');
            $table->tinyInteger('status')->comment('0-Inactive, 1-Active');
            $table->string('razorpay_payment_id')->nullable();
            $table->string('razorpay_payment_status')->nullable();
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
        Schema::dropIfExists('user_bid_packages');
    }
}
