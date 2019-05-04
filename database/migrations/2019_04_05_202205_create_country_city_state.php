<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateCountryCityState extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('countries', function (Blueprint $table) {
            $table->increments('id');
            $table->string('name',100)->nullable();
        });

        Schema::create('states', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('country_id');
            $table->string('name',100)->nullable();
        });
        Schema::create('cities', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('country_id');
            $table->integer('state_id');
            $table->string('name',100)->nullable();
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
