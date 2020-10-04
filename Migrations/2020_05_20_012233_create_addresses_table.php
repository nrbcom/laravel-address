<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateAddressesTable extends Migration
{
    /**
     *
     */
    public function up()
    {
        Schema::create('addresses', function (Blueprint $table) {
            $table->bigIncrements('id');

            $table->morphs('model');
            $table->string('line1');
            $table->string('line2')->nullable();
            $table->string('building_number')->nullable();
            $table->string('door_number')->nullable();
            $table->string('state')->nullable();
            $table->string('province')->nullable();
            $table->string('region')->nullable();
            $table->string('county')->nullable();
            $table->string('city')->nullable()->index();
            $table->string('zip')->nullable();
            $table->string('country')->nullable()->index();
            $table->boolean('primary')->default(false)->index();
            $table->boolean('invoice')->default(false)->index();
            $table->string('cord_lat', 15)->nullable();
            $table->string('cord_lng', 15)->nullable();

            $table->nullableTimestamps();
            $table->softDeletes();
        });
    }


    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('addresses');
    }
}