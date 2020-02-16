<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreatePostJobsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('post_jobs', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('user_id');
            $table->string('job_title');
            $table->integer('category_id');
            $table->string('job_tags');
            $table->text('description');
            $table->double('budget',15,5)->default(0);
            $table->string('company_name')->nullable();
            $table->string('location')->nullable();
            $table->string('email')->nullable();
            $table->string('website')->nullable();
            $table->date('closing_date')->nullable();
            $table->mediumText('tagline')->nullable();
            /*$table->integer('expected_working_days')->default(0);
            $table->integer('expected_working_hours')->default(0);
            $table->integer('taken_working_days')->default(0);
            $table->integer('taken_working_hours')->default(0);*/
            $table->integer('assigned_to')->nullable();
            $table->double('final_bid',15,5)->default(0);
            $table->tinyInteger('status')->default(0)->comment('0-Not started,1-finished biding,2-started,3-finished');
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
        Schema::dropIfExists('post_jobs');
    }
}
