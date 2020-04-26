<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateRiderLogsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('rider_logs', function (Blueprint $table) {
            $table->unsignedBigInteger('rider_id');
            $table->unsignedBigInteger('order_id');
            $table->boolean('status')->nullable();
            $table->string('start_time')->nullable();
            $table->string('end_time')->nullable();
            $table->string('distance')->nullable();
            $table->double('origin_latitude');
            $table->double('origin_longitude');
            $table->double('destination_latitude');
            $table->double('destination_longitude');
            $table->double('rider_latitude');
            $table->double('rider_longitude');
            $table->timestamps();

            $table->foreign('rider_id')->references('id')->on('riders');
            $table->foreign('order_id')->references('id')->on('orders');
            $table->primary(['rider_id','order_id']);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('rider_logs');
    }
}
