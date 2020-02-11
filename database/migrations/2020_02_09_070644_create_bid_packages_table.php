<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateBidPackagesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('bid_packages', function (Blueprint $table) {
            $table->increments('id');
            $table->string('name');
            $table->integer('period')->default(0)->comment("In Months");
            $table->double('amount',15,5)->default(0);
            $table->integer('no_of_bids')->default(0)->comment("Number bid for the plans");
            $table->integer('sort');
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
        Schema::dropIfExists('bid_packages');
    }
}
