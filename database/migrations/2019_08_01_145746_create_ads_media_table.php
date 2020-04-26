<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateAdsMediaTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('ads_media',function (Blueprint $table){
            $table->bigIncrements('id');
            $table->string('image');
            $table->unsignedBigInteger('ad_id');
            $table->string('type');
            $table->softDeletes();
            $table->timestamps();
            $table->foreign('ad_id')->references('id')->on('ads')->onDelete('cascade')->onUpdate("cascade");
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('ads_media');
    }
}
