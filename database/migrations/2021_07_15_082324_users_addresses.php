<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class UsersAddresses extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('users_addresses', function (Blueprint $table) {
            $table->timestamps();

            $table->foreignId('user_id')->references('id')->on('users')->constrained()->onDelete('cascade');

            $table->string('street', 100)->nullable();
            $table->string('suite', 100)->nullable();
            $table->string('city', 50)->nullable();
            $table->string('zipcode', 20)->nullable();
            $table->string('lat', 20)->nullable();
            $table->string('lng', 20)->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('users_addresses');
    }
}
