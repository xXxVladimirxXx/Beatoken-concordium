<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
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
            $table->string('email')->unique();
            $table->timestamp('email_verified_at')->nullable();
            $table->string('password');
            $table->string('balance')->nullable();
            $table->string('fee_sale_drop')->default(20)->nullable();
            $table->string('fee_sale_marketplace')->default(5)->nullable();
            $table->string('avatar_url')->nullable();

            // user info
            $table->string('first_name')->nullable();
            $table->string('last_name')->nullable();
            $table->string('country_code')->nullable();
            $table->string('city')->nullable();
            $table->string('address')->nullable();
            $table->string('zip')->nullable();
            $table->string('cell_cc')->nullable();
            $table->string('cell_number')->nullable();

            $table->integer('role_id')->default(4);
            $table->string('twitter_url')->nullable();
            $table->string('instagram_url')->nullable();
            $table->string('facebook_url')->nullable();
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
};
