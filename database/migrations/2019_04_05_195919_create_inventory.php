<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateInventory extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('hotels', function (Blueprint $table) {
            $table->increments('id');
            $table->string('name')->nullable();
            $table->integer('country_id')->nullable();
            $table->integer('state_id')->nullable();
            $table->integer('city_id')->nullable();
            $table->decimal('lat',15,12)->nullable();
            $table->decimal('lng',15,12)->nullable();
            $table->text('short_desc')->nullable();
            $table->text('long_desc')->nullable();
            
            $table->timestamps();
        });

        Schema::create('rooms', function (Blueprint $table) {
            $table->increments('id');
            $table->string('name')->nullable();
            $table->integer('hotel_id')->nullable();
            $table->text('short_desc')->nullable();
            $table->text('long_desc')->nullable();
            
            $table->timestamps();
        });

        Schema::create('amenities', function (Blueprint $table) {
            $table->increments('id');
            $table->string('name');
            $table->timestamps();
        });

        Schema::create('amenity_hotel', function (Blueprint $table) {
            $table->integer('amenity_id');
            $table->integer('hotel_id');
        });

        Schema::create('amenity_room', function (Blueprint $table) {
            $table->integer('amenity_id');
            $table->integer('room_id');
        });

        Schema::create('travellers', function (Blueprint $table) {
            $table->increments('id');
            $table->string('name_prefix',10)->nullable();
            $table->string('first_name',50)->nullable();
            $table->string('last_name',50)->nullable();
            $table->integer('age')->nullable();
            $table->boolean('is_child')->nullable();
            $table->text('long_desc')->nullable();
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
        //
    }
}
