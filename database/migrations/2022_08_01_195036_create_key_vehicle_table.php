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
        Schema::create('key_vehicle', function (Blueprint $table) {
            $table->unsignedBigInteger('key_id')->index();
            $table->foreign('key_id')->references('id')->on('keys')->onDelete('cascade');
            $table->unsignedBigInteger('vehicle_id')->index();
            $table->foreign('vehicle_id')->references('id')->on('vehicles')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('key_vehicle');
    }
};
