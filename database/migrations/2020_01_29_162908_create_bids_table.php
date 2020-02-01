<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateBidsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('bids', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('user_id');
            $table->integer('post_job_id');
            $table->double('bid_amount',15,5)->default(0)->nullable();
            $table->string('period')->comment('Period in days')->default(0)->nullable();
            $table->mediumText('description')->nullable();
            $table->integer('status')->comment('0-Not, 1-Accepted');
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
        Schema::dropIfExists('bids');
    }
}
