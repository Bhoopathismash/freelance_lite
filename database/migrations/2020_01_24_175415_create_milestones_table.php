<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateMilestonesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('milestones', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('post_job_id');
            $table->string('milestone');
            $table->text('description');
            $table->double('amount',15,5)->default(0);
            $table->tinyInteger('worker_status')->default(0)->comment('0-Not started,1-Stared,2-Pending,3-Finished');
            $table->text('worker_comment')->nullable();
            $table->tinyInteger('hirer_status')->default(0)->comment('0-Not started,1-Stared,2-Pending,3-Finished');
            $table->text('hirer_comment')->nullable();
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
        Schema::dropIfExists('milestones');
    }
}
