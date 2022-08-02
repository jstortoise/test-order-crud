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
        Schema::create('orders', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('vehicle_id')->index();
            $table->foreign('vehicle_id')->references('id')->on('vehicles');
            $table->unsignedBigInteger('key_id')->index();
            $table->foreign('key_id')->references('id')->on('keys');
            $table->unsignedBigInteger('technician_id')->index();
            $table->foreign('technician_id')->references('id')->on('technicians');
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
        Schema::dropIfExists('orders');
    }
};
