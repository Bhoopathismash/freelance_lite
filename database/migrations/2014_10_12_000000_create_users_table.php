<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateUsersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('users', function (Blueprint $table) {
            $table->increments('id');
            $table->string('name');
            $table->string('last_name')->nullable();
            $table->string('profile_name')->nullable();
            $table->string('profile_image',255)->nullable();
            $table->string('email')->unique();
            $table->string('password');
            $table->mediumText('description')->nullable();
            $table->string('mobile')->nullable();
            $table->tinyInteger('user_type')->comment('1-hire,2-work');
            $table->string('website_url')->nullable();
            $table->string('facebook_url')->nullable();
            $table->string('linkedin_url')->nullable();
            $table->string('github_url')->nullable();
            $table->tinyInteger('email_verified')->default(0)->comment('0-Not,1-Verified');
            $table->tinyInteger('admin_verified')->default(1)->comment('0-Not,1-Verified');
            $table->timestamp('email_verified_at')->nullable();
            $table->string('email_token',255)->nullable();
            $table->rememberToken();
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
        Schema::dropIfExists('users');
    }
}
